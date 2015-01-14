<pre>
<?php
function read_cashindex()
{
	//$start = get_time();

	if (!file_exists(cashindex_file))
	{
		log_error("Cash index file not available. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(cashindex_file)) .
	"' INTO TABLE tbl_cash_prices 
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(isin, @x, @y, price, @z)
				SET date = '" . date . "'";
	$res = mysql_query($query);
	
	if (($err_code = mysql_errno()))
	{
		log_error("Unable to read cash index file. MYSQL error code " . $err_code .
				". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in cash index file. Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	else
	{
		log_info("Cash index file read. Rows inserted = " . $rows);
	}
	
	/* 
	 * TODO: 
	 * a) See how to free memory used by the above query
	 * b) Send an email incase of:
	 * 		i) More than 5% fluctuation today.
	 */
			
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
		
	read_pricefile();
	//saveProcess(2);
	//mysql_close();
}
?>