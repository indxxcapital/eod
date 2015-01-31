<?php

class Calcftpca extends Application{

	function __construct()
	{
		parent::__construct();
	}
		
	function index()
	{
	 	$datevalue2 = $this->_date;
	
	 	if($_GET['log_file'])
	 		define("log_file", $_GET['log_file']);

	 	$this->log_info(log_file, "Calcftpca started(TO BE IMPLEMENTED)");

	 	if (false)
	 	{
	 		 
		// set up basic connection
		$conn_id = ftp_connect("ftp.processdo.com");
		
		// login with username and password
		$login_result = ftp_login($conn_id, "icaitest@processdo.com", 'icaitest@2014');
		
		$file2 = '../files/output/ca-output/pga/ca-IPJAS-'. $datevalue2.'.txt';
		$remote_file2 = 'ca-IPJAS-'. $datevalue2.'.txt';
		
		// upload a file
		if (!ftp_put($conn_id, $remote_file2, $file2, FTP_ASCII)) 
			$this->mail_skip(log_file, __FILE__, __LINE__);

		$file3 = '../files/ouput/ca-output/pga/ca-IPJAR-'. $datevalue2.'.txt';
		$remote_file3 = 'ca-IPJAR-'. $datevalue2.'.txt';
		
		// upload a file
		if (!ftp_put($conn_id, $remote_file3, $file3, FTP_ASCII)) 
			$this->mail_skip(log_file, __FILE__, __LINE__);
				
		//$this->saveProcess();
		ftp_close($conn_id);
	 	}
		
		$this->log_info(log_file, "Calcftpca done");
	}
}
?>