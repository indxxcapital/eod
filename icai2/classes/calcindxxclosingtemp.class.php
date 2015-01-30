<?php

class Calcindxxclosingtemp extends Application
{
	function __construct()
	{
		parent::__construct();
	}
		
	function index()
	{				
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		
		$datevalue = $this->_date;
				
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		$this->log_info(log_file, "Closing file generation process started for upcoming indexes.");

		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;

		$final_array=array();
		
		/* Fetch list of all upcoming indexes with mentioned properties */	
		$indxxs = mysql_query("select * from tbl_indxx_temp where status = '1' and usersignoff = '1' and
															dbusersignoff = '1' and submitted = '1'");
		if ($err_code = mysql_errno())
		{
			$this->log_error(log_file, "Unable to read upcoming indexes. MYSQL error code " . $err_code .
					". Exiting closing file process.");
			$this->mail_exit(log_file, __FILE__, __LINE__);		
		}

		/* Process each index */
		while(false != ($row = mysql_fetch_assoc($indxxs)))
		{
			$row_id  = $row['id'];
			$this->log_info(log_file, "Processing closing data file for index = " . $row_id);
				
			if($this->checkHoliday($row['zone'],$datevalue))
			{
				$final_array[$row_id] = $row;
			
				$client = $this->db->getResult("select ftpusername from tbl_ca_client where id = '".$row['client_id']."'", false, 1);
				$final_array[$row_id]['client'] = $client['ftpusername'];
			
				/* Fetch the last day opening index value */
				$indxx_value = $this->db->getResult("select * from tbl_indxx_value_open_temp where indxx_id = '".$row_id."' order by date desc ", false, 1);

				/* TODO: Check in which scenario we will go in else */
				if(!empty($indxx_value))
				{
					$row['index_value'] = $indxx_value;
				}
				else
				{
					$row['index_value']['market_value'] = $row['investmentammount'];
					$row['index_value']['indxx_value'] = $row['indexvalue'];
					
					if($row['divisor'])
					{
						$row['index_value']['olddivisor'] =
								$row['index_value']['newdivisor'] = $row['divisor'];						
					}
					else
					{
						$row['index_value']['olddivisor'] = 
									$row['index_value']['newdivisor'] = $row['investmentammount']/$row['indexvalue'];
					}
				}

				/* Fetch securities for this index */
				$query = "SELECT  it.id, it.name, it.isin, it.ticker, it.curr, it.sedol, it.cusip, it.countryname, 
							fp.localprice, fp.currencyfactor, fp.price as calcprice, sh.share as calcshare 
							FROM `tbl_indxx_ticker_temp` it left join tbl_final_price_temp fp on fp.isin=it.isin 
							left join tbl_share_temp sh on sh.isin=it.isin where it.indxx_id='" . $row_id . "' 
							and fp.indxx_id='" . $row_id . "' and sh.indxx_id='" . $row_id . "' and fp.date='" . $datevalue . "'";
		
				$indxxprices =	$this->db->getResult($query, true);	
					
				if(!empty($indxxprices))
				{
					foreach($indxxprices as $key=> $indxxprice)
					{
						$indxx_dp_value = $this->db->getResult("select * from tbl_dividend_ph_temp where 
												indxx_id='".$row_id."' and ticker_id ='".$indxxprice['id']."' ", false, 1);
	
						if(!empty($indxx_dp_value))
						{
							foreach($indxx_dp_value as $dpvalue)
							{
								$row['divpvalue'] += $dpvalue['share'] * $dpvalue['dividend'];
							}
						}
					}
				}
				$final_array[$row_id]['values'] = $indxxprices;
			}
		}
		mysql_free_result($indxxs);

		$backup_folder = "../files/output/backup/";
		
		/* Generate closing file for this index */
		if(!empty($final_array))
		{
			foreach($final_array as $indxxKey=> $closeIndxx)
			{
				file_put_contents($backup_folder .'preclosetempdata'. "_" .$indxxKey. "_" .date("Y-m-d-H-i-s").time().'.json', json_encode($final_array[$indxxKey]));
				$this->log_info(log_file, "Pre-CloseData file generated for upcoming index = " .$indxxKey);
				
				$entry1	=	'Date'.",";
				$entry1	.=	date("Y-m-d", strtotime($datevalue)).",\n";
				$entry1	.=	'INDEX VALUE'.",";

				$entry3	=	'EFFECTIVE DATE'.",";
				$entry3	.=	'TICKER'.",";
				$entry3	.=	'NAME'.",";
				$entry3	.=	'ISIN'.",";
				$entry3	.=	'SEDOL'.",";
				$entry3	.=	'CUSIP'.",";
				$entry3	.=	'COUNTRY'.",";
				$entry3	.=	'INDEX SHARES'.",";
				$entry3	.=	'PRICE'.",";
					
				if($row['display_currency'])
				{
					$entry3.='CURRENCY'.",";
					$entry3.='CURRENCY FACTOR'.",";
				}
				$entry4='';
							
				$oldindexvalue = $row['index_value']['indxx_value'];
				$newindexvalue = 0;
				$oldDivisor = $newDivisor = $row['index_value']['newdivisor'];
				$marketValue = 0;
				$sumofDividendes = 0;
					
				foreach($closeIndxx['values'] as $closeprices)
				{
					$shareValue = $closeprices['calcshare'];
					$securityPrice = $closeprices['calcprice'];
					$localprice = (float)$closeprices['localprice'];
					$dividendPrice = 0;
	
					$marketValue 		+= $shareValue * $securityPrice;	
					$sumofDividendes	+= $shareValue * $dividendPrice;	
	
					$entry4	.= 	"\n".date("Ymd", strtotime($datevalue)).",";
		            $entry4	.=  $closeprices['ticker'].",";
		            $entry4	.=	$closeprices['name'].",";
		            $entry4	.=	$closeprices['isin'].",";;
		            $entry4	.=	$closeprices['sedol'].",";;
		            $entry4	.=	$closeprices['cusip'].",";;
		            $entry4	.=	$closeprices['countryname'].",";
		            $entry4	.=	$closeprices['calcshare'].",";
		       		$entry4	.=	number_format($localprice,2,'.','').",";
	
					if($row['display_currency'])
				   	{
				   		$entry4.=$closeprices['curr'].",";
						$entry4.=number_format($closeprices['currencyfactor'],6,'.','').",";
					}
				}
					
				if($closeIndxx['divpvalue'])
					$marketValue += $row['divpvalue'];

				$newindexvalue = number_format(($marketValue/$newDivisor),2,'.','');
	
 				$entry2 = $newindexvalue.",\n";
 				
 				/* Check if index value has fluctuated by >=5% from previous day, send an email if so. */
 				$liveindexvalue = $this->db->getResult("SELECT indxx_value from tbl_indxx_value_temp
								where indxx_id='" . $indxxKey . "'order by date desc limit 0,1", true );
 				
 				//echo "id=" . $indxxKey. " old_val=" .$oldindexvalue. " new_value=" . $newindexvalue ;
 				if ($liveindexvalue && count($liveindexvalue))
 				{
 					//echo " count=" . count($liveindexvalue);
 					if (($existing_value = $liveindexvalue[0]['indxx_value']))
 					{
 						//echo " existing value=" . $existing_value . "<br>";
 						$diff = 100 * (($newindexvalue - $existing_value) / $existing_value);
 						if(($diff >= 5) || ($diff <= - 5))
 						{
 							$this->log_warning(log_file, "Index value fluctuated by more than 5% for index = " . $indxxKey);
							$this->mail_skip(log_file, __FILE__, __LINE__);		
 						}
 					}
 					elseif ($newindexvalue)
 					{
 						$this->log_warning(log_file, "Index value fluctuated by more than 5% for index = " . $indxxKey);
 						$this->mail_skip(log_file, __FILE__, __LINE__);
 					}
 				}
 				
 				/* Write new index value in DB */
 				$insertQuery = 'INSERT into tbl_indxx_value_temp (indxx_id, code, market_value, indxx_value, date, olddivisor, newdivisor) values 
		 				("'.$closeIndxx['id'].'", "'.$closeIndxx['code'].'", "'.$marketValue.'", "'.$newindexvalue.'",
 							"'.$datevalue.'", "'.$oldDivisor.'", "'.$newDivisor.'")';	 				
 				$this->db->query($insertQuery);	

 				$backup_folder1 = "../files/output/ca-output_upcomming/";
 				if (!file_exists($backup_folder1))
 					mkdir($backup_folder1, 0777, true);
 					
 				$file=$backup_folder1. "Closing-".strtolower($closeIndxx['code'])."p-".$datevalue.".txt";

 				$output_folder = "../files/output/ca-output_upcoming/";
 				if (!file_exists($output_folder))
 					mkdir($output_folder, 0777, true);
 					
				$file = $output_folder . "Closing-". strtolower($closeIndxx['code']) . "p-".$datevalue.".txt";
				$open = fopen($file, "w+");
						
				if($open)
				{
					if(fwrite($open, $entry1.$entry2.$entry3.$entry4))
					{
						$insertlogQuery='INSERT into tbl_indxx_temp_log (type, indxx_id, value) values 
										("1", "'.$closeIndxx['id'].'", "'.mysql_real_escape_string($entry1.$entry2.$entry3.$entry4).'")';
						$this->db->query($insertlogQuery);

						fclose($open);
						$this->log_info(log_file, "Closing file [upcoming index] written for client = " .$closeIndxx['client']. ", index = " .$closeIndxx['code']);
					}
					else
					{
						$this->log_error(log_file, "Closing file [upcoming index] generation failed for client = " .$closeIndxx['client']. ", index = " .$closeIndxx['code']);
						$this->mail_exit(log_file, __FILE__, __LINE__);
					}
				}
				file_put_contents($backup_folder .'postclosetempdata'. "_" . $indxxKey . "_"    .date("Y-m-d-H-i-s").time().'.json', json_encode($final_array[$indxxKey]));
				$this->log_info(log_file, "Post-CloseData file generated for upcoming index = " .$indxxKey);
								
				unset($final_array[$indxxKey]);					
			}
			unset($final_array);
		}
		
		$this->log_info(log_file, "Closing file generation process finished for upcoming indexes.");
		
		//$this->saveProcess(2);
		$this->Redirect("index.php?module=compositclose&date=" .$datevalue. "&log_file=" . log_file, "", "");
	}		
} 
?>