<?php
class Calcrebalance extends Application 
{

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
		
		if($_GET['DEBUG'])
		{
			define("DEBUG", $_GET['DEBUG']);
		
			if($_GET['date'])
			{
				$datevalue2 = $_GET['date'];
			}
			else
			{
				$this->log_error(log_file, "No date provided in DEBUG mode");
				$this->mail_exit(log_file, __FILE__, __LINE__);
			}
		}
		$this->log_info(log_file, "CA rebalance process started");
		$final_array = array ();
		
		$indxxs = $this->db->getResult ( "select * from tbl_indxx_temp  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and recalc='1' and dateStart='" . $datevalue2 . "'", true );
		
		if (! empty ( $indxxs )) 
		{
			foreach ( $indxxs as $row ) 
			{	
				$final_array [$row ['id']] = $row;
				
				$liveindexid = $this->db->getResult ( "select id from tbl_indxx where code='" . $row ['code'] . "' ", true );
				$indxx_value = $this->db->getResult ( "select * from tbl_indxx_value where indxx_id='" . $liveindexid ['0'] ['id'] . "' order by date desc ", false, 1 );

				$final_array [$row ['id']] ['index_value'] = $indxx_value ['indxx_value'];
				$final_array [$row ['id']] ['market_value'] = $indxx_value ['market_value'];
				$final_array [$row ['id']] ['last_close_date'] = $indxx_value ['date'];
				$final_array [$row ['id']] ['last_close_id'] = $indxx_value ['id'];
				
				$indxx_value = $this->db->getResult ( "select * from tbl_indxx_value_temp where indxx_id='" . $row ['id'] . "' order by date desc ", false, 1 );
				$final_array [$row ['id']] ['last_close_temp_id'] = $indxx_value ['id'];
				
				$datevalue = $indxx_value ['date'];

				$query = $this->db->getResult ("SELECT it.name, it.isin, it.ticker, 
								fp.price as calcprice, fp.localprice, fp.currencyfactor, sh.share as calcshare 
								from `tbl_indxx_ticker_temp` it left join tbl_final_price_temp fp on fp.isin=it.isin 
								left join tbl_share_temp sh on sh.isin=it.isin 
								where fp.date='" . $datevalue . "' and fp.indxx_id='" . $row ['id'].
								"' and sh.indxx_id='" . $row ['id'] . "' and it.indxx_id='" . $row ['id']. "'", false, 1 );				
				$indxxprices = $this->db->getResult ( $query, true );		
				$final_array [$row ['id']] ['values'] = $indxxprices;
			}
		}

		if (! empty ( $final_array )) 
		{
			$output_folder = "../files/output/backup/";
			if (!file_exists($output_folder))
				mkdir($output_folder, 0777, true);
			
			file_put_contents ($output_folder. 'prerebalancedata' . date ( "Y-m-d-H-i-s" ) . '.json', json_encode ( $final_array ) );

			foreach ( $final_array as $indexKey => $index ) 
			{
				$newDivisor = 0;
				$oldIndexValue = $index ['index_value'];
				$newMarketCap = 0;

				if (! empty ( $index ['values'] )) 
				{
					foreach ( $index ['values'] as $securities )
						$newMarketCap += $securities ['calcshare'] * $securities ['calcprice'];
				}
				
				if ($newMarketCap != 0) 
				{
					$newDivisor = $newMarketCap / $oldIndexValue;
					$final_array [$indexKey] ['newDivisor'] = $newDivisor;
					
					$updateQuery = 'update tbl_indxx_value_temp set market_value="' . $newMarketCap . '",indxx_value="' . $oldIndexValue . '",newdivisor="' . $newDivisor . '",olddivisor="' . $newDivisor . '" where id="' . $index ['last_close_temp_id'] . '"';
					$this->db->query ( $updateQuery );
				}
			}
			file_put_contents ($output_folder. 'postrebalancedata' . date ( "Y-m-d-H-i-s" ) . '.json', json_encode ( $final_array ) );
		}		
		$this->log_info(log_file, "CA rebalance process finished");
		
		//$this->saveProcess ( 1 );
		if (DEBUG)
		{
			$this->Redirect2("index.php?module=calcdp&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
		}
		else
		{
			//$this->Redirect("index.php?module=calcdp&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
			log_error("Unable to locate calcdp index module.");
			mail_exit(__FILE__, __LINE__);
		}
	}
}
?>

