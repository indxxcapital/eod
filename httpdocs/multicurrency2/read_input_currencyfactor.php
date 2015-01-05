<pre>
<?php
function read_currencyfactor()
{
	$start = get_time();

	if (!file_exists(currencyfactor_file))
	{
		log_error("Currency factor file not available. Exiting closing file process.");
		mail(email_errors, "Currency factor file not available.", currencyfactor_file . " not available.");
		exit();
	}
	
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(currencyfactor_file)) .
				"' INTO TABLE tbl_curr_prices
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(currencyticker, @x, @y, price, currency, @z)
				SET date = '" . date . "'";
	$res = mysql_query($query);

	if (($err_code = mysql_errno()))
	{
		log_error("Unable to read currency factor file. MYSQL error code " . $err_code . 
					". Exiting closing file process.");
		mail(email_errors, "Unable to read currency factor file.", "MYSQL error code " . $err_code . ".");
		exit();
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in currency factor file. Exiting closing file process.");
		mail(email_errors, "No data in currency factor file.", "No data in currency factor file.");
		exit();
	}
	else
	{
		log_info("Currency factor file read. Rows inserted = " . $rows . ".");
	}

	/* 
	 * TODO: 
	 * a) See how to free memory used by the above query
	 * b) Send an email incase of more than 5% fluctuation today
	 * c) Add a check for non-numeric values. Send an email in that case and use previous day value for calculation
	 */
	
	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	log_info("Currency factor file read in " . $total_time . " seconds.");
		
	read_liborrate();
	//saveProcess(2);
	//mysql_close();
}
?>