<pre>
<?php
function read_cashindex()
{
	$start = get_time();

	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(cashindex_file)) .
	"' INTO TABLE tbl_cash_prices 
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(isin, @x, @y, price, @z)
				SET date = '" . date . "'";

	if (false == mysql_query($query))
	{
		echo "Failed to read cash index file" . PHP_EOL;
		exit();
	}
	else
	{
		echo "Cash index file read[Rows inserted: " . mysql_affected_rows() . "]" . PHP_EOL;
	}

	read_pricefile();

	//saveProcess(2);
	//mysql_close();
	//webopen("read_input_price.php");
	/* echo '<script>document.location.href="read_input_price.php";</script>'; */
	
	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	echo 'Page generated in '.$total_time.' seconds. ' . PHP_EOL;
}
?>