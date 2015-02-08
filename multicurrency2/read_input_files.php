<pre>
<?php
include("function.php");
include("read_input_currencyfactor.php");
include("read_input_liborrate.php");
include("read_input_cashindex.php");
include("read_input_pricefile.php");
include("convert_security_price.php");
include("convert_hedged_security_price.php");

/* Enable error capturing in log files and display the same in browser */
error_reporting(E_ALL);
set_error_handler("error_handler", E_ALL);

//$start_time = get_time();

/* Execution time for the script. Must be defined based on performance and load. */
ini_set('max_execution_time', 60 * 60);
ini_set("memory_limit", "1024M");

/* Prepare logging mechanism */
define("log_file", prepare_logfile());

/* Define date for fetching input files and manipulations */
if ($_GET['date'])
	define("date", $_GET['date']);
else
	define("date", date("Y-m-d"));

init_process();
if (DEBUG)
{
	log_info("Executing closing index process in debug mode");
	log_info("Timezone set to Asia/Kolkata");
}
else
{
	log_info("Executing closing index process in non-debug mode");	
	log_info("Timezone set to America/New_York");
}
log_info("All notification/error emails will be send to " . email_errors);
log_info("Process will execute on data for " .date);

/* Input file paths */
define("currencyfactor_file", get_input_file("CURRENCY_FACTOR", date));
define("liborrate_file", get_input_file("LIBOR_RATE", date));
define("cashindex_file", get_input_file("CASH_INDEX", date));
define("price_file", get_input_file("PRICE_FILE", date));

$backup_file = realpath(get_dbbackup_path()) . "/" .$db_name ."_" .date. "_" .time(). '.sql';
if (DEBUG)
{	
	$command = "C:/wamp/bin/mysql/mysql5.6.17/bin/mysqldump.exe --opt -h" .$db_host.
	" -u" .$db_user. " -p" .$db_password. " " .$db_name. " > " .$backup_file;		
}
else
{	
	 $command = "C:/xampp/mysql/bin/mysqldump.exe --opt -h" .$db_host.
	 " -u" .$db_user. " -p" .$db_password. " " .$db_name. " > " .$backup_file;
}

//echo $command;
//exit();
$res=0;
system($command, $res);
if ($res)
{
	log_error("Error[code = " .$res. "] while taking DB backup. Exiting process");
	mail_exit(__FILE__, __LINE__);
}
else
{
	log_info("Database backup taken at " .$backup_file);
	
	/* TODO: Here we can delete previous day db backups to avoid memory over-run */
}
read_currencyfactor();

//$end_time = get_time();
//$total_time = round(($end_time - $start_time), 4);
?>