<pre>
<?php
function read_currencyfactor()
{
	$start = get_time();

	/*
	$query = "LOAD DATA INFILE 'C:/wamp/www/eod/httpdocs/files/ca-input/curr1.csv.20140827'
				INTO TABLE tbl_curr_prices
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(currencyticker, @x, @y, price, currency, @z)
				SET date = '" . date . "'";
	echo $query . PHP_EOL;
	*/
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(currencyfactor_file)) .
				"' INTO TABLE tbl_curr_prices
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(currencyticker, @x, @y, price, currency, @z)
				SET date = '" . date . "'";
	
	if (false == mysql_query($query))
	{
		echo "Failed to read currency factor file" . PHP_EOL;
		exit();
	}
	else
	{
		echo "Currency factor file read[Rows inserted: " . mysql_affected_rows() . "]" . PHP_EOL;
	}

	read_liborrate();

	//saveProcess(2);
	//mysql_close();
	//webopen("read_libor.php");
	/* echo '<script>document.location.href="read_libor.php";</script>'; */

	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	echo 'Page generated in '.$total_time.' seconds. ' . PHP_EOL;
}
?>