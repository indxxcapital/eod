<?php
class Calcftpclose extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		$datevalue2 = $this->_date;
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		$this->log_info(log_file, "Calcftpclose started (TO BE IMPLEMENTED)");

		if (false)
		{
		
		/* TODO: Check with Deepak, why this is 4? */
		$indxxs = mysql_query("select code from tbl_indxx  where status='1' and client_id='4'");
		if (($err_code = mysql_errno()))
		{
			$this->log_error(log_file, "MYSQL error, code " . $err_code. ". Exiting closing file process.");
			mail_exit(__FILE__, __LINE__);
		}
		
		while ($indxx = mysql_fetch_assoc($indxxs))
		{				
			$file = '../files/output/ca-output/syntax/Closing-' . $indxx ['code'] . '-' . $datevalue2 . '.txt';
			$strFileName = 'Closing-' . $indxx ['code'] . '-' . $datevalue2 . '.txt';
				
			$fp = fopen ( $file, 'r' );
				
			// Connecting to website.
			$ch = curl_init ();
				
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
				
			if (curl_errno ( $ch )) 
				$msg = curl_error ( $ch );
			else	
				$msg = 'File uploaded successfully.';
				
			curl_close ( $ch );
				
			$return = array ('msg' => $msg);
			//echo json_encode ( $return );
		}

		// ftp_close($conn_id);
		}
		
		$this->log_info(log_file, "Calcftpclose done");
	}
}
?>