<?php

class Calcspinstockaddtemp extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		$date=$this->_date;
		$data=	$this->db->getResult("Select ssa.dbApprove,ssa.action_id,ssa.id,tbl_ca.id as ca_id,tbl_ca.identifier,tbl_ca.company_name,tbl_ca.mnemonic,tbl_ca.eff_date from tbl_spin_stock_add ssa 
	left join tbl_ca on ssa.action_id=tbl_ca.action_id 
	where tbl_ca.eff_date='".$date."' and ssa.dbApprove='1'
	 ",true);
//$this->pr($data);

$finalArray=array();
	if(!empty($data))
	{
	foreach($data as $key=> $newcTicker)
	{
		$finalArray[$key]=$newcTicker;
		
	$data2=	$this->db->getResult("Select ssas.*,tbl_indxx_temp.name  as indxx_name,tbl_indxx_temp.curr as indxx_curr,tbl_indxx_temp.code as indxx_code from tbl_spin_stock_add_securities_temp ssas 
	left join tbl_indxx_temp on tbl_indxx_temp.id=ssas.indxx_id
	where ssas.req_id=".$newcTicker['action_id']."
	 ",true);
	  $finalArray[$key]['newTickers']=$data2;
	 
	 if(!empty($data2))
	 {
		foreach($data2 as  $tickerKey=>$indxx)
		{
		$indxx_value=$this->db->getResult("select tbl_indxx_value_temp.* from tbl_indxx_value_temp where indxx_id='".$indxx['indxx_id']."' order by date desc ",false,1);	
		if(!empty($indxx_value))
		{
		$ticker_details=$this->db->getResult("SELECT  it.id,it.name,it.isin,it.ticker,curr,divcurr,curr,sedol,cusip,countryname,(select price from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$indxx_value['date']."' and fp.indxx_id='".$indxx['indxx_id']."') as calcprice,,(select localprice from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$indxx_value['date']."' and fp.indxx_id='".$indxx['indxx_id']."') as localprice(select share from tbl_share_temp sh where sh.isin=it.isin  and sh.indxx_id='".$indxx['indxx_id']."') as calcshare FROM `tbl_indxx_ticker_temp` it where it.indxx_id='".$indxx['indxx_id']."' and ticker='".$newcTicker['identifier']."'",false,1);	
		
		
		$finalArray[$key]['newTickers'][$tickerKey]['old_ticker']=$ticker_details;
		
		$lastday_value=$this->getLastDayPriceValue($indxx,$indxx['indxx_curr'],$indxx_value['date']);
		$lastday_local_value=$this->getLastDayLocalPriceValue($indxx,$indxx['indxx_curr'],$indxx_value['date']);
		$lastday_currency_value=$this->getLastDayPriceCurrencyValue($indxx,$indxx['indxx_curr'],$indxx_value['date']);
		$finalArray[$key]['newTickers'][$tickerKey]['lastdaycurrencyvalue']=$lastday_currency_value;
		$finalArray[$key]['newTickers'][$tickerKey]['lastdaylocalvalue']=$lastday_local_value;
		
		$finalArray[$key]['newTickers'][$tickerKey]['lastdayvalue']=$lastday_value;
		$finalArray[$key]['newTickers'][$tickerKey]['lastday']=$indxx_value['date'];
		}
		
		
		}
		
		}
	 
	 
	 
	 $finalArray[$key]['factor']=$this->getAdjFactorforSpin($newcTicker['ca_id'],$newcTicker['action_id']);
	 
	 
	 
	
	}
	}	
	//$this->pr($finalArray,true);
		
	if(!empty($finalArray))
	{
	foreach($finalArray as $ca)
	{
		//
	if(!empty($ca))
	{
	foreach($ca['newTickers'] as $newTicker)
	{
//$this->pr($newTicker);
	$oldMarketCap=$newTicker['old_ticker']['calcprice']*$newTicker['old_ticker']['calcshare'];
	//$newPrice=$newTicker['old_ticker']['calcprice']-($newTicker['old_ticker']['calcprice']*$ca['factor']);
	$newPrice=$newTicker['old_ticker']['calcprice']*$ca['factor'];
		//$newlocalPrice=$newTicker['old_ticker']['localprice']-($newTicker['old_ticker']['localprice']*$ca['factor']);
	$newlocalPrice=$newTicker['old_ticker']['localprice']*$ca['factor'];
//echo "<br>";
	$newMarketCap=$newPrice*$newTicker['old_ticker']['calcshare'];
	 $currentShare=($oldMarketCap-$newMarketCap)/$newTicker['lastdayvalue'];
	 //"<br>";
	 
	 	 
	 
	 $updatePriceQuery="update tbl_final_price_temp set price='".$newPrice."',localprice='".$newlocalPrice."'  where indxx_id='".$newTicker['indxx_id']."' and date='".$newTicker['lastday']."' and isin='".$newTicker['old_ticker']['isin']."'";
	 
	  $insertTickerQuery="Insert into tbl_indxx_ticker_temp set name='".mysql_real_escape_string($newTicker['name'])."',isin='".mysql_real_escape_string($newTicker['isin'])."',ticker='".mysql_real_escape_string($newTicker['ticker'])."',weight='0',curr='".mysql_real_escape_string($newTicker['curr'])."',divcurr='".mysql_real_escape_string($newTicker['divcurr'])."',status='1', indxx_id='".$newTicker['indxx_id']."' ";
	
	
	 $insertShareQuery="Insert into tbl_share_temp set dateAdded='".$date."',isin='".$newTicker['isin']."',date='".$date."',share='". $currentShare."', indxx_id='".$newTicker['indxx_id']."' ";
	
	
	 $insertPriceQuery="Insert into tbl_final_price_temp set dateAdded='".$date."',isin='".$newTicker['isin']."',date='".$newTicker['lastday']."',price='".$newTicker['lastdayvalue']."',currencyfactor='".$newTicker['lastdaycurrencyvalue']."',  	localprice='".$newTicker['lastdaylocalvalue']."', indxx_id='".$newTicker['indxx_id']."' ";
	
	
	 $insertIgnoreQuery="Insert into tbl_ignore_index_temp set ca_id='".$ca['ca_id']."',ca_action_id='".$ca['action_id']."', indxx_id='".$newTicker['indxx_id']."' ";
	
	
$this->db->query($insertPriceQuery);
	
	
	$this->db->query($insertShareQuery);
	
$this->db->query($insertTickerQuery);
	 
	$this->db->query($insertIgnoreQuery); 
	 
	 	 $this->db->query($updatePriceQuery); 
	}
	
	
	
	}
	
	
	
	
	
	}
	}	
		$this->saveProcess();
		
//	$this->Redirect("index.php?module=calcrebalance","","");	
	$this->Redirect("index.php?module=calccadp","","");	
	}
}