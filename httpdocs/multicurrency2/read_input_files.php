<pre>
<?php
include("function.php");

$start_time = get_time();

/* 
 * Execution time (seconds) for the script/process.
 * This must be defined based on performance and load.
 */
ini_set('max_execution_time', 60 * 60);

date_default_timezone_set("Asia/Kolkata");
define("sec_per_day", 86400);
//$date = date("Y-m-d", strtotime(date("Y-m-d"))- sec_per_day);
$date='2014-08-27';

/* L1 Centralized error handling: Check if all input files exist */
if (!file_exists(get_input_file("CURRENCY_FACTOR", $date)))
{
	echo "Bloomberg file [CURRENCY_FACTOR] fetch failed." . PHP_EOL;
	/*
	mail("amitmahajan86@gmail.com", "CRITICAL: BBG input file not generated.",
			"BBG file fetch failed: " . $currency_factor_file);
	*/
	exit();
}

if (!file_exists(get_input_file("LIBOR_RATE", $date)))
{
	echo "Bloomberg file [LIBOR_RATE] fetch failed." . PHP_EOL;
	/*
	 mail("amitmahajan86@gmail.com", "CRITICAL: BBG input file not generated.",
	 "BBG file fetch failed: " . $currency_factor_file);
	 */
	exit();
}

if (!file_exists(get_input_file("CASH_INDEX", $date)))
{
	echo "Bloomberg file [CASH_INDEX] fetch failed: " . PHP_EOL;
	/*
	 mail("amitmahajan86@gmail.com", "CRITICAL: BBG input file not generated.",
	 "BBG file fetch failed: " . $currency_factor_file);
	 */
	exit();
}

if (!file_exists(get_input_file("PRICE_FILE", $date)))
{
	echo "Bloomberg file [PRICE_FILE]fetch failed." . PHP_EOL;
	/*
	 mail("amitmahajan86@gmail.com", "CRITICAL: BBG input file not generated.",
	 "BBG file fetch failed: " . $currency_factor_file);
	 */
	exit();
}

//webopen("read_input_curr2.php");
/* echo '<script>document.location.href="read_libor.php";</script>'; */

$end_time = get_time();
$total_time = round(($end_time - $start_time), 4);
echo 'Page generated in '.$total_time.' seconds. ';
?>