<pre>
<?php
function read_liborrate()
{
	//$start = get_time();
	
	if (!file_exists(liborrate_file))
	{
		log_error("Libor rate file not available. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
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
		mail_exit(__FILE__, __LINE__);	
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in libor rate file. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	else
	{
		log_info("Libor rate file read. Rows inserted = " . $rows);
	}

	/* 
	 * TODO: 
	 * a) Send an email incase of:
	 * 		i) More than 5% fluctuation today.
	 * 		ii) Non-numeric/Blank value is received from BBG.
	 */
		
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
		
	read_cashindex();
	//saveProcess(2);
	//mysql_close();
}
?>