<?php
class Calcdelist extends Application {
	function __construct() 
	{
		parent::__construct ();
	}

	function index() 
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		/* TODO: This logic can be optimized more */
		
		$datevalue2 = $this->_date;
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		$this->log_info(log_file, "CA [delist live index] process started");
		
		$final_array = array ();
		
		/* Fetch the list of indexes with delist security request pending for today */
		$indxxs = $this->db->getResult ( "select id, indxx_id from tbl_delist_runnindex_req where 
				startdate='" . $datevalue2 . "' and adminapprove='1' ", true );
		
		if (! empty ( $indxxs )) 
		{
			foreach ( $indxxs as $indxx ) 
			{	
				$indxx_value = $this->db->getResult ( "select * from tbl_indxx_value where indxx_id='" . $indxx ['indxx_id'] . "' order by date desc ", false, 1 );
				if (! empty ( $indxx_value )) 
				{
					$final_array [$indxx ['indxx_id']]['index_value'] = $indxx_value;
					$datevalue = $indxx_value ['date'];
				}
				else
				{
					$this->log_error(log_file, "datevalue not defined, next MYSQL query will fail");
					$this->mail_exit(log_file, __FILE__, __LINE__);
				}
				
				$query = "Select it.id, it.name, it.isin, it.ticker, it.curr, it.divcurr, 
					fp.price as calcprice, fp.localprice, fp.currencyfactor, sh.share as calcshare from  
					tbl_indxx_ticker it left join tbl_final_price fp on fp.isin=it.isin  
					left join tbl_share sh on sh.isin=it.isin where 
					fp.date='" .$datevalue. "' and fp.indxx_id='" .$indxx ['indxx_id'].
									"' and sh.indxx_id='" .$indxx ['indxx_id']. "' and it.indxx_id='" . $indxx ['indxx_id']. "'";				
				$indxxprices = $this->db->getResult ( $query, true );				
				$final_array [$indxx ['indxx_id']]['olddata'] = $indxxprices;

				/* List of securities that needs to be removed */
				$oldsecurity = $this->db->getResult ( "select security_id from tbl_delist_runnsecurity where req_id='" . $indxx ['id'] . "' and  indxx_id='" . $indxx ['indxx_id'] . "' ", true );
				$final_array [$indxx ['indxx_id']]['removesecurity'] = $oldsecurity;
			}
		}
		
		if (! empty ( $final_array )) 
		{
			/* Delete delisted securities and re-calculate divisors for the index */
			foreach ( $final_array as $id => $indxx_array ) 
			{				
				$tempMarketCap = 0;
				
				if (! empty ( $indxx_array ['removesecurity'] )) 
				{
					foreach ( $indxx_array ['removesecurity'] as $removedSecurtity ) 
					{
						if (! empty ( $removedSecurtity )) 
						{
							foreach ( $indxx_array ['olddata'] as $oldsecuritykey => $oldsecuriti ) 
							{
								if ($oldsecuriti ['id'] == $removedSecurtity ['security_id']) 
								{
									$this->log_info(log_file, "Delist live isin = " .$oldsecuriti ['isin']);
									$tempMarketCap += $oldsecuriti ['calcshare'] * $oldsecuriti ['calcprice'];
									
									$deleteSecurityQuery = 'Delete from tbl_indxx_ticker where id="' . $oldsecuriti ['id'] . '"';
									$this->db->query ( $deleteSecurityQuery );

									$deletepriceQuery = 'Delete from tbl_final_price where indxx_id="' . $id . '" and  isin ="' . $oldsecuriti ['isin'] . '" and date ="' . $indxx_array ['index_value'] ['date'] . '" ';
									$this->db->query ( $deletepriceQuery );
										
									$deleteshareQuery = 'Delete from tbl_share where indxx_id="' . $id . '" and  isin ="' . $oldsecuriti ['isin'] . '" ';
									$this->db->query ( $deleteshareQuery );
									
									unset ( $final_array [$id] ['olddata'] [$oldsecuritykey] );
								}
							}
						}
					}
				}
				
				if ($tempMarketCap) 
				{
					$newDivisor = 0;
					$newDivisor = $indxx_array ['index_value'] ['newdivisor'];
					
					$newDivisor = $newDivisor - ($tempMarketCap / $indxx_array ['index_value'] ['indxx_value']);
					
					/* Update index parameters */
					$updateQuery = 'update tbl_indxx_value set newdivisor="' . $newDivisor . '",olddivisor="' . $newDivisor . '" where  date="' . $indxx_array ['index_value'] ['date'] . '" and indxx_id="' . $id . '"';
					$this->db->query ( $updateQuery );
				}				
			}
		}
		
		$this->log_info(log_file, "CA [delist live index] process finished");
		
		//$this->saveProcess ( 1 );
		$this->Redirect("index.php?module=calcreplace&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
	}
}
?>