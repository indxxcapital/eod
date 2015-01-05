<pre>
<?php
include("function.php");
include("read_input_currencyfactor.php");
include("read_input_liborrate.php");
include("read_input_cashindex.php");
include("read_input_pricefile.php");
include("convert_security_price.php");
include("convert_hedged_security_price.php");

date_default_timezone_set("Asia/Kolkata");
//$start_time = get_time();

/* Execution time for the script. Must be defined based on performance and load. */
ini_set('max_execution_time', 60 * 60);

/* Logs file */
define("log_file", prepare_logfile());

/* Email id for notification emails */
define("email_errors", "amitmahajan86@gmail.com");

define("sec_per_day", 86400);
//define("date", date("Y-m-d", strtotime(date("Y-m-d"))- sec_per_day));
//TODO: TESTING HACK
define("date", '2014-08-27');

/* Input file paths */
define("currencyfactor_file", get_input_file("CURRENCY_FACTOR", date));
define("liborrate_file", get_input_file("LIBOR_RATE", date));
define("cashindex_file", get_input_file("CASH_INDEX", date));
define("price_file", get_input_file("PRICE_FILE", date));

/* TODO: Prepare DB backup here, this will be needed in case restoration is needed 
 * or if possible define a revert process by tracking queries executed */

/* TODO: NA values cases in various fields will be handled during manipulations */

read_currencyfactor();

//$end_time = get_time();
//$total_time = round(($end_time - $start_time), 4);
//log_info("Closing file generation process completed in " . $total_time . " seconds.");

//clean environment variables, if any
?>