<?php

class Calcindxxopeningcheck extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		$type="open";
		
		 $datevalue2=$this->_date;
		//$datevalue2="2014-08-06";
		//exit;
		if($_GET['id'])
		{
			$page=$_GET['id'];	
		}
		else
		{
			$page=0;	
		}
		
		$limit=88;
		
		
		//echo $_SESSION['currentPriority']['priority'];
		//exit;
		// and priority='".$_SESSION['currentPriority']['priority']."'
		
		$indxxs=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' limit  $page,$limit",true);
		
		$totalindxxs=$this->db->getResult("select tbl_indxx.id from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1'    and submitted='1'",true);
		
		$totalindexes=count($totalindxxs);
		//exit;
		$final_array=array();
		
		if(!empty($indxxs))
		{
		
			foreach($indxxs as $row)
			{
			
	//$this->pr($indxx);
			
		//	if($row['id']==31)
		//{
					if($this->checkHoliday($row['zone'], $datevalue2)){
			$final_array[$row['id']]=$row;
			

			$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
		//	
		$final_array[$row['id']]['client']=$client['ftpusername'];
			
			$indxx_value=$this->db->getResult("select tbl_indxx_value.* from tbl_indxx_value where indxx_id='".$row['id']."' order by date desc ",false,1);	
			//$this->pr($indxx_value,true);
			
			
			
			
			if(!empty($indxx_value))
			{
			$final_array[$row['id']]['index_value']=$indxx_value;
			$datevalue=$indxx_value['date'];
			}
			else{
			$final_array[$row['id']]['index_value']['market_value']=$row['investmentammount'];
			$final_array[$row['id']]['index_value']['olddivisor']=$row['divisor'];
			$final_array[$row['id']]['index_value']['newdivisor']=$row['divisor'];
			$final_array[$row['id']]['index_value']['indxx_value']=$row['investmentammount']/$row['divisor'];
		//	$final_array[$row['id']]['index_value']['date']='2014-01-10';
				//$datevalue="2014-01-10";
			}
			
			
			//echo $datevalue;
		//	exit;
		//	$query="SELECT  it.id,it.name,it.isin,it.ticker,curr,divcurr,curr,sedol,cusip,countryname,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
		
		 $query="SELECT  it.id,it.name,it.isin,it.ticker,it.curr,it.sedol,it.cusip,it.countryname,fp.localprice,fp.currencyfactor,fp.price as calcprice,sh.share as calcshare FROM `tbl_indxx_ticker` it
left join tbl_final_price fp on fp.isin=it.isin
left join tbl_share sh on sh.isin=it.isin
 where it.indxx_id='".$row['id']."'
 and fp.indxx_id='".$row['id']."'
 and sh.indxx_id='".$row['id']."'
 and fp.date='".$datevalue."' 
  ";		
		$query1="select count(id) as count1 from tbl_indxx_ticker where indxx_id='".$row['id']."'  ";
		$query2="select count(id) as count2 from tbl_final_price where indxx_id='".$row['id']."' and date='".$datevalue."' ";
		$query3="select count(id) as count3 from tbl_share where indxx_id='".$row['id']."'  ";
		
			$data1=$this->db->getResult($query1,false);
			$data2=$this->db->getResult($query2,false);
			$data3=$this->db->getResult($query3,false);
			echo $row['id']."=>".$data1['count1']."=>".$data2['count2']."=>".$data3['count3']."<br>";
						//$indxxprices=	$this->db->getResult($query,true);
			// $row['id'];
			
			$this->pr($indxxprices);	
		/*	if(!empty($indxxprices))
			{
			foreach($indxxprices as $tickers)
			{
			if(!$tickers['calcshare'] || !$tickers['price'])
			{$this->pr($tickers);
			}
			}
			
				}*/
			
			//$final_array[$row['id']]['values']=$indxxprices;
		
		
		//$this->pr($indxxprices);	
			
					}
			}	
		
		
		//	$this->pr($final_array,true);
	
			//exit;
			
//$this->pr($final_array,true);

		
		}
		//echo $totalindexes."=>".$page;
		//exit;
		
		
	}
	
	
   
} 
?>