<?php
class Calccadp extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		/* TODO: This logic can be optimized more */
		
		$date = $this->_date;
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
			define("DEBUG", $_GET['DEBUG']);
		
		$this->log_info(log_file, "CA adp process started");
		$finalArray = array ();
		
		$data = $this->db->getResult ( "Select ssa.ca_action_id, ssa.id, ssa.indxx_id, 
						ca.id as ca_id, ca.identifier, ca.company_name, ca.mnemonic, ca.eff_date 
						from tbl_dividend_ph_req ssa left join tbl_ca ca on ssa.ca_action_id=ca.action_id 
						where ca.eff_date='" . $date . "'", true );
		
		if (! empty ( $data )) 
		{
			foreach ( $data as $key => $newcTicker ) 
			{
				$finalArray [$key] = $newcTicker;
				
				$indxx_value = $this->db->getResult ( "select * from tbl_indxx_value where indxx_id='" . $newcTicker ['indxx_id'] . "' order by date desc ", false, 1 );

				if (! empty ( $indxx_value )) 
				{
					$ticker_details = $this->db->getResult ("SELECT  it.id, it.name, it.isin, it.ticker, it.curr, it.divcurr, it.curr, it.sedol, it.cusip, it.countryname,
								fp.price as calcprice, fp.localprice, sh.share as calcshare
								from `tbl_indxx_ticker` it left join tbl_final_price fp on fp.isin=it.isin
								left join tbl_share sh on sh.isin=it.isin
								where fp.date='" . $indxx_value ['date'] . "' and fp.indxx_id='" . $newcTicker ['indxx_id'].
							"' and sh.indxx_id='" . $newcTicker ['indxx_id'] . "' and it.indxx_id='" . $newcTicker ['indxx_id']. "' and ticker='" . $newcTicker ['identifier'] . "'", false, 1 );					

					$finalArray [$key] ['old_ticker'] = $ticker_details;					
				}				
			}
		}
		
		if (! empty ( $finalArray )) 
		{	
			foreach ( $finalArray as $key => $request ) 
			{
				
				$updatePriceQuery = "insert into tbl_dividend_ph set  indxx_id='" . $request ['indxx_id'] . "',ticker_id='" . $request ['old_ticker'] ['id'] . "',share='" . $request ['old_ticker'] ['calcshare'] . "',dividend='" . $request ['old_ticker'] ['calcprice'] . "'";
				$this->db->query ( $updatePriceQuery );
				
				$deleteTickerQuery = "delete from tbl_indxx_ticker where indxx_id='" . $request ['indxx_id'] . "' and ticker_id='" . $request ['old_ticker'] ['id'] . "' ";
				$this->db->query ( $deleteTickerQuery );
				
				$deletePriceQuery = "delete from tbl_final_price where indxx_id='" . $request ['indxx_id'] . "' and isin='" . $request ['old_ticker'] ['isin'] . "' ";
				$this->db->query ( $deletePriceQuery );
				
				$deleteShareQuery = "delete from tbl_share where indxx_id='" . $request ['indxx_id'] . "' and isin='" . $request ['old_ticker'] ['isin'] . "' ";				
				$this->db->query ( $deleteShareQuery );
			}
		}
		$this->log_info(log_file, "CA adp process finished");
				
		//$this->saveProcess ( 1 );
		if (DEBUG)
		{
			$this->Redirect("index.php?module=calccadptemp&DEBUG=" .DEBUG. "&date=" .$date. "&log_file=" . basename(log_file), "", "" );
		}
		else
		{
			//$this->Redirect("index.php?module=calccadptemp&DEBUG=" .DEBUG. "&date=" .$date. "&log_file=" . basename(log_file), "", "" );
			log_error("Unable to locate calccadptemp index module.");
			mail_exit(__FILE__, __LINE__);
		}
	}
}