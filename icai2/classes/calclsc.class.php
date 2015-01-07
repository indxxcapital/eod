<?php

class Calclsc extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		//echo "select * from tbl_indxx_cs  where status='1' ";
		$indxxs=$this->db->getResult("select * from tbl_indxx_lsc  where status='1' ",true);	
	//	$this->pr($indxxs,true);
		 $datevalue2=date('Y-m-d');
		 
		 
		 $final_array=array();
		 if(!empty($indxxs))
		 {
			 
			 foreach($indxxs as $row)
			 {
				if($this->checkHoliday($row['zone'], $datevalue2)){
				$final_array[$row['id']]=$row;
				
				
					$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
					$final_array[$row['id']]['client']=$client['ftpusername'];
				//echo "select * from tbl_lsc_adj_factor  where lsc_indxx_id='".$row['id']."' ";
				$calcfactor=$this->db->getResult("select * from tbl_lsc_adj_factor  where lsc_indxx_id='".$row['id']."' ",false,1);	
				$final_array[$row['id']]['calcfactor']=$calcfactor;
			
				if(!empty($calcfactor))
				{
					
				$long_indxx_value=$this->db->getResult("select indxx_value,date from tbl_indxx_value  where code='".$calcfactor['long_code']."' order by date desc ",false,1);
				$final_array[$row['id']]['long_index_value']=$long_indxx_value;
				$short_indxx_value=$this->db->getResult("select indxx_value,date from tbl_indxx_value  where code='".$calcfactor['short_code']."' order by date desc ",false,1);
				$final_array[$row['id']]['short_index_value']=$short_indxx_value;
					//echo "select indxx_value,date from tbl_cash_indxx_value  where code='".$calcfactor['cash_code']."' order by date desc ";
				$cash_indxx_value=$this->db->getResult("select indxx_value,date from tbl_cash_indxx_value  where code='".$calcfactor['cash_code']."' order by date desc ",false,1);
					
				$final_array[$row['id']]['cash_index_value']=$cash_indxx_value;
				//$this->pr($final_array);
				if(!empty($long_indxx_value) && !empty($short_indxx_value) && !empty($cash_indxx_value))
				{if($cash_indxx_value['date']!=$short_indxx_value['date']  && $cash_indxx_value['date'] !=$long_indxx_value['date'])
				{
					
					//echo "Date Mismatch";
					
					$msg="Long short Cash Index is not calculated ".$row['name']." due to value mismatch";
					
					mail("ICAL@indxx.com","Softlayer - Long Short Cash Index Not Calculated ",$msg);
				unset($final_array[$row['id']]);
				
				}}else{
				$msg="Long short Cash Index is not calculated ".$row['name']." due to value unavailable";
					
				mail("ICAL@indxx.com","Softlayer - Long Short Cash Index Not Calculated ",$msg);
						unset($final_array[$row['id']]);
				
				}
				
				
					/*
				foreach($calcfactors as $key=> $calcfactor)
				{
				//$this->pr($calcfactor);
				
				
				$indxx_name=$this->db->getResult("select name from tbl_indxx  where code='".$calcfactor['code']."' ",false,1);
			//	echo "select indxx_value from tbl_indxx_value  where code='".$calcfactor['code']."' order by date desc ";
				$indxx_value=$this->db->getResult("select indxx_value,date from tbl_indxx_value  where code='".$calcfactor['code']."' order by date desc ",false,2);
					$calcfactors[$key]['indxx_name']=$indxx_name['name'];
					$calcfactors[$key]['indxx_value']=$indxx_value;
				
				
				}
				*/}
				$final_array[$row['id']]['values']=$calcfactors;
				
				}
			
			}
			 
			 
		 }
		 
//$this->pr( $final_array,true);
	//exit;	
		if(!empty($final_array))
		{  file_put_contents('../files2/backup/preCLOSELSCdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
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
			$entry3.='CODE'.",";
			$entry3.='FACTOR'.",";
			$entry3.='INDEX VALUE'.",";
			
			
			$entry4='';
		$index_value=0;
		
			if(!empty($closeIndxx))
		{
			
			$index_value=($closeIndxx['long_index_value']['indxx_value']*$closeIndxx['calcfactor']['long_fraction'])-($closeIndxx['short_index_value']['indxx_value']*$closeIndxx['calcfactor']['short_fraction'])+($closeIndxx['cash_index_value']['indxx_value']*$closeIndxx['calcfactor']['cash_fraction']);
			
			 $entry4.= "\n".$closeIndxx['calcfactor']['long_code'].",";
            $entry4.=$closeIndxx['calcfactor']['long_fraction'].",";
            $entry4.=$closeIndxx['long_index_value']['indxx_value'].",";
	
			$entry4.= "\n".$closeIndxx['calcfactor']['short_code'].",";
            $entry4.=$closeIndxx['calcfactor']['short_fraction'].",";
            $entry4.=$closeIndxx['short_index_value']['indxx_value'].",";
			
			$entry4.= "\n".$closeIndxx['calcfactor']['cash_code'].",";
            $entry4.=$closeIndxx['calcfactor']['cash_fraction'].",";
            $entry4.=$closeIndxx['cash_index_value']['indxx_value'].",";
			
			
			
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
//exit;
 $insertQuery='INSERT into tbl_indxx_lsc_value (indxx_id,code,indxx_value,date) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.number_format($index_value,2,'.','').'","'.$datevalue2.'")';
		$this->db->query($insertQuery);	
	
	if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{

}}
		
		}
		 file_put_contents('../files2/backup/postOPENLSCdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
		}
		
		
		$this->saveProcess(2);
		$this->Redirect2("index.php?module=calccsi","","");
	/*echo '<script>document.location.href="http://10.24.52.130/icai2/publishcsixls.php";</script>';
		//$this->Redirect("index.php?module=calcftpclose","","");		*/
	}

}