<?php

class Calcftpclose extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
	
	 $datevalue2=date('Y-m-d',strtotime($this->_date)-86400);
	

// set up basic connection
$conn_id = ftp_connect("ftp.processdo.com");

// login with username and password
$login_result = ftp_login($conn_id, "icaitest@processdo.com", 'icaitest@2014');
$file1 = '../files2/ca-output/pga/Closing-WDAA-'. $datevalue2.'.txt';
$remote_file1 = 'Closing-WDAA-'. $datevalue2.'.txt';

// upload a file
if (ftp_put($conn_id, $remote_file1, $file1, FTP_ASCII)) {
 echo "successfully uploaded $file1\n";
} else {
 echo "There was a problem while uploading $file\n";
}

$file2 = '../files2/ca-output/pga/Closing-IPJAS-'. $datevalue2.'.txt';
$remote_file2 = 'Closing-IPJAS-'. $datevalue2.'.txt';

// upload a file
if (ftp_put($conn_id, $remote_file2, $file2, FTP_ASCII)) {
 echo "successfully uploaded $file2\n";
} else {
 echo "There was a problem while uploading $file\n";
}
$file3 = '../files2/ca-output/pga/Closing-IPJAR-'. $datevalue2.'.txt';
$remote_file3 = 'Closing-IPJAR-'. $datevalue2.'.txt';

// upload a file
if (ftp_put($conn_id, $remote_file3, $file3, FTP_ASCII)) {
 echo "successfully uploaded $file3\n";
} else {
 echo "There was a problem while uploading $file\n";
}
$file4 = '../files2/ca-output/pga/pga-values-'. $datevalue2.'.xls';
$remote_file4 = 'pja-values-'. $datevalue2.'.xls';

// upload a file
if (ftp_put($conn_id, $remote_file4, $file4, FTP_ASCII)) {
 echo "successfully uploaded $file4\n";
} else {
 echo "There was a problem while uploading $file\n";
}



// close the connection
ftp_close($conn_id);

	$this->saveProcess(2);
		$this->Redirect2("index.php?module=checkivchange","","");	
	}
}
?>