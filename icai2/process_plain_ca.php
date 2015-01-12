<pre><?php
// echo date("Ymd",strtotime($date));
// date_default_timezone_set("Asia/Kolkata");
ini_set ( 'max_execution_time', 60 * 60 );
$time = microtime ();
$time = explode ( ' ', $time );
$time = $time [1] + $time [0];
$start = $time;

include ("core/function.php");
// delete_old_ca();

$date = date ( "Y-m-d" );
// $date ='2014-12-18';
// exit;
$handle = @fopen ( "../bloomberg-input2/ca_sl.csv." . date ( "Ymd", strtotime ( $date ) - 86400 ), "r" );

// $handle = @fopen("../bloomberg-input/ca_test.csv.20141212", "r");
$i = 0;

$skipped = 0;
$inserted = 0;
$updated = 0;
$empty = 0;

$query = '';
if ($handle) {
	
	delete_plain_ca ();
	
	while ( ! feof ( $handle ) ) {
		// echo ($i++)."=>".fgets($handle, 4096);
		
		// echo "<br>";
		$str = fgets ( $handle, 4096 );
		$i ++;
		
		if ($i > 19) {
			// echo $str;
			$security = explode ( "|", $str );
			
			if (count ( $security ) > 5) {
				
				// echo "Insert into tbl_ca_plain_txt (value) values ('".mysql_real_escape_string(json_encode($security))."');";
				$query = "Insert into tbl_ca_plain_txt (value) values ('" . mysql_real_escape_string ( json_encode ( $security ) ) . "');";
				mysql_query ( $query );
			}
		}
	}
	
	fclose ( $handle );
} 

else {
	echo "Error File not exist";
	mail ( "dbajpai@indxx.com", "Softlayer - File Read Error!", "corporate actions file not available for today - " . date ( "Y-m-d" ) );
	exit ();
}

$time = microtime ();
$time = explode ( ' ', $time );
$time = $time [1] + $time [0];
$finish = $time;
$total_time = round ( ($finish - $start), 4 );

saveProcess ();
mysql_close ();
echo 'Page generated in ' . $total_time . ' seconds. ';
echo '<script>document.location.href="process_ca.php";</script>';

?>