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
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		$this->log_info(log_file, "Closing file generation process started.");
		
		$this->_title = $this->siteconfig->site_title;
		$this->_meta_description = $this->siteconfig->default_meta_description;
		$this->_meta_keywords = $this->siteconfig->default_meta_keyword;
		
		$datevalue = date("Y-m-d", strtotime($this->_date) - 86400);
		//TODO: FOR TESTING
		$datevalue = '2014-08-27';
		
		$final_array = array();

		$indxxs = mysql_query("select * from tbl_indxx where status = '1' and usersignoff = '1' and 
															dbusersignoff = '1' and submitted = '1'");

		while(false != ($row = mysql_fetch_assoc($indxxs)))
		{
			$this->log_info(log_file, "Processing closing data file for index = " . $row['id']);	
			$row_id  = $row['id'];
				
			if($this->checkHoliday($row['zone'], $datevalue))
			{
				$final_array[$row_id] = $row;			
			
				$client = $this->db->getResult("select ftpusername from tbl_ca_client where 
												id = '" . $row['client_id'] . "'", false, 1);
				$final_array[$row_id]['client'] = $client['ftpusername'];
			
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
				//TODO: FREE MEMORY FOR queries
				//mysql_free_result($client);
				//mysql_free_result($indxx_value);
				
				$query = "SELECT it.id, it.name, it.isin, it.ticker, curr, sedol, cusip, countryname, fp.price as calcprice, 
						fp.localprice as localprice, fp.currencyfactor as currencyfactor, sh.share as calcshare  
						FROM tbl_indxx_ticker it, tbl_final_price fp, tbl_share sh where 
						it.indxx_id='".$row_id."' and sh.isin=it.isin  and sh.indxx_id='".$row_id."' and 
						fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row_id."'";

				$indxxprices = $this->db->getResult($query, true);	
				
				if(!empty($indxxprices))
				{
					foreach($indxxprices as $key=> $indxxprice)
					{						
						$indxx_dp_value = $this->db->getResult("select * from tbl_dividend_ph where indxx_id='".$row_id."' 
																and ticker_id ='".$indxxprice['id']."' ", false, 1);
							
						if(!empty($indxx_dp_value))
						{
							foreach($indxx_dp_value as $dpvalue)
							{
								$final_array[$row_id]['divpvalue'] += $dpvalue['share'] * $dpvalue['dividend'];
							}
						}
						//TODO: FREE MEMORY FOR queries
						//mysql_free_result($indxx_dp_value);

						/*
						$ca_query = "select identifier, action_id, id, mnemonic, field_id, company_name, ann_date, 
									eff_date, amd_date, currency from tbl_ca where 
									eff_date = '".$datevalue."' and identifier = '".$indxxprice['ticker']."' and status = '1'";
						$cas = $this->db->getResult($ca_query,true);	
						*/
					}
				}
			
				$final_array[$row_id]['values']=$indxxprices;				
			}		
		}
		//TODO: FREE MEMORY FOR queries
		//mysql_free_result($indxxs);
		
		if (!file_exists("../files/output"))
			mkdir("../files/output", 0777);
		file_put_contents('../files/output/preclosedata'.date("Y-m-d-H-i-s").time().'.json', json_encode($final_array));

		if(!empty($final_array))
		{
			foreach($final_array as $indxxKey=> $closeIndxx)
			{
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
				}
				
				if($closeIndxx['divpvalue'])
					$marketValue	+=	$closeIndxx['divpvalue'];

				$newindexvalue=number_format(($marketValue/$newDivisor),2,'.','');
	 
				$entry2	=	$newindexvalue.",\n";
					
				$insertQuery = 'INSERT into tbl_indxx_value (indxx_id, code, market_value, indxx_value, date, olddivisor, 
															newdivisor) values 
								("'.$closeIndxx['id'].'", "'.$closeIndxx['code'].'", "'.$marketValue.'", "'.$newindexvalue.'", 
									"'.$datevalue.'", "'.$oldDivisor.'", "'.$newDivisor.'")';
				$this->db->query($insertQuery);	

				if(!$closeIndxx['client'])
				{
					$file="../files/output/Closing-".$closeIndxx['code']."-".$datevalue.".txt";
				}
				else
				{
					if (!file_exists("../files/output/" . $closeIndxx['client']))
						mkdir("../files/output/" . $closeIndxx['client'], 0777);
						
					$file="../files/output/".$closeIndxx['client']."/Closing-".$closeIndxx['code']."-".$datevalue.".txt";
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
						echo "file written for ".$closeIndxx['code']."({$closeIndxx['client']})<br>";
					}
				}  		
			}
		}
		
		file_put_contents('../files/output/postclosedata'.date("Y-m-d-H-i-s").time().'.json', json_encode($final_array));
		$this->log_info(log_file, "Closing file generation process finished.");
	}   
} 
?>