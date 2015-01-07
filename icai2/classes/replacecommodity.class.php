<?php

class Replacecommodity extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		$date=$this->_date;
		//$date="2014-04-24";
	$finalArray=array();
	
			$indexdata=$this->db->getResult("select * from tbl_commodity_indxx_temp where datestart='".$date."'",true);
			//$this->pr($indexdata);
	
if(!empty($indexdata))
{
foreach($indexdata as $key=>$index)
{

$finalArray[$index['id']]=$index;
	$indextickers=$this->db->getResult("select * from tbl_commodity_indxx_ticker_temp where indxx_id='".$index['id']."'",true);
	$finalArray[$index['id']]['tickers']=$indextickers;
}	

}	
	
	$newData=array();
	if(!empty($finalArray))
	{
		  file_put_contents('../files2/backup/preReplaceCommoditydata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
	
		foreach($finalArray as $key=>$index)
		{
			
				$runningindexdata=$this->db->getResult("select * from tbl_commodity_indxx where code='".$index['code']."'",false,1);
			
			if(!empty($runningindexdata))
			{
				//echo "dont ";
				$newData[$key]=$runningindexdata;
				$runningTickers=$this->db->getResult("select * from tbl_commodity_indxx_ticker where indxx_id='".$runningindexdata['id']."'");;
				$newData[$key]['tickers']=$runningTickers;
				
				$this->db->query("delete from tbl_commodity_indxx where id='".$runningindexdata['id']."' ");
				
				$this->db->query("delete from tbl_commodity_indxx_ticker where indxx_id='".$runningindexdata['id']."' ");
				
				
		$this->db->query("Insert into tbl_commodity_indxx set name='".mysql_real_escape_string($index['name'])."' , code='".mysql_real_escape_string($index['code'])."' , zone='".mysql_real_escape_string($index['zone'])."' , client_id='".mysql_real_escape_string($index['client_id'])."' , datestart='".mysql_real_escape_string($index['datestart'])."' , user_id='".mysql_real_escape_string($index['user_id'])."',status='1'");
			
			$insertedId=mysql_insert_id();
			if(!empty($index['tickers']))
			{
			foreach($index['tickers'] as $ticker)
			{
				$this->db->query("Insert into tbl_commodity_indxx_ticker set weight='".mysql_real_escape_string($ticker['weight'])."' ,ticker_id='".mysql_real_escape_string($ticker['ticker_id'])."' ,indxx_id='".mysql_real_escape_string($insertedId)."',status='1' ");
			
			}
			}
			
			$this->db->query("delete from tbl_commodity_indxx_temp where id='".$index['id']."' ");
				
			$this->db->query("delete from tbl_commodity_indxx_ticker_temp where indxx_id='".$index['id']."' ");
			
				
				
			}
			else{
			//echo "do";	
			$this->db->query("Insert into tbl_commodity_indxx set name='".mysql_real_escape_string($index['name'])."' , code='".mysql_real_escape_string($index['code'])."' , zone='".mysql_real_escape_string($index['zone'])."' , client_id='".mysql_real_escape_string($index['client_id'])."' , datestart='".mysql_real_escape_string($index['datestart'])."' , user_id='".mysql_real_escape_string($index['user_id'])."',status='1'");
			
			$insertedId=mysql_insert_id();
			if(!empty($index['tickers']))
			{
			foreach($index['tickers'] as $ticker)
			{
				$this->db->query("Insert into tbl_commodity_indxx_ticker set weight='".mysql_real_escape_string($ticker['weight'])."' ,ticker_id='".mysql_real_escape_string($ticker['ticker_id'])."' ,indxx_id='".mysql_real_escape_string($insertedId)."',status='1' ");
			
			}
			}
			
			$this->db->query("delete from tbl_commodity_indxx_temp where id='".$index['id']."' ");
				
			$this->db->query("delete from tbl_commodity_indxx_ticker_temp where indxx_id='".$index['id']."' ");
				
			
			}
			
			
			
		//$livedata=$this->db->getResult("select * from tbl_commodity_indxx where code='".$index['code']."'");
		//if
		
		}
	  file_put_contents('../files2/backup/postReplaceCommoditydata'.date("Y-m-d-H-i-s").'.json', json_encode($newData));		
	}
	$this->saveProcess(3);
	$this->Redirect("index.php?module=calccomodity","","");	

//	$this->pr($finalArray);	
	}
}
?>