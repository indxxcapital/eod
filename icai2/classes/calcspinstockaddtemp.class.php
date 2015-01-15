<?php
class Calcspinstockaddtemp extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		/* TODO: This logic can be optimized more */
		
		$date = $this-->_date;
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
		{
			define("DEBUG", $_GET['DEBUG']);
		
			if($_GET['date'])
			{
				$date = $_GET['date'];
			}
			else
			{
				$this->log_error(log_file, "No date provided in DEBUG mode");
				$this->mail_exit(log_file, __FILE__, __LINE__);
			}
		}
				
		$this->log_info(log_file, "CA spinstockaddtemp process started");
		$finalArray = array ();
		
		$data = $this->db->getResult ( "Select ssa.dbApprove, ssa.action_id, ssa.id, 
							ca.id as ca_id, ca.identifier, ca.company_name, ca.mnemonic, ca.eff_date 
							from tbl_spin_stock_add ssa left join tbl_ca ca on ssa.action_id=tbl_ca.action_id 
							where ca.eff_date='" . $date . "' and ssa.dbApprove='1'", true );
		
		if (! empty ( $data )) 
		{
			foreach ( $data as $key => $newcTicker ) 
			{
				$finalArray [$key] = $newcTicker;
				
				$data2 = $this->db->getResult ( "Select ssas.*, it.name as indxx_name, it.curr as indxx_curr, it.code as indxx_code 
						from tbl_spin_stock_add_securities_temp ssas left join tbl_indxx_temp it on it.id=ssas.indxx_id 
						where ssas.req_id=" . $newcTicker ['action_id'] . "", true );
				$finalArray [$key] ['newTickers'] = $data2;
				
				if (! empty ( $data2 )) {
					foreach ( $data2 as $tickerKey => $indxx ) 
					{
						$indxx_value = $this->db->getResult ( "select * from tbl_indxx_value_temp where indxx_id='" . $indxx ['indxx_id'] . "' order by date desc ", false, 1 );

						if (! empty ( $indxx_value )) 
						{
							$ticker_details = $this->db->getResult ("SELECT  it.id, it.name, it.isin, it.ticker, it.curr, it.divcurr, it.curr, it.sedol, it.cusip, it.countryname,
								fp.price as calcprice, fp.localprice, sh.share as calcshare 
								from `tbl_indxx_ticker_temp` it left join tbl_final_price_temp fp on fp.isin=it.isin 
								left join tbl_share_temp sh on sh.isin=it.isin  
								where fp.date='" . $indxx_value ['date'] . "' and fp.indxx_id='" . $indxx ['indxx_id'].
								"' and sh.indxx_id='" . $indxx ['indxx_id'] . "' and it.indxx_id='" . $indxx ['indxx_id']. "' and ticker='" . $newcTicker ['identifier'] . "'", false, 1 );
								
								$finalArray [$key] ['newTickers'] [$tickerKey] ['old_ticker'] = $ticker_details;
								
								$lastday_value = $this->getLastDayPriceValue ( $indxx, $indxx ['indxx_curr'], $indxx_value ['date'] );
								$lastday_local_value = $this->getLastDayLocalPriceValue ( $indxx, $indxx ['indxx_curr'], $indxx_value ['date'] );

								$lastday_currency_value = $this->getLastDayPriceCurrencyValue ( $indxx, $indxx ['indxx_curr'], $indxx_value ['date'] );
								$finalArray [$key] ['newTickers'] [$tickerKey] ['lastdaycurrencyvalue'] = $lastday_currency_value;
								$finalArray [$key] ['newTickers'] [$tickerKey] ['lastdaylocalvalue'] = $lastday_local_value;
								
								$finalArray [$key] ['newTickers'] [$tickerKey] ['lastdayvalue'] = $lastday_value;
								$finalArray [$key] ['newTickers'] [$tickerKey] ['lastday'] = $indxx_value ['date'];
						}
					}
				}
				
				$finalArray [$key] ['factor'] = $this->getAdjFactorforSpin ( $newcTicker ['ca_id'], $newcTicker ['action_id'] );
			}
		}
		
		if (! empty ( $finalArray )) 
		{
			foreach ( $finalArray as $ca ) 
			{
				if (! empty ( $ca )) 
				{
					foreach ( $ca ['newTickers'] as $newTicker ) 
					{
						$oldMarketCap = $newTicker ['old_ticker'] ['calcprice'] * $newTicker ['old_ticker'] ['calcshare'];
						$newPrice = $newTicker ['old_ticker'] ['calcprice'] * $ca ['factor'];
						$newlocalPrice = $newTicker ['old_ticker'] ['localprice'] * $ca ['factor'];
						$newMarketCap = $newPrice * $newTicker ['old_ticker'] ['calcshare'];
						$currentShare = ($oldMarketCap - $newMarketCap) / $newTicker ['lastdayvalue'];

						$insertPriceQuery = "Insert into tbl_final_price_temp set dateAdded='" . $date . "',isin='" . $newTicker ['isin'] . "',date='" . $newTicker ['lastday'] . "',price='" . $newTicker ['lastdayvalue'] . "',currencyfactor='" . $newTicker ['lastdaycurrencyvalue'] . "',  	localprice='" . $newTicker ['lastdaylocalvalue'] . "', indxx_id='" . $newTicker ['indxx_id'] . "' ";
						$this->db->query ( $insertPriceQuery );
						
						$insertShareQuery = "Insert into tbl_share_temp set dateAdded='" . $date . "',isin='" . $newTicker ['isin'] . "',date='" . $date . "',share='" . $currentShare . "', indxx_id='" . $newTicker ['indxx_id'] . "' ";
						$this->db->query ( $insertShareQuery );
						
						$insertTickerQuery = "Insert into tbl_indxx_ticker_temp set name='" . mysql_real_escape_string ( $newTicker ['name'] ) . "',isin='" . mysql_real_escape_string ( $newTicker ['isin'] ) . "',ticker='" . mysql_real_escape_string ( $newTicker ['ticker'] ) . "',weight='0',curr='" . mysql_real_escape_string ( $newTicker ['curr'] ) . "',divcurr='" . mysql_real_escape_string ( $newTicker ['divcurr'] ) . "',status='1', indxx_id='" . $newTicker ['indxx_id'] . "' ";
						$this->db->query ( $insertTickerQuery );
						
						$insertIgnoreQuery = "Insert into tbl_ignore_index_temp set ca_id='" . $ca ['ca_id'] . "',ca_action_id='" . $ca ['action_id'] . "', indxx_id='" . $newTicker ['indxx_id'] . "' ";
						$this->db->query ( $insertIgnoreQuery );
						
						$updatePriceQuery = "update tbl_final_price_temp set price='" . $newPrice . "',localprice='" . $newlocalPrice . "'  where indxx_id='" . $newTicker ['indxx_id'] . "' and date='" . $newTicker ['lastday'] . "' and isin='" . $newTicker ['old_ticker'] ['isin'] . "'";
						$this->db->query ( $updatePriceQuery );
					}
				}
			}
		}
		$this->log_info(log_file, "CA spinstockaddtemp process finished");
						
		//$this->saveProcess ( 1 );
		if (DEBUG)
		{
			$this->Redirect2("index.php?module=calccadp&DEBUG=" .DEBUG. "&date=" .$date. "&log_file=" . basename(log_file), "", "" );
		}
		else
		{
			//$this->Redirect("index.php?module=calccadp&DEBUG=" .DEBUG. "&date=" .$date. "&log_file=" . basename(log_file), "", "" );
			log_error("Unable to locate calccadp index module.");
			mail_exit(__FILE__, __LINE__);
		}
	}
}