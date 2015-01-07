<?php

class Calcrebalance extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		
	//$this->pr($indxxs,true);
		
	//	$type="close";
		
		 $datevalue2=$this->_date;
//echo date("D",strtotime($datevalue));
//exit;

//$datevalue2='2014-03-17';

$indxxs=$this->db->getResult("select tbl_indxx_temp.* from tbl_indxx_temp  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and recalc='1' and dateStart='". $datevalue2."'",true);	
//$this->pr($indxxs,true);


		$final_array=array();
		
		if(!empty($indxxs))
		{
			foreach($indxxs as $row)
			{
					
			$final_array[$row['id']]=$row;
			

			
			
				$final_array[$row['id']]=$row;
				$liveindexid=$this->db->getResult("select tbl_indxx.id from tbl_indxx where code='".$row['code']."' ",true);
				//echo "select tbl_indxx_value.* from tbl_indxx_value where indxx_id='".$liveindexid['0']['id']."' order by date desc ";
				
				$indxx_value=$this->db->getResult("select tbl_indxx_value.* from tbl_indxx_value where indxx_id='".$liveindexid['0']['id']."' order by date desc ",false,1);	
				$final_array[$row['id']]['index_value']=$indxx_value['indxx_value'];
				$final_array[$row['id']]['market_value']=$indxx_value['market_value'];
				$final_array[$row['id']]['last_close_date']=$indxx_value['date'];
				$final_array[$row['id']]['last_close_id']=$indxx_value['id'];
				
				$indxx_value=$this->db->getResult("select tbl_indxx_value_temp.* from tbl_indxx_value_temp where indxx_id='".$row['id']."' order by date desc ",false,1);	
				$final_array[$row['id']]['last_close_temp_id']=$indxx_value['id'];
				
				
				
				$datevalue=$indxx_value['date'];
				
				
				
			$query="SELECT  it.name,it.isin,it.ticker,(select price from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price_temp fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share_temp sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker_temp` it where it.indxx_id='".$row['id']."'";			
		
		
		
			$indxxprices=	$this->db->getResult($query,true);	
		
			$final_array[$row['id']]['values']=$indxxprices;
			
			}	
		
		}
	//$this->pr($final_array,true);
	if(!empty($final_array))
	{
	 file_put_contents('../files2/backup/prerebalancedata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
	foreach($final_array as $indexKey=> $index)
	{
	
	
	//$this->pr($index,true);
	
	$newDivisor=0;
	$oldIndexValue=$index['index_value'];
	$newMarketCap=0;
	if(!empty($index['values']))
	{
	foreach($index['values'] as $securities )
	{
	$newMarketCap+=$securities['calcshare']*$securities['calcprice'];
	}
	}
	
	if($newMarketCap!=0)
	{
 		$newDivisor= $newMarketCap/$oldIndexValue;
//	echo "<br>";
	$final_array[$indexKey]['newDivisor']=$newDivisor;
	$updateQuery='update tbl_indxx_value_temp set market_value="'.$newMarketCap.'",indxx_value="'.$oldIndexValue.'",newdivisor="'.$newDivisor.'",olddivisor="'.$newDivisor.'" where id="'.$index['last_close_temp_id'].'"';
	$this->db->query($updateQuery);
	
//	$this->db->query($updateQuery);

	
	
	}
	
	
	
	
	}
	
	
	 file_put_contents('../files2/backup/prerebalancedata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
	}
	


$this->saveProcess(1);
$this->Redirect2("index.php?module=calcdp","","");
}
   
} // class ends here


/*


*/

?>

