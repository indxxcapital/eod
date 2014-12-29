<?php

class Calcweight extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{		
		
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		$type="close";
		
		$datevalue=$this->_date;
		
		$datevalue=date("Y-m-d",strtotime($datevalue)-86400);
		
		if($_GET['id'])
		{
			$page=$_GET['id'];	
		}
		else
		{
			$page=0;	
		}
		
		$limit=5;
		
		$indxxs=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' limit $page,5",true);
		
		$totalindxxs=$this->db->getResult("select tbl_indxx.id from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1'",true);
		
		$totalindexes=count($totalindxxs);
		
		
		$final_array=array();
		
		if(!empty($indxxs))
		{
			
			foreach($indxxs as $row)
			{
	//$this->pr($indxx,true);
					
		//if($row['id']==31)
		//{
if($this->checkHoliday($row['zone'],$datevalue)){
				$final_array[$row['id']]=$row;
			
		
			$indxx_value=$this->db->getResult("select tbl_indxx_value_open.* from tbl_indxx_value_open where indxx_id='".$row['id']."' order by date desc ",false,1);	
		//	$this->pr($indxx_value,true);
			if(!empty($indxx_value))
			{
			$final_array[$row['id']]['index_value']=$indxx_value;
			}
			else{
			$final_array[$row['id']]['index_value']['market_value']=$row['investmentammount'];
			$final_array[$row['id']]['index_value']['olddivisor']=$row['divisor'];
			$final_array[$row['id']]['index_value']['newdivisor']=$row['divisor'];
			$final_array[$row['id']]['index_value']['indxx_value']=$row['indexvalue'];
			if($final_array[$row['id']]['index_value']['olddivisor']==0){
			$final_array[$row['id']]['index_value']['olddivisor']=$row['investmentammount']/$row['indexvalue'];
			}
			if($final_array[$row['id']]['index_value']['newdivisor']==0){
			$final_array[$row['id']]['index_value']['newdivisor']=$row['investmentammount']/$row['indexvalue'];
			}


			}
		
			
			$query="SELECT  it.isin,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);	
		
		//$this->pr($indxxprices,true);
		
			
			
			$final_array[$row['id']]['values']=$indxxprices;
		
		
		//$this->pr($indxxprices);	
			
			
			}	
		
			}
			
		//}
			

		}
		
		
		
		if($type=='close')
{	
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			
			$oldDivisor=$closeIndxx['index_value']['newdivisor'];
			$newDivisor=$oldDivisor;
			$marketValue=0;
			$sumofDividendes=0;
			
			foreach($closeIndxx['values'] as $closeprices)
			{
			//$this->pr($closeprices);
		
			$shareValue=$closeprices['calcshare'];	
			$securityPrice=$closeprices['calcprice'];
			$marketValue+=$shareValue*$securityPrice;	
			}
		
			foreach($closeIndxx['values'] as $closeprices)
			{
			$weight=(($closeprices['calcshare']*$closeprices['calcprice'])/$marketValue)*100;
			
			$insertQuery='INSERT into tbl_weights (indxx_id,code,date,share,price,weight,isin) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.$datevalue.'","'.$closeprices['calcshare'].'","'.$closeprices['calcprice'].'","'.$weight.'","'.$closeprices['isin'].'")';
		$this->db->query($insertQuery);	
			}
 
 
		
		}
	}
	
	}
		
		if($totalindexes<=$page)
		{
		//echo "Completed";	
		
		$this->saveProcess(2);
		//$this->Redirect("index.php?module=calcindxxclosingtemp","","");		
		}
		else
		{
			$this->saveProcess(2);
			$this->Redirect2("index.php?module=calcweight&event=index&id=".($page+5),"","");	
		}
		
	}
		
		
   
} 


	
?>