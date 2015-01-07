<?php

class Calcftpopen extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
		function index()
	{
	
	 $datevalue2=$this->_date;
	 //$datevalue2="2014-12-19";
/*	$conn_id = ftp_connect("ftp.processdo.com");
ftp_pasv($conn_id, true);
// login with username and password
$login_result = ftp_login($conn_id, "syntax@processdo.com", '.xafK3k(h#Op');
*/	
	
		if($_GET['id'])
		{
			$page=$_GET['id'];	
		}
		else
		{
			$page=0;	
		}
	$totalindxxs=$this->db->getResult("select tbl_indxx.id from tbl_indxx  where status='1' and client_id='4' ",true);
	$totalindexes=count($totalindxxs);
	$indxxs=$this->db->getResult("select tbl_indxx.code from tbl_indxx  where status='1' and client_id='4'  limit $page,1",true);
	
	
	if(!empty($indxxs))
	{
	foreach ($indxxs as $indxx )
	{
	
	
	
	
	$file = '../files2/ca-output/syntax/Opening-'.$indxx['code'].'-'. $datevalue2.'.txt';
	$strFileName= 'Opening-'.$indxx['code'].'-'. $datevalue2.'.txt';
	//$localFile = $_FILES[$fileKey]['tmp_name']; 

$fp = fopen($file, 'r');

// Connecting to website.
$ch = curl_init();

curl_setopt($ch, CURLOPT_USERPWD, "syntax@processdo.com:.xafK3k(h#Op");
curl_setopt($ch, CURLOPT_URL, 'ftp://ftp.processdo.com/'.$strFileName);
curl_setopt($ch, CURLOPT_UPLOAD, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 86400); // 1 Day Timeout
curl_setopt($ch, CURLOPT_INFILE, $fp);
curl_setopt($ch, CURLOPT_NOPROGRESS, false);
curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'CURL_callback');
curl_setopt($ch, CURLOPT_BUFFERSIZE, 128);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file));
curl_exec ($ch);

if (curl_errno($ch)) {

    $msg = curl_error($ch);
}
else {

    $msg = 'File uploaded successfully.';
}

curl_close ($ch);

$return = array('msg' => $msg);

echo json_encode($return);
	
	
	}
	}
	
	//ftp_close($conn_id);
		if($totalindexes<=$page)
		{
		//echo "Completed";	
		
		$this->saveProcess(2);
		//$this->Redirect2("index.php?module=checkivchange","","");	
		}
		else
		{
			$this->saveProcess(2);
			$this->Redirect2("index.php?module=calcftpopen&event=index&id=".($page+1),"","");	
		}


//	$this->saveProcess(2);
	//	$this->Redirect2("index.php?module=checkivchange","","");	
	}
	function index_old()
	{
	
	
//	$this->pr($_SESSION,true);
	
	 $datevalue2=$this->_date;
	
/*
// set up basic connection
$conn_id = ftp_connect("ftp.processdo.com");

// login with username and password
$login_result = ftp_login($conn_id, "icaitest@processdo.com", 'icaitest@2014');

$file2 = '../files2/ca-output/pga/Opening-IPJAS-'. $datevalue2.'.txt';
$remote_file2 = 'Opening-IPJAS-'. $datevalue2.'.txt';

// upload a file
if (ftp_put($conn_id, $remote_file2, $file2, FTP_ASCII)) {
 echo "successfully uploaded $file2\n";
} else {
 echo "There was a problem while uploading $file\n";
}
$file3 = '../files2/ca-output/pga/Opening-IPJAR-'. $datevalue2.'.txt';
$remote_file3 = 'Opening-IPJAR-'. $datevalue2.'.txt';

// upload a file
if (ftp_put($conn_id, $remote_file3, $file3, FTP_ASCII)) {
 echo "successfully uploaded $file3\n";
} else {
 echo "There was a problem while uploading $file\n";
}



// close the connection

	$this->saveProcess(1);
ftp_close($conn_id);

	*/
	
	}
}
?>