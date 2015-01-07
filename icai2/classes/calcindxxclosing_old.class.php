<?php

class Calcindxxclosing_old extends Application{

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
		$indxxs=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1'",true);	
		//$this->pr($indxxs,true);
		
		$type="close";
		
		 $datevalue=$this->_date;
		
 $datevalue=date("Y-m-d",strtotime($datevalue)-86400);
//$datevalue="2014-04-23";
//$datevalue='2013-12-26';
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
			
			
			
			
			
			
			
			$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
		//	
		$final_array[$row['id']]['client']=$client['ftpusername'];
			
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
			//$this->pr(	$final_array,true);
			
			
			$query="SELECT  it.name,it.isin,it.ticker,curr,sedol,cusip,countryname,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);	
		
		//$this->pr($indxxprices,true);
		
			if(!empty($indxxprices))
			{
			foreach($indxxprices as $key=> $indxxprice)
			{
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
	//echo $datevalue;
	//exit;
if($type=='close')
{	
		  file_put_contents('../files2/backup/preclosedata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			
			if(!$closeIndxx['client'])
			$file="../files2/ca-output/Closing-".$closeIndxx['code']."-".$datevalue.".txt";
			else
			$file="../files2/ca-output/".$closeIndxx['client']."/Closing-".$closeIndxx['code']."-".$datevalue.".txt";
			
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
			if(!empty($closeprices['ca']))
			{
			
				foreach($closeprices['ca'] as $ca_actions)
				{
					if($ca_actions['mnemonic']=='DVD_CASH')
					{
			//			echo $datevalue;
						
					$ca_prices= $this->getCaPrices($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$datevalue);			$dividendPrice+=$ca_prices['ca_price_index_currency'];
				//	echo "<br>";
					}
				
				
				}
				
			}
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
		
		$newindexvalue=number_format(($marketValue/$newDivisor),2,'.','');
		$entry2=$newindexvalue.",\n";
		//echo $entry1.$entry2.$entry3.$entry4;
		//exit;
	$insertQuery='INSERT into tbl_indxx_value (indxx_id,code,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.$marketValue.'","'.$newindexvalue.'","'.$datevalue.'","'.$oldDivisor.'","'.$newDivisor.'")';
		$this->db->query($insertQuery);	
		
		if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{    

$insertlogQuery='INSERT into tbl_indxx_log (type,indxx_id,value) values ("1","'.$closeIndxx['id'].'","'.mysql_real_escape_string($entry1.$entry2.$entry3.$entry4).'")';
		$this->db->query($insertlogQuery);
    fclose($open);
echo "file Writ for ".$closeIndxx['code']."<br>";

}
}  

		
		}
	}
	
	  file_put_contents('../files2/backup/postclosedata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
}



$this->Redirect("index.php?module=calcindxxclosingtemp","","");	

}
   
} 


	
?>