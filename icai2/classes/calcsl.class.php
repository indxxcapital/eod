<?php

class Calcsl extends Application
{
	function __construct()
	{
		parent::__construct();
	}
		
	function index()
	{		
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		
		$datevalue2 = $this->_date;
				
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		$this->log_info(log_file, "SL index file generation process started.");
		
		$final_array=array();

		/* Fetch the list of various SL indexes */
		$indxxs=$this->db->getResult("select * from tbl_indxx_sl  where status='1' ",true);	
		
		if(!empty($indxxs))
		{	 
			 foreach($indxxs as $row)
			 {
				if($this->checkHoliday($row['zone'], $datevalue2))
				{
					$final_array[$row['id']]=$row;
				
					$client=$this->db->getResult("select ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
					$final_array[$row['id']]['client']=$client['ftpusername'];

					$slindxx_value=$this->db->getResult("select indxx_value from tbl_indxx_sl_value  where indxx_id='".$row['id']."' order by dateAdded desc ",false,1);
					$final_array[$row['id']]['last_index_value']=$slindxx_value['indxx_value'];

					$liborrates=$this->db->getResult("select price from tbl_libor_prices  where ticker like '%LIBR360  Index%' and date ='".$datevalue2."' ",false,1);	
					$final_array[$row['id']]['libor_rate']=$liborrates['price'];

					/* Fetch user defined adjustment factor for this SL index */
					$calcfactors=$this->db->getResult("select * from tbl_sl_adj_factor  where cs_indxx_id='".$row['id']."' ",true);
					if(!empty($calcfactors))
					{
						foreach($calcfactors as $key=> $calcfactor)
						{
							$indxx_name=$this->db->getResult("select name from tbl_indxx  where code='".$calcfactor['code']."' ",false,1);
							$calcfactors[$key]['indxx_name']=$indxx_name['name'];
							
							$indxx_value=$this->db->getResult("select indxx_value,date from tbl_indxx_value  where code='".$calcfactor['code']."' and date<='".$datevalue2."' order by date desc ",false,2);
							$calcfactors[$key]['indxx_value']=$indxx_value;				
						}
					}
				
					$final_array[$row['id']]['values']=$calcfactors;
				}
			}
		 }
		 		
		/* Generate index value files for various SL indexes */
		if(!empty($final_array))
		{  
			file_put_contents('../files/output/backup/preCLOSESLdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));

		 	foreach($final_array as $key=>$closeIndxx)
			{
				$folder = null;
				if(!$closeIndxx['client'])
				{
					$folder = "../files/output/ca-output/";
					$file= $folder . "Closing-".$closeIndxx['code']."-".$datevalue2.".txt";
				}
				else
				{
					$folder = "../files/output/ca-output/" . $closeIndxx['client'] . "/";
					$file= $folder. "Closing-".$closeIndxx['code']."-".$datevalue2.".txt";
				}
					
				if (!file_exists($folder))
					mkdir($folder, 0777, true);
								
				$entry1='Date'.",";
				$entry1.=date("Y-m-d",strtotime($datevalue2)).",\n";
				$entry1.='INDEX VALUE'.",";
				$entry3.='NAME'.",";
				$entry3.='CODE'.",";
				$entry3.='FACTOR'.",";
				$entry3.='INDEX VALUE'.",";
								
				$entry4='';
		
				/* Calculate the new index value for this SL index based on last value, Libor rate and user defined adjustment factor */
				$index_value=0;
				if(!empty($closeIndxx))
				{
					foreach($closeIndxx['values'] as $security)
					{
						$index_value=$closeIndxx['last_index_value']*(1+($security['fraction']*(($security['indxx_value'][0]['indxx_value']/$security['indxx_value'][1]['indxx_value'])-1)));

			            $entry4.= "\n".$security['indxx_name'].",";
    			        $entry4.=$security['code'].","; 
						$entry4.=$security['fraction'].",";
            			$entry4.=$security['indxx_value'][0]['indxx_value'].",";
			
						$newIndex_value=$index_value-(($closeIndxx['last_index_value']*($security['fraction']-1)*($closeIndxx['libor_rate'])/100)/360);
					}
				}

				$entry2=number_format($newIndex_value,2,'.','').",\n";

				/* Update values of indexes in DB */
				$insertQuery='INSERT into tbl_indxx_sl_value (indxx_id,code,indxx_value,date) values 
						("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.number_format($newIndex_value,2,'.','').'","'.$datevalue2.'")';
				$this->db->query($insertQuery);	

				$open = fopen($file,"w+");
				if ($open)
				{
					if (fwrite($open, $entry1 . $entry2 . $entry3 . $entry4))
					{
						$this->log_info(log_file, "SL index file written for client = " .$closeIndxx['code']);
					}
					else
					{
						$this->log_error(log_file, "SL index file write failed for client = " .$closeIndxx['code']);
						$this->mail_exit(log_file, __FILE__, __LINE__);
					}
				}
				else
				{
					$this->log_error(log_file, "SL index file open failed for client = " .$closeIndxx['code']);
					$this->mail_exit(log_file, __FILE__, __LINE__);
				}
			}
			file_put_contents('../files/output/backup/postOPENSLdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
			unset($final_array);
		}

		$this->log_info(log_file, "SL index file generation process finished.");
		
		$this->Redirect("publishcsixls.php?date=" .$datevalue2. "&log_file=" . log_file, "", "");		
		//$this->saveProcess(2);
	}
}
?>