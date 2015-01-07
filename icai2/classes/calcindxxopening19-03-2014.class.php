<?php

class Calcindxxopening extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		
	//	$this->pr($_SESSION,true);
		
		//$this->_baseTemplate="main-template";
		//$this->_bodyTemplate="404";
		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;
		
		//echo "select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1 and id='1'";
		$indxxs=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' ",true);	
		
		
		//$this->pr($indxxs,true);
		$type="open";
		
		 $datevalue2=$this->_date;
//	exit;
	
	//	 $datevalue='';
//$datevalue2='2014-03-10';
//if(date('D')!="Mon")
// $datevalue=date("Y-m-d",strtotime($this->_date)-86400);
//else
// $datevalue=date("Y-m-d",strtotime($this->_date)-86400*3);

		//exit;
		//
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
			$query="SELECT  it.name,it.isin,it.ticker,curr,divcurr,curr,sedol,cusip,countryname,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);
			//$this->pr($indxxprices,true);	
			if(!empty($indxxprices))
			{
			foreach($indxxprices as $key=> $indxxprice)
			{
			$ca_query="select identifier,action_id,id,mnemonic,field_id,company_name,ann_date,eff_date,amd_date,currency from tbl_ca where  eff_date='".$datevalue2."' and identifier='".$indxxprice['ticker']."'  and status='1'";
			$cas=$this->db->getResult($ca_query,true);	
			
			//$caflag=false;
			
			
			if(!empty($cas))
			{
			foreach($cas as $cakey=> $ca)
			{
			
			
			
			$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$ca['id']."'  and ca_action_id='".$ca['action_id']."' ";
			$ca_values=$this->db->getResult($ca_value_query,true);	
			
//			if($row['ireturn']==1 && $ca['mnemonic'] )
			$value=0;
			if(!empty($ca_values) )
			{
			foreach($ca_values as $ca_value)
			{
			if($ca_value['field_name']=='CP_DVD_TYP')
			{
			$value=$ca_value['field_value'];
			}
			}
			}
		//	echo $value;
if($row['ireturn']==1 && $ca['mnemonic']=='DVD_CASH' && $value==1000 )
			{
			$cas[$cakey]=array();
			}
			else{
			$cas[$cakey]['ca_values']=$ca_values;
			}
			
			}
			}
			
			
			$indxxprices[$key]['ca']=$cas;
			}
			}
			
			$final_array[$row['id']]['values']=$indxxprices;
		
		
		//$this->pr($indxxprices);	
			
					}
			}	
		
		}
	//	}
	
