<pre>
<?php

function check_security_price_fluctuations()
{
	$msg = '';
	
	$securities = mysql_query("SELECT distinct (ticker) FROM tbl_indxx_ticker WHERE status='1' 
						union SELECT distinct(ticker)  FROM tbl_indxx_ticker_temp WHERE status='1'");

	if ($err_code = mysql_errno())
		mail_exit(__FILE__, __LINE__);	

	while ($security = mysql_fetch_assoc($securities))
	{
		$security_values = mysql_query("SELECT price, isin from tbl_prices_local_curr where ticker ='" .$security['ticker']. 
								"'order by date desc limit 0,2");

		if (($err_code = mysql_errno()))
			mail_exit(__FILE__, __LINE__);

		$row1 = mysql_fetch_assoc($security_values);
		$row2 = mysql_fetch_assoc($security_values);
				
		if ($row1['price'] && $row2['price'])
		{
			$diff = 100 * (($row1['price'] - $row2['price']) / $row2['price']);

			if(($diff >= 5) || ($diff <= - 5))
				$msg .= "Security value fluctuated by more than 5% for security_isin=" . $row2['isin'] . ".\n";
		}
	}
	
	if ($msg != '')
		mail_info($msg);
}

function send_index_deactivation_mail($keyindex, $valueindex, $index_type)
{	
	$index_table = "tbl_indxx";
	
	$emailsids			=	'';
	$dbuseremailsids	=	'';
	
	if ($index_type != "LIVE")
		$index_table = "tbl_indxx_temp";

	$indexnameres = mysql_query("select name from " .$index_table. " where id='" . $keyindex . "'");
	$indexname = mysql_fetch_assoc($indexnameres);
	//print_r($indexname);
	
	$useremailres = mysql_query("select name, email from tbl_ca_user where status = '1'");
	while(false != ($users = mysql_fetch_assoc($useremailres)))
	{
		if(!empty($users['email']))
			$emailsids .= $users['email'] . ",";
	}
	$emailsids = substr($emailsids, 0, -1);
	//echo $emailsids;
	
	$dbuseremailres = mysql_query("select name, email from tbl_database_users where status = '1'");
	while(false != ($dbusers = mysql_fetch_assoc($dbuseremailres)))
	{
		if(!empty($dbusers['email']))
			$dbuseremailsids.=$dbusers['email'].",";
	}
	$dbuseremailsids = substr($dbuseremailsids, 0, -1);
	//echo $dbuseremailsids;

	$sub ='ICAI currency mismatch notification';
	$msg ='Currency mismatch in index <strong>'. $indexname['name'] . '</strong> for security <strong>' . $valueindex . '</strong>.<br>Thanks!';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n";
	
	if(!empty($emailsids))
	{
		if(mail($emailsids, $sub, $msg, $headers))
			log_info("Index de-activated. Mail sent to users.");
		else
			log_error("Index de-activated. Unable to send email to users.");
	}

	if(!empty($dbuseremailsids))
	{
		if(mail($dbuseremailsids, $sub, $msg, $headers))
			log_info("Index de-activated. Mail sent to dbusers.");
		else
			log_error("Index de-activated. Unable to send email to dbusers.");
	}		
}

function convert_security_to_indxx_curr()
{
	//$start = get_time();

	/* Check if the security price has fluctuated more than 5%, if so send email. */
	check_security_price_fluctuations();
	
	$index_query =	mysql_query("SELECT id, currency_hedged, curr FROM `tbl_indxx` WHERE `status` = '1' 
									AND `usersignoff` = '1'	AND `dbusersignoff` = '1' AND `submitted` = '1'");

	if (!($err_code = mysql_errno()))
	{	
		$final_price_array	=	array();
		$indexarray			=	array();

		while(false != ($index = mysql_fetch_assoc($index_query)))
		{
			$index_id = $index['id'];
			log_info("Processing index = " .$index_id);
				
			/* Check if given index is local currency hedged index or not. */
			$convert_flag = false;			
			if($index['currency_hedged'] == 1)
			{
				/* TODO: Check this logic and why this table is used instead of tbl_indxx_ticker */
				if (false != ($res = mysql_query("Select date from tbl_final_price 
													where indxx_id = '".$index_id."' order by date desc limit 0, 1")))
				{
					if(!mysql_num_rows($res))
						$convert_flag = true;
				}
				else
				{
					log_error("MYSQL query failed. Exiting closing process.");
					mail_exit(__FILE__, __LINE__);
				}
				mysql_free_result($res);
			}
			else
			{
				$convert_flag = true;
			}

			/* Start processing the securities for this index */
			if($convert_flag)
			{
				$res = mysql_query("SELECT it.isin, it.ticker, pf.price as localprice , pf.curr as local_currency, 
									it.curr as ticker_currency 
									FROM tbl_indxx_ticker it left join tbl_prices_local_curr pf on pf.isin=it.isin 
									where it.indxx_id='".$index_id."' and pf.date='".date."'");
				log_info("	Securities in index = " .mysql_num_rows($res));

				if (($err_code = mysql_errno()))
				{
					log_error("Unable to read securities for live index = " . $index_id . 
								". MYSQL error code = " . $err_code . ". Exiting closing file processing.");
					mail_exit(__FILE__, __LINE__);
				}
				
				$row = 0;				
				while(false != ($priceRow = mysql_fetch_assoc($res)))
				{
					$currencyPrice = 0;
					//log_info("	Processing security isin = " .$priceRow['isin']);
						
					/*
					 * Check if got the right currency for the security from Bloomberg.
					 * If not, raise alert and disable this index.
					 */					
					if($priceRow['local_currency'] != $priceRow['ticker_currency'])
					{
						mail_info("Currency mismatch for index=" .$index_id. "[localcurrency=" 
									.$priceRow['local_currency']. "][ticker_curr=" .$priceRow['ticker_currency']. "]");
						
						$indexarray[$index_id] = $priceRow['ticker'];
						break;
					}
					else
					{
						$currencyPrice = 1;
						$final_price_array[$index_id][$row]['price'] = $priceRow['localprice'];
												
						if($index['curr'] && ($index['curr'] != $priceRow['local_currency']))
						{
							//log_info("	Conversion Required for ".$index['curr'].$priceRow['local_currency']);
							$cfactor_code = $index['curr'].$priceRow['local_currency'];

							$cfactor = getPriceforCurrency($cfactor_code, date);
							$currencyPrice = $cfactor;
							$final_price_array[$index_id][$row]['price'] = $priceRow['localprice']/$cfactor;

							/* Some currency tickers are in cents - GBP/GBp */
							if(strcmp($cfactor_code, strtoupper($cfactor_code)))
								$final_price_array[$index_id][$row]['price'] /= 100;
						}

						$final_price_array[$index_id][$row]['isin'] = $priceRow['isin'];
						$final_price_array[$index_id][$row]['localprice'] = $priceRow['localprice'];
						$final_price_array[$index_id][$row]['currencyfactor'] = $currencyPrice; //TODO: Should not this be cfactor?
					}
					$row++;
				}

				/* Free the security table for this index */
				mysql_free_result($res);
			}
		}
		
		/* Remove duplicates from the array */
		$indexarray = array_unique($indexarray);

		/* Send email for faulty indexes and de-activate the same. */
		foreach($indexarray as $keyindex => $valueindex)
		{
			//send_index_deactivation_mail($keyindex, $valueindex, "LIVE");
		
			/* De-activate this index */
			unset($final_price_array[$keyindex]);
			$res1 = mysql_query("update tbl_indxx set status = '0' where id = '" . $keyindex . "'");

			if (($err_code = mysql_errno()))
			{
				log_error("Unable to de-activate index = " . $keyindex .
							". MYSQL error code = " . $err_code . 
							". Exiting process");
				mail_exit(__FILE__, __LINE__);
			}
		}

		/* Update tbl_final_price table for rest of the indexes */
		if(!empty($final_price_array))
		{
			foreach($final_price_array as $indxx_id => $ival)
			{
				if(!empty($ival))
				{
					foreach($ival as $tempKey=>$ivalue)
					{				
						$fpquery="INSERT into tbl_final_price 
								(indxx_id, isin, date, price, localprice, currencyfactor) values 
								('" . $indxx_id . "','" . $ivalue['isin'] . "','" . date . "', 
								 '" . $ivalue['price'] . "','" . $ivalue['localprice'] . "', '" . $ivalue['currencyfactor'] . "')";
						mysql_query($fpquery);
						
						if (($err_code = mysql_errno()))
						{
							log_error("Unable to update converted prices for live index = " . $indxx_id .
											". MYSQL error code = " . $err_code . ". ");
							mail_exit(__FILE__, __LINE__);
						}
					}
				}
				unset($final_price_array[$indxx_id]);
			}
			unset($final_price_aray);
		}
		mysql_free_result($index_query);
	}
	else
	{
		log_error("Unable to read live indexes. MYSQL error code " . $err_code .
				". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);

	convert_security_to_indxx_curr_upcomingindex();
	//saveProcess(2);
	//mysql_close();	
}

function convert_security_to_indxx_curr_upcomingindex()
{
	//$start = get_time();

	$final_price_array	=	array();
	$indexarray			=	array();
	
	$index_query =	mysql_query("SELECT id, name, code, curr, currency_hedged FROM `tbl_indxx_temp` 
								WHERE `status` = '1' AND `submitted` = '1'");
	
	if (!($err_code = mysql_errno()))
	{
		while(false != ($index = mysql_fetch_assoc($index_query)))
		{
			$index_id = $index['id'];
			log_info("Processing upcoming index = " .$index_id);
				
			/* Check if given index is local currency hedged index or not. */
			$convert_flag = false;
			if($index['currency_hedged'] == 1)
			{
				/* TODO: Check this logic and why this table is used instead of tbl_indxx_ticker */
				if (false != ($res = mysql_query("Select date from tbl_final_price_temp 
													where indxx_id = '".$index_id."' order by date desc limit 0, 1")))
				{
					if(!mysql_num_rows($res))
						$convert_flag = true;
				}
				else
				{
					log_error("MYSQL query failed. Exiting closing process.");
					mail_exit(__FILE__, __LINE__);
				}
				mysql_free_result($res);
			}
			else
			{
				$convert_flag = true;
			}
			
			if($convert_flag)
			{
				$res = mysql_query("SELECT it.isin, it.ticker, pf.price as localprice , pf.curr as local_currency,
									it.curr as ticker_currency
									FROM tbl_indxx_ticker_temp it left join tbl_prices_local_curr pf on pf.isin=it.isin
									where it.indxx_id='".$index_id."' and pf.date='".date."'");

				log_info("	Securities in index = " .mysql_num_rows($res));
				
				if (($err_code = mysql_errno()))
				{
					log_error("Unable to read securities for upcoming index = " . $index_id .
						". MYSQL error code = " . $err_code . ". Exiting closing file processing.");
					mail_exit(__FILE__, __LINE__);
				}
				
				$row = 0;
				while(false != ($priceRow = mysql_fetch_assoc($res)))
				{
					$currencyPrice = 0;
					log_info("	Processing security isin = " .$priceRow['isin']);
						
					/*
					 * Check if got the right currency for the security from Bloomberg.
					 * If not, raise alert and disable this index.
					 */
					if($priceRow['local_currency'] != $priceRow['ticker_currency'])
					{
						mail_info("	Currency mismatch for index=" .$index_id. "[localcurrency="
								.$priceRow['local_currency']. "][ticker_curr=" .$priceRow['ticker_currency']. "]");

						$indexarray[$index_id] = $priceRow['ticker'];
						break;
					}
					else
					{
						$currencyPrice = 1;
						$final_price_array[$index_id][$row]['price'] = $priceRow['localprice'];

						if($index['curr'] && ($index['curr'] != $priceRow['local_currency']))
						{
							$cfactor_code = $index['curr'].$priceRow['local_currency'];

							$cfactor = getPriceforCurrency($cfactor_code, date);
							$currencyPrice = $cfactor;

							$final_price_array[$index_id][$row]['price']= $priceRow['localprice']/$cfactor;
							
							if(strcmp($cfactor_code,strtoupper($cfactor_code)))
								$final_price_array[$index_id][$row]['price'] /= 100;
						}
					
						$final_price_array[$index_id][$row]['isin'] = $priceRow['isin'];
						$final_price_array[$index_id][$row]['localprice'] = $priceRow['localprice'];
						$final_price_array[$index_id][$row]['currencyfactor'] = $currencyPrice;
					}
					$row++;
				}
				/* Free the security table for this index */
				mysql_free_result($res);
			}
		}

		/* Remove duplicates from the array */
		$indexarray = array_unique($indexarray);
			
		/* Send email for faulty indexes and de-activate the same. */
		foreach($indexarray as $keyindex => $valueindex)
		{
			//send_index_deactivation_mail($keyindex, $valueindex, "UPCOMING");
			
			/* De-activate this index */
			unset($final_price_array[$keyindex]);
			mysql_query("update tbl_indxx_temp set status = '0' where id = '" . $keyindex . "'");
				
			if (($err_code = mysql_errno()))
			{
				log_error("Unable to de-activate index = " . $keyindex .
							". MYSQL error code = " . $err_code .
							". Exiting process");
				mail_exit(__FILE__, __LINE__);
			}
		}

		/* Update tbl_final_price table for rest of the indexes */
		if(!empty($final_price_array))
		{
			foreach($final_price_array as $indxx_id => $ival)
			{
				if(!empty($ival))
				{
					foreach($ival as $tempKey=>$ivalue)
					{
						$fpquery="INSERT into tbl_final_price_temp
									(indxx_id, isin, date, price, localprice, currencyfactor) values
									('" . $indxx_id . "','" . $ivalue['isin'] . "','" . date . "',
									 '" . $ivalue['price'] . "','" . $ivalue['localprice'] . "', '" . $ivalue['currencyfactor'] . "')";
						mysql_query($fpquery);
		
						if (($err_code = mysql_errno()))
						{
							log_error("Unable to update converted prices for upcoming index = " . $indxx_id .
										". MYSQL error code = " . $err_code . ". ");
							mail_exit(__FILE__, __LINE__);
						}
					}
				}
				unset($final_price_array[$indxx_id]);
			}
			unset($final_price_array);
		}
		mysql_free_result($index_query);
	}
	else
	{
		log_error("Unable to read upcoming indexes. MYSQL error code " . $err_code .
					". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}	
	
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
	
	convert_headged_security_to_indxx_curr();
	//webopen("convert_currency_hedged_temp.php");
	//saveProcess(2);
	//mysql_close();
}
?>