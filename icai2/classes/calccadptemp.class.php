<?php

class Calccadptemp extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		$date=$this->_date;
		//$date="2014-10-15";
		$data=	$this->db->getResult("Select ssa.ca_action_id,ssa.id,ssa.indxx_id,tbl_ca.id as ca_id,tbl_ca.identifier,tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.eff_date from tbl_dividend_ph_req_temp ssa 
	left join tbl_ca on ssa.ca_action_id=tbl_ca.action_id 
	where tbl_ca.eff_date='".$date."'
	 ",true);
//$this->pr($data,true);

$finalArray=array();
	if(!empty($data))
	{
	foreach($data as $key=> $newcTicker)
	{
		$finalArray[$key]=$newcTicker;
		
	
		$indxx_value=$this->db->getResult("select tbl_indxx_value_temp.* from tbl_indxx_value_temp where indxx_id='".$newcTicker['indxx_id']."' order by date desc ",false,1);	
		if(!empty($indxx_value))
		{
		$ticker_details=$this->db->getResult("SELECT  it.id,it.name,it.isin,it.ticker,curr,divcurr,curr,sedol,cusip,countryname,(select price from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$indxx_value['date']."' and fp.indxx_id='".$newcTicker['indxx_id']."') as calcprice,(select localprice from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$indxx_value['date']."' and fp.indxx_id='".$newcTicker['indxx_id']."') as localprice,(select share from tbl_share_temp sh where sh.isin=it.isin  and sh.indxx_id='".$newcTicker['indxx_id']."') as calcshare FROM `tbl_indxx_ticker_temp` it where it.indxx_id='".$newcTicker['indxx_id']."' and ticker='".$newcTicker['identifier']."'",false,1);	
		
		
		$finalArray[$key]['old_ticker']=$ticker_details;
		
		//$lastday_value=$this->getLastDayPriceValue($indxx,$indxx['indxx_curr'],$indxx_value['date']);
		//$lastday_local_value=$this->getLastDayLocalPriceValue($indxx,$indxx['indxx_curr'],$indxx_value['date']);
		//$lastday_currency_value=$this->getLastDayPriceCurrencyValue($indxx,$indxx['indxx_curr'],$indxx_value['date']);
		//$finalArray[$key]['newTickers'][$tickerKey]['lastdaycurrencyvalue']=$lastday_currency_value;
		
		//$finalArray[$key]['newTickers'][$tickerKey]['lastdayvalue']=$lastday_value;
		//$finalArray[$key]['newTickers'][$tickerKey]['lastdaylocalvalue']=$lastday_local_value;
		//$finalArray[$key]['newTickers'][$tickerKey]['lastday']=$indxx_value['date'];
		
		}
	 
	 
	 
	// $finalArray[$key]['factor']=$this->getAdjFactorforSpin($newcTicker['ca_id'],$newcTicker['action_id']);
	 
	 
	 
	
	}
	}	
	//$this->pr($finalArray,true);
		
	if(!empty($finalArray))
	{
		
		foreach($finalArray as $key=>$request)
		{
		
		 $updatePriceQuery="insert into tbl_dividend_ph_temp set  indxx_id='".$request['indxx_id']."',ticker_id='".$request['old_ticker']['id']."',share='".$request['old_ticker']['calcshare']."',dividend='".$request['old_ticker']['calcprice']."'";
	 
	$deleteTickerQuery="delete from tbl_indxx_ticker_temp where indxx_id='".$request['indxx_id']."' and ticker_id='".$request['old_ticker']['id']."' ";
		
		
		
	$deletePriceQuery="delete from tbl_final_price_temp where indxx_id='".$request['indxx_id']."' and isin='".$request['old_ticker']['isin']."' ";
		
	$deleteShareQuery="delete from tbl_share_temp where indxx_id='".$request['indxx_id']."' and isin='".$request['old_ticker']['isin']."' ";
		
		$this->db->query($updatePriceQuery);
		$this->db->query($deleteTickerQuery);
		$this->db->query($deletePriceQuery);
		$this->db->query($deleteShareQuery);
		
		}
		
		
		
	}	
		$this->saveProcess();
	$this->Redirect2("index.php?module=calcrebalance","","");
		}
}