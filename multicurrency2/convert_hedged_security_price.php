<pre>
<?php

function convert_headged_security_to_indxx_curr()
{
	$start = get_time();

	$final_price_array	=	array();

	/* 
	 * TODO: Don't we need to check for active and signed indexes here and look for currency mismatches? ? 
	 * Convert this to direct mysql query
	 */
	$indxx = selectrow(array('id', 'name', 'code', 'curr'), 'tbl_indxx', array("currency_hedged" => 1));
	//$indxx = mysql_query("Select id, name, code, curr from tbl_indxx where currency_heged = '1'");
	
	if(!empty($indxx))
	{
		foreach($indxx as $key => $index)
		{
			//print_r($index);
			$res = mysql_query("Select date from tbl_final_price where indxx_id = '" . $index['id'] . "' order by date desc limit 0, 1");
			if (false != ($resdate = mysql_fetch_assoc($res)))
			{
				$lastConversionDate = $resdate['date'];

				/*
				$pricequery = mysql_query("SELECT it.isin, it.price, it.localprice, pf.price as localpricetoday   
							FROM `tbl_final_price` it,  tbl_prices_local_curr pf 
							where it.indxx_id = '" . $index['id'] . "' and it.date ='" . $lastConversionDate . "' and 
							pf.isin = it.isin  and pf.date ='" . date . "'");
				*/
				$pricequery = mysql_query("SELECT it.isin, it.price, it.localprice,
						(select price from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".date."') as localpricetoday  
						FROM `tbl_final_price` it where it.indxx_id='".$index['id']."' and it.date='".$lastConversionDate."'");
				

				while(false != ($priceRow = mysql_fetch_assoc($pricequery)))
				{
					//print_r($priceRow);
					if($priceRow['localprice'] && $priceRow['localpricetoday'])
					{
						$change = ($priceRow['localpricetoday'] - $priceRow['localprice'])/$priceRow['localprice'];
						$final_price_array[$index['id']][$priceRow['isin']]['price'] = $priceRow['price'] * (1 + $change);
						$final_price_array[$index['id']][$priceRow['isin']]['localprice'] = $priceRow['localpricetoday'];
					}
					//echo "currency headged";
				}
			}
		}

		if(!empty($final_price_array))
		{	
			foreach($final_price_array as $index_key => $security)
			{
				if(!empty($security))
				{
					foreach($security as $security_key => $prices)
					{
						$fpquery="INSERT into tbl_final_price (indxx_id, isin, date, price, localprice, currencyfactor) values 
								('" . $index_key . "','" . $security_key . "','" . date . "','" . $prices['price'] . "', 
								'" . $prices['localprice'] . "', '0')";
						mysql_query($fpquery);
					}
				}	
			}
		}
	}

	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	log_info("Price conversion for live hedged indexes done in " . $total_time . " seconds.");
	
	convert_headged_security_to_indxx_curr_upcomingindex();
	//webopen("http://localhost/eod/httpdocs/icai2/index.php?module=calcindxxclosing");
	//saveProcess(2);
	//mysql_close();
	//webopen("http://97.74.65.118/icai2/index.php?module=calcindxxclosing");
	/* echo '<script>document.location.href="http://97.74.65.118/icai2/index.php?module=calcindxxclosing";</script>'; */
}

function convert_headged_security_to_indxx_curr_upcomingindex()
{
	$start = get_time();
	
	$final_price_array	=	array();
	
	$indxx = selectrow(array('id', 'name', 'code', 'curr'), 'tbl_indxx_temp', array("currency_hedged" => 1));
	
	if(!empty($indxx))
	{
		foreach($indxx as $key => $index)
		{
			//print_r($index);
			$res = mysql_query("Select date from tbl_final_price_temp where indxx_id = '" . $index['id'] . "' order by date desc limit 0, 1");
			if (false != ($resdate = mysql_fetch_assoc($res)))
			{
				$lastConversionDate = $resdate['date'];
	
				$pricequery= mysql_query("SELECT it.isin, it.price, it.localprice,
							(select price from tbl_prices_local_curr pf where pf.isin=it.isin  and pf.date='".$date."') as localpricetoday  
							FROM `tbl_final_price_temp` it where it.indxx_id='".$index['id']."' and it.date='".$lastConversionDate."'");
				/*
				$pricequery = mysql_query("SELECT it.isin, it.price, it.localprice, pf.price as localpricetoday
							FROM `tbl_final_price_temp` it,  tbl_prices_local_curr pf
							where it.indxx_id = '" . $index['id'] . "' and it.date ='" . $lastConversionDate . "' and
							pf.isin = it.isin  and pf.date ='" . date . "'");
				*/
				while(false != ($priceRow = mysql_fetch_assoc($pricequery)))
				{
					//print_r($priceRow);
					if($priceRow['localprice'] && $priceRow['localpricetoday'])
					{
						$change = ($priceRow['localpricetoday'] - $priceRow['localprice'])/$priceRow['localprice'];
						$final_price_array[$index['id']][$priceRow['isin']]['price'] = $priceRow['price']*(1 + $change);
						$final_price_array[$index['id']][$priceRow['isin']]['localprice'] = $priceRow['localpricetoday'];
					}
				}
			}
			//echo "currency headged";
		}
	
		if(!empty($final_price_array))
		{
			foreach($final_price_array as $index_key => $security)
			{
				if(!empty($security))
				{
					foreach($security as $security_key => $prices)
					{
						$fpquery="INSERT into tbl_final_price_temp (indxx_id, isin, date, price, localprice, currencyfactor) values
								('" . $index_key . "','" . $security_key . "','" . date . "','" . $prices['price'] . "',
								'" . $prices['localprice'] . "', '0')";
						mysql_query($fpquery);
					}
				}
			}
		}
	}
	
	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	log_info("Price conversion for upcoming hedged indexes done in " . $total_time . " seconds.");
	
	webopen("http://localhost/eod/icai2/index.php?module=calcindxxclosing&date=" .date. "&log_file=" . basename(log_file));
	//saveProcess(2);
	//mysql_close();
}
?>