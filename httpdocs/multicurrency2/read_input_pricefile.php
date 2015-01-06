<pre>
<?php
function read_pricefile()
{
	$start = get_time();

	if (!file_exists(price_file))
	{
		log_error("Price file not available. Exiting closing file process.");
		mail(email_errors, "Price file not available.", price_file . " not available.");
		exit();
	}
	
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(price_file)) .
			"' INTO TABLE tbl_prices_local_curr 
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(ticker, @x, @y, @price, curr, @a, isin, @c)
				SET date = '" . date . "',
					price = round(@price, 2)";
	$res = mysql_query($query);
	
	if (($err_code = mysql_errno()))
	{
		log_error("Unable to read price file. MYSQL error code " . $err_code .
					". Exiting closing file process.");
		mail(email_errors, "Unable to read price file.", "MYSQL error code " . $err_code . ".");
		exit();
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in price file. Exiting closing file process.");
		mail(email_errors, "No data in price file.", "No data in price file.");
		exit();
	}
	else
	{
		log_info("Price file read. Rows inserted = " . $rows . ".");
	}

	/* TODO: QUERY - NEEDS TO BE DISCUSSED - MAY BE THE CASE WITH RE-PROCESSING OF DATA 
	 * 	in case of delisting etc errors
		$data['ticker']="'".$security[0]."'";
		$data['isin']="'".$security[6]."'";
		$data['price']="'".round($security[3],2)."'";
		$data['curr']="'".$security[4]."'";
		$data['date']="'".$date."'";
				
		if(is_numeric($security[3]))
		{
			$price=selectrow(array('id'),'tbl_prices_local_curr',array('isin'=>$security[6],'date'=>$date));
			if(empty($price))
				qry_insert('tbl_prices_local_curr',$data);			
		}
	*/

	/*
	 * TODO:
	 * a) See how to free memory used by the above query
	 * b) Send an email incase of more than 5% fluctuation today
	 * c) Add a check for non-numeric values. Send an email in that case and use previous day value for calculation
	 */
			
	/* 
	 * TODO: Send an email incase -
	 * a) Security price is same for 3 consecutive days.
	 *    Security might be suspended but Bloomberg has not updated it yet.
	 * b) If security price has fluctuated by 5% or more
	 */
		
	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	log_info("Price file read in " . $total_time . " seconds.");
	
	convert_security_to_indxx_curr();
	//saveProcess(2);
	//mysql_close();
}
?>