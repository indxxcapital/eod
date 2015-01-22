<?php
define ( "DEBUG", 1 );

function error_handler($errno, $errstr, $errfile, $errline) 
{
	if (!(error_reporting() & $errno))
		return false;
	
	switch ($errno) 
	{		
		case E_USER_WARNING:
			log_warning("Errfile = " .$errfile. ", Errline = " .$errline. ", Errno = " .$errno);
			log_warning("Errstr = " .$errstr);
			break;
		
		case E_USER_NOTICE:
			log_info("Errfile = " .$errfile. ", Errline = " .$errline. ", Errno = " .$errno);
			log_info("Errstr = " .$errstr);
			break;
		
		case E_USER_ERROR:
		default:
			log_error("Errfile = " .$errfile. ", Errline = " .$errline. ", Errno = " .$errno);
			log_error("Errstr = " .$errstr);
			break;
	}
	return false;
}

function get_logs_folder()
{
	$logs_folder = "../files/logs/";
	return 	$logs_folder;
}

function prepare_logfile() 
{
	$logs_folder = get_logs_folder();
	$closing_logs = $logs_folder ."closing_process_logs_". date('Y-m-d_H-i-s', $_SERVER ['REQUEST_TIME']) . ".txt";
	
	/* Check if log folder exists, if not create it. */
	if (! file_exists ( $logs_folder ))
		mkdir($logs_folder, 0777, false);
	
	return $closing_logs;
}

function log_error($text) 
{
	file_put_contents (log_file, "ERROR: " .$text. ".\n", FILE_APPEND);
}

function log_warning($text) 
{
	file_put_contents (log_file, "WARNING: " .$text. ".\n", FILE_APPEND);
}

function log_info($text) 
{
	file_put_contents (log_file, "INFO: " .$text. ".\n", FILE_APPEND);
}

function get_dbbackup_path()
{
	$dbbackup_path = "../files/db-backup/";
	if (! file_exists ( $dbbackup_path ))
		mkdir($dbbackup_path, 0777, false);

	return $dbbackup_path;
}

function mail_exit($file, $line)
{
	if (process)
		$value = process;
	else
		log_error("Please define the process type, needed for logging and emails !!");
		
	log_error("Sending email for abrupt process exit at file=" .$file. " and line=" .$line);
	mail(email_errors, $value. " file generation process existed with error.", 
			"Please check log[" .log_file. "] file for more info.");
	exit();	
}

/* TODO: Sending emails slows down the process, consolidate emails and send at one go */
function mail_skip($file, $line)
{
	if (process)
		$value = process;
	else
		log_error("Please define the process type, needed for logging and emails !!");
	
	log_warning("Sending email for anomaly at file=" .$file. " and line=" .$line);
	mail(email_errors, $value. " file generation process encountered anomaly.",
			"Please check log[" .log_file. "] file for more info.");
}

/*
 * Path from where BBG input files are fetched:
 * Corporate actions, Cash Index, LIBOR rate, Currency factor, Price file, Adjusted benchmark index
 */
function get_input_file($file, $date) 
{
	if (DEBUG)
	{
		log_info("Input files fetched from " .realpath("../files/input"). " directory");
		$currency_factor = "../files/input/curr1.csv." . date ( "Ymd", strtotime ( $date ) );
		$libor_rate = "../files/input/libr.csv." . date ( "Ymd", strtotime ( $date ) );
		$cash_index = "../files/input/cashindex.csv." . date ( "Ymd", strtotime ( $date ) );
		$price_file = "../files/input/multicurr.csv." . date ( "Ymd", strtotime ( $date ) );
		$ca_file = "../files/input/ca_test.csv." . date ( "Ymd", strtotime ( $date ) );
	}
	else
	{
		printf("Input file paths not defined.\n");
		log_error("Input file paths not defined");
		exit();
	}	

	// echo "Request for input file: " . $file . "[" . $file . "]" . PHP_EOL;
	switch ($file) {
		case "CURRENCY_FACTOR" :
			return $currency_factor;
		case "LIBOR_RATE" :
			return $libor_rate;
		case "CASH_INDEX" :
			return $cash_index;
		case "PRICE_FILE" :
			return $price_file;
		case "CA" :
			return $ca_file;
		default:
			printf("Input file paths not defined.\n");
			log_error("Input file paths not defined");
			exit();
	}
}
?>
