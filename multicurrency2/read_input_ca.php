<pre><?php
include("function.php");
//include ("../icai2/core/function.php");

/* TODO: Add TZ, RAM, EXEC etc. */
prepare_logfile();
define("log_file", get_logs_folder() . "ca_process_logs_" . date('Y-m-d_H-i-s', $_SERVER ['REQUEST_TIME']) . ".txt");

log_info("Reading CA file");

if (DEBUG)
{
	log_info("Executing CA process in debug mode");

	/* Email id for notification emails */
	define("email_errors", "amitmahajan86@gmail.com");

	/* Define date for fetching input files and manipulations */
	define("date", '2014-08-27');
}
else
{
	log_info("Executing CA process in non-debug mode");

	define("email_errors", "kaggarwal@indxx.com");
	define("date", date("Y-m-d"));
}

define("ca_file", get_input_file("CA", date));

/* TODO: Add this for closing and opening */
define("process", "CA");

read_ca_file();
process_ca_file();

log_info("CA file read");

function read_ca_file()
{
	//$start = get_time();
	
	if (!file_exists(ca_file))
	{
		log_error("CA file not available. Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	/* TODO: Write this and other functions cleanly */
	delete_plain_ca();
	
	$query = "LOAD DATA INFILE '" . str_replace("\\", "/", realpath(ca_file)) .
			"' INTO TABLE tbl_ca_plain_txt LINES TERMINATED BY '\n' IGNORE 2 LINES (value)";
	$res = mysql_query($query);

	if (($err_code = mysql_errno()))
	{
		log_error("Unable to read CA file. MYSQL error code " . $err_code .
			". Exiting CA process.");
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

	/* TODO: See how to free memory used by the above query */
		
	//$finish = get_time();
	//$total_time = round(($finish - $start), 4);
		
	//saveProcess(2);
	//mysql_close();
}

function process_ca_file()
{
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
		$security = explode('|', $row['value']);

		/* Ignore securities with no CAs */
		if (count($security) > 5) 
		{	
			log_info("Reading CA for security = " .$security[0]);
			//print_r($security); exit();	
							
			$checkArray = array();				
			$checkTickerArray = array();

			$data ['status'] 			= "'1'";

			$data ['identifier'] 		= "'" . mysql_real_escape_string ( $security ['0'] ) . "'";
			$checkArray ['identifier'] 	= $security ['0'];
				
			$data ['company_id'] 		= "'" . mysql_real_escape_string ( $security ['1'] ) . "'";
			$data ['security_id'] 		= "'" . mysql_real_escape_string ( $security ['2'] ) . "'";		
			$data ['rcode'] 			= "'" . mysql_real_escape_string ( $security ['3'] ) . "'";

			$data ['action_id'] 		= "'" . mysql_real_escape_string ( $security ['4'] ) . "'";
			$checkArray ['action_id'] 	= $security ['4'];

			$data ['mnemonic'] 			= "'" . mysql_real_escape_string ( $security ['5'] ) . "'";
			$checkArray ['mnemonic'] 	= $security ['5'];
			
			$ca_field_id = selectrow (array('id'), 'tbl_ca_subcategory', array('code' => $security ['5']));
				
			$data ['field_id'] 			= "'" . mysql_real_escape_string ( $ca_field_id ['0'] ['id'] ) . "'";
			$data ['company_name'] 		= "'" . mysql_real_escape_string ( $security ['7'] ) . "'";			
			$data ['secid_type'] 		= "'" . mysql_real_escape_string ( $security ['8'] ) . "'";
			$data ['secid'] 			= "'" . mysql_real_escape_string ( $security ['9'] ) . "'";
			$data ['currency'] 			= "'" . mysql_real_escape_string ( $security ['10'] ) . "'";				
			$data ['market_sector_desc'] 	= "'" . mysql_real_escape_string ( $security ['11'] ) . "'";
			$data ['bloomberg_unique_id'] 	= "'" . mysql_real_escape_string ( $security ['12'] ) . "'";
				
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
					
			$data ['bloomberg_global_id'] 	= "'" . mysql_real_escape_string ( $security ['16'] ) . "'";
			$data ['bl_global_company_id'] 	= "'" . mysql_real_escape_string ( $security ['17'] ) . "'";
			$data ['bl_security_id_num'] 	= "'" . mysql_real_escape_string ( $security ['18'] ) . "'";
			$data ['feed_source'] 			= "'" . mysql_real_escape_string ( $security ['19'] ) . "'";
			$data ['nfields'] 				= "'" . mysql_real_escape_string ( $security ['20'] ) . "'";
				
			if($checkArray['mnemonic'] == '' || $checkArray ['ann_date'] == '0000-00-00' 
					|| $checkArray ['eff_date'] == '0000-00-00') 
			{
				log_warning("Mnemonic/Ann_date/Eff_date missing in security = " .$data ['identifier']. 
				", bloomberg_unique_id = " .$data ['bloomberg_unique_id']. ". Ignoring this CA");
				mail_skip(__FILE__, __LINE__);
			} 
			else 
			{
				$ca_id = qry_insert ( 'tbl_ca', $data );
				$num_fields = $security ['20'];
	
				for($k = 1; $k < ($num_fields * 2) + 1; $k = $k + 2) 
				{
					$field_id = selectrow ( array ('id'), 'tbl_ca_action_fields', array ('field_name' => $security [$k + 20]) );
					$data2 ['ca_id'] = "'" . $ca_id . "'";
					$data2 ['ca_action_id'] = $data ['action_id'];
					$data2 ['field_name'] = "'" . $security [$k + 20] . "'";
					$data2 ['field_id'] = "'" . $field_id ['0'] ['id'] . "'";
					$data2 ['field_value'] = "'" . mysql_real_escape_string ( $security [$k + 20 + 1] ) . "'";
					
					/*TODO: convert this to direct mysql */
					if ($security [$k + 21] != 'N.A.' && trim ( $security [$k + 21] ) != '' && $security [$k + 21] != ' ')
						qry_insert ( 'tbl_ca_values', $data2 );
				}	
			}
		}
	}
	mysql_free_result($res);
}
?>