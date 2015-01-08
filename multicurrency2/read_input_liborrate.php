<pre>
<?php
function read_liborrate()
{
	$start = get_time();
	
	if (!file_exists(liborrate_file))
	{
		log_error("Libor rate file not available. Exiting closing file process.");
		mail(email_errors, "Libor rate file not available.", liborrate_file . " not available.");
		exit();
	}
	
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(liborrate_file)) .
			"' INTO TABLE tbl_libor_prices 
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(ticker, @x, @y, price, @z)
				SET date = '" . date . "'";
	$res = mysql_query($query);
	
	if (($err_code = mysql_errno()))
	{
		log_error("Unable to read libor rate file. MYSQL error code " . $err_code .
			". Exiting closing file process.");
		mail(email_errors, "Unable to read libor rate file.", "MYSQL error code " . $err_code . ".");
		exit();
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in libor rate file. Exiting closing file process.");
		mail(email_errors, "No data in libor rate file.", "No data in libor rate file.");
		exit();
	}
	else
	{
		log_info("Libor rate file read. Rows inserted = " . $rows . ".");
	}

	/*
	 * TODO:
	 * a) See how to free memory used by the above query
	 * b) Send an email incase of more than 5% fluctuation today
	 * c) Add a check for non-numeric values. Send an email in that case and use previous day value for calculation
	 */
	
	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	//log_info("Libor rate file read in " . $total_time . " seconds.");
		
	read_cashindex();
	//saveProcess(2);
	//mysql_close();
}
?>