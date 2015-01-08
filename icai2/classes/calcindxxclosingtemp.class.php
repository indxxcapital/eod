<?php

class Calcindxxclosingtemp extends Application
{
	function __construct()
	{
		parent::__construct();
	}
		
	function index()
	{				
		$datevalue = date("Y-m-d", strtotime($this->_date) - 86400);
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
		{
			define("DEBUG", $_GET['DEBUG']);
			//$this->log_info(log_file, "Executing closing file generation process in DEBUG mode");
		
			if($_GET['date'])
			{
				$datevalue = $_GET['date'];
			}
			else
			{
				$this->log_info(log_file, "No date provided in DEBUG mode");
				exit();
			}
		}
		
		$this->log_info(log_file, "Closing file generation process started for upcoming indexes.");

		$this->_title=$this->siteconfig->site_title;
		$this->_meta_description=$this->siteconfig->default_meta_description;
		$this->_meta_keywords=$this->siteconfig->default_meta_keyword;

		$final_array=array();
		
		$indxxs = mysql_query("select * from tbl_indxx_temp where status = '1' and usersignoff = '1' and
															dbusersignoff = '1' and submitted = '1'");
		if ($err_code = mysql_errno())
		{
			log_error("Unable to read upcoming indexes. MYSQL error code " . $err_code .
					". Exiting closing file process.");
			mail(email_errors, "Unable to read upcoming indexes.", "MYSQL error code " . $err_code . ".");
			exit();
		}

		while(false != ($row = mysql_fetch_assoc($indxxs)))
		{
			$row_id  = $row['id'];
			$this->log_info(log_file, "Processing closing data file for index = " . $row_id);
				
			if($this->checkHoliday($row['zone'],$datevalue))
			{
				$final_array[$row_id] = $row;
			
				$client = $this->db->getResult("select ftpusername from tbl_ca_client where id = '".$row['client_id']."'", false, 1);
				$final_array[$row_id]['client'] = $client['ftpusername'];
			
				$indxx_value = $this->db->getResult("select * from tbl_indxx_value_open_temp where indxx_id = '".$row_id."' order by date desc ", false, 1);

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

		if(!empty($final_array))
		{
			foreach($final_array as $indxxKey=> $closeIndxx)
			{
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
	
 				$insertQuery = 'INSERT into tbl_indxx_value_temp (indxx_id, code, market_value, indxx_value, date, olddivisor, newdivisor) values 
		 				("'.$closeIndxx['id'].'", "'.$closeIndxx['code'].'", "'.$marketValue.'", "'.$newindexvalue.'",
 							"'.$datevalue.'", "'.$oldDivisor.'", "'.$newDivisor.'")';	 				
 				$this->db->query($insertQuery);	

				$file = "../files/output/Closing-". strtolower($closeIndxx['code']) . "p-".$datevalue.".txt";
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
					}
				}
				unset($final_array[$indxxKey]);					
			}
			unset($final_array);
		}
		
		$this->log_info(log_file, "Closing file generation process finished for upcoming indexes.");
		
		//$this->saveProcess(2);
		if (DEBUG)
		{
			$this->Redirect2("index.php?module=compositclose&DEBUG=" .DEBUG. "&date=" .$datevalue. "&log_file=" . log_file, "", "");
		}
		else
		{
			//$this->Redirect2("index.php?module=calcindxxclosingtemp&DEBUG=" .DEBUG. "&date=" .$datevalue. "&log_file=" . log_file, "", "");
			log_error("Unable to locate composite close module.");
			exit();
		}
	}		
} 
?>