//$this->pr($final_array,true);
	
	
if($type="open"){
	
	  file_put_contents('../files/backup/preopendata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
	 // exit;
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			$oldindexvalue=$closeIndxx['index_value']['indxx_value'];
			$newindexvalue=0;
		 $oldDivisor=$closeIndxx['index_value']['olddivisor'];
		//echo "<br>";
		$final_array[$indxxKey]['index_value']['divisor_impact']=0;
	//$newDivisor=$oldDivisor;
			$oldmarketValue=0;
			$newmarketValue=0;
			$sumofDividendes=0;
			$divisorAdjustinStock=$closeIndxx['cash_adjust'];
	///	exit;	
		
			
			
			foreach($closeIndxx['values'] as $securityKey=> $closeprices)
			{
				
			$divisorImpact=0;
			
			$priceAdjfactor=1;
			$shareAdjfactor=1;
			
			//$this->pr($closeprices);	
			if(!empty($closeprices['ca']))
			{
				foreach($closeprices['ca'] as $ca_key=> $ca_actions)
				{
					$final_array[$indxxKey]['values'][$securityKey]['ca'][$ca_key]['ca_values']=	$this->getCa($ca_actions['id'],$ca_actions['action_id']);
					if($ca_actions['mnemonic']=='STOCK_SPLT')
					{
						$adjfactor=	$this->getAdjFactorforSplit($ca_actions['id'],$ca_actions['action_id']);
						$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']*$adjfactor);
						$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']/$adjfactor);
						
						$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
						$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					
					}
						if($ca_actions['mnemonic']=='DVD_STOCK')
					{
			
						$adjfactor=	$this->getAdjFactorforDvdStock($ca_actions['id'],$ca_actions['action_id']);
						$adjfactor=($adjfactor/100)+1;
						$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']*$adjfactor);
						$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']/$adjfactor);
						
						$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
						$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					}
					
					if($ca_actions['mnemonic']=='SPIN')
					{
			
					$adjfactorSpin=	$this->getAdjFactorforSpin($ca_actions['id'],$ca_actions['action_id']);
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']/$adjfactorSpin);
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']*$adjfactorSpin);
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
						
		
					}
					
					
					
					
					if($ca_actions['mnemonic']=='RIGHTS_OFFER')
					{
						
				//	$oldDivisorTemp=$newDivisor;
						
						$cp_ratio=	$this->getcpratio($ca_actions['id'],$ca_actions['action_id']);
						$cp_adj=	$this->getAdjFactorforSpin($ca_actions['id'],$ca_actions['action_id']);
					$offerpricesArray=	$this->getOfferPrices($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$closeIndxx['index_value']['date']);	
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=((1+$cp_ratio)*$closeprices['calcshare']*$cp_adj);
					$z=($closeprices['calcshare']*$closeprices['calcprice'])+($closeprices['calcshare']*$cp_ratio*$offerpricesArray['op_price_index_currency']);
		$c=$closeprices['calcshare']+($closeprices['calcshare']*$cp_ratio);
	// ($z/$c);
		$offerprices=$z/$c;
		
				$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$offerprices;
				$newDivisor=$oldDivisor+((($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']*$final_array[$indxxKey]['values'][$securityKey]['newcalcprice'])-($closeprices['calcshare']*$closeprices['calcprice']))/$oldindexvalue);
			
			
			
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
			
					$divisorImpact=$newDivisor-$oldDivisor;
		
					
					
					}
					if($ca_actions['mnemonic']=='DVD_CASH')
					{
					$ca_prices= $this->getCaPrices($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$closeIndxx['index_value']['date']);	
//$this->pr($ca_prices);
					
					if($divisorAdjustinStock)
					{
					//	echo $closeprices['calcprice']-$ca_prices['ca_price_in_ca_currency'];
					//	exit;
						
					 $newfactor=($closeprices['calcprice']-$ca_prices['ca_price_in_ca_currency'])/$closeprices['calcprice'];
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare']/$newfactor;
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']*$newfactor;
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					
					}
					elseif($ca_prices['CP_DVD_TYP']=='1001')
					{
					$adjfactorforcash=$ca_prices['CP_ADJ'];
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare']/$adjfactorforcash;
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']*$adjfactorforcash;
					
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					
					}else{
						
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']-$ca_prices['ca_price_in_ca_currency'];
										
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);
					$newDivisor=$oldDivisor-(($closeprices['calcshare']*$ca_prices['ca_price_in_ca_currency'])/$oldindexvalue);
					$divisorImpact=$newDivisor-$oldDivisor;
					}
					
					
					
					
					}
					
					
					if($ca_actions['mnemonic']=='CHG_ID')
					{
						$oldisin=	$this->getoldISIN($ca_actions['id'],$ca_actions['action_id']);
						$newisin=	$this->getnewISIN($ca_actions['id'],$ca_actions['action_id']);
						
					}
					if($ca_actions['mnemonic']=='CHG_NAME')
					{
				
						$oldname=	$this->getoldName($ca_actions['id'],$ca_actions['action_id']);
						$newname=	$this->getnewName($ca_actions['id'],$ca_actions['action_id']);
						 $nametickerUpdateQuery='UPDATE  tbl_indxx_ticker  set name ="'.$newname.'" where indxx_id="'.$indxxKey.'"  and isin="'.			$final_array[$indxxKey]['values'][$securityKey]['isin'].'"'; 
				 $this->db->query($nametickerUpdateQuery);	
					$final_array[$indxxKey]['values'][$securityKey]['name']=$newname;
					}
					
					
				}
			}
			
			$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']*$priceAdjfactor;
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=$closeprices['localprice']*$priceAdjfactor;
			$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare']*$shareAdjfactor;
			if($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']!=$closeprices['calcshare'])
			{
			$shareUpdateQuery='UPDATE  tbl_share  set share ="'.$final_array[$indxxKey]['values'][$securityKey]['newcalcshare'].'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"';
			$this->db->query($shareUpdateQuery);
			}
			
			
			if($oldisin!='' && $newisin!=''){
				if($closeprices['isin']==$oldisin)
				{
				  $isinUpdateQuery='UPDATE  tbl_share  set isin ="'.$newisin.'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 				$this->db->query($isinUpdateQuery);	
				  $isintickerUpdateQuery='UPDATE  tbl_indxx_ticker  set isin ="'.$newisin.'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 
			$this->db->query($isintickerUpdateQuery);	

				
				
				
					$final_array[$indxxKey]['values'][$securityKey]['isin']=$newisin;
		//			$final_array[$indxxKey]['values'][$securityKey]['newisin']=$newisin;
				
				
				}
				else{
				echo "Not Equal";
				}
			}
			
			
			 $final_array[$indxxKey]['index_value']['divisor_impact']+=	$divisorImpact;;
			 	//echo "<br>";	
			}
			
	
			}
		
		
		
		}
	 file_put_contents('../files/backup/postopendata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));	
	}
		//$this->pr($final_array,true);
	if(!empty($final_array))
	{
		foreach($final_array as $key=>$closeIndxx)
		{
			if(!$closeIndxx['client'])
			$file="../files/ca-output/opening-".$closeIndxx['code']."-".$datevalue2.".txt";
			else
			$file="../files/ca-output/".$closeIndxx['client']."/opening-".$closeIndxx['code']."-".$datevalue2.".txt";
			
			$open=fopen($file,"w+");

			$entry1='Date'.",";
			$entry1.=date("Y-m-d",strtotime($datevalue2)).",\r\n";
			$entry1.='INDEX VALUE'.",";
			$entry3='EFFECTIVE DATE'.",";
			$entry3.='TICKER'.",";
			$entry3.='NAME'.",";
			$entry3.='ISIN'.",";
			$entry3.='SEDOL'.",";
			$entry3.='CUSIP'.",";
			$entry3.='COUNTRY NAME'.",";
			$entry3.='INDEX SHARES'.",";
			$entry3.='PRICE'.",";
			if($closeIndxx['display_currency'])
			{$entry3.='CURRENCY'.",";
			$entry3.='CURRENCY FACTOR'.",";
			}$entry4='';
					
		
		
		
		
		$newMarketValue=0;
		if(!empty($closeIndxx))
		{
		foreach($closeIndxx['values'] as $security)
		{
		//$this->pr($security);
			
		$newMarketValue+=$security['newcalcprice']*$security['newcalcshare'];



			$entry4.= "\r\n".date("Ymd",strtotime($datevalue2)).",";
            $entry4.=  $security['ticker'].",";
            $entry4.= $security['name'].",";
            $entry4.=$security['isin'].","; 
			 $entry4.=$security['sedol'].",";;
            $entry4.=$security['cusip'].",";;
            $entry4.=$security['countryname'].",";
		    $entry4.=$security['newcalcshare'].",";
       		$entry4.=($security['newlocalprice']).",";
			if($closeIndxx['display_currency'])
	     	{$entry4.=$security['curr'].",";
			$entry4.=$security['currencyfactor'].",";
			}			

		}
		}
		//echo $closeIndxx['index_value']['divisor_impact'];
		//echo "<br>";
		 $newDivisorforindxx=$closeIndxx['index_value']['olddivisor']+$closeIndxx['index_value']['divisor_impact'];
		//echo "<br>";
	//	 $closeIndxx['index_value']['indxx_value']."<br>";
//		 $newMarketValue/$closeIndxx['index_value']['newdivisor'];
		  $newindexvalue=number_format(($newMarketValue/$newDivisorforindxx),4,'.','');
		  	$insertQuery='INSERT into tbl_indxx_value_open (indxx_id,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$closeIndxx['id'].'","'.$newMarketValue.'","'.$newindexvalue.'","'.$datevalue2.'","'.$closeIndxx['index_value']['olddivisor'].'","'.$newDivisorforindxx.'")';
		$this->db->query($insertQuery);	
		
			$entry2=$newindexvalue.",\r\n";
			
			//echo $entry1.$entry2.$entry3.$entry4;
			//exit;
			
if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{
	
	
$insertlogQuery='INSERT into tbl_indxx_log (type,indxx_id,value) values ("0","'.$closeIndxx['id'].'","'.mysql_real_escape_string($entry1.$entry2.$entry3.$entry4).'")';
		$this->db->query($insertlogQuery);
	
 fclose($open);
$filetext= "file Written for ".$closeIndxx['code']."<br>";

}
}  
		
		
		}
	}
	
	
	
	
	
	
	





$this->Redirect("index.php?module=calcindxxopeningtemp","","");	

}
   
} 
?>