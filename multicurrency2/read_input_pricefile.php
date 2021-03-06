<pre>
<?php
function read_pricefile()
{
	//$start = get_time();

	if (!file_exists(price_file))
	{
		log_error("Price file not available. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	/* HACK - 0.001 is added since mysql rounds 10.135 to 10.13 but we want 10.14 */
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(price_file)) .
			"' INTO TABLE tbl_prices_local_curr 
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(ticker, @x, @y, @price, curr, @a, isin, @c)
				SET date = '" . date . "', price = round(@price + 0.001, 2)";
	$res = mysql_query($query);
	
	if (($err_code = mysql_errno()))
	{
		log_error("Unable to read price file. MYSQL error code " . $err_code .
					". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in price file. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	else
	{
		log_info("Price file read. Rows inserted = " . $rows);
	}


	/*
	 * TODO:
	 * Send an email incase of:
	 *   a) Security price is same for 3 consecutive days.
	 *    	Security might be suspended but Bloomberg has not updated it yet.
	 */
		
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
	
	convert_security_to_indxx_curr();
	//saveProcess(2);
	//mysql_close();
}
?>