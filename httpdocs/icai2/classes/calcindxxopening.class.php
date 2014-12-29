<?php

class Calcindxxopening extends Application{

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
		
		$limit=1;
		
		
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
			$query="SELECT  it.id,it.name,it.isin,it.ticker,curr,divcurr,curr,sedol,cusip,countryname,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);
			//$this->pr($indxxprices,true);	
			if(!empty($indxxprices))
			{
			foreach($indxxprices as $key=> $indxxprice)
			{
				
					$indxx_dp_value=$this->db->getResult("select tbl_dividend_ph.* from tbl_dividend_ph where indxx_id='".$row['id']."' and ticker_id ='".$indxxprice['id']."' ",true);	
				if(!empty($indxx_dp_value))
			{
			foreach($indxx_dp_value as $dpvalue)
			{	$final_array[$row['id']]['divpvalue']+=$dpvalue['share']*$dpvalue['dividend'];
			}}
		$ca_query="select identifier,action_id,id,mnemonic,field_id,company_name,ann_date,eff_date,amd_date,currency from tbl_ca cat where  eff_date='".$datevalue2."' and identifier='".$indxxprice['ticker']."'  and status='1'  and action_id not in (select ca_action_id from tbl_ignore_index where ca_action_id=cat.action_id)";
			
			$cas=$this->db->getResult($ca_query,true);	
			
			
			//echo "<br>";
			//$caflag=false;
			
			//$this->pr($cas);
			if(!empty($cas))
			{
			foreach($cas as $cakey=> $ca)
			{
			
			
			$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values_user_edited where ca_id='".$ca['id']."'  and ca_action_id='".$ca['action_id']."' and indxx_id='".$row['id']."' ";
			$ca_values=$this->db->getResult($ca_value_query,true);	
//$this->pr($ca_values);
		if(empty($ca_values)){
			$ca_value_query="Select field_name,field_value,field_id from tbl_ca_values where ca_id='".$ca['id']."'  and ca_action_id='".$ca['action_id']."' ";
			$ca_values=$this->db->getResult($ca_value_query,true);	
		}
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
if($row['ireturn']==1 && $ca['mnemonic']=='DVD_CASH' && $value!=1001 )
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
		
		
		//	$this->pr($final_array,true);
			if($type="open"){
	
	  file_put_contents('../files2/backup/preopendata'.date("Y-m-d-H-i-s").time().'.json', json_encode($final_array));
	 // exit;
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			
			//$this->pr($closeIndxx,true);
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
				
				//$this->pr($closeprices);
			$divisorImpact=0;
			
			$priceAdjfactor=1;
			$shareAdjfactor=1;
			$base_price=$closeprices['calcprice'];
			//$local_adj_factor=0;
			//$this->pr($closeprices);	
			$userAdjfactor=$this->get_user_ca_adj_factor($closeIndxx['id'],$closeprices['id']);
			if($userAdjfactor)
			{///echo $userAdjfactor;
			//echo "<br>";
						$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']*$userAdjfactor);
						$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']/$userAdjfactor);
						
					 	$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);
					//echo "<br>";						
					 	$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					//echo "<br>";
					//exit;
			}
			
			
			
			if(!empty($closeprices['ca']))
			{
				foreach($closeprices['ca'] as $ca_key=> $ca_actions)
				{
					$final_array[$indxxKey]['values'][$securityKey]['ca'][$ca_key]['ca_values']=	$this->getCa($ca_actions['id'],$ca_actions['action_id']);
					
					
				
					
					if($ca_actions['mnemonic']=='STOCK_SPLT' && $closeprices['calcprice']!=0)
					{
						$adjfactor=	$this->getAdjFactorforSplit($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
						
						if($adjfactor){
						$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']*$adjfactor);
						$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']/$adjfactor);
						
						$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
						$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
						}
					
					}
						if($ca_actions['mnemonic']=='DVD_STOCK' && $closeprices['calcprice']!=0)
					{
			
						$adjfactor=	$this->getAdjFactorforDvdStock($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
						if($adjfactor)
						{$adjfactor=($adjfactor/100)+1;
						$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']*$adjfactor);
						$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']/$adjfactor);
						
						$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
						$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);			
						}
					}
					
					if($ca_actions['mnemonic']=='SPIN' && $closeprices['calcprice']!=0)
					{
			
					$adjfactorSpin=	$this->getAdjFactorforSpin($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
					
					if($adjfactorSpin){
					
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=($closeprices['calcshare']/$adjfactorSpin);
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=($closeprices['calcprice']*$adjfactorSpin);
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					}
					
		
					}
					
					
					
					
					if($ca_actions['mnemonic']=='RIGHTS_OFFER' && $closeprices['calcprice']!=0)
					{
						
				//	$oldDivisorTemp=$newDivisor;
						
						$cp_ratio=	$this->getcpratio($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
						$cp_adj=	$this->getAdjFactorforSpin($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
					
					if($cp_ratio && $cp_adj){
					$offerpricesArray=	$this->getOfferPrices($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$closeIndxx['index_value']['date'],$indxxKey);	
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=((1+$cp_ratio)*$closeprices['calcshare']);
					$z=($closeprices['calcshare']*$closeprices['calcprice'])+($closeprices['calcshare']*$cp_ratio*$offerpricesArray['op_price_index_currency']);
		$c=$closeprices['calcshare']+($closeprices['calcshare']*$cp_ratio);
	// ($z/$c);
		$offerprices=$z/$c;
		
				$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$offerprices;
				$newDivisor=$oldDivisor+((($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']*$final_array[$indxxKey]['values'][$securityKey]['newcalcprice'])-($closeprices['calcshare']*$closeprices['calcprice']))/$oldindexvalue);
			
			
			
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
			
					$divisorImpact+=$newDivisor-$oldDivisor;
		
					
					}
					}
					if($ca_actions['mnemonic']=='DVD_CASH' && $closeprices['calcprice']!=0)
					{
					$ca_prices= $this->getCaPrices2($ca_actions['id'],$ca_actions['action_id'],$ca_actions['currency'],$final_array[$indxxKey]['curr'],$closeIndxx['index_value']['date'],$closeIndxx['div_type'],$indxxKey);	
//$this->pr($ca_prices);
					
					
					
					if($closeIndxx['ireturn']==2 && $ca_prices['CP_DVD_TYP']!='1001')
					{
						//$this->pr($ca_prices);
						//$this->pr($closeprices);
						
					
						
//$this->db->query('INSERT into tbl_dividend_ph (date,indxx_id, ticker_id,share,dividend) values ("'.$datevalue2.'","'.$closeIndxx['id'].'","'.$closeprices['id'].'","'.$closeprices['calcshare'].'","'.$ca_prices['ca_price_index_currency'].'")');
					
					$final_array[$indxxKey]['divpvalue']+=($closeprices['calcshare']*$ca_prices['ca_price_index_currency']);
						$local_adj_factor=0;
						
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$base_price-$ca_prices['ca_price_index_currency'];
										
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$base_price);
				//	$newDivisor=$oldDivisor-(($closeprices['calcshare']*$ca_prices['ca_price_index_currency'])/$oldindexvalue);
				//	$divisorImpact+=$newDivisor-$oldDivisor;
					
					$local_adj_factor=($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$base_price);
				//echo "<br>";
				 	$base_price=$local_adj_factor*$base_price;
						
					//$final_array[$indxxKey]['dividendmarketcap']+=($closeprices['calcshare']*$ca_prices['ca_price_index_currency']);
					
					}elseif($divisorAdjustinStock)
					{
					//	echo $closeprices['calcprice']-$ca_prices['ca_price_in_ca_currency'];
					//	exit;
						
					 $newfactor=($closeprices['calcprice']-$ca_prices['ca_price_index_currency'])/$closeprices['calcprice'];
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare']/$newfactor;
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']*$newfactor;
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					
					}
					elseif($ca_prices['CP_DVD_TYP']=='1001')
					{
					//$adjfactorforcash=$ca_prices['CP_ADJ'];
					
					$adjfactorforcash=($closeprices['calcprice']-$ca_prices['ca_price_index_currency'])/$closeprices['calcprice'];
					
					$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare']/$adjfactorforcash;
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']*$adjfactorforcash;
					
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$closeprices['calcprice']);						
					$shareAdjfactor=$shareAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcshare']/$closeprices['calcshare']);
					
					}else{
						
						$local_adj_factor=0;
						
					$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$base_price-$ca_prices['ca_price_index_currency'];
										
					$priceAdjfactor=$priceAdjfactor*($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$base_price);
					$newDivisor=$oldDivisor-(($closeprices['calcshare']*$ca_prices['ca_price_index_currency'])/$oldindexvalue);
					$divisorImpact+=$newDivisor-$oldDivisor;
					
					$local_adj_factor=($final_array[$indxxKey]['values'][$securityKey]['newcalcprice']/$base_price);
				//echo "<br>";
				 	$base_price=$local_adj_factor*$base_price;
				//		echo "<br>";
					}
					
					
					
					
					}
					
					
					if($ca_actions['mnemonic']=='CHG_ID')
					{
						$oldisin=	$this->getoldISIN($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
						$newisin=	$this->getnewISIN($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
						
					}
					if($ca_actions['mnemonic']=='CHG_NAME')
					{
				
						$oldname=	$this->getoldName($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
						$newname=	$this->getnewName($ca_actions['id'],$ca_actions['action_id'],$indxxKey);
						 
						 if($newname)
						{ $nametickerUpdateQuery='UPDATE  tbl_indxx_ticker  set name ="'.$newname.'" where indxx_id="'.$indxxKey.'"  and isin="'.			$final_array[$indxxKey]['values'][$securityKey]['isin'].'"'; 
				 $this->db->query($nametickerUpdateQuery);	
					$final_array[$indxxKey]['values'][$securityKey]['name']=$newname;
						}
						}
					
					
				}
			}
		//	echo $closeprices['calcshare']."=>".strlen((string)$closeprices['calcshare']);
		//	echo "<br>";
			$final_array[$indxxKey]['values'][$securityKey]['newcalcprice']=$closeprices['calcprice']*$priceAdjfactor;
			$final_array[$indxxKey]['values'][$securityKey]['newlocalprice']=	$closeprices['localprice']*$priceAdjfactor;
			if($shareAdjfactor==1)
			{
			$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=$closeprices['calcshare'];
			}
			else{
			$final_array[$indxxKey]['values'][$securityKey]['newcalcshare']=number_format($closeprices['calcshare']*$shareAdjfactor,13,'.','');
			}
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
		
	 file_put_contents('../files2/backup/postopendata'.date("Y-m-d-H-i-s").time().'.json', json_encode($final_array));	
	}
			//exit;
			
			//$this->pr($final_array,true);
			
			if(!empty($final_array))
	{
		foreach($final_array as $key=>$closeIndxx)
		{
			if(!$closeIndxx['client'])
			$file="../files2/ca-output/Opening-".$closeIndxx['code']."-".$datevalue2.".txt";
			else
			$file="../files2/ca-output/".$closeIndxx['client']."/Opening-".$closeIndxx['code']."-".$datevalue2.".txt";
			
			$open=fopen($file,"w+");

			$entry1='Date'.",";
			$entry1.=date("Y-m-d",strtotime($datevalue2)).",\n";
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
					
		
		
		
		
		$newMarketValue=0;
		if(!empty($closeIndxx))
		{
		foreach($closeIndxx['values'] as $security)
		{
		//$this->pr($security);
			
		$newMarketValue+=$security['newcalcprice']*$security['newcalcshare'];



			$entry4.= "\n".date("Ymd",strtotime($datevalue2)).",";
            $entry4.=  $security['ticker'].",";
            $entry4.= $security['name'].",";
            $entry4.=$security['isin'].","; 
			 $entry4.=$security['sedol'].",";;
            $entry4.=$security['cusip'].",";;
            $entry4.=$security['countryname'].",";
		    $entry4.=$security['newcalcshare'].",";
       		$entry4.=number_format($security['newlocalprice'],2,'.','').",";
			if($closeIndxx['display_currency'])
	     	{$entry4.=$security['curr'].",";
			$entry4.=number_format($security['currencyfactor'],6,'.','').",";
			}			

		}
		}
		//echo $closeIndxx['index_value']['divisor_impact'];
		//echo "<br>";
		 $newDivisorforindxx=$closeIndxx['index_value']['olddivisor']+$closeIndxx['index_value']['divisor_impact'];
		//echo "<br>";
	//	 $closeIndxx['index_value']['indxx_value']."<br>";
//		 $newMarketValue/$closeIndxx['index_value']['newdivisor'];


if($closeIndxx['divpvalue'])
{
	
	
	//	$insertQuery='update tbl_indxx set divpvalue="'.$closeIndxx['divpvalue'].'" where id="'.$closeIndxx['id'].'" ';
	//	$this->db->query($insertQuery);	
		
	$newMarketValue+=$closeIndxx['divpvalue'];
	 $newindexvalue=number_format((($newMarketValue)/$newDivisorforindxx),2,'.','');
}
else
 {$newindexvalue=number_format(($newMarketValue/$newDivisorforindxx),2,'.','');
 }
 $insertQuery='INSERT into tbl_indxx_value_open (indxx_id,code,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.$newMarketValue.'","'.$newindexvalue.'","'.$datevalue2.'","'.$closeIndxx['index_value']['olddivisor'].'","'.$newDivisorforindxx.'")';
		$this->db->query($insertQuery);	
		
			$entry2=$newindexvalue.",\n";
			
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
			
		
		}
		//echo $totalindexes."=>".$page;
		//exit;
		if($totalindexes<=$page)
		{
			//echo "Redirect Next";	
			
			$this->saveProcess(1);
			
			$this->Redirect2("index.php?module=calcindxxopeningtemp","","");	
		}
		else
		{
			$this->saveProcess(1);
			$this->Redirect2("index.php?module=calcindxxopening&event=index&id=".($page+$limit),"","");	
		}
		
		
	}
	
	
   
} 
?>