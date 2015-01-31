<?php
class Calcftpopen extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}

	function index() 
	{
		/* TODO: Uncomment this in live setup */
		if (false)
		{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		$datevalue2 = $this->_date;
		
		define("log_file", $_GET['log_file']);
		
		$this->log_info(log_file, "FTP opening file process started.");
				
		/* Find all live indexes with client_id = 4, TODO: Why 4? */
		$indxxs = $this->exec_mysql_query("select code from tbl_indxx where status='1' and client_id='4' ", log_file, __FUNCTION__, __LINE__);
		
		$output_folder = "../files/output/ca-output/syntax/";
		if (!file_exists($output_folder))
			mkdir($output_folder, 0777, true);
		
		while(false != ($indxx = mysql_fetch_assoc($indxxs)))
		{				
			$file = $output_folder. 'Opening-' . $indxx ['code'] . '-' . $datevalue2 . '.txt';
			$strFileName = 'Opening-' . $indxx ['code'] . '-' . $datevalue2 . '.txt';
			
			/* Open the opening file for this index */
			$fp = fopen ( $file, 'r' );
			
			// Connecting to website.
			$ch = curl_init ();
			
			/* Write the opening file on FTP server */
			curl_setopt ( $ch, CURLOPT_USERPWD, "syntax@processdo.com:.xafK3k(h#Op" );
			curl_setopt ( $ch, CURLOPT_URL, 'ftp://ftp.processdo.com/' . $strFileName );
			curl_setopt ( $ch, CURLOPT_UPLOAD, 1 );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 86400 ); // 1 Day Timeout
			curl_setopt ( $ch, CURLOPT_INFILE, $fp );
			curl_setopt ( $ch, CURLOPT_NOPROGRESS, false );
			curl_setopt ( $ch, CURLOPT_PROGRESSFUNCTION, 'CURL_callback' );
			curl_setopt ( $ch, CURLOPT_BUFFERSIZE, 128 );
			curl_setopt ( $ch, CURLOPT_INFILESIZE, filesize ( $file ) );
			curl_exec ( $ch );
			
			/* Send email for failures */
			if (curl_errno ( $ch ))				
				$msg = curl_error ( $ch );
			else
				$msg = 'File uploaded successfully.';
			
			curl_close ( $ch );
			
			$return = array ('msg' => $msg );	
			$this->log_info(log_file, json_encode($return));
			//echo json_encode ( $return );
		}	
	
		// ftp_close($conn_id);
		//$this->saveProcess ( 2 );
		$this->log_info(log_file, "FTP opening file process finished.");
		}
	}	
}
?>