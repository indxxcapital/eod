<?php

class Calclsc extends Application
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
		
		if($_GET['DEBUG'])
			define("DEBUG", $_GET['DEBUG']);

		$this->log_info(log_file, "LSC index file generation process started.");
		
		$final_array=array();
		
		$indxxs=$this->db->getResult("select * from tbl_indxx_lsc  where status='1' ",true);	
						  		
		if(!empty($indxxs))
		{	 
			foreach($indxxs as $row)
			{
				if($this->checkHoliday($row['zone'], $datevalue2))
				{
					$final_array[$row['id']]=$row;
				
					$client=$this->db->getResult("select ftpusername from tbl_ca_client where id='".$row['client_id']."'",false,1);	
					$final_array[$row['id']]['client']=$client['ftpusername'];

					$calcfactor=$this->db->getResult("select * from tbl_lsc_adj_factor where lsc_indxx_id='".$row['id']."' ",false,1);	
					$final_array[$row['id']]['calcfactor']=$calcfactor;
			
					if(!empty($calcfactor))
					{	
						$long_indxx_value=$this->db->getResult("select indxx_value, date from tbl_indxx_value where code='".$calcfactor['long_code']."' order by date desc ",false,1);
						$final_array[$row['id']]['long_index_value']=$long_indxx_value;

						$short_indxx_value=$this->db->getResult("select indxx_value,date from tbl_indxx_value  where code='".$calcfactor['short_code']."' order by date desc ",false,1);
						$final_array[$row['id']]['short_index_value']=$short_indxx_value;
				
						$cash_indxx_value=$this->db->getResult("select indxx_value,date from tbl_cash_indxx_value  where code='".$calcfactor['cash_code']."' order by date desc ",false,1);
						$final_array[$row['id']]['cash_index_value']=$cash_indxx_value;

						if(!empty($long_indxx_value) && !empty($short_indxx_value) && !empty($cash_indxx_value))
						{
							if($cash_indxx_value['date']!=$short_indxx_value['date']  && $cash_indxx_value['date'] !=$long_indxx_value['date'])
							{		
								$msg="Long short Cash Index is not calculated ".$row['name']." due to value mismatch";
								mail("ICAL@indxx.com","Softlayer - Long Short Cash Index Not Calculated ",$msg);
								$this->log_error(log_file, $msg);
								unset($final_array[$row['id']]);
							}
						}
						else
						{
							$msg="LSC index not calculated, ".$row['name']." not available.";					
							$this->log_error(log_file, $msg);
							unset($final_array[$row['id']]);
							$this->mail_exit(log_file, __FILE__, __LINE__);
								
						}
					}
					$final_array[$row['id']]['values']=$calcfactors;
				}
			}
		 }
		 
		if(!empty($final_array))
		{  
			file_put_contents('../files/output/backup/preCLOSELSCdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
		 	
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
				}

				$entry2=number_format($index_value,2,'.','').",\n";

				$insertQuery='INSERT into tbl_indxx_lsc_value (indxx_id, code, indxx_value, date) values 
						("'.$closeIndxx['id'].'","'.$closeIndxx['code'].'","'.number_format($index_value,2,'.','').'","'.$datevalue2.'")';
				$this->db->query($insertQuery);	
	
				$open=fopen($file,"w+");
				if ($open)
				{
					if (fwrite($open, $entry1 . $entry2 . $entry3 . $entry4))
					{
						$this->log_info(log_file, "LSC index file written for client = " .$closeIndxx['code']);
					}
					else
					{
						$this->log_error(log_file, "LSC index file write failed for client = " .$closeIndxx['code']);
						$this->mail_exit(log_file, __FILE__, __LINE__);
					}
				}
				else
				{
					$this->log_error(log_file, "LSC index file open failed for client = " .$closeIndxx['code']);
					$this->mail_exit(log_file, __FILE__, __LINE__);
				}
				
			}

			file_put_contents('../files/output/backup/postCLOSELSCdata'.date("Y-m-d-H-i-s").'.json', json_encode($final_array));
			
			unset($final_array);	
		}
		
		$this->log_info(log_file, "LSC index file generation process finished.");
		
		//$this->saveProcess(2);
		if (DEBUG)
		{
			$this->Redirect("index.php?module=calccsi&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . log_file, "", "");
		}
		else
		{
			//$this->Redirect("index.php?module=calccsi&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . log_file, "", "");
			$this->log_error("Unable to locate CSI index module.");
			$this->mail_exit(log_file, __FILE__, __LINE__);
		}
	}
}
?>