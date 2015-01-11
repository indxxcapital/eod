<pre>
<?php
function read_currencyfactor()
{
	//$start = get_time();

	if (!file_exists(currencyfactor_file))
	{
		log_error("Currency factor file not available. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
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
		mail_exit(__FILE__, __LINE__);
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in currency factor file. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	else
	{
		log_info("Currency factor file read. Rows inserted = " . $rows);
	}

	/* 
	 * TODO: 
	 * a) See how to free memory used by the above query
	 * b) Send an email incase of:
	 * 		i) More than 5% fluctuation today.
	 * 		ii) Non-numeric/Blank value is received from BBG.
	 */
	
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
		
	read_liborrate();
	//saveProcess(2);
	//mysql_close();
}
?>