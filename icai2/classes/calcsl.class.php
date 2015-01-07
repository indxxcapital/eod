<?php

class Calcsl extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		//echo "select * from tbl_indxx_cs  where status='1' ";
		$indxxs=$this->db->getResult("select * from tbl_indxx_sl  where status='1' ",true);	
		//$this->pr($indxxs);
		 $datevalue2=date('Y-m-d');
		 
		  //$datevalue2='2014-09-03';
		 $final_array=array();
		 if(!empty($indxxs))
		 {
			 
			 foreach($indxxs as $row)
			 {
				if($this->checkHoliday($row['zone'], $datevalue2)){
				$final_array[$row['id']]=$row;
				
				
					$client=$this->db->getResult("select tbl_ca_client.ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
					$final_array[$row['id']]['client']=$client['ftpusername'];
			//	echo "select * from tbl_sl_adj_factor  where ca_indxx_id='".$row['id']."' ";
				$calcfactors=$this->db->getResult("select * from tbl_sl_adj_factor  where cs_indxx_id='".$row['id']."' ",true);	
				
				$slindxx_value=$this->db->getResult("select indxx_value from tbl_indxx_sl_value  where indxx_id='".$row['id']."' order by dateAdded desc ",false,1);
				
				$liborrates=$this->db->getResult("select price from tbl_libor_prices  where ticker like '%LIBR360  Index%' and date ='".$datevalue2."' ",false,1);	
				$final_array[$row['id']]['libor_rate']=$liborrates['price'];
				$final_array[$row['id']]['last_index_value']=$slindxx_value['indxx_value'];
				if(!empty($calcfactors))
				{
				foreach($calcfactors as $key=> $calcfactor)
				{
				//$this->pr($calcfactor);
				
				
				$indxx_name=$this->db->getResult("select name from tbl_indxx  where code='".$calcfactor['code']."' ",false,1);
			//	echo "select indxx_value from tbl_indxx_value  where code='".$calcfactor['code']."' order by date desc ";
				$indxx_value=$this->db->getResult("select indxx_value,date from tbl_indxx_value  where code='".$calcfactor['code']."' and date<='".$datevalue2."' order by date desc ",false,2);
					$calcfactors[$key]['indxx_name']=$indxx_name['name'];
					$calcfactors[$key]['indxx_value']=$indxx_value;
				
				
				}
				}
				$final_array[$row['id']]['values']=$calcfactors;
				
				}
			
			}
			 
			 
		 }
		 
	//$this->pr( $final_array,true);
		
		if(!empty($final_array))
		{  file_put_contents('../files2/backup/preCLOSESLdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
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
			$entry3.='NAME'.",";
			$entry3.='CODE'.",";
			$entry3.='FACTOR'.",";
			$entry3.='INDEX VALUE'.",";
			
			
			$entry4='';
		$index_value=0;
		
			if(!empty($closeIndxx))
		{
		foreach($closeIndxx['values'] as $security)
		{
			
			//$this->pr($security);

//echo (1+($security['fraction']*(($security['indxx_value'][0]['indxx_value']/$security['indxx_value'][1]['indxx_value'])-1)));
	//		exit;
		$index_value=$closeIndxx['last_index_value']*(1+($security['fraction']*(($security['indxx_value'][0]['indxx_value']/$security['indxx_value'][1]['indxx_value'])-1)));
		//echo 	$index_value;
	//	exit;
		
            $entry4.= "\n".$security['indxx_name'].",";
            $entry4.=$security['code'].","; 
			 $entry4.=$security['fraction'].",";
            $entry4.=$security['indxx_value'][0]['indxx_value'].",";
		//	echo (($closeIndxx['last_index_value']*($security['fraction']-1)*($closeIndxx['libor_rate'])/100)/360);
			
		$newIndex_value=$index_value-(($closeIndxx['last_index_value']*($security['fraction']-1)*($closeIndxx['libor_rate'])/100)/360);
		}
		
		}

//echo $newIndex_value;
//exit;


	$entry2=number_format($newIndex_value,2,'.','').",\n";

 $insertQuery='INSERT into tbl_indxx_sl_value (indxx_id,code,indxx_value,date) values ("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.number_format($newIndex_value,2,'.','').'","'.$datevalue2.'")';
		$this->db->query($insertQuery);	
	
	if($open){   
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{

}}
		
		}
		 file_put_contents('../files2/backup/postOPENSLdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
		}
		
		
		$this->saveProcess(2);
		$url="http://174.36.193.130/icai2/publishcsixls.php";
/*echo '<script>document.location.href="http://10.24.52.130/icai2/publishcsixls.php";</script>';
*/		//$this->Redirect("index.php?module=calcftpclose","","");		*/
	$link="<script type='text/javascript'>
window.open('".$url."');  
</script>";
echo $link;
	
	}

}