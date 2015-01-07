<?php

class Calcindxxclosingtemp extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		unset($_SESSION);
		//$this->pr($_SESSION);
		
		//$this->_baseTemplate="main-template";
		//$this->_bodyTemplate="404";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		
		if($_GET['id'])
		{
			$page=$_GET['id'];	
		}
		else
		{
			$page=0;	
		}
		
		
		
		$indxxs=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp  where status='1' and usersignoff='1' and dbusersignoff='1' and runindex='1' and submitted='1' limit $page,1 ",true);	
		//$this->pr($indxxs,true);
		
		
			$totalindxxs=$this->db->getResult("select tbl_indxx_temp.id from tbl_indxx_temp  where status='1' and usersignoff='1' and dbusersignoff='1'  and runindex='1'  and submitted='1'",true);
		
		$totalindexes=count($totalindxxs);
		
		$type="close";
		
		 $datevalue=$this->_date;
		
 //$datevalue=date("Y-m-d");
//$datevalue="2014-07-23";
//$datevalue='2014-12-17';
	//
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
			
			$indxx_value=$this->db->getResult("select tbl_indxx_value_open_temp.* from tbl_indxx_value_open_temp where indxx_id='".$row['id']."' order by date desc ",false,1);	
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
			//$this->pr(	$final_array,true);
			
			
			$query="SELECT  it.name,it.isin,it.ticker,curr,sedol,cusip,countryname,(select price from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share_temp sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker_temp` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);	
		
		//$this->pr($indxxprices,true);
		
			if(!empty($indxxprices))
			{
			foreach($indxxprices as $key=> $indxxprice)
			{
				
				$indxx_dp_value=$this->db->getResult("select tbl_dividend_ph_temp.* from tbl_dividend_ph_temp where indxx_id='".$row['id']."' and ticker_id ='".$indxxprice['id']."' ",true);	
if(!empty($indxx_dp_value))
			{
			foreach($indxx_dp_value as $dpvalue)
			{	$final_array[$row['id']]['divpvalue']+=$dpvalue['share']*$dpvalue['dividend'];
			}}				
			$ca_query="select identifier,action_id,id,mnemonic,field_id,company_name,ann_date,eff_date,amd_date,currency from tbl_ca where  eff_date='".$datevalue."' and identifier='".$indxxprice['ticker']."'  and status='1'";
			$cas=$this->db->getResult($ca_query,true);	
			/*if(!empty($cas))
			{
			foreach($cas as $cakey=> $ca)
			{
			$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$ca['id']."'  and ca_action_id='".$ca['action_id']."' ";
			$ca_values=$this->db->getResult($ca_value_query,true);	
			
			$cas[$cakey]['ca_values']=$ca_values;
			}
			}
			*/
			
			//$indxxprices[$key]['ca']=$cas;
			}
			}
			
			$final_array[$row['id']]['values']=$indxxprices;
		
		
		//$this->pr($indxxprices);	
			
			
			}	
		
			}
			
		//}
			}
	//$this->pr($final_array,true);
	
if($type=='close')
{		  //file_put_contents('../files2/backup/preclosetempdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
	
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			
			$file="../files2/ca-output_upcomming/Closing-".strtolower($closeIndxx['code'])."p-".$datevalue.".txt";

			$open=fopen($file,"w+");

			$entry1='Date'.",";
			$entry1.=$datevalue.",\n";
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
			
			if($closeIndxx['display_currency'])
			{$entry3.='CURRENCY'.",";
			$entry3.='CURRENCY FACTOR'.",";
			}$entry4='';
			
			
			//$this->pr($closeIndxx);
			$oldindexvalue=$closeIndxx['index_value']['indxx_value'];
			$newindexvalue=0;
			$oldDivisor=$closeIndxx['index_value']['newdivisor'];
			$newDivisor=$oldDivisor;
			$marketValue=0;
			$sumofDividendes=0;
			
			foreach($closeIndxx['values'] as $closeprices)
			{
			//$this->pr($closeprices);
		
			$shareValue=$closeprices['calcshare'];	
			$securityPrice=$closeprices['calcprice'];
			$localprice=(float)$closeprices['localprice'];
			$dividendPrice=0;
			
			//echo $dividendPrice."<br>";
			$marketValue+=$shareValue*$securityPrice;	
			$sumofDividendes+=$shareValue*$dividendPrice;	
		//	$sumofDividendes;
		//exit;
			
				$entry4.= "\n".date("Ymd",strtotime($datevalue)).",";
            $entry4.=  $closeprices['ticker'].",";
            $entry4.= $closeprices['name'].",";
            $entry4.=$closeprices['isin'].",";;
            $entry4.=$closeprices['sedol'].",";;
            $entry4.=$closeprices['cusip'].",";;
            $entry4.=$closeprices['countryname'].",";
            $entry4.=$closeprices['calcshare'].",";
       		$entry4.=number_format($localprice,2,'.','').",";
			if($closeIndxx['display_currency'])
	     	{$entry4.=$closeprices['curr'].",";
			$entry4.=number_format($closeprices['currencyfactor'],6,'.','').",";
			}

			}
		
	
//echo $closeIndxx['id']."<br>";
		//echo $oldindexvalue;
		//exit;
		//$newDivisor=number_format($oldDivisor-($sumofDividendes/$oldindexvalue),4,'.','');
		
if($closeIndxx['divpvalue'])
{
	
	
	
	$marketValue+=$closeIndxx['divpvalue'];
	 $newindexvalue=number_format((($marketValue)/$newDivisor),2,'.','');
}
else
 {$newindexvalue=number_format(($marketValue/$newDivisor),2,'.','');
 }	//		$newindexvalue=number_format(($marketValue/$newDivisor),4,'.','');
		$entry2=$newindexvalue.",\n";
		
	$insertQuery='INSERT into tbl_indxx_value_temp (indxx_id,code,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.$marketValue.'","'.$newindexvalue.'","'.$datevalue.'","'.$oldDivisor.'","'.$newDivisor.'")';
		$this->db->query($insertQuery);	
		
		if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{  
$insertlogQuery='INSERT into tbl_indxx_temp_log (type,indxx_id,value) values ("1","'.$closeIndxx['id'].'","'.mysql_real_escape_string($entry1.$entry2.$entry3.$entry4).'")';
		$this->db->query($insertlogQuery);	

      fclose($open);
echo "file Writ for ".$closeIndxx['code']."<br>";

}
}  

		
		}
	}
	
	// file_put_contents('../files2/backup/postclosetempdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
}


//$this->saveProcess(2);
if($totalindexes<=$page)
		{
		//echo "Completed";	
		
		$this->saveProcess(2);
		$this->Redirect2("index.php?module=compositclose","","");		
		}
		else
		{
			$this->saveProcess(2);
			$this->Redirect2("index.php?module=calcindxxclosingtemp&event=index&id=".($page+1),"","");	
		}

//$this->Redirect2("index.php?module=compositclose","","");	

}
   
} // class ends here

?>