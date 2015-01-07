<?php

class Calcftpclose extends Application{

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
	
	 $datevalue2=$this->_date;
	
	
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
	
	
	
	$file = '../files2/ca-output/syntax/Closing-'.$indxx['code'].'-'. $datevalue2.'.txt';
	$strFileName= 'Closing-'.$indxx['code'].'-'. $datevalue2.'.txt';
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
		$this->Redirect2("index.php?module=checkivchange","","");	
		}
		else
		{
			$this->saveProcess(2);
			$this->Redirect2("index.php?module=calcftpclose&event=index&id=".($page+1),"","");	
		}


//	$this->saveProcess(2);
	//	$this->Redirect2("index.php?module=checkivchange","","");	
	}
}
?>