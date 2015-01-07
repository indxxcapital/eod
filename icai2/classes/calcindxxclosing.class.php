<?php

class Calcindxxclosing extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{		
		
		//$this->pr($_SESSION);
		
		//$this->_baseTemplate="main-template";
		//$this->_bodyTemplate="404";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		$type="close";
		
		$datevalue=$this->_date;
		
		//$datevalue="2014-12-22";
		
		if($_GET['id'])
		{
			$page=$_GET['id'];	
		}
		else
		{
			$page=0;	
		}
		
		$limit=5;
		//echo "select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' limit $page,3";
		//exit;
		$indxxs=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1'  and submitted='1' limit $page,1",true);
		
		$totalindxxs=$this->db->getResult("select tbl_indxx.id from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1'",true);
		
		$totalindexes=count($totalindxxs);
		
		
		$final_array=array();
		
		if(!empty($indxxs))
		{
			
			foreach($indxxs as $row)
			{
	//$this->pr($indxxs,true);
					
		//if($row['id']==31)
		//{
if($this->checkHoliday($row['zone'],$datevalue)){
				$final_array[$row['id']]=$row;
			
			
			
			
			
			
			
			$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
		//	
		$final_array[$row['id']]['client']=$client['ftpusername'];
			
			$indxx_value=$this->db->getResult("select tbl_indxx_value_open.* from tbl_indxx_value_open where indxx_id='".$row['id']."' order by date desc ",false,1);	
		//$this->pr($indxx_value,true);
			if(!empty($indxx_value))
			{
			$row['index_value']=$indxx_value;
			}
			else{
			$row['index_value']['market_value']=$row['investmentammount'];
			$row['index_value']['olddivisor']=$row['divisor'];
			$row['index_value']['newdivisor']=$row['divisor'];
			$row['index_value']['indxx_value']=$row['indexvalue'];
			if($final_array[$row['id']]['index_value']['olddivisor']==0){
			$row['index_value']['olddivisor']=$row['investmentammount']/$row['indexvalue'];
			}
			if($final_array[$row['id']]['index_value']['newdivisor']==0){
			$row['index_value']['newdivisor']=$row['investmentammount']/$row['indexvalue'];
			}


			}
			//$this->pr(	$row,true);
			
			//$indxx_value=$this->db->getResult("select tbl_indxx_value_open.* from tbl_indxx_value_open where indxx_id='".$row['id']."' order by date desc ",false,1);	
			
			
		//	$query="SELECT  it.id,it.name,it.isin,it.ticker,curr,sedol,cusip,countryname,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
 	$query="SELECT  it.id,it.name,it.isin,it.ticker,it.curr,it.sedol,it.cusip,it.countryname,fp.localprice,fp.currencyfactor,fp.price as calcprice,sh.share as calcshare FROM `tbl_indxx_ticker` it
left join tbl_final_price fp on fp.isin=it.isin
left join tbl_share sh on sh.isin=it.isin
 where it.indxx_id='".$row['id']."'
 and fp.indxx_id='".$row['id']."'
 and sh.indxx_id='".$row['id']."'
 and fp.date='".$datevalue."' 
  ";		//exit;	
		
		
			$indxxprices=	$this->db->getResult($query,true);	
		
		//$this->pr($indxxprices,true);
		
			if(!empty($indxxprices))
			{
			foreach($indxxprices as $key=> $indxxprice)
			{
				
			$indxx_dp_value=$this->db->getResult("select tbl_dividend_ph.* from tbl_dividend_ph where indxx_id='".$row['id']."' and ticker_id ='".$indxxprice['id']."' ",false,1);	
			if(!empty($indxx_dp_value))
			{
			foreach($indxx_dp_value as $dpvalue)
			{	$row['divpvalue']+=$dpvalue['share']*$dpvalue['dividend'];
			}}
				
				
			
			}
			}
			
			
			
			
			
			if(!$client['ftpusername'])
			$file="../files2/ca-output/Closing-".$row['code']."-".$datevalue.".txt";
			else
			$file="../files2/ca-output/".$client['ftpusername']."/Closing-".$row['code']."-".$datevalue.".txt";
			
			$open=fopen($file,"w+");

			$entry1='Date'.",";
			$entry1.=date("Y-m-d",strtotime($datevalue)).",\n";
			$entry1.='INDEX VALUE'.",";
			$entry3='EFFECTIVE DATE'.",";
			$entry3.='TICKER'.",";
			$entry3.='NAME'.",";
			$entry3.='ISIN'.",";
			$entry3.='SEDOL'.",";
			$entry3.='CUSIP'.",";
			$entry3.='COUNTRY'.",";
			$entry3.='INDEX SHARES'.",";
			$entry3.='PRICE'.",";
			
			if($row['display_currency'])
			{$entry3.='CURRENCY'.",";
			$entry3.='CURRENCY FACTOR'.",";
			}$entry4='';
			
			
			//$this->pr($closeIndxx);
			$oldindexvalue=$row['index_value']['indxx_value'];
			$newindexvalue=0;
			$oldDivisor=$row['index_value']['newdivisor'];
			$newDivisor=$oldDivisor;
			$marketValue=0;
			$sumofDividendes=0;
			
			foreach($indxxprices as $closeprices)
			{
			//$this->pr($closeprices,true);
		
			$shareValue=$closeprices['calcshare'];	
			$securityPrice=$closeprices['calcprice'];
			$localprice=(float)$closeprices['localprice'];
			$dividendPrice=0;
			
			//echo $dividendPrice."<br>";
			$marketValue+=$shareValue*$securityPrice;	
			$sumofDividendes+=$shareValue*$dividendPrice;	
			//echo $marketValue;
		//exit;
			//echo "<br>";
			$entry4.= "\n".date("Ymd",strtotime($datevalue)).",";
            $entry4.=  $closeprices['ticker'].",";
            $entry4.= $closeprices['name'].",";
            $entry4.=$closeprices['isin'].",";;
            $entry4.=$closeprices['sedol'].",";;
            $entry4.=$closeprices['cusip'].",";;
            $entry4.=$closeprices['countryname'].",";
            $entry4.=$closeprices['calcshare'].",";
       		$entry4.=number_format($localprice,2,'.','').",";
			if($row['display_currency'])
	     	{$entry4.=$closeprices['curr'].",";
			$entry4.=number_format($closeprices['currencyfactor'],6,'.','').",";
			}

			}
		
	
//echo $closeIndxx['id']."<br>";
		//echo $oldindexvalue;
		//exit;
		
		//$newDivisor=number_format($oldDivisor-($sumofDividendes/$oldindexvalue),4,'.','');
		
if($row['divpvalue'])
{
	$marketValue+=$row['divpvalue'];
	 $newindexvalue=number_format((($marketValue)/$newDivisor),2,'.','');
}
else
 {$newindexvalue=number_format(($marketValue/$newDivisor),2,'.','');
 }	
 //exit;
 //	$newindexvalue=number_format(($marketValue/$newDivisor),2,'.','');
		$entry2=$newindexvalue.",\n";
		//echo $entry1.$entry2.$entry3.$entry4;
		//exit;
	$insertQuery='INSERT into tbl_indxx_value (indxx_id,code,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$row['id'].'","'.$row['code'].'","'.$marketValue.'","'.$newindexvalue.'","'.$datevalue.'","'.$oldDivisor.'","'.$newDivisor.'")';
		$this->db->query($insertQuery);	
		
		if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{    

$insertlogQuery='INSERT into tbl_indxx_log (type,indxx_id,value) values ("1","'.$row['id'].'","'.mysql_real_escape_string($entry1.$entry2.$entry3.$entry4).'")';
		$this->db->query($insertlogQuery);
    fclose($open);
echo "file Writ for ".$row['code']."<br>";

}
}  

		
		
			
			//$final_array[$row['id']]['values']=$indxxprices;
		
		
		//$this->pr($indxxprices);	
			
			
			}	
		
			}
			
		//}
			

		}
		
		
		//$this->pr($final_array,true);

		
		if($totalindexes<=$page)
		{
		//echo "Completed";	
		
		$this->saveProcess(2);
		$this->Redirect2("index.php?module=calcindxxclosingtemp","","");		
		}
		else
		{
			$this->saveProcess(2);
			$this->Redirect2("index.php?module=calcindxxclosing&event=index&id=".($page+1),"","");	
		}
		
	}
		
		
   
} 


	
?>