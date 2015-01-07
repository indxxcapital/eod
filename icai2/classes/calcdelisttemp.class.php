<?php

class Calcdelisttemp extends Application{

	function __construct()
	{
		parent::__construct();
		//$this->checkUserSession();
	}
	
	
	function index()
	{
	 $datevalue2=$this->_date;	
	//exit;
	/*if($_SESSION['currentPriorityIndex']==0)
		
	{	*/
	
	$indxxs=	$this->db->getResult("select id,indxx_id from tbl_delist_tempindex_req where startdate='".$datevalue2."' and adminapprove='1' ",true);
	//$this->pr($indxxs,true);
		$final_array=array();
	
	
	if(!empty($indxxs))	
	{
	foreach ($indxxs as $indxx)
	{
	
		$indxx_value=$this->db->getResult("select tbl_indxx_value_temp.* from tbl_indxx_value_temp where indxx_id='".$indxx['indxx_id']."' order by date desc ",false,1);	
			//$this->pr($indxx_value,true);
			if(!empty($indxx_value))
			{
			$final_array[$indxx['indxx_id']]['index_value']=$indxx_value;
			$datevalue=$indxx_value['date'];
			}
			
				$query="SELECT  it.id,it.name,it.isin,it.ticker,curr,divcurr,(select price from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$indxx['indxx_id']."') as calcprice,(select localprice from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$indxx['indxx_id']."') as localprice,(select currencyfactor from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$indxx['indxx_id']."') as currencyfactor,(select share from tbl_share_temp sh where sh.isin=it.isin  and sh.indxx_id='".$indxx['indxx_id']."') as calcshare FROM `tbl_indxx_ticker_temp` it where it.indxx_id='".$indxx['indxx_id']."'";			
		
		$indxxprices=	$this->db->getResult($query,true);
	//		$this->pr($indxxprices,true);
			
	$final_array[$indxx['indxx_id']]['olddata']=$indxxprices;

	//echo 	$datevalue;
	
	$oldsecurity=	$this->db->getResult("select security_id from tbl_delist_tempsecurity where req_id='".$indxx['id']."' and  indxx_id='".$indxx['indxx_id']."' ",true);
	//$this->pr($oldsecurity,true);

	$final_array[$indxx['indxx_id']]['removesecurity']=$oldsecurity;
	
	}
	}
	
	
	//$this->pr($final_array,true);
	
	if(!empty($final_array))
	{
	foreach($final_array as $id=>$indxx_array)
	{
		
		$tempMarketCap=0;
		
		
	if(!empty($indxx_array['removesecurity']))
	{
		foreach($indxx_array['removesecurity'] as $removedSecurtity)
		{
		//$this->pr($removedSecurtity);
		
		if(!empty($removedSecurtity))
		{
				foreach($indxx_array['olddata'] as $oldsecuritykey=>$oldsecuriti)
				{
					if($oldsecuriti['id']==$removedSecurtity['security_id'])
					{
			//		echo "got it<br>";
				//echo $oldsecuritykey;
				
					$tempMarketCap+=$oldsecuriti['calcshare']*$oldsecuriti['calcprice'];
				
				
				
				 $deleteSecurityQuery='Delete from tbl_indxx_ticker_temp where id="'.$oldsecuriti['id'].'"'; 
			$this->db->query($deleteSecurityQuery);	
				//echo "<br>";
				 $deletepriceQuery='Delete from tbl_final_price_temp where indxx_id="'.$id.'" and  isin ="'.$oldsecuriti['isin'].'" and date ="'.$indxx_array['index_value']['date'].'" '; 
			$this->db->query($deletepriceQuery);	
				//echo "<br>";
				
		$deleteshareQuery='Delete from tbl_share_temp where indxx_id="'.$id.'" and  isin ="'.$oldsecuriti['isin'].'" '; 
			//	echo "<br>";
				
				$this->db->query($deleteshareQuery);	
				
				
				
				
				unset($final_array[$id]['olddata'][$oldsecuritykey]);
				
					}
				
				}
		}
		
		
		}
	}
	
	
	//echo $tempMarketCap;
	//echo "<br>";
	
	
	//echo $id;
	
	
//$this->pr($final_array,true);
	
	if($tempMarketCap)
	{
		$newDivisor=0;
		$newDivisor=$indxx_array['index_value']['newdivisor'];
		
		$newDivisor=$newDivisor-($tempMarketCap/$indxx_array['index_value']['indxx_value']);
		
	$updateQuery='update tbl_indxx_value_temp set newdivisor="'.$newDivisor.'" where  date="'.$indxx_array['index_value']['date'].'" and indxx_id="'.$id.'"';
		
$this->db->query($updateQuery);	
		
		
		
	}
	
	/*if($tempMarketCap)
	{
		$newDivisor=0;
		$newDivisor=$indxx_array['index_value']['newdivisor'];
		
	$newDivisor=$newDivisor-($tempMarketCap/$indxx_array['index_value']['indxx_value']);

echo $indxx_array['index_value']['indxx_value'];
echo "<br>";
$marketCap=0;
foreach($final_array as $newindxx)
{
	foreach($newindxx['olddata'] as $newSecurity){
	
		$marketCap+=$newSecurity['calcshare']*$newSecurity['calcprice'];
	}
}
echo $marketCap/$newDivisor;




	}
	*/
	
	}
//	echo $tempMarketCap;
	
	}
	
	$this->saveProcess(1);
	
	///$this->pr($final_array,true);
	
		
	//}
	$this->Redirect("index.php?module=calcreplacetemp","","");	
	
	}
}?>