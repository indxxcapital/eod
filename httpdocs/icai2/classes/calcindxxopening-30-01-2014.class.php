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
		
		// 
		$indxxs=$this->db->getResult("select tbl_indxx.* from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1'",true);	
		
		//$this->pr($indxxs,true);
		$type="open";
		
		 $datevalue2=$this->_date;
//	exit;
	
	//	 $datevalue='';
//$datevalue2='2014-01-27';
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
			$query="SELECT  it.name,it.isin,it.ticker,curr,divcurr,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);
			//$this->pr($indxxprices,true);	
			if(!empty($indxxprices))
			{
			foreach($indxxprices as $key=> $indxxprice)
			{
			$ca_query="select identifier,action_id,id,mnemonic,field_id,company_name,ann_date,eff_date,amd_date,currency from tbl_ca where  eff_date='".$datevalue2."' and identifier='".$indxxprice['ticker']."'  and status='1'";
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
	
if($type=='close')
{	
	
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			
			$file="../fils/ca-output/closing-".$closeIndxx['code']."-".$datevalue.".txt";

			$open=fopen($file,"w+");

			$entry1='Date'.",";
			$entry1.=$datevalue.",\n";
			$entry1.='INDEX VALUE'.",";
			$entry3='EFFECTIVE DATE'.",";
			$entry3.='TICKER'.",";
			$entry3.='NAME'.",";
			$entry3.='ISIN'.",";
			$entry3.='INDEX SHARES'.",";
			$entry3.='PRICE'.",";
			$entry3.='CURRENCY FACTOR'.",";
			$entry4='';
			
			
			//$this->pr($closeIndxx);
			$oldindexvalue=$closeIndxx['index_value']['indxx_value'];
			$newindexvalue=0;
			$oldDivisor=$closeIndxx['index_value']['newdivisor'];
			$newDivisor=0;
			$marketValue=0;
			$sumofDividendes=0;
			
			foreach($closeIndxx['values'] as $closeprices)
			{
			//$this->pr($closeprices);
		
			$shareValue=$closeprices['calcshare'];	
			$securityPrice=$closeprices['calcprice'];
			
			$dividendPrice=0;
			if(!empty($closeprices['ca']))
			{
			
				foreach($closeprices['ca'] as $ca_actions)
				{
					if($ca_actions['mnemonic']=='DVD_CASH')
					{
					$ca_prices= $this->getCaPrices($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$datevalue);			$dividendPrice+=$ca_prices['ca_price_index_currency'];
				//	echo "<br>";
				
				
				
					}
				
				
				}
				
			}
			//echo $dividendPrice."<br>";
			$marketValue+=$shareValue*$securityPrice;	
			$sumofDividendes+=$shareValue*$dividendPrice;	
			
			
			$entry4.= "\n".$datevalue.",";
            $entry4.=  $closeprices['ticker'].",";
            $entry4.= $closeprices['name'].",";
            $entry4.=$closeprices['isin'].",";
            $entry4.=$closeprices['calcshare'].",";
       		$entry4.=$closeprices['localprice'].",";
	     	$entry4.=$closeprices['currencyfactor'].",";
			

			}
		
		
		 $newDivisor=number_format($oldDivisor-($sumofDividendes/$oldindexvalue),4,'.','');
		
		$newindexvalue=number_format(($marketValue/$newDivisor),4,'.','');
		$entry2=$newindexvalue.",\n";
		
		$insertQuery='INSERT into tbl_indxx_value (indxx_id,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$row['id'].'","'.$marketValue.'","'.$newindexvalue.'","'.$datevalue.'","'.$oldDivisor.'","'.$newDivisor.'")';
		$this->db->query($insertQuery);	
		//echo $marketValue."=>".$sumofDividendes;
		//$indexvalue=$marketValue/$oldDivisor;
		if($open){        
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{        fclose($open);
echo "file Writ for ".$row['code']."<br>";

}
}  
	
		
		}
	}
	
	
}
elseif($type="open"){
	
	
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			
			/*$file="../files/ca-output_upcomming/opening-".$closeIndxx['code']."-".$closeIndxx['dateStart']."-".$datevalue2.".txt";

			$open=fopen($file,"w+");

			$entry1='Date'.",";
			$entry1.=$datevalue2.",\n";
			$entry1.='INDEX VALUE'.",";
			$entry3='EFFECTIVE DATE'.",";
			$entry3.='TICKER'.",";
			$entry3.='NAME'.",";
			$entry3.='ISIN'.",";
			$entry3.='INDEX SHARES'.",";
			$entry3.='PRICE'.",";
			$entry3.='CURRENCY FACTOR'.",";
			$entry4='';*/
			
			
			//$this->pr($closeIndxx);
			$oldindexvalue=$closeIndxx['index_value']['indxx_value'];
			$newindexvalue=0;
			//$oldDivisor=$closeIndxx['index_value']['newdivisor'];
			$newDivisor=0;
			$oldmarketValue=0;
			$newmarketValue=0;
			$sumofDividendes=0;
			$divisorAdjustinStock=$closeIndxx['cash_adjust'];
	///	exit;	
			
			
			
			foreach($closeIndxx['values'] as $securityKey=> $closeprices)
			{
		//$this->pr($closeprices);
		
			$shareValue=$closeprices['calcshare'];	
			$securityPrice=$closeprices['calcprice'];
			
			$dividendPrice=0;
			$dividendAmmount=0;
			$dividendPrice2=0;
			$dividendAmmount2=0;
			$adjfactor=0;
			$adjfactorforcash=0;
			$adjfactorSpin=0;
			$cp_ratio=0;
			$cp_adj=0;
			$offerprices=0;
			$offerpricesArray=0;
			$oldisin='';
			$newisin='';
			$oldname='';
			$newname='';
			
			
			//echo $closeIndxx['index_value']['date'];
			//exit;
			if(!empty($closeprices['ca']))
			{
			
				foreach($closeprices['ca'] as $ca_key=> $ca_actions)
				{
					////Adj factor calculation////
					
					
				$final_array[$indxxKey]['values'][$securityKey]['ca'][$ca_key]['ca_values']=	$this->getCa($ca_actions['id'],$ca_actions['action_id']);
					
					
					
					if($ca_actions['mnemonic']=='RIGHTS_OFFER')
					{
				//	echo "in rights offer";
				//	exit;
				
						$cp_ratio=	$this->getcpratio($ca_actions['id'],$ca_actions['action_id']);
						$cp_adj=	$this->getAdjFactorforSpin($ca_actions['id'],$ca_actions['action_id']);
					$offerpricesArray=	$this->getOfferPrices($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$closeIndxx['index_value']['date']);	
					
				//	$this->pr($offerpricesArray,true);
					
					}
					
					if($ca_actions['mnemonic']=='CHG_ID')
					{
				//	echo "in Split";
				//	exit;
				
						$oldisin=	$this->getoldISIN($ca_actions['id'],$ca_actions['action_id']);
						$newisin=	$this->getnewISIN($ca_actions['id'],$ca_actions['action_id']);
						
					//	$final_array[$indxxKey]['values'][$securityKey]['oldisin']=$oldisin;
					//	$final_array[$indxxKey]['values'][$securityKey]['newisin']=$newisin;
					}
					if($ca_actions['mnemonic']=='CHG_NAME')
					{
				//	echo "in Split";
				//	exit;
				
						$oldname=	$this->getoldName($ca_actions['id'],$ca_actions['action_id']);
						$newname=	$this->getnewName($ca_actions['id'],$ca_actions['action_id']);
						
					//	$final_array[$indxxKey]['values'][$securityKey]['oldisin']=$oldisin;
					//	$final_array[$indxxKey]['values'][$securityKey]['newisin']=$newisin;
					}
					
					if($ca_actions['mnemonic']=='STOCK_SPLT')
					{
				//	echo "in Split";
				//	exit;
				
						$adjfactor=	$this->getAdjFactorforSplit($ca_actions['id'],$ca_actions['action_id']);
		
					}
					if($ca_actions['mnemonic']=='DVD_STOCK')
					{
				//	echo "in dvd Stock";
				//	exit;
				
						$adjfactor=	$this->getAdjFactorforDvdStock($ca_actions['id'],$ca_actions['action_id']);
						$adjfactor=($adjfactor/100)+1;
		
					}
					
					if($ca_actions['mnemonic']=='SPIN')
					{
				//	echo "in dvd Stock";
				//	exit;
				
						$adjfactorSpin=	$this->getAdjFactorforSpin($ca_actions['id'],$ca_actions['action_id']);
						//$adjfactor=($adjfactor/100)+1;
		
					}
					
					if($ca_actions['mnemonic']=='DVD_CASH')
					{
					$ca_prices= $this->getCaPrices($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$closeIndxx['index_value']['date']);	
//$this->pr($ca_prices);
				
					$dividendAmmount+=$ca_prices['ca_value_local_price'];
					$dividendPrice+=$ca_prices['ca_price_in_ca_currency'];
				//	echo "<br>";
					if($ca_prices['CP_DVD_TYP']=='1001')
					{
					$dividendAmmount2+=$ca_prices['ca_value_local_price'];
					$dividendPrice2+=$ca_prices['ca_price_in_ca_currency'];
					$adjfactorforcash=$ca_prices['CP_ADJ'];
					}
					
					
					}
				
				
				}
				
			}
			//echo $closeprices['ticker']."=>".$dividendPrice2."=>".$dividendAmmount2."<br>";
			
			//echo  $closeprices['ticker']."=>".$cp_ratio."=>".$cp_adj."<br>";
			
			if($dividendAmmount2){
			$final_array[$indxxKey]['values'][$securityKey]['cashdividend']=$dividendPrice;
			$final_array[$indxxKey]['values'][$securityKey]['cashdividendlocal']=$dividendAmmount;
			$final_array[$indxxKey]['values'][$securityKey]['cashdividendSC']=$dividendPrice-$dividendPrice2;
			$final_array[$indxxKey]['values'][$securityKey]['cashdividendlocalSC']=$dividendAmmount-$dividendAmmount2;
			$final_array[$indxxKey]['values'][$securityKey]['adjfactorforcash']=$adjfactorforcash;
			
			}else{
			$final_array[$indxxKey]['values'][$securityKey]['cashdividend']=$dividendPrice;
			$final_array[$indxxKey]['values'][$securityKey]['cashdividendlocal']=$dividendAmmount;
			}//	$oldmarketValue+=$shareValue*$oldsecurityPrice;	
			//$sumofDividendes+=$shareValue*$dividendPrice;	
			//echo $sumofDividendes;
			//echo "<br>";
			
			
			if($cp_ratio && $cp_adj && !empty($offerpricesArray))
			{
			$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=((1+$cp_ratio)*$closeprices['calcshare']*$cp_adj);
			$final_array[$indxxKey]['values'][$securityKey]['isRightIsshue']=1;
			//echo $closeprices['calcshare']*$cp_ratio*$offerpricesArray['op_price_index_currency'];
			//exit;
		$z=($closeprices['calcshare']*$closeprices['calcprice'])+($closeprices['calcshare']*$cp_ratio*$offerpricesArray['op_price_index_currency']);
		$c=$closeprices['calcshare']+($closeprices['calcshare']*$cp_ratio);
	// ($z/$c);
		$offerprices=$z/$c;
		
			$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$offerprices;
			//$closeprices['newlocalprice']=number_format(($closeprices['localprice']*$adjfactorSpin),2,'.','');
		
		if($final_array[$indxxKey]['curr']!=$closeprices['divcurr'])
	{	$cfactor=$this->getPriceforCurrency($final_array[$indxxKey]['curr'],$closeprices['divcurr'],$closeIndxx['index_value']['date'],'','');
		//	echo $cfactor;
			
			if(strcmp(strtoupper($final_array[$indxxKey]['curr'].$closeprices['divcurr']),$final_array[$indxxKey]['curr'].$closeprices['divcurr'])==0){
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=$offerprices*$cfactor;
			}else{
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=($offerprices*$cfactor)/100;
			
			}
	}else{
	$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=$offerprices;
	}
			
			//$this->pr($offerpricesArray);
		//$this->pr($closeprices,true);
			
			$shareUpdateQuery='UPDATE  tbl_share  set share ="'.$final_array[$indxxKey]['values'][$securityKey]['newcalcshare'].'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 
			$this->db->query($shareUpdateQuery);	
			
			}
			
			
			
			if($adjfactorSpin)
			{
			$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']/$adjfactorSpin);
			$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']*$adjfactorSpin);
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=($closeprices['localprice']*$adjfactorSpin);
			//$this->pr($closeprices,true);
			$shareUpdateQuery='UPDATE  tbl_share  set share ="'.$final_array[$indxxKey]['values'][$securityKey]['newcalcshare'].'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 
		$this->db->query($shareUpdateQuery);	
			
			}
			if($adjfactor)
			{
				//echo "Adjustment Required";	
			//exit;
		//	$this->pr($closeprices,true);
			$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']*$adjfactor);
			$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']/$adjfactor);
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=($closeprices['localprice']/$adjfactor);
			//$this->pr($closeprices,true);
			$shareUpdateQuery='UPDATE  tbl_share  set share ="'.$final_array[$indxxKey]['values'][$securityKey]['newcalcshare'].'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 
$this->db->query($shareUpdateQuery);	
			
			}
			
			if($oldisin && $newisin)
			{
				
				if($closeprices['isin']==$oldisin)
				{
				//echo "Got It";
				
				  $isinUpdateQuery='UPDATE  tbl_share  set isin ="'.$newisin.'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 
			$this->db->query($isinUpdateQuery);	

				
			 $isintickerUpdateQuery='UPDATE  tbl_indxx_ticker  set isin ="'.$newisin.'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 
				$this->db->query($isintickerUpdateQuery);	

				
				
				
					$final_array[$indxxKey]['values'][$securityKey]['isin']=$newisin;
		//			$final_array[$indxxKey]['values'][$securityKey]['newisin']=$newisin;
				
				
				}
				else{
				echo "Not Equal";
				}
		//		exit;
				
					
			
			}
			
			
			if($oldname && $newname)
			{
				
				
				
							 
				
			 $nametickerUpdateQuery='UPDATE  tbl_indxx_ticker  set name ="'.$newname.'" where indxx_id="'.$indxxKey.'"  and isin="'.$final_array[$indxxKey]['values'][$securityKey]['isin'].'"'; 
	 $this->db->query($nametickerUpdateQuery);	

				
				
				
					$final_array[$indxxKey]['values'][$securityKey]['name']=$newname;
		//			$final_array[$indxxKey]['values'][$securityKey]['newisin']=$newisin;
				
				
				}
		
				
				if($final_array[$indxxKey]['values'][$securityKey]['cashdividend']!=0)
			{
				
			//	$this->pr( $closeprices);
				if($divisorAdjustinStock)
				{$newfactor=($closeprices['calcprice']-$dividendPrice)/$closeprices['calcprice'];
				if($newfactor)
				{
					//echo $closeprices['calcshare'];
					
				$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare']/$newfactor;
				$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']-$final_array[$indxxKey]['values'][$securityKey]['cashdividend'];
				$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=$closeprices['localprice']-$final_array[$indxxKey]['values'][$securityKey]['cashdividendlocal'];		
				$shareUpdateQuery='UPDATE  tbl_share  set share ="'.$final_array[$indxxKey]['values'][$securityKey]['newcalcshare'].'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"'; 
$this->db->query($shareUpdateQuery);	
	//	exit;
				
				
				}
			
			
				
				
				
				}else{
					
					if($final_array[$indxxKey]['values'][$securityKey]['adjfactorforcash'])
					{
					
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare']/$final_array[$indxxKey]['values'][$securityKey]['adjfactorforcash'];
					
					$shareUpdateQuery='UPDATE  tbl_share  set share ="'.$final_array[$indxxKey]['values'][$securityKey]['newcalcshare'].'" where indxx_id="'.$indxxKey.'"  and isin="'.$closeprices['isin'].'"';
				$this->db->query($shareUpdateQuery);
					
			$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']*$final_array[$indxxKey]['values'][$securityKey]['adjfactorforcash'])-$final_array[$indxxKey]['values'][$securityKey]['cashdividendSC'];
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=($closeprices['localprice']*$final_array[$indxxKey]['values'][$securityKey]['adjfactorforcash'])-$final_array[$indxxKey]['values'][$securityKey]['cashdividendlocalSC'];
$final_array[$indxxKey]['values'][$securityKey]['cashdividend']=$final_array[$indxxKey]['values'][$securityKey]['cashdividendSC'];
					
					}
					else
					{$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare'];
				
			$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']-$final_array[$indxxKey]['values'][$securityKey]['cashdividend'];
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=$closeprices['localprice']-$final_array[$indxxKey]['values'][$securityKey]['cashdividendlocal'];
		//	exit;
					}
			}
				
				
				
			}	
			
			}
			//echo $final_array[$indxxKey]['values'][$securityKey]['cashdividend']."<br>";
			
						
	/*		$entry4.= "\n".$datevalue2.",";
            $entry4.=  $closeprices['ticker'].",";
            $entry4.= $closeprices['name'].",";
            $entry4.=$closeprices['isin'].",";
            $entry4.=$closeprices['calcshare'].",";
       		$entry4.=($closeprices['localprice']).",";
	     	$entry4.=$closeprices['currencyfactor'].",";
			
*/
			}
		
		
		//$entry2=$oldindexvalue.",\n";
		
		/*if($open){        
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{        fclose($open);
echo "file Writ for ".$closeIndxx['code']."<br>";

}
}  
	*/
		
		}
		
	}
	//$this->pr($final_array,true);
	if(!empty($final_array))
	{
		foreach($final_array as $key=>$closeIndxx)
		{
		
		$file="../files/ca-output/opening-".$closeIndxx['code']."-".$closeIndxx['dateStart']."-".$datevalue2.".txt";

			$open=fopen($file,"w+");

			$entry1='Date'.",";
			$entry1.=$datevalue2.",\n";
			$entry1.='INDEX VALUE'.",";
			$entry3='EFFECTIVE DATE'.",";
			$entry3.='TICKER'.",";
			$entry3.='NAME'.",";
			$entry3.='ISIN'.",";
			$entry3.='INDEX SHARES'.",";
			$entry3.='PRICE'.",";
			$entry3.='CURRENCY FACTOR'.",";
			$entry4='';
			
			$oldindexvalue=$closeIndxx['index_value']['indxx_value'];
		//echo "<br>";
			$newindexvalue=0;
			$oldDivisor=$closeIndxx['index_value']['newdivisor'];
			$newDivisor=$oldDivisor;
			$divisorAdjustinStock=$closeIndxx['cash_adjust'];
			//echo "<br>";
			$oldmarketValue=0;
			$newmarketValue=0;
			$sumofDividendes=0;
			$i=0;
			foreach($closeIndxx['values'] as $securityKey=> $closeprices)
			{
				$i++;
			
			//if($closeprices['newcalcshare'])
			//echo $closeprices['newcalcshare']."<br>";
			//else
		//echo $closeprices['calcshare']."<br>";
				$oldmarketValue+=$closeprices['calcshare']*$closeprices['calcprice'];
				if($closeprices['newcalcshare'] && $closeprices['newcalcprice'] )
				{$newmarketValue+=$closeprices['newcalcshare']*$closeprices['newcalcprice'];
				
				//echo $i;
				
					if($closeprices['isRightIsshue'])
					{
				  	$newDivisor=$newDivisor+((($closeprices['newcalcshare']*$closeprices['newcalcprice'])-($closeprices['calcshare']*$closeprices['calcprice']))/$oldindexvalue);
				//echo "<br>";
					}
				
				
				}else{
				
				//echo $i."in Simple";
				$newmarketValue+=$closeprices['calcshare']*$closeprices['calcprice'];
				}
				if($closeprices['cashdividend'])
				{
					$sumofDividendes+=$closeprices['cashdividend']*$closeprices['newcalcshare'];
				}
				//echo "<br>";
				
				
				$entry4.= "\n".$datevalue2.",";
            $entry4.=  $closeprices['ticker'].",";
            $entry4.= $closeprices['name'].",";
            $entry4.=$closeprices['isin'].",";
			if($closeprices['newcalcshare'])
            $entry4.=$closeprices['newcalcshare'].",";
       		else
			$entry4.=$closeprices['calcshare'].",";
       		
			if($closeprices['newlocalprice'])
			$entry4.=($closeprices['newlocalprice']).",";
			else
			$entry4.=($closeprices['localprice']).",";
			
	     	$entry4.=$closeprices['currencyfactor'].",";
			
					
			}
		// echo $oldmarketValue."=>".$newmarketValue."<br>";
		//exit;
		
		//echo $sumofDividendes;
		//echo "<br>";
			
			if($divisorAdjustinStock)
			{
			}else{
				if($sumofDividendes)
				$newDivisor=$newDivisor-($sumofDividendes/$oldindexvalue);
			}
			
			
			
	//	echo $newDivisor."<br>";
			//exit;
			//echo $oldDivisor."<br>";
				/*if($newmarketValue!=$oldmarketValue)
				{
				$newDivisor=number_format($newDivisor+(($newmarketValue-$oldmarketValue)/$oldindexvalue),4,'.','');
				}*/
			//echo $newmarketValue."<br>";
			//echo $newDivisor;
			//echo "<br>";
			  $newindexvalue=number_format(($newmarketValue/$newDivisor),4,'.','');

				$insertQuery='INSERT into tbl_indxx_value_open (indxx_id,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$closeIndxx['id'].'","'.$newmarketValue.'","'.$newindexvalue.'","'.$datevalue2.'","'.$oldDivisor.'","'.$newDivisor.'")';
		$this->db->query($insertQuery);	

			$entry2=$newindexvalue.",\n";
if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{

$filetext= "file Written for ".$closeIndxx['code']."<br>";

}
}  

			
			
			
			
		//	echo  	$sumofDividendes."=>".$oldmarketValue."=>".$newmarketValue;
		
		}
	}
	
	
	
	
	
	
	





$this->Redirect("index.php?module=calcindxxopeningtemp","","");	

}
   
} 
?>