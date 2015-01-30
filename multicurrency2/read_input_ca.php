<pre><?php
include("function.php");
include("verify_process_ca.php");

/* Enable error capturing in log files and display the same in browser */
error_reporting(E_ALL);
set_error_handler("error_handler", E_ALL);
ini_set("display_errors", 1);

//$start_time = get_time();

/* Execution time for the script. Must be defined based on performance and load. */
ini_set('max_execution_time', 60 * 60);
ini_set("memory_limit", "1024M");

/* Prepare logging mechanism */
prepare_logfile();
define("log_file", get_logs_folder() . "ca_process_logs_" . date('Y-m-d_H-i-s', $_SERVER ['REQUEST_TIME']) . ".txt");

if (DEBUG)
{
	log_info("Executing CA process in debug mode");

	date_default_timezone_set("Asia/Kolkata");
	log_info("Timezone set to Asia/Kolkata");
	
	/* Email id for notification emails */
	define("email_errors", "amitmahajan86@gmail.com");

	/* Define date for fetching input files and manipulations */
	define("date", $_GET['date']);
}
else
{
	log_info("Executing CA process in non-debug mode");

	date_default_timezone_set("America/New_York");
	log_info("Timezone set to America/New_York");
	
	define("email_errors", "icalc@indxx.com");
	define("date", date("Y-m-d"));
}
log_info("All notification/error emails will be send to " . email_errors);
log_info("Process will execute on data for " .date);

/* Input file paths */
define("ca_file", get_input_file("CA", date));

define("process", "CA");

read_ca_file();
//check_dvd_currency();

//$finish = get_time();
//$total_time = round(($finish - $start), 4);
//echo 'Page generated in '.$total_time.' seconds. ';

