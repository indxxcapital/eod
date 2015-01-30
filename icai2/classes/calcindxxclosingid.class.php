<?php

class Calcindxxclosingid extends Application{

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
		$id=$_GET['id'];
		//echo "select tbl_indxx_temp.* from tbl_indxx_temp  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and id='".$id."'";
		$indxxs=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and id='".$id."'",true);	
	//$this->pr($indxxs,true);
		
		$type="close";
		
		 $datevalue=$this->_date;
//echo date("D",strtotime($datevalue));
//exit;
 if(date("D",strtotime($datevalue))=="Mon")
 $datevalue=date("Y-m-d",strtotime($datevalue)-86400*3);
else
 $datevalue=date("Y-m-d",strtotime($datevalue)-86400);

//$datevalue="2014-12-16";
//echo $datevalue;
//exit;

//exit;
	//
		$final_array=array();
		
		if(!empty($indxxs))
		{
			foreach($indxxs as $row)
			{
	//$this->pr($indxx);
					
			$final_array[$row['id']]=$row;
			

			
			
			/*$indxx_value=$this->db->getResult("select tbl_indxx_value_temp.* from tbl_indxx_value_temp where indxx_id='".$row['id']."' and  code='".$row['code']."' order by date desc ",false,1);	
		//	$this->pr($indxx_value,true);
			if(!empty($indxx_value))
			{
			$final_array[$row['id']]['index_value']=$indxx_value;
			}
			else{*/
			$final_array[$row['id']]['index_value']['market_value']=$row['investmentammount'];
			$final_array[$row['id']]['index_value']['divpvalue']=$row['divpvalue'];
			$final_array[$row['id']]['index_value']['olddivisor']=$row['divisor'];
			$final_array[$row['id']]['index_value']['newdivisor']=$row['divisor'];
			$final_array[$row['id']]['index_value']['indxx_value']=$row['indexvalue'];
			if($final_array[$row['id']]['index_value']['olddivisor']==0){
			$final_array[$row['id']]['index_value']['olddivisor']=$row['investmentammount']/$row['indexvalue'];
			}
			if($final_array[$row['id']]['index_value']['newdivisor']==0){
			$final_array[$row['id']]['index_value']['newdivisor']=$row['investmentammount']/$row['indexvalue'];
			}


			//}
			//$this->pr(	$final_array,true);
			
			
			// $query="SELECT  it.name,it.isin,it.ticker,(select price from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share_temp sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker_temp` it where it.indxx_id='".$row['id']."'";			
		$query="SELECT  it.id,it.name,it.isin,it.ticker,it.curr,it.sedol,it.cusip,it.countryname,fp.localprice,fp.currencyfactor,fp.price as calcprice,sh.share as calcshare FROM `tbl_indxx_ticker_temp` it
left join tbl_final_price_temp fp on fp.isin=it.isin
left join tbl_share_temp sh on sh.isin=it.isin
 where it.indxx_id='".$row['id']."'
 and fp.indxx_id='".$row['id']."'
 and sh.indxx_id='".$row['id']."'
 and fp.date='".$datevalue."' 
  ";
	//	exit;
		
			$indxxprices=	$this->db->getResult($query,true);	
		
		//$this->pr($indxxprices,true);
		
			
			
			$final_array[$row['id']]['values']=$indxxprices;
		
		
	//	$this->pr($indxxprices,true);	
			
			
			}	
		
		}
//	$this->pr($final_array,true);
	
if($type=='close')
{	
	
	if(!empty($final_array))
	{
		foreach($final_array as $indxxKey=> $closeIndxx)
		{
			$output_folder = "../files/output/ca-output_upcoming/";
			
			if (!file_exists($output_folder))
				mkdir($output_folder, 0777, true);
			
			//$file="../files2/ca-output_upcomming/pre-closing-".$closeIndxx['code']."-".$closeIndxx['dateStart']."-".$datevalue.".txt";
			$file= $output_folder . "pre-closing-".$closeIndxx['code']."-".$closeIndxx['dateStart']."-".$datevalue.".txt";
				
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
			$newDivisor=$oldDivisor;
			$marketValue=0;
			$sumofDividendes=0;
			
			foreach($closeIndxx['values'] as $closeprices)
			{
			//$this->pr($closeprices);
		
			$shareValue=$closeprices['calcshare'];	
			$securityPrice=$closeprices['calcprice'];
			
		
			//echo $dividendPrice."<br>";
			if(!$securityPrice){
			echo "Price Not Found For ".$closeprices['ticker']."=>".$closeprices['name'];
			exit;
			}
			/*if(!$shareValue)
			{
			echo "Share Not Found For ".$closeprices['ticker']."=>".$closeprices['name'];
			exit;
			}*/
			
			
		 	$marketValue+=number_format($closeprices['calcshare']*$closeprices['calcprice'],11,'.','');	
		//	$sumofDividendes+=$shareValue*$dividendPrice;	
		//	echo "<br>";
			
			$entry4.= "\n".$datevalue.",";
            $entry4.=  $closeprices['ticker'].",";
            $entry4.= $closeprices['name'].",";
            $entry4.=$closeprices['isin'].",";
            $entry4.=$closeprices['calcshare'].",";
       		$entry4.=$closeprices['localprice'].",";
	     	$entry4.=$closeprices['currencyfactor'].",";
			

			}
		
$marketValue= number_format($marketValue,11,'.','');	
	//exit;
//echo $closeIndxx['id']."<br>";
		
		//$newDivisor=number_format($oldDivisor-($sumofDividendes/$oldindexvalue),4,'.','');
		if($closeIndxx['index_value']['divpvalue'])
		{
		$marketValue+=$closeIndxx['index_value']['divpvalue'];
		}
		$newDivisor=$marketValue/$oldindexvalue;
		$oldDivisor=$newDivisor;
		 $newindexvalue=number_format(($marketValue/$newDivisor),4,'.','');
		$entry2=$newindexvalue.",\n";
	//	exit;
		if(!$newindexvalue)
		{
			echo "Index Value are Zero";
			exit;
		}
		
		//exit;
	$insertQuery='INSERT into tbl_indxx_value_temp (indxx_id,code,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.$marketValue.'","'.$newindexvalue.'","'.$datevalue.'","'.$oldDivisor.'","'.$newDivisor.'")';
		$this->db->query($insertQuery);	
		$insertQuery='INSERT into tbl_indxx_value_open_temp (indxx_id,code,market_value,indxx_value,date,olddivisor,newdivisor) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.$marketValue.'","'.$newindexvalue.'","'.$datevalue.'","'.$oldDivisor.'","'.$newDivisor.'")';
		$this->db->query($insertQuery);	
		
		if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{
	$query=$this->db->Query("update tbl_indxx_temp set runindex='1' where tbl_indxx_temp.id='".$_GET['id']."'");
	
	        fclose($open);

$filetext= "file Written for ".$closeIndxx['code']."<br>";

}
}  

		
		}
	}
	
	$this->Redirect("index.php?module=caupcomingindex","Record updated successfully!!!".$filetext,"success");	
}





}
   
} // class ends here


/*


*/

?>

