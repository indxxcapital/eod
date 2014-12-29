<?php

class Uploadetfs extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		
		 $datevalue2=$this->_date;
		
	//ftp_close($conn_id);
$conn_id = ftp_connect("ftp.processdo.com");

// login with username and password
$login_result = ftp_login($conn_id, "commodity@processdo.com", 'commodity@2013');

$file4 = '../files2/ca-output/indxx/indxx-commodity-values-'.$datevalue2.'.xls';
$remote_file4 = 'values-'.$datevalue2.'.xls';

// upload a file
if (ftp_put($conn_id, $remote_file4, $file4, FTP_BINARY)) {
 echo "successfully uploaded $file4\n";
} else {
 echo "There was a problem while uploading $file\n";
 
 mail("dbajpai@indxx.com",'error etfs file uploading ',' etfs file not uploaded');
}

ftp_close($conn_id);

	}

}
?>