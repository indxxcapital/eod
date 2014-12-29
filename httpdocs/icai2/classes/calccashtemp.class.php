<?php

class Calccashtemp extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		//echo "select * from tbl_indxx_cs  where status='1' ";
		$indxxs=$this->db->getResult("select * from tbl_cash_index_temp  where 1=1 ",true);	
		//$this->pr($indxxs);
		 $datevalue2=date('Y-m-d',strtotime($this->_date)-86400);
	//	 $datevalue2='2014-08-22';
		 
		 $final_array=array();
		 if(!empty($indxxs))
		 {
			 
			 foreach($indxxs as $row)
			 {
				if($this->checkHoliday($row['zone'], $datevalue2)){
				$final_array[$row['id']]=$row;
					$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
					$final_array[$row['id']]['client']=$client['ftpusername'];
					$cashindxx_value=$this->db->getResult("select indxx_value from tbl_cash_indxx_value_temp  where indxx_id='".$row['id']."' order by dateAdded desc ",false,1);
				
				$final_array[$row['id']]['last_index_value']=$cashindxx_value['indxx_value'];
		
	//	echo "select price from tbl_cash_prices  where isin like '%".$row['isin']."%' order by date desc ";
				$cashrates=$this->db->getResult("select price from tbl_cash_prices  where isin like '%".$row['isin']."%' order by date desc ",true,2);	
				$final_array[$row['id']]['last_2_days_cash_rate']=$cashrates;
				
				
				
			}
		}
		
		}
		
		//$this->pr($final_array);

		if(!empty($final_array))
		{  file_put_contents('../files2/backup/preCLOSECASH_tempdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
		 	foreach($final_array as $key=>$closeIndxx)
		{
			if(!$closeIndxx['client'])
			$file="../files2/ca-output/Closing-".$closeIndxx['code']."-".$datevalue2.".txt";
			else
			$file="../files2/ca-output/".$closeIndxx['client']."/Closing-".$closeIndxx['code']."-".$datevalue2.".txt";
			
			$open=fopen($file,"w+");
			
			$entry1='Date'.",";
			$entry1.=date("Y-m-d",strtotime($datevalue2)).",\n";
			$entry1.='INDEX VALUE'.",";
			
			
			$entry4='';
		$index_value=0;
		
			if(!empty($closeIndxx))
		{
			
			$index_value=$closeIndxx['last_index_value']*($closeIndxx['last_2_days_cash_rate'][0]['price']/$closeIndxx['last_2_days_cash_rate'][1]['price']);
			
			/*
		foreach($closeIndxx['values'] as $security)
		{
			
			//$this->pr($security);
			//echo ($security['indxx_value'][0]['indxx_value']/$security['indxx_value'][1]['indxx_value'])-1;
			//exit;
		$index_value=$closeIndxx['last_index_value']*(1+($security['fraction']*(($security['indxx_value'][0]['indxx_value']/$security['indxx_value'][1]['indxx_value'])-1)));
		//echo 	$index_value;
		//exit;
		
            $entry4.= "\n".$security['indxx_name'].",";
            $entry4.=$security['code'].","; 
			 $entry4.=$security['fraction'].",";
            $entry4.=$security['indxx_value'][0]['indxx_value'].",";
	//		echo (($closeIndxx['last_index_value']*($security['fraction']-1)*$closeIndxx['libor_rate'])/360);
			
		$newIndex_value=$index_value-(($closeIndxx['last_index_value']*($security['fraction']-1)*($closeIndxx['libor_rate'])/100)/360);
		}
		
		*/}

//echo $newIndex_value;
//exit;


	$entry2=number_format($index_value,2,'.','').",\n";

 $insertQuery='INSERT into tbl_cash_indxx_value_temp (indxx_id,code,indxx_value,date) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.number_format($index_value,2,'.','').'","'.$datevalue2.'")';
		$this->db->query($insertQuery);	
	
	if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{

}}
		
		}
		 file_put_contents('../files2/backup/postOPENCASH_tempdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
		}
		
		
	//	$this->saveProcess(2);
		
		
		$this->saveProcess(2);
$this->Redirect2("index.php?module=calclsc","","");		
		
		
	}
}