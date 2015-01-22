<pre>
<?php

function convert_headged_security_to_indxx_curr()
{
	//$start = get_time();

	$final_price_array	=	array();

	/* TODO: Don't we need to check for active and signed indexes here and look for currency mismatches? */
	//$indxx = selectrow(array('id', 'name', 'code', 'curr'), 'tbl_indxx', array("currency_hedged" => 1));
	$indxx = mysql_query("Select id, name, code, curr from tbl_indxx where currency_hedged = '1'");

	if ($err_code = mysql_errno())
	{
		log_error("Unable to read live hedged indexes. MYSQL error code " . $err_code .
				". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while(false != ($index = mysql_fetch_assoc($indxx)))
	{
		$index_id = $index['id'];

		$res = mysql_query("Select date from tbl_final_price where indxx_id = '" . $index_id . "' order by date desc limit 0, 1");
		if ($err_code = mysql_errno())
		{
			log_error("Unable to read securities for live hedged indexes. MYSQL error code " . $err_code .
					". Exiting closing file process.");
			mail_exit(__FILE__, __LINE__);
		}
			
		if (false != ($resdate = mysql_fetch_assoc($res)))
		{
			$lastConversionDate = $resdate['date'];

			/* TODO: Check with Deepak, why we are using final_price table here, should not we take inputs from ticker table */	
			$pricequery = mysql_query("SELECT it.isin, it.price, it.localprice, pf.price as localpricetoday   
						FROM `tbl_final_price` it left join  tbl_prices_local_curr pf on pf.isin = it.isin  
						where it.indxx_id = '" . $index['id'] . "' and it.date ='" . $lastConversionDate . "' 
						and pf.date ='" . date . "'");			
			/*
			$pricequery = mysql_query("SELECT it.isin, it.price, it.localprice,
									(select price from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".date."') as localpricetoday  
									FROM `tbl_final_price` it where it.indxx_id='".index_id."' and it.date='".$lastConversionDate."'");
			*/
			
			if ($err_code = mysql_errno())
			{
				log_error("Unable to read price for securities for live hedged indexes. MYSQL error code " . $err_code .
						". Exiting closing file process.");
				mail_exit(__FILE__, __LINE__);
			}

			while(false != ($priceRow = mysql_fetch_assoc($pricequery)))
			{
				if($priceRow['localprice'] && $priceRow['localpricetoday'])
				{
					$change = ($priceRow['localpricetoday'] - $priceRow['localprice']) / $priceRow['localprice'];
					$final_price_array[$index_id][$priceRow['isin']]['price'] = $priceRow['price'] * (1 + $change);
					$final_price_array[$index_id][$priceRow['isin']]['localprice'] = $priceRow['localpricetoday'];
				}
			}
			mysql_free_result($pricequery);
		}
		mysql_free_result($res);
	}
	mysql_free_result($indxx);
		
	if(!empty($final_price_array))
	{	
		foreach($final_price_array as $index_key => $security)
		{
			if(!empty($security))
			{
				foreach($security as $security_key => $prices)
				{
					$fpquery = "INSERT into tbl_final_price (indxx_id, isin, date, price, localprice, currencyfactor) 
								values ('".$index_key."', '".$security_key."', '".date."', '".$prices['price']."', '".$prices['localprice']."', '0')";
					mysql_query($fpquery);
					if ($err_code = mysql_errno())
					{
						log_error("Unable to write prices for live hedged indexes. MYSQL error code " . $err_code .
									". Exiting closing file process.");
						mail_exit(__FILE__, __LINE__);
					}
					unset($security[$security_key]);
				}
				unset($security);
			}
			unset($final_price_array[$index_key]);
		}
		unset($final_price_array[$index_key]);
	}
	
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
	
	convert_headged_security_to_indxx_curr_upcomingindex();
	//saveProcess(2);
	//mysql_close();
}

function convert_headged_security_to_indxx_curr_upcomingindex()
{
	//$start = get_time();
	
	$final_price_array	=	array();
	
	/* TODO: Don't we need to check for active and signed indexes here and look for currency mismatches? */
	//$indxx = selectrow(array('id', 'name', 'code', 'curr'), 'tbl_indxx_temp', array("currency_hedged" => 1));
	$indxx = mysql_query("Select id, name, code, curr from tbl_indxx_temp where currency_hedged = '1'");
	
	if ($err_code = mysql_errno())
	{
		log_error("Unable to read upcoming hedged indexes. MYSQL error code " . $err_code .
				". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while(false != ($index = mysql_fetch_assoc($indxx)))
	{
		$index_id = $index['id'];
	
		$res = mysql_query("Select date from tbl_final_price_temp where indxx_id = '" . $index_id . "' order by date desc limit 0, 1");
		if ($err_code = mysql_errno())
		{
			log_error("Unable to read securities for upcoming hedged indexes. MYSQL error code " . $err_code .
					". Exiting closing file process.");
			mail_exit(__FILE__, __LINE__);
		}
		
		if (false != ($resdate = mysql_fetch_assoc($res)))
		{
			$lastConversionDate = $resdate['date'];

			/*
			$pricequery = mysql_query("SELECT it.isin, it.price, it.localprice,
						(select price from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".$date."') as localpricetoday  
						FROM `tbl_final_price_temp` it where it.indxx_id='".$index['id']."' and it.date='".$lastConversionDate."'");
			*/
			$pricequery = mysql_query("SELECT it.isin, it.price, it.localprice, pf.price as localpricetoday
						FROM `tbl_final_price_temp` it left join  tbl_prices_local_curr pf on pf.isin = it.isin 
						where it.indxx_id = '" . $index_id . "' and it.date ='" . $lastConversionDate . "' 
						and pf.date ='" . date . "'");

			if ($err_code = mysql_errno())
			{
				log_error("Unable to read price for securities for upcoming hedged indexes. MYSQL error code " . $err_code .
							". Exiting closing file process.");
				mail_exit(__FILE__, __LINE__);
			}
				
			while(false != ($priceRow = mysql_fetch_assoc($pricequery)))
			{
				if($priceRow['localprice'] && $priceRow['localpricetoday'])
				{
					$change = ($priceRow['localpricetoday'] - $priceRow['localprice'])/$priceRow['localprice'];
					$final_price_array[$index_id][$priceRow['isin']]['price'] = $priceRow['price']*(1 + $change);
					$final_price_array[$index_id][$priceRow['isin']]['localprice'] = $priceRow['localpricetoday'];
				}
			}
			mysql_free_result($pricequery);
		}
		mysql_free_result($res);
	}
	mysql_free_result($indxx);
	
	if(!empty($final_price_array))
	{
		foreach($final_price_array as $index_key => $security)
		{
			if(!empty($security))
			{
				foreach($security as $security_key => $prices)
				{
					$fpquery="INSERT into tbl_final_price_temp (indxx_id, isin, date, price, localprice, currencyfactor) 
							values ('".$index_key."', '".$security_key."', '".date."', '".$prices['price']."', '".$prices['localprice']."', '0')";
					mysql_query($fpquery);
					
					if ($err_code = mysql_errno())
					{
						log_error("Unable to write prices for upcoming hedged indexes. MYSQL error code " . $err_code .
									". Exiting closing file process.");
						mail_exit(__FILE__, __LINE__);
					}			
					unset($security[$security_key]);
				}
				unset($security);
			}
			unset($final_price_array[$index_key]);
		}
		unset($final_price_array[$index_key]);
	}
	
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
	
	if (DEBUG)
	{
		//exit();
		webopen("http://localhost/eod/icai2/index.php?module=calcindxxclosing&DEBUG=" .DEBUG. "&date=" .date. "&log_file=" . basename(log_file));
	}
	else
	{
		//webopen("http://localhost/eod/icai2/index.php?module=calcindxxclosing&DEBUG=" .DEBUG. "&date=" .date. "&log_file=" . basename(log_file));
		log_error("Unable to locate closing index module.");
		mail_exit(__FILE__, __LINE__);
	}	
	//saveProcess(2);
	//mysql_close();
}
?>