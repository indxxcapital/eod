<?php
define ( "DEBUG", 1 );

function error_handler($errno, $errstr, $errfile, $errline) 
{
	if (! (error_reporting () & $errno)) 
	{
		// This error code is not included in error_reporting
		return;
	}
	
	switch ($errno) {
		case E_USER_ERROR :
			log_error ( "Errfile = " . $errfile . ", Errline = " . $errline . ", Errno = " . $errno );
			log_error ( "Errstr = " . $errstr );
			break;
		
		case E_USER_WARNING :
			log_warning ( "Errfile = " . $errfile . ", Errline = " . $errline . ", Errno = " . $errno );
			log_warning ( "Errstr = " . $errstr );
			break;
		
		case E_USER_NOTICE :
			log_info ( "Errfile = " . $errfile . ", Errline = " . $errline . ", Errno = " . $errno );
			log_info ( "Errstr = " . $errstr );
			break;
		
		default :
			log_error ( "Errfile = " . $errfile . ", Errline = " . $errline . ", Errno = " . $errno );
			log_error ( "Errstr = " . $errstr );
			break;
	}
	return false;
}

function prepare_logfile() 
{
	/* Logging mechanisms */
	$logs_folder = "../files/logs/";
	$closing_logs = $logs_folder . "closing_process_logs_" . date ( 'Y-m-d_H-i-s', $_SERVER ['REQUEST_TIME'] ) . ".txt";
	
	/* Check if log folder exists, if not create it. */
	if (! file_exists ( $logs_folder ))
		mkdir ( $logs_folder, 0777, false );
	
	return $closing_logs;
}

function log_error($text) 
{
	file_put_contents ( log_file, "ERROR: " . $text . "\n", FILE_APPEND );
}

function log_warning($text) 
{
	file_put_contents ( log_file, "WARNING: " . $text . "\n", FILE_APPEND );
}

function log_info($text) 
{
	file_put_contents ( log_file, "INFO: " . $text . "\n", FILE_APPEND );
}

/*
 * Paths where input files fetched from Bloomberg:
 * a) Corporate actions
 * b) Cash Index
 * c) LIBOR rate
 * d) Currency factor
 * e) Price file
 * f) Adjusted benchmark index
 */
function get_input_file($file, $date) 
{
	if (DEBUG)
	{
		$currency_factor = "../files/input/curr1.csv." . date ( "Ymd", strtotime ( $date ) );
		$libor_rate = "../files/input/libr.csv." . date ( "Ymd", strtotime ( $date ) );
		$cash_index = "../files/input/cashindex.csv." . date ( "Ymd", strtotime ( $date ) );
		$price_file = "../files/input/multicurr.csv." . date ( "Ymd", strtotime ( $date ) );
	}
	else
	{
		echo "Input file paths not defined" . "\n";
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
	}
}
?>