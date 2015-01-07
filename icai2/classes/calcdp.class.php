<?php

class Calcdp extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		//echo "select * from tbl_indxx_cs  where status='1' ";
		$indxxs=$this->db->getResult("select tbl_indxx.id from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and ireturn='2'" ,true);	
		//$this->pr($indxxs);
		 $datevalue2=date('Y-m-d',strtotime($this->_date));
		 
		 
		 $final_array=array();
		 if(!empty($indxxs))
		 {
			 
			 foreach($indxxs as $row)
			 {
				if($this->checkHoliday($row['zone'], $datevalue2)){
				$final_array[$row['id']]=$row;
				
			
				$indxx_value=$this->db->getResult("select tbl_indxx_value.* from tbl_indxx_value where indxx_id='".$row['id']."' and date like '".date("Y-m",strtotime($datevalue2))."%'",true);	
				
			//echo "select sum(dividend*share) as dividendmarketcap from tbl_dividend_ph where indxx_id='".$row['id']."'  and date like '". date("Y-m",strtotime(date('Y-m')." -1 month"))."%' ";
			
				if(empty($indxx_value)){
					$lastindxx_value=$this->db->getResult("select tbl_indxx_value.* from tbl_indxx_value where indxx_id='".$row['id']."' order by date desc ",false,1);	
					$final_array[$row['id']]['index_value']=$lastindxx_value;
					
					
						$dividend_total_value=$this->db->getResult("select sum(dividend*share) as dividendmarketcap from tbl_dividend_ph where indxx_id='".$row['id']."'  and date like '". date("Y-m",strtotime(date('Y-m')." -1 month"))."%' ",false,1);	
		//	$this->pr($dividend_total_value,true);
		
			$final_array[$row['id']]['dividendmarketcap']=$dividend_total_value['dividendmarketcap'];
		
					
					
				}
				
				
				
				
				//$this->pr($indxx_value);
				
				}
			 }
			
			}
			
		if(!empty($final_array))
		{
	
			foreach($final_array as $key=>$closeIndxx)
			{
				
				//$this->pr($closeIndxx);
				
				if(!empty($closeIndxx['index_value']) && $closeIndxx['dividendmarketcap'])
				$newDivisor=$closeIndxx['index_value']['newdivisor']-($closeIndxx['dividendmarketcap']/$closeIndxx['index_value']);
				
					
$insertlogQuery='update tbl_indxx_value set  newdivisor="'.$newDivisor.'", olddivisor="'.$newDivisor.'" where indxx_id="'.$closeIndxx['id'].'" and id="'.$closeIndxx['index_value']['id'].'"';
		$this->db->query($insertlogQuery);
				
				
			}			
		}
			
			
	
	
	$this->saveProcess(1);
$this->Redirect2("index.php?module=replaceindex","","");
	}
}


?>