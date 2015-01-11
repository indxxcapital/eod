<?php
//include("function.php");

class Calcindxxclosing extends Application
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		
		$datevalue = date ( "Y-m-d" );
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
		{
			define("DEBUG", $_GET['DEBUG']);

			if($_GET['date'])
			{
				$datevalue = $_GET['date'];
			}
			else
			{
				$this->log_info(log_file, "No date provided in DEBUG mode");
				$this->mail_exit(log_file, __FILE__, __LINE__);		
			}
		}
						
		$this->log_info(log_file, "Closing file generation process started for live indexes.");
		
		$this->_title 				= $this->siteconfig->site_title;
		$this->_meta_description 	= $this->siteconfig->default_meta_description;
		$this->_meta_keywords 		= $this->siteconfig->default_meta_keyword;
		
		$final_array = array();

		$indxxs = mysql_query("select * from tbl_indxx where status = '1' and usersignoff = '1' and 
															dbusersignoff = '1' and submitted = '1'");
		if ($err_code = mysql_errno())
		{
			log_error("Unable to read live indexes. MYSQL error code " . $err_code .
					". Exiting closing file process.");
			$this->mail_exit(log_file, __FILE__, __LINE__);
		}
		
		while(false != ($row = mysql_fetch_assoc($indxxs)))
		{
			$row_id  = $row['id'];
			$this->log_info(log_file, "Processing closing data file for index = " . $row_id);	
				
			if($this->checkHoliday($row['zone'], $datevalue))
			{
				$final_array[$row_id] = $row;			
			
				$res = mysql_query("select ftpusername from tbl_ca_client where id = '" .$row['client_id']. "'");
				if ($err_code = mysql_errno())
				{
					log_error("Mysql query failed, error code " .$err_code. ". Exiting closing file process.");
					$this->mail_exit(log_file, __FILE__, __LINE__);
				}
				$client = mysql_fetch_assoc($res);				
				$final_array[$row_id]['client'] = $client['ftpusername'];
				mysql_free_result($res);
				
				$indxx_value = $this->db->getResult("select * from tbl_indxx_value_open where 
													indxx_id = '" . $row_id . "' order by date desc ", false, 1);
			
				if(!empty($indxx_value))
				{
					$final_array[$row_id]['index_value'] = $indxx_value;
				}
				else
				{
					$final_array[$row_id]['index_value']['market_value'] = $row['investmentammount'];
					$final_array[$row_id]['index_value']['indxx_value'] = $row['indexvalue'];

					if($row['divisor'])
					{
						$final_array[$row_id]['index_value']['olddivisor'] =
								$final_array[$row_id]['index_value']['newdivisor'] = $row['divisor'];
					}
					else
					{
						$final_array[$row_id]['index_value']['olddivisor'] = 
								$final_array[$row_id]['index_value']['newdivisor'] = $row['investmentammount']/$row['indexvalue'];
					}
				}
				/*
				$query = "SELECT it.id, it.name, it.isin, it.ticker, it.curr, it.sedol, it.cusip, it.countryname, fp.price as calcprice, 
						fp.localprice as localprice, fp.currencyfactor as currencyfactor, sh.share as calcshare  
						FROM tbl_indxx_ticker it, tbl_final_price fp, tbl_share sh where 
						it.indxx_id='".$row_id."' and sh.isin=it.isin  and sh.indxx_id='".$row_id."' and 
						fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row_id."'";
				*/
				$query="SELECT  it.id, it.name, it.isin, it.ticker, it.curr, it.sedol, it.cusip, it.countryname, fp.localprice, fp.currencyfactor, 
						fp.price as calcprice, sh.share as calcshare FROM `tbl_indxx_ticker` it left join tbl_final_price fp on fp.isin=it.isin 
						left join tbl_share sh on sh.isin=it.isin where it.indxx_id='".$row_id."' and fp.indxx_id='".$row_id."'
						 and sh.indxx_id='".$row_id."' and fp.date='".$datevalue."'";
				
				$indxxprices = $this->db->getResult($query, true);	
				
				if(!empty($indxxprices))
				{
					foreach($indxxprices as $key=> $indxxprice)
					{						
						/* TODO: Convert this to direct mysql query */
						$indxx_dp_value = $this->db->getResult("select * from tbl_dividend_ph where indxx_id='".$row_id."' 
																and ticker_id ='".$indxxprice['id']."' ", false, 1);
							
						if(!empty($indxx_dp_value))
						{
							foreach($indxx_dp_value as $dpvalue)
							{
								$final_array[$row_id]['divpvalue'] += $dpvalue['share'] * $dpvalue['dividend'];
							}
						}
					}
				}			
				$final_array[$row_id]['values'] = $indxxprices;				
			}		
		}
		mysql_free_result($indxxs);
			
		$backup_folder = "../files/output/backup/";
		if (!file_exists($backup_folder))
			mkdir($backup_folder, 0777, true);
		
		if(!empty($final_array))
		{
			foreach($final_array as $indxxKey=> $closeIndxx)
			{
				file_put_contents($backup_folder .'preclosedata'. "_" .$indxxKey. "_" .date("Y-m-d-H-i-s").time().'.json', json_encode($final_array[$indxxKey]));
				$this->log_info(log_file, "Pre-CloseData file generated for index = " .$indxxKey);
				
				$entry1		 =	'Date'.",";
				$entry1		.=	date("Y-m-d", strtotime($datevalue)).",\n";
				$entry1		.=	'INDEX VALUE'.",";
				
				$entry3		 =	'EFFECTIVE DATE'.",";
				$entry3		.=	'TICKER'.",";
				$entry3		.=	'NAME'.",";
				$entry3		.=	'ISIN'.",";
				$entry3		.=	'SEDOL'.",";
				$entry3		.=	'CUSIP'.",";
				$entry3		.=	'COUNTRY'.",";
				$entry3		.=	'INDEX SHARES'.",";
				$entry3		.=	'PRICE'.",";
			
				if($closeIndxx['display_currency'])
				{
					$entry3	.=	'CURRENCY'.",";
					$entry3	.=	'CURRENCY FACTOR'.",";
				}

				$entry4	= '';
			
				$oldindexvalue		=	$closeIndxx['index_value']['indxx_value'];
				$newindexvalue		=	0;
				$newDivisor = $oldDivisor =	$closeIndxx['index_value']['newdivisor'];
				$marketValue		=	0;
				$sumofDividendes	=	0;
			
				foreach($closeIndxx['values'] as $closeprices)
				{
					//echo "for loop for ".$closeIndxx['client']. " index = " .$closeIndxx['code']. "<br>";
					$shareValue		=	$closeprices['calcshare'];	
					$securityPrice	=	$closeprices['calcprice'];
					$localprice		=	(float)$closeprices['localprice'];
					$dividendPrice	=	0;

					if(!empty($closeprices['ca']))
					{
						foreach($closeprices['ca'] as $ca_actions)
						{
							if($ca_actions['mnemonic']	==	'DVD_CASH')
							{
									$ca_prices= $this->getCaPrices($ca_actions['id'], $ca_actions['action_id'], $ca_actions['currency'],
																	$final_array[$indxxKey]['curr'], $datevalue);
									$dividendPrice += $ca_prices['ca_price_index_currency'];
							}
						}
					}
			
					$marketValue		+=	$shareValue * $securityPrice;	
					$sumofDividendes	+=	$shareValue * $dividendPrice;	
			
					$entry4	.= 	"\n".date("Ymd",strtotime($datevalue)).",";
		            $entry4	.=  $closeprices['ticker'].",";
		            $entry4	.= 	$closeprices['name'].",";
		            $entry4	.=	$closeprices['isin'].",";;
		            $entry4	.=	$closeprices['sedol'].",";;
		            $entry4	.=	$closeprices['cusip'].",";;
		            $entry4	.=	$closeprices['countryname'].",";
		            $entry4	.=	$closeprices['calcshare'].",";
		       		$entry4	.=	number_format($localprice,2,'.','').",";

					if($closeIndxx['display_currency'])
			     	{
			     		$entry4	.=	$closeprices['curr'].",";
						$entry4	.=	number_format($closeprices['currencyfactor'],6,'.','').",";
					}
				
					/* TODO: Weight calculation, this is not getting used anywhere at the moment */
					if(false)
					{	
						/* Calculate the weight of the security for this index */
						$weight = (($closeprices ['calcshare'] * $closeprices ['calcprice']) / $marketValue) * 100;
						
						$insertQuery = 'INSERT into tbl_weights (indxx_id, code, date, share, price, weight, isin) values 
								("' . $closeIndxx ['id'] . '","' . $closeIndxx ['code'] . '","' . $datevalue . '","' . $closeprices ['calcshare'] . '","' . $closeprices ['calcprice'] . '","' . $weight . '","' . $closeprices ['isin'] . '")';
						$this->db->query ( $insertQuery );
						//TODO: Error handling
					}
				}
				
				if($closeIndxx['divpvalue'])
					$marketValue	+=	$closeIndxx['divpvalue'];
				
				$newindexvalue=number_format(($marketValue/$newDivisor),2,'.','');
				
				$entry2	=	$newindexvalue.",\n";

				/*
				 * Check if index value has fluctuated by >=5% from previous day, send an email if so. 
				 * TODO: This check should be between opening price and current price?
				 * Current code is for closing to closing variation 
				 */
				$liveindexvalue = $this->db->getResult("SELECT indxx_value from tbl_indxx_value 
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
							/* TODO: Send email for this */
						}
					}
				}
				
				$insertQuery = 'INSERT into tbl_indxx_value (indxx_id, code, market_value, indxx_value, date, olddivisor, newdivisor) values 
								("'.$closeIndxx['id'].'", "'.$closeIndxx['code'].'", "'.$marketValue.'", "'.$newindexvalue.'", 
									"'.$datevalue.'", "'.$oldDivisor.'", "'.$newDivisor.'")';
				$this->db->query($insertQuery);	

				$output_folder = "../files/output/ca-output/";
				if (!file_exists($output_folder))
					mkdir($output_folder, 0777);
				
				if(!$closeIndxx['client'])
				{
					$file=$output_folder ."Closing-".$closeIndxx['code']."-".$datevalue.".txt";
				}
				else
				{
					if (!file_exists($output_folder . $closeIndxx['client']))
						mkdir($output_folder . $closeIndxx['client'], 0777);
						
					$file=$output_folder .$closeIndxx['client']."/Closing-".$closeIndxx['code']."-".$datevalue.".txt";
				}					
				
				$open = fopen($file, "w+");
				
				if($open)
				{   
					if(fwrite($open, $entry1.$entry2.$entry3.$entry4))
					{    
						$insertlogQuery='INSERT into tbl_indxx_log (type, indxx_id, value) values 
										("1", "'.$closeIndxx['id'].'", "'.mysql_real_escape_string($entry1.$entry2.$entry3.$entry4).'")';
						$this->db->query($insertlogQuery);
	   					fclose($open);
						$this->log_info(log_file, "Closing file written for client = " .$closeIndxx['client']. ", index = " .$closeIndxx['code']);
					}
					else
					{
						$this->log_error(log_file, "Closing file generation failed for client = " .$closeIndxx['client']. ", index = " .$closeIndxx['code']);
					}
				}
				file_put_contents($backup_folder .'postclosedata'. "_" . $indxxKey . "_"    .date("Y-m-d-H-i-s").time().'.json', json_encode($final_array[$indxxKey]));
				$this->log_info(log_file, "Post-CloseData file generated for index = " .$indxxKey);
				
				unset($final_array[$indxxKey]);
			}
			unset($final_array);
		}
		
		$this->log_info(log_file, "Closing file generation process finished for live indexes.");
		
		//$this->saveProcess(2);
		if (DEBUG)
		{
			$this->Redirect2("index.php?module=calcindxxclosingtemp&DEBUG=" .DEBUG. "&date=" .$datevalue. "&log_file=" . log_file, "", "");
		}
		else
		{
			//$this->Redirect2("index.php?module=calcindxxclosingtemp&DEBUG=" .DEBUG. "&date=" .$datevalue. "&log_file=" . log_file, "", "");
			log_error("Unable to locate closing upcoming index module.");
			exit();
		}
	}   
} 
?>