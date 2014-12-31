<pre>
<?php
function read_pricefile()
{
	$start = get_time();

	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(price_file)) .
	"' INTO TABLE tbl_prices_local_curr 
				FIELDS TERMINATED BY '|'
				LINES TERMINATED BY '\n'
				(ticker, @x, @y, @price, curr, @a, isin, @c)
				SET date = '" . date . "',
					price = '" . round(@price, 2) . "'";

	if (false == mysql_query($query))
	{
		echo "Failed to read price file" . PHP_EOL;
		exit();
	}
	else
	{
		echo "Price file read[Rows inserted: " . mysql_affected_rows() . "]" . PHP_EOL;
	}

	/* TODO: THIS LOOKS LIKE SOME PATCH, NEEDS TO BE DISCUSSED - MAY BE THE CASE WITH DELISTING
	$data['ticker']="'".$security[0]."'";
	$data['isin']="'".$security[6]."'";
	$data['price']="'".round($security[3],2)."'";
	$data['curr']="'".$security[4]."'";
	$data['date']="'".$date."'";
			
	if(is_numeric($security[3]))
	{
		$price=selectrow(array('id'),'tbl_prices_local_curr',array('isin'=>$security[6],'date'=>$date));
		if(empty($price))
			qry_insert('tbl_prices_local_curr',$data);			
	}
	*/
	
	//saveProcess(2);
	//webopen("convertprice.php");
	//echo '<script>document.location.href="convertprice.php";</script>';
	//mysql_close();
		
	$finish = get_time();
	$total_time = round(($finish - $start), 4);
	echo 'Page generated in '.$total_time.' seconds. ' . PHP_EOL;
}
?>