function read_ca_file()
{
	log_info("Reading CA file");
	
	if (!file_exists(ca_file))
	{
		log_error("CA file not available. Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	delete_plain_ca();
	
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(ca_file)) .
			"' INTO TABLE tbl_ca_plain_txt LINES TERMINATED BY '\n' IGNORE 2 LINES (value)";
	$res = mysql_query($query);

	if (($err_code = mysql_errno()))
	{
		log_error("MYSQL error, code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);	
	}
	else if (!($rows = mysql_affected_rows()))
	{
		log_error("No data in CA file. Exiting CA file process.");
		mail_exit(__FILE__, __LINE__);
	}
	else
	{
		log_info("CA file read. Rows inserted = " . $rows);
	}

	//saveProcess(2);
	//mysql_close();
	log_info("CA file read");

	process_ca_file();
}

function process_ca_file()
{
	log_info("Processing CA file");
	
	$msg = '';
	
	$data2 = array();
	$ca_row = 0;
	$query = "INSERT INTO tbl_ca_values (ca_id, ca_action_id, field_name, field_value) VALUES";
	
	delete_old_ca ();

	$res = mysql_query("Select * from tbl_ca_plain_txt");
	if (($err_code = mysql_errno()))
	{
		log_error("Unable to read CA plain table. MYSQL error code " . $err_code .
					". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while(false != ($row = mysql_fetch_assoc($res)))
	{
		$security = explode('|', mysql_real_escape_string($row['value']));

		/* Ignore securities with no CAs */
		if (count($security) > 5) 
		{	
			log_info("Reading CA for security = " .$security[0]);
			//print_r($security); exit();	
							
			$checkArray = array();				
			$checkTickerArray = array();

			$data ['status'] 			= "'1'";

			$data ['identifier'] 		= "'"  .$security ['0']. "'";
			$checkArray ['identifier'] 	= $security ['0'];
				
			$data ['company_id'] 		= "'"  .$security ['1']. "'";
			$data ['security_id'] 		= "'"  .$security ['2']. "'";		
			$data ['rcode'] 			= "'"  .$security ['3']. "'";

			$data ['action_id'] 		= "'"  .$security ['4']. "'";
			$checkArray ['action_id'] 	= $security ['4'];

			$data ['mnemonic'] 			= "'"  .$security ['5']. "'";
			$checkArray ['mnemonic'] 	= $security ['5'];
			
			$ca_field_id = selectrow (array('id'), 'tbl_ca_subcategory', array('code' => $security ['5']));
				
			$data ['field_id'] 			= "'"  .$ca_field_id ['0'] ['id']. "'";
			$data ['company_name'] 		= "'"  .$security ['7']. "'";			
			$data ['secid_type'] 		= "'"  .$security ['8']. "'";
			$data ['secid'] 			= "'"  .$security ['9']. "'";
			$data ['currency'] 			= "'"  .$security ['10']. "'";				
			$data ['market_sector_desc'] 	= "'"  .$security ['11']. "'";
			$data ['bloomberg_unique_id'] 	= "'"  .$security ['12']. "'";
				
			if ($security ['13'] == '')
				$data ['ann_date'] = '0000-00-00';
			else
				$data ['ann_date'] = "'" . date ( "Y-m-d", strtotime ( $security ['13'] ) ) . "'";
				
			$checkArray ['ann_date'] = str_replace ( "'", "", $data ['ann_date'] );
				
			$security ['14'] = str_replace ( 'N.A.', "", $security ['14'] );
			if ($security ['14'] == '')
				$data ['eff_date'] = '0000-00-00';
			else
				$data ['eff_date'] = "'" . date ( "Y-m-d", strtotime ( $security ['14'] ) ) . "'";
				
			$checkArray ['eff_date'] = str_replace ( "'", "", $data ['eff_date'] );
				
			if ($security ['15'] == '')
				$data ['amd_date'] = '0000-00-00';
			else
				$data ['amd_date'] = "'" . date ( "Y-m-d", strtotime ( $security ['15'] ) ) . "'";
					
			$data ['bloomberg_global_id'] 	= "'"  .$security ['16']. "'";
			$data ['bl_global_company_id'] 	= "'"  .$security ['17']. "'";
			$data ['bl_security_id_num'] 	= "'"  .$security ['18']. "'";
			$data ['feed_source'] 			= "'"  .$security ['19']. "'";
			$data ['nfields'] 				= "'"  .$security ['20']. "'";
				
			if($checkArray['mnemonic'] == '' || $checkArray ['ann_date'] == '0000-00-00' 
					|| $checkArray ['eff_date'] == '0000-00-00') 
			{
				$msg .= "Mnemonic/Ann_date/Eff_date missing in security = " .$data ['identifier']. 
						", bloomberg_unique_id = " .$data ['bloomberg_unique_id']. ". Ignoring this CA.\n";
				//log_warning("Mnemonic/Ann_date/Eff_date missing in security = " .$data ['identifier']. 
				//", bloomberg_unique_id = " .$data ['bloomberg_unique_id']. ". Ignoring this CA");
				//mail_skip(__FILE__, __LINE__);
			} 
			else 
			{
				$ca_id = qry_insert ( 'tbl_ca', $data );
				$num_fields = 2 * $security ['20'];
	
				for($k = 1; $k < $num_fields + 1; $k = $k + 2) 
				{
					$name = $security [$k + 20];
					$value = $security [$k + 21];

					if ($value != 'N.A.' && trim($value) != '' && $value != ' ')
					{		
						/*
						$field_id = selectrow ( array ('id'), 'tbl_ca_action_fields', array ('field_name' => $security [$k + 20]) );
						$data2 ['field_id'] = "'" . $field_id ['0'] ['id'] . "'";

						$data2[$ca_row] ['ca_id'] = $ca_id;//"'" . $ca_id . "'";
						$data2[$ca_row] ['ca_action_id'] = $data ['action_id'];
						$data2[$ca_row] ['field_name'] = $name;//"'" . $name. "'";
						$data2[$ca_row] ['field_value'] = $value;//"'"  .$value. "'";
					
						qry_insert ( 'tbl_ca_values', $data2 );
						*/
						
						if ($ca_row)
							$query .= ",";
							
						$query .= " ('" .$ca_id. "', " .$data ['action_id']. ", '" .$name. "', '"  .$value. "')";						
						$ca_row++;
						
					}
				}	
			}
			unset($checkArray);
			unset($checkTickerArray);
		}
	}
	mysql_free_result($res);

	if ($ca_row)
	{
		mysql_query($query);
	
		if (($err_code = mysql_errno()))
		{
			log_error("MYSQL query failed, error code " . $err_code . ". Exiting CA process.");
			mail_exit(__FILE__, __LINE__);
		}
	}
	unset($query);

	if ($msg != '')
	{
		log_warning($msg);
		mail_skip(__FILE__, __LINE__);
	}
	unset($msg);
	
	log_info("Processing CA file done");

	check_dvd_currency();

	//$end_time = get_time();
	//$total_time = round(($end_time - $start_time), 4);
	//echo "Time taken = " .$total_time . "<br>";
}
?>