<pre>
<?php
function read_liborrate()
{
	$start = get_time();

	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(liborrate_file)) .
	"' INTO TABLE tbl_libor_prices 
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(ticker, @x, @y, price, @z)
				SET date = '" . date . "'";
	
	if (false == mysql_query($query))
	{
		echo "Failed to read libor rate file" . PHP_EOL;
		exit();
	}
	else
	{
		echo "Libor rate file read[Rows inserted: " . mysql_affected_rows() . "]" . PHP_EOL;
	}

	read_cashindex();

	//saveProcess(2);
	//mysql_close();
	//webopen("read_cashindex.php");
	/*echo '<script>document.location.href="read_cashindex.php";</script>'; */

	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	echo 'Page generated in '.$total_time.' seconds. ' . PHP_EOL;
}
?>