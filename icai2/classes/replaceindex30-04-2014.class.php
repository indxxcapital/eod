<?php

class Replaceindex extends Application{

	function __construct()
	{
		
		parent::__construct();
	
	}
	
	function index(){

	 $datevalue=$this->_date;
//exit;
	$indexdata=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp where 1=1 and status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and finalsignoff='1' and dateStart='".$this->_date."' ",true);
		
			$finalArray=array();
		
		if(!empty($indexdata))
		{
		foreach($indexdata as $k1=>$oldindxx)
		{
	//	$this->pr($oldindxx);
		
//		$finalArray=array();
		
		
		$oldTickers=$this->db->getResult("Select * from  tbl_indxx_ticker_temp where indxx_id ='".$oldindxx['id']."'",true) ;
		$finalArray[$k1]=$oldindxx;
		$finalArray[$k1]['tickers']=$oldTickers;
		$oldShares=$this->db->getResult("Select * from  tbl_share_temp where indxx_id ='".$oldindxx['id']."'",true) ;
		$finalArray[$k1]['shares']=$oldShares;
		$oldindxxvalue=$this->db->getResult("Select * from  tbl_indxx_value_temp where indxx_id ='".$oldindxx['id']."' order by date desc ",false,1) ;
		$finalArray[$k1]['oldindxxvalue']=$oldindxxvalue;
		
		
		
		$oldPrices=$this->db->getResult("Select * from  tbl_final_price_temp where indxx_id ='".$oldindxx['id']."' and date='".$oldindxxvalue['date']."'",true) ;
		$finalArray[$k1]['prices']=$oldPrices;
		
	//echo	"Select * from  tbl_delist_tempindex_req where indxx_id ='".$oldindxx['id']."'";
		
		$delistReq=$this->db->getResult("Select * from  tbl_delist_tempindex_req where indxx_id ='".$oldindxx['id']."'",true) ;
		$delistArray=array();
		if(!empty($delistReq))
		{
		foreach($delistReq as $k2=> $delisting)
		{
		$delistSec=$this->db->getResult("Select * from  tbl_delist_tempsecurity where indxx_id ='".$delisting['indxx_id']."' and req_id='".$delisting['id']."'",true) ;
		$delistArray[$k2]=$delisting;
		$delistArray[$k2]['security']=$delistSec;
		}
		}
		$finalArray[$k1]['delisting']=$delistArray;
		////Replace Security
		$replaceReq=$this->db->getResult("Select * from  tbl_replace_tempindex_req where indxx_id ='".$oldindxx['id']."'",true) ;
		$replaceArray=array();
		if(!empty($replaceReq))
		{
		foreach($replaceReq as $k3=> $replacement)
		{
		$replaceSec=$this->db->getResult("Select * from  tbl_replace_tempsecurity where indxx_id ='".$replacement['indxx_id']."' and req_id='".$replacement['id']."'",true) ;
		$replaceArray[$k3]=$replacement;
		$replaceArray[$k3]['selectedsecurity']=$replaceSec;
		
		
		$replacedSec=$this->db->getResult("Select * from  tbl_tempsecurities_replaced where indxx_id ='".$replacement['indxx_id']."' and req_id='".$replacement['id']."'",true) ;
		//$replaceArray[$k3]=$replacement;
		$replaceArray[$k3]['replacedsecurity']=$replacedSec;
		
		}
		}
		$finalArray[$k1]['replacement']=$replaceArray;
		
		
		
		
		}
		
		
		}		
		
		//$this->pr($finalArray,true);
		if(!empty($finalArray))
		{
	$textdata=	$this->arr_to_csv($finalArray);
		$csv='';
		foreach($textdata as $text)
		$csv.=$text."\n";
	//	echo $csv;
	
		$file="../files2/ca-index-backup/backup-upcomming-".$datevalue.".txt";
		$open=fopen($file,"w+");
		
		if($open){        
		 if(   fwrite($open,$csv))
		{        fclose($open);
		echo "file Writ for <br>";
		
		}
		}  
		
	
	foreach($finalArray as $skey=> $newIndxx)
	{
		$newIndexArray=array();
		
		$checkindex=$this->db->getResult("Select * from  tbl_indxx where code ='".$newIndxx['code']."'") ;
		if(!empty($checkindex))
		{		
		$newIndexArray['indexdetails']=$checkindex;
		
		
		
		$this->db->query("delete from  tbl_indxx where code ='".$newIndxx['code']."'") ;
		
		
		
		
		$checktickers=$this->db->getResult("Select * from  tbl_indxx_ticker where indxx_id ='".$checkindex['id']."'",true) ;
		$newIndexArray['indexdetails']['tickers']=$checktickers;
		$this->db->query("delete from  tbl_indxx_ticker where indxx_id ='".$checkindex['id']."'") ;
		
		$checkindexvalue=$this->db->getResult("Select * from  tbl_indxx_value where indxx_id ='".$checkindex['id']."' order by date desc",false,1) ;
		$newIndexArray['indexdetails']['indexvalue']=$checkindexvalue;
		
		$this->db->query("delete from  tbl_indxx_value where indxx_id ='".$checkindex['id']."' and date='".$checkindexvalue['date']."'") ;
		//$this->pr($newIndexArray,true);
		
		$checkprice=$this->db->getResult("Select * from  tbl_final_price where indxx_id ='".$checkindex['id']."' and date='".$checkindexvalue['date']."'",true) ;
		$newIndexArray['indexdetails']['price']=$checkprice;
		$this->db->query("delete from  tbl_final_price where indxx_id ='".$checkindex['id']."' and date='".$checkindexvalue['date']."'") ;
		
		
		$checkshares=$this->db->getResult("Select * from  tbl_share where indxx_id ='".$checkindex['id']."'",true) ;
		$newIndexArray['indexdetails']['shares']=$checkshares;
		$this->db->query("delete from  tbl_share where indxx_id ='".$checkindex['id']."'") ;
		
		
		
		
		//$checkdelisting=$this->db->getResult("Select * from  tbl_delist_runnindex_req where indxx_id ='".$checkindex['id']."'",true) ;
		//$newIndexArray['indexdetails']['delisting']=$checkdelisting;
		
		
		$checkdelistReq=$this->db->getResult("Select * from  tbl_delist_runnindex_req where indxx_id ='".$checkindex['id']."'",true) ;
		
		
		$checkdelistArray=array();
		if(!empty($checkdelistReq))
		{
		foreach($checkdelistReq as $kch=> $checkdelisting)
		{
			
			
		$checkdelistSec=$this->db->getResult("Select * from  tbl_delist_runnsecurity where indxx_id ='".$checkdelisting['indxx_id']."' and req_id='".$checkdelisting['id']."'",true) ;
		$checkdelistArray[$kch]=$checkdelisting;
		$checkdelistArray[$kch]['security']=$checkdelistSec;
		
		$this->db->query("delete from  tbl_delist_runnsecurity where indxx_id ='".$checkdelisting['indxx_id']."' and req_id='".$checkdelisting['id']."'") ;
		}
		}
		$newIndexArray['indexdetails']['delisting']=$checkdelistArray;	
		
		$this->db->query("delete from  tbl_delist_runnindex_req where indxx_id ='".$checkindex['id']."'") ;
		
		//$this->pr($checkdelistArray,true);
		
		$checkreplaceReq=$this->db->getResult("Select * from  tbl_replace_runnindex_req where indxx_id ='".$checkindex['id']."'",true) ;
		$checkreplaceArray=array();
		if(!empty($checkreplaceReq))
		{
		foreach($checkreplaceReq as $kchk=> $checkreplacement)
		{
		$checkreplaceSec=$this->db->getResult("Select * from  tbl_replace_runnsecurity where indxx_id ='".$checkreplacement['indxx_id']."' and req_id='".$checkreplacement['id']."'",true) ;
		$checkreplaceArray[$kchk]=$checkreplacement;
		$checkreplaceArray[$kchk]['selectedsecurity']=$checkreplaceSec;
		$this->db->query("delete from  tbl_replace_runnsecurity where indxx_id ='".$checkreplacement['indxx_id']."' and req_id='".$checkreplacement['id']."'") ;
		
		
		$checkreplacedSec=$this->db->getResult("Select * from  tbl_runnsecurities_replaced where indxx_id ='".$checkreplacement['indxx_id']."' and req_id='".$checkreplacement['id']."'",true) ;
		//$replaceArray[$k3]=$replacement;
		$checkreplaceArray[$kchk]['replacedsecurity']=$checkreplacedSec;
		
		$this->db->query("delete from  tbl_runnsecurities_replaced where indxx_id ='".$checkreplacement['indxx_id']."' and req_id='".$checkreplacement['id']."'") ;
		
		}
		}
		$newIndexArray['indexdetails']['replacement']=$checkreplaceArray;
		$this->db->query("delete from  tbl_replace_runnindex_req where indxx_id ='".$checkindex['id']."'") ;
		
		
			if(!empty($newIndexArray))
		{
	$textdata=	$this->arr_to_csv($newIndexArray);
		$csv='';
		foreach($textdata as $text)
		$csv.=$text."\n";
	//	echo $csv;
	
		$file="../files2/ca-index-backup/backup-running-".$checkindex['code']."-".$datevalue.".txt";
		$open=fopen($file,"w+");
		
		if($open){        
		 if(   fwrite($open,$csv))
		{        fclose($open);
		echo "file Writ for".$checkindex['code']." <br>";
		
		}
		}
		}
		
		}
		//$this->pr($newIndxx,true);
		
		
		//$this->pr($newIndexArray,true);
		
		
		
	//
	
	
	
	$insertIndexQuery="Insert into tbl_indxx set name='".mysql_real_escape_string($newIndxx['name'])."',code='".mysql_real_escape_string($newIndxx['code'])."',investmentammount='".mysql_real_escape_string($newIndxx['investmentammount'])."',indexvalue='".mysql_real_escape_string($newIndxx['indexvalue'])."',divisor='".($newIndxx['divisor'])."',type='".mysql_real_escape_string($newIndxx['type'])."',cash_adjust='".mysql_real_escape_string($newIndxx['cash_adjust'])."',curr='".mysql_real_escape_string($newIndxx['curr'])."',status='".mysql_real_escape_string($newIndxx['status'])."',dateAdded='".mysql_real_escape_string($newIndxx['dateAdded'])."',lastupdated='".mysql_real_escape_string($newIndxx['lastupdated'])."',dateStart='".mysql_real_escape_string($newIndxx['dateStart'])."',usersignoff='".mysql_real_escape_string($newIndxx['usersignoff'])."',dbusersignoff='".mysql_real_escape_string($newIndxx['dbusersignoff'])."',submitted='".mysql_real_escape_string($newIndxx['submitted'])."',finalsignoff='".mysql_real_escape_string($newIndxx['finalsignoff'])."',runindex='".mysql_real_escape_string($newIndxx['runindex'])."',addtype='".mysql_real_escape_string($newIndxx['addtype'])."',zone='".mysql_real_escape_string($newIndxx['zone'])."',client_id='".mysql_real_escape_string($newIndxx['client_id'])."',display_currency='".mysql_real_escape_string($newIndxx['display_currency'])."' ,ireturn='".mysql_real_escape_string($newIndxx['ireturn'])."',div_type='".mysql_real_escape_string($newIndxx['div_type'])."'";
	
	$this->db->query($insertIndexQuery);
$NewIndxxId= mysql_insert_id();		
	$this->db->query("delete from tbl_indxx_temp where id='".$newIndxx['id']."'");
	

$tickerTempArray=array();


	if(!empty($newIndxx['tickers']))
	{
	foreach($newIndxx['tickers'] as $k4=> $newTickers)
	{
	$insertTickerQuery="Insert into tbl_indxx_ticker set name='".mysql_real_escape_string($newTickers['name'])."',isin='".mysql_real_escape_string($newTickers['isin'])."',ticker='".mysql_real_escape_string($newTickers['ticker'])."',weight='".mysql_real_escape_string($newTickers['weight'])."',curr='".mysql_real_escape_string($newTickers['curr'])."',divcurr='".mysql_real_escape_string($newTickers['divcurr'])."',dateAdded='".mysql_real_escape_string($newTickers['dateAdded'])."',status='".($newTickers['status'])."',sedol='".mysql_real_escape_string($newTickers['sedol'])."',cusip='".mysql_real_escape_string($newTickers['cusip'])."',countryname='".mysql_real_escape_string($newTickers['countryname'])."', indxx_id='".$NewIndxxId."' ";
	
		$this->db->query($insertTickerQuery);

	$tickerTempArray[$newTickers['id']]=mysql_insert_id();
	//$tickerTempArray[$k4]['neqKey']= mysql_insert_id();
	
	
	$this->db->query("delete from tbl_indxx_ticker_temp where indxx_id='".$newIndxx['id']."'");
	
	}
	}
	
	if(!empty($newIndxx['shares']))
	{
	foreach($newIndxx['shares'] as $k4=> $newShares)
	{
	$insertShareQuery="Insert into tbl_share set dateAdded='".$newShares['dateAdded']."',isin='".$newShares['isin']."',date='".$newShares['date']."',share='".$newShares['share']."', indxx_id='".$NewIndxxId."' ";
	
	$this->db->query($insertShareQuery);
	
	$this->db->query("delete from tbl_share_temp where indxx_id='".$newIndxx['id']."'");

	
	}
	}
	
	
	if(!empty($newIndxx['prices']))
	{
	foreach($newIndxx['prices'] as $k4=> $newPrices)
	{
	$insertPriceQuery="Insert into tbl_final_price set dateAdded='".$newPrices['dateAdded']."',isin='".$newPrices['isin']."',date='".$newPrices['date']."',price='".$newPrices['price']."',currencyfactor='".$newPrices['currencyfactor']."', 	localprice='".$newPrices['localprice']."', indxx_id='".$NewIndxxId."' ";
	
	$this->db->query($insertPriceQuery);
	
	$this->db->query("delete from tbl_final_price_temp where indxx_id='".$newIndxx['id']."' and date='".$newPrices['date']."'");

	
	}
	}
	
	if(!empty($newIndxx['oldindxxvalue']))
	{
	$insertOldindxxvalueQuery="Insert into tbl_indxx_value set dateAdded='".$newIndxx['oldindxxvalue']['dateAdded']."',market_value='".$newIndxx['oldindxxvalue']['market_value']."',indxx_value='".$newIndxx['oldindxxvalue']['indxx_value']."',date='".$newIndxx['oldindxxvalue']['date']."',olddivisor='".$newIndxx['oldindxxvalue']['olddivisor']."', 	newdivisor='".$newIndxx['oldindxxvalue']['newdivisor']."', indxx_id='".$NewIndxxId."' ";
	
	$this->db->query($insertOldindxxvalueQuery);
	
	$this->db->query("delete from tbl_indxx_value_temp where indxx_id='".$newIndxx['id']."' and date='".$newIndxx['oldindxxvalue']['date']."'");
	}
	////Delisting Insert to new
	
		if(!empty($newIndxx['delisting']))
	{
	foreach($newIndxx['delisting'] as $k5=> $newdelist)
	{
	$insertDelistReqQuery="Insert into tbl_delist_runnindex_req set status='".$newdelist['status']."',dateAdded='".$newdelist['dateAdded']."',startdate='".$newdelist['startdate']."', 	adminapprove='".$newdelist['adminapprove']."',dbapprove='".$newdelist['dbapprove']."',user_id='".$newdelist['user_id']."', indxx_id='".$NewIndxxId."' ";
	
	$this->db->query($insertDelistReqQuery);
$newdelistId=mysql_insert_id();




		if(!empty($newdelist['security']))
		{
		foreach($newdelist['security'] as $newDelistSecurity)
		{
		$insertDelistSecQuery="Insert into tbl_delist_runnsecurity set status='".$newDelistSecurity['status']."',dateAdded='".$newDelistSecurity['dateAdded']."',security_id='".$tickerTempArray[$newDelistSecurity['security_id']]."',req_id='".$newdelistId."', indxx_id='".$NewIndxxId."' ";
			$this->db->query($insertDelistSecQuery);
			
			$this->db->query("delete from tbl_delist_tempsecurity where id='".$newDelistSecurity['id']."'");
			
			
		}
		
		}

	$this->db->query("delete from tbl_delist_tempindex_req where indxx_id='".$newIndxx['id']."' and id='".$newdelist['id']."'");
	}
	
	}
	
	
	
	
		if(!empty($newIndxx['replacement']))
	{
	foreach($newIndxx['replacement'] as $k6=> $newReplace)
	{
	$insertReplaceReqQuery="Insert into tbl_replace_runnindex_req set status='".$newReplace['status']."',dateAdded='".$newReplace['dateAdded']."',startdate='".$newReplace['startdate']."', 	adminapprove='".$newReplace['adminapprove']."',dbapprove='".$newReplace['dbapprove']."',user_id='".$newReplace['user_id']."', indxx_id='".$NewIndxxId."' ";
	
	$this->db->query($insertReplaceReqQuery);
$newReplaceId=mysql_insert_id();
		if(!empty($newReplace['selectedsecurity']))
		{
		foreach($newReplace['selectedsecurity'] as $newReplaceSecurity)
		{
		$insertReplaceSecQuery="Insert into tbl_replace_runnsecurity set status='".$newReplaceSecurity['status']."',dateAdded='".$newReplaceSecurity['dateAdded']."',security_id='".$tickerTempArray[$newReplaceSecurity['security_id']]."',req_id='".$newReplaceId."', indxx_id='".$NewIndxxId."' ";
			$this->db->query($insertReplaceSecQuery);
			
			$this->db->query("delete from tbl_replace_tempsecurity where id='".$newReplaceSecurity['id']."'");
		}
		
		}


			if(!empty($newReplace['replacedsecurity']))
		{
		foreach($newReplace['replacedsecurity'] as $newReplacedSecurity)
		{
		$insertReplacedQuery="Insert into tbl_runnsecurities_replaced set status='".$newReplaceSecurity['status']."',dateAdded='".$newReplaceSecurity['dateAdded']."',name='".mysql_real_escape_string($newReplacedSecurity['name'])."',isin='".mysql_real_escape_string($newReplacedSecurity['isin'])."',ticker='".mysql_real_escape_string($newReplacedSecurity['ticker'])."',weight='".mysql_real_escape_string($newReplacedSecurity['weight'])."',curr='".mysql_real_escape_string($newReplacedSecurity['curr'])."',divcurr='".mysql_real_escape_string($newReplacedSecurity['divcurr'])."',sedol='".mysql_real_escape_string($newReplacedSecurity['sedol'])."',cusip='".mysql_real_escape_string($newReplacedSecurity['cusip'])."',countryname='".mysql_real_escape_string($newReplacedSecurity['countryname'])."',req_id='".$newReplaceId."', indxx_id='".$NewIndxxId."' ";
			$this->db->query($insertReplacedQuery);
			
			$this->db->query("delete from tbl_tempsecurities_replaced where id='".$newReplacedSecurity['id']."'");
		}
		
		}
			

	$this->db->query("delete from tbl_replace_tempindex_req where indxx_id='".$newIndxx['id']."' and id='".$newReplace['id']."'");
	}
	
	
	
	
	}
	
	
	
	//$this->pr(	$tickerTempArray);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}
	
	
		
		}
		

	$this->saveProcess(1);
	
	$this->Redirect("index.php?module=calcdelisttemp","","");	
	
	//$this->Redirect("index.php?module=calcindxxopening","","");	
	
	
	
	}
	
}?>