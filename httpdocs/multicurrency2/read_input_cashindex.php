<pre>
<?php
function read_cashindex()
{
	$start = get_time();

	if (!file_exists(cashindex_file))
	{
		log_error("Cash index file not available. Exiting closing file process.");
		mail(email_errors, "Cash index file not available.", cashindex_file . " not available.");
		exit();
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
		mail(email_errors, "Unable to read cash index file.", "MYSQL error code " . $err_code . ".");
		exit();
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in cash index file. Exiting closing file process.");
		mail(email_errors, "No data in cash index file.", "No data in cash index file.");
		exit();
	}
	else
	{
		log_info("Cash index file read. Rows inserted = " . $rows . ".");
	}
	//mysql_free_result($res);
	
	/* TODO: Send an email incase of more than 5% fluctuation today */
	
	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	log_info("Cash index file read in " . $total_time . " seconds.");
		
	read_pricefile();
	//saveProcess(2);
	//mysql_close();
}
?>