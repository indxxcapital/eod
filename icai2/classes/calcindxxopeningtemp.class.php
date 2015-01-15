<?php
class Calcindxxopeningtemp extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		//unset ( $_SESSION );

		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		$datevalue2 = $this->_date;
		
		define("log_file", $_GET['log_file']);
		echo "Putting logs in " . log_file;
		
		if($_GET['DEBUG'])
			define("DEBUG", $_GET['DEBUG']);

		$this->log_info(log_file, "Opening file generation process started for upcoming indexes.");
				
		$this->_title = $this->siteconfig->site_title;
		$this->_meta_description = $this->siteconfig->default_meta_description;
		$this->_meta_keywords = $this->siteconfig->default_meta_keyword;
		
		$final_array = array ();
		
		$indxxs = mysql_query("select * from tbl_indxx_temp where status = '1' and usersignoff = '1' and
													dbusersignoff = '1' and submitted = '1' and runindex = '1'");
		if ($err_code = mysql_errno())
		{
			log_error("Unable to read live indexes. MYSQL error code " . $err_code .
			". Exiting opening file process.");
			$this->mail_exit(log_file, __FILE__, __LINE__);
		}
		
		while(false != ($row = mysql_fetch_assoc($indxxs)))
		{
			$row_id  = $row['id'];
			$this->log_info(log_file, "Processing opening data file for index = " . $row_id);
		
			if ($this->checkHoliday($row['zone'], $datevalue2 )) 
			{
				$row_id = $row['id'];
				$final_array[$row_id] = $row;
				
				$indxx_value = $this->db->getResult("select * from tbl_indxx_value_temp where 
													indxx_id = '" .$row_id. "' order by date desc ", false, 1);

				if (!empty($indxx_value)) 
				{
					$final_array [$row_id] ['index_value'] = $indxx_value;
					$datevalue = $indxx_value ['date'];
				} 
				else 
				{
					$final_array [$row_id] ['index_value'] ['market_value'] = $row ['investmentammount'];
					$final_array [$row_id] ['index_value'] ['olddivisor'] = $row ['divisor'];
					$final_array [$row_id] ['index_value'] ['newdivisor'] = $row ['divisor'];
					$final_array [$row_id] ['index_value'] ['indxx_value'] = $row ['investmentammount'] / $row ['divisor'];
				}
								
				$query = "SELECT it.id, it.name, it.isin, it.ticker, it.curr, it.sedol, it.cusip, it.countryname, fp.localprice, 
						fp.currencyfactor, fp.price as calcprice, sh.share as calcshare 
						FROM `tbl_indxx_ticker_temp` it left join tbl_final_price_temp fp on fp.isin=it.isin 
						left join tbl_share_temp sh on sh.isin=it.isin 
						where it.indxx_id='" . $row_id . "' and fp.indxx_id='" . $row_id . "' and sh.indxx_id='" . $row_id . "' 
						 and fp.date='" . $datevalue . "'";
				$indxxprices = $this->db->getResult ( $query, true );

				if (!empty($indxxprices) && !$row ['ica']) 
				{
					foreach ($indxxprices as $key => $indxxprice) 
					{						
						$indxx_dp_value = $this->db->getResult ( "select * from tbl_dividend_ph_temp where indxx_id='" . $row_id . "' and ticker_id ='" . $indxxprice ['id'] . "' ", true );

						if (!empty($indxx_dp_value )) 
						{
							foreach ( $indxx_dp_value as $dpvalue ) 
								$final_array [$row_id] ['divpvalue'] += $dpvalue ['share'] * $dpvalue ['dividend'];
						}

						$ca_query = "select identifier, action_id, id, mnemonic, field_id, company_name, ann_date, eff_date, amd_date,
								currency from tbl_ca cat where eff_date='" . $datevalue2 . "' and identifier='" . $indxxprice ['ticker'] . "'  
								and status='1'  and action_id not in (select ca_action_id from tbl_ignore_index_temp where ca_action_id=cat.action_id)";

						$cas = $this->db->getResult ( $ca_query, true );
						
						if (!empty($cas)) 
						{
							foreach($cas as $cakey => $ca) 
							{
								$ca_value_query = "Select field_name, field_value, field_id from tbl_ca_values_user_edited_temp 
										where ca_id='" . $ca ['id'] . "' and ca_action_id='" . $ca ['action_id'] . "' and indxx_id='" . $row_id . "' ";
								$ca_values = $this->db->getResult ( $ca_value_query, true );

								if (empty($ca_values)) 
								{
									$ca_value_query = "Select field_name, field_value, field_id from tbl_ca_values where 
												ca_id='" . $ca ['id'] . "'  and ca_action_id='" . $ca ['action_id'] . "' ";
									$ca_values = $this->db->getResult ( $ca_value_query, true );
								}
								
								$value = 0;
								if (! empty ( $ca_values )) 
								{
									foreach ( $ca_values as $ca_value ) 
									{
										if ($ca_value ['field_name'] == 'CP_DVD_TYP')
											$value = $ca_value ['field_value'];
									}
								}

								if ($row ['ireturn'] == 1 && $ca ['mnemonic'] == 'DVD_CASH' && $value != 1001)
									$cas [$cakey] = array ();
								else
									$cas [$cakey] ['ca_values'] = $ca_values;
							}
						}
						$indxxprices [$key] ['ca'] = $cas;
					}
				}
				
				$final_array [$row_id] ['values'] = $indxxprices;
			}
		}
		mysql_free_result($indxxs);
		
		$backup_folder = "../files/output/backup/";
		if (!file_exists($backup_folder))
			mkdir($backup_folder, 0777, true);
		
					
		if (! empty ( $final_array )) 
		{
			foreach ( $final_array as $indxxKey => $closeIndxx ) 
			{	
				$index = $final_array[$indxxKey];
				
				//TODO=========================
				file_put_contents($backup_folder .'preopentempdata' . "_" .$indxxKey. '.json', json_encode($index));
				//file_put_contents($backup_folder .'preopentempdata' . "_" .$indxxKey. "_" . date ( "Y-m-d-H-i-s" ) . time () . '.json', json_encode($index));
				
				$this->log_info(log_file, "Preopentempdata file created for index= " . $indxxKey);
					
				$oldindexvalue = $closeIndxx ['index_value'] ['indxx_value'];
				$newindexvalue = 0;
				$oldmarketValue = 0;
				
				$index['index_value']['divisor_impact'] = 0;
				
				$oldDivisor = $closeIndxx ['index_value'] ['olddivisor'];
				$divisorAdjustinStock = $closeIndxx ['cash_adjust'];
								
				foreach ( $closeIndxx ['values'] as $securityKey => $closeprices ) 
				{
					$security = $index['values'][$securityKey];
					$this->log_info(log_file, "	Processing CA for security = " . $security['isin']);
					
					$oldisin = $newisin = '';
						
					$divisorImpact = 0;
					
					$priceAdjfactor = 1;
					$shareAdjfactor = 1;
					
					$base_price = $closeprices ['calcprice'];
					
					$userAdjfactor = $this->get_user_ca_adj_factor ( $closeIndxx ['id'], $closeprices ['id'] );
					if ($userAdjfactor)
					{
						$security['newcalcshare'] = ($closeprices ['calcshare'] * $userAdjfactor);
						$security['newcalcprice'] = ($closeprices ['calcprice'] / $userAdjfactor);
							
						$priceAdjfactor /= $userAdjfactor;
						$shareAdjfactor *= $userAdjfactor;
					}
	
					if (!empty($closeprices ['ca'])) 
					{
						foreach ($closeprices ['ca'] as $ca_key => $ca_actions) 
						{
							$security['ca'] [$ca_key] ['ca_values'] = $this->getCa ( $ca_actions ['id'], $ca_actions ['action_id'] );
							
							if ($closeprices ['calcprice'])
							{
								switch ($ca_actions ['mnemonic'])
								{
									case 'STOCK_SPLT':
										$adjfactor = $this->getAdjFactorforSplit ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey, 1);
											
										if ($adjfactor)
										{
											$security['newcalcshare'] = ($closeprices ['calcshare'] * $adjfactor);
											$security['newcalcprice'] = ($closeprices ['calcprice'] / $adjfactor);
									
											$priceAdjfactor /= $adjfactor;
											$shareAdjfactor *= $adjfactor;
										}
										break;
									
									case 'DVD_STOCK':
										$adjfactor = $this->getAdjFactorforDvdStock ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey, 1);
										if ($adjfactor)
										{
											$adjfactor = ($adjfactor / 100) + 1;
											$security['newcalcshare'] = ($closeprices ['calcshare'] * $adjfactor);
											$security['newcalcprice'] = ($closeprices ['calcprice'] / $adjfactor);
									
											$priceAdjfactor /= $adjfactor;
											$shareAdjfactor *= $adjfactor;
										}
										break;
										
									case 'SPIN':
										$adjfactorSpin = $this->getAdjFactorforSpin ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey, 1 );
									
										if ($adjfactorSpin)
										{
											$security['newcalcshare'] = ($closeprices ['calcshare'] / $adjfactorSpin);
											$security['newcalcprice'] = ($closeprices ['calcprice'] * $adjfactorSpin);
									
											$priceAdjfactor *= $adjfactorSpin;
											$shareAdjfactor /= $adjfactorSpin;
										}
										break;

									case 'RIGHTS_OFFER':
										$cp_ratio = $this->getcpratio ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey, 1 );
										$cp_adj = $this->getAdjFactorforSpin ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey, 1 );
											
										if ($cp_ratio && $cp_adj)
										{
											$offerpricesArray = $this->getOfferPrices ( $ca_actions ['id'], $ca_actions ['action_id'], $ca_actions ['currency'], $index['curr'], $closeIndxx ['index_value'] ['date'], $indxxKey, 1 );
									
											$security['newcalcshare'] = ((1 + $cp_ratio) * $closeprices ['calcshare']);
												
											$z = $closeprices ['calcshare'] * ($closeprices ['calcprice'] + ($cp_ratio * $offerpricesArray ['op_price_index_currency']));
											$security['newcalcprice'] = $z / $security['newcalcshare'];
									
											$newDivisor = $oldDivisor + ((($security['newcalcshare'] * $security['newcalcprice']) - ($closeprices ['calcshare'] * $closeprices ['calcprice'])) / $oldindexvalue);
									
											$priceAdjfactor = $priceAdjfactor * ($security['newcalcprice'] / $closeprices ['calcprice']);
											$shareAdjfactor = $shareAdjfactor * ($security['newcalcshare'] / $closeprices ['calcshare']);
									
											$divisorImpact += $newDivisor - $oldDivisor;
										}
										break;
										
									case 'DVD_CASH':
										$ca_prices = $this->getCaPrices2 ( $ca_actions ['id'], $ca_actions ['action_id'], $ca_actions ['currency'], $index['curr'], $closeIndxx ['index_value'] ['date'], $closeIndxx ['div_type'], $indxxKey, 1 );
											
										if ($closeIndxx ['ireturn'] == 2 && $ca_prices ['CP_DVD_TYP'] != '1001')
										{
											$index['divpvalue'] += ($closeprices ['calcshare'] * $ca_prices ['ca_price_index_currency']);
									
											$security['newcalcprice'] = $base_price - $ca_prices ['ca_price_index_currency'];
									
											$priceAdjfactor = $priceAdjfactor * ($security['newcalcprice'] / $base_price);
									
											$base_price = $security['newcalcprice'];
									
										}
										elseif ($divisorAdjustinStock)
										{
											$newfactor = ($closeprices ['calcprice'] - $ca_prices ['ca_price_index_currency']) / $closeprices ['calcprice'];
											$security['newcalcshare'] = $closeprices ['calcshare'] / $newfactor;
											$security['newcalcprice'] = $closeprices ['calcprice'] * $newfactor;
												
											$priceAdjfactor *= $newfactor;
											$shareAdjfactor /= $newfactor;
										}
										elseif ($ca_prices ['CP_DVD_TYP'] == '1001')
										{
											$adjfactorforcash = $ca_prices ['CP_ADJ'];
																				
											$security['newcalcshare'] = $closeprices ['calcshare'] / $adjfactorforcash;
											$security['newcalcprice'] = $closeprices ['calcprice'] * $adjfactorforcash;
									
											$priceAdjfactor *= $adjfactorforcash;
											$shareAdjfactor /= $adjfactorforcash;
										}
										else
										{
											$security['newcalcprice'] = $base_price - $ca_prices ['ca_price_index_currency'];
									
											$priceAdjfactor = $priceAdjfactor * ($security['newcalcprice'] / $base_price);
											$newDivisor = $oldDivisor - (($closeprices ['calcshare'] * $ca_prices ['ca_price_index_currency']) / $oldindexvalue);
											$divisorImpact += $newDivisor - $oldDivisor;
									
											$base_price = $security['newcalcprice'];
										}
										break;
								}
							}
							
							
							switch ($ca_actions ['mnemonic'])
							{
								case 'CHG_ID':
									$oldisin = $this->getoldISIN ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey );
									$newisin = $this->getnewISIN ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey );
									break;
							
								case 'CHG_NAME':
									$oldname = $this->getoldName ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey );
									$newname = $this->getnewName ( $ca_actions ['id'], $ca_actions ['action_id'], $indxxKey );

									//$nametickerUpdateQuery = 'UPDATE  tbl_indxx_ticker_temp  set name ="' . $newname . '" where indxx_id="' . $indxxKey . '"  and isin="' . $security ['isin'] . '"';
									// $this->db->query($nametickerUpdateQuery);
									$final_array [$indxxKey] ['values'] [$securityKey] ['name'] = $newname;
										
									break;
							}							
						}
					}

					$security['newcalcprice'] = $closeprices ['calcprice'] * $priceAdjfactor;
					$security['newlocalprice'] = $closeprices ['localprice'] * $priceAdjfactor;
					$security ['newcalcshare'] = $closeprices ['calcshare'] * $shareAdjfactor;
						
					if ($security['newcalcshare'] != $closeprices ['calcshare'])
					{
						$shareUpdateQuery = 'UPDATE  tbl_share_temp  set share ="' . $security['newcalcshare'] . '" where indxx_id="' . $indxxKey . '"  and isin="' . $closeprices ['isin'] . '"';
						$this->db->query ( $shareUpdateQuery );
					}
						
					if ($oldisin != '' && $newisin != '')
					{
						if ($closeprices ['isin'] == $oldisin)
						{
							//$isinUpdateQuery = 'UPDATE  tbl_share_temp  set isin ="' . $newisin . '" where indxx_id="' . $indxxKey . '"  and isin="' . $closeprices ['isin'] . '"';
							//$this->db->query ( $isinUpdateQuery );
					
							$isintickerUpdateQuery = 'UPDATE  tbl_indxx_ticker_temp  set isin ="' . $newisin . '" where indxx_id="' . $indxxKey . '"  and isin="' . $closeprices ['isin'] . '"';
							$this->db->query ( $isintickerUpdateQuery );
								
							$security['isin'] = $newisin;
						}
						else
						{
							echo "ISIN mismatch. Exiting process" . "<br>";
							$this->mail_exit(log_file, __FILE__, __LINE__);
						}
					}
					$index['index_value'] ['divisor_impact'] += $divisorImpact;						
				}

				//TODO:================
				file_put_contents($backup_folder . 'postopentempdata' . "_" .$indxxKey.'.json', json_encode ($index));
				//file_put_contents($backup_folder . 'postopentempdata' . "_" .$indxxKey. "_" . date ( "Y-m-d-H-i-s" ) . time () . '.json', json_encode ($index));
				$this->log_info(log_file, "Postopentempdata file created for index= " . $indxxKey);
			}
		}
				
		if (! empty ( $final_array ))
		{
			foreach ( $final_array as $key => $closeIndxx )
			{
				
				$entry1 = 'Date' . ",";
				$entry1 .= $datevalue2 . ",\n";
				$entry1 .= 'INDEX VALUE' . ",";

				$entry3 = 'EFFECTIVE DATE' . ",";
				$entry3 .= 'TICKER' . ",";
				$entry3 .= 'NAME' . ",";
				$entry3 .= 'ISIN' . ",";
				$entry3 .= 'SEDOL' . ",";
				$entry3 .= 'CUSIP' . ",";
				$entry3 .= 'COUNTRY' . ",";
				$entry3 .= 'INDEX SHARES' . ",";
				$entry3 .= 'PRICE' . ",";
			
				if ($closeIndxx ['display_currency']) 
				{
					$entry3 .= 'CURRENCY' . ",";
					$entry3 .= 'CURRENCY FACTOR' . ",";
				}
				
				$entry4 = '';
			
				$newMarketValue = 0;
				
				if (!empty($closeIndxx)) 
				{
					foreach ( $closeIndxx ['values'] as $security ) 
					{
						$newMarketValue += $security ['newcalcprice'] * $security ['newcalcshare'];
						
						$entry4 .= "\n" . date ( "Ymd", strtotime ( $datevalue2 ) ) . ",";
						$entry4 .= $security ['ticker'] . ",";
						$entry4 .= $security ['name'] . ",";
						$entry4 .= $security ['isin'] . ",";
						$entry4 .= $security ['sedol'] . ",";
						$entry4 .= $security ['cusip'] . ",";
						$entry4 .= $security ['countryname'] . ",";
						$entry4 .= $security ['newcalcshare'] . ",";
						$entry4 .= number_format ( $security ['newlocalprice'], 2, '.', '' ) . ",";
						if ($closeIndxx ['display_currency']) 
						{
							$entry4 .= $security ['curr'] . ",";
							$entry4 .= number_format ( $security ['currencyfactor'], 6, '.', '' ) . ",";
						}
					}
				}

				$newDivisorforindxx = $closeIndxx ['index_value'] ['olddivisor'] + $closeIndxx ['index_value'] ['divisor_impact'];
				
				if ($closeIndxx ['divpvalue']) 
					$newMarketValue += $closeIndxx ['divpvalue'];

				$newindexvalue = number_format ( ($newMarketValue / $newDivisorforindxx), 2, '.', '' );
			

				$insertQuery = 'INSERT into tbl_indxx_value_open_temp (indxx_id, code, market_value, indxx_value, date, olddivisor, newdivisor) 
					values ("' . $closeIndxx ['id'] . '","' . $closeIndxx ['code'] . '","' . $newMarketValue . '","' . $newindexvalue . '","' . $datevalue2 . '","' . $closeIndxx ['index_value'] ['olddivisor'] . '","' . $newDivisorforindxx . '")';
				$this->db->query ( $insertQuery );
			
				$entry2 = $newindexvalue . ",\n";

				$output_folder = "../files/output/ca-output_upcoming/";
				if (!file_exists($output_folder))
					mkdir($output_folder, 0777);
				
				$file = $output_folder. "Opening-" . strtolower ( $closeIndxx ['code'] ) . "p-" . $datevalue2 . ".txt";
				$open = fopen ( $file, "w+" );
				
				if ($open) 
				{
					if (fwrite ( $open, $entry1 . $entry2 . $entry3 . $entry4 )) 
					{		
						$insertlogQuery = 'INSERT into tbl_indxx_temp_log (type,indxx_id,value) values 
							("0","' . $closeIndxx ['id'] . '","' . mysql_real_escape_string ( $entry1 . $entry2 . $entry3 . $entry4 ) . '")';
						$this->db->query ( $insertlogQuery );
					
						fclose ( $open );
						$this->log_info(log_file, "Opening file written for client = " .$closeIndxx['client']. ", index = " .$closeIndxx['code']);
					}
					else
					{
						$this->log_error(log_file, "Opening file generation failed for client = " .$closeIndxx['client']. ", index = " .$closeIndxx['code']);
						$this->mail_exit(log_file, __FILE__, __LINE__);
					}
				}
				unset($final_array[$indxxKey]);
			}
			unset($final_array);
		}
		$this->log_info(log_file, "Opening file generation process finished for upcoming indexes.");
				
		// $this->saveProcess(1);
		
		if (DEBUG)
		{
			$this->Redirect("index.php?module=notifyforca&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . log_file, "", "");
		}
		else
		{
			//$this->Redirect("index.php?module=notifyforca&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . log_file, "", "");
			log_error("Unable to locate notify CA module.");
			$this->mail_exit(log_file, __FILE__, __LINE__);
		}		
	}
}
?>