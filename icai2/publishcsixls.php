<?php
include ("core/function.php");
require_once 'PHPExcel/Classes/PHPExcel.php';

$date = $_GET['date'];

if($_GET['log_file'])
	define("log_file", get_logs_folder() . $_GET['log_file']);

if($_GET['DEBUG'])
	define("DEBUG", $_GET['DEBUG']);

log_info("Publish XLS generation process started");

$array = array();

/* Fetch the list of various complex strategy indexes */
$res1 = mysql_query("Select client_id, id, code from tbl_indxx_cs where status='1' ");
if (($err_code = mysql_errno()))
{
	log_error("Excel generation failed. Unable to read tbl_indxx_cs table. MYSQL error code " . $err_code .
				". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
}

while ($client = mysql_fetch_assoc($res1))
{
	$res3 = mysql_query("Select ftpusername from tbl_ca_client where id='" . $client ['client_id'] . "'");
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	$clientname = mysql_fetch_assoc ( $res3 );
	$array [$client ['client_id']] ['name'] = $clientname ['ftpusername'];	
	$array [$client ['client_id']] [$client ['id']] ['code'] = $client ['code'];
	mysql_free_result($res3);
	
	/* Find the value of the index */
	$res4 = mysql_query ( "select indxx_value from tbl_indxx_cs_value where indxx_id='" . $client ['id'] . "' and code ='" . $client ['code'] . "' and date='" . $date . "'" );
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting closing file process.");
		mail_exit(__FILE__, __LINE__);
	}
		
	$value = mysql_fetch_assoc ( $res4 );
	if (!empty($value))
		$array [$client ['client_id']] [$client ['id']] ['value'] = $value ['indxx_value'];

	mysql_free_result($res4);
}
mysql_free_result($res1);

/* Generate the XLS file for various CS indexes */
if (!empty($array)) 
{
	foreach ( $array as $client_id => $client ) 
	{	
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setCreator ( "INDXX CAPITAL EoD Calculator" )->setLastModifiedBy ( "Automatic" )->setTitle ( "PHPExcel Test Document" )->setSubject ( "PHPExcel Test Document" )->setDescription ( "Test document for PHPExcel, generated using PHP classes." )->setKeywords ( "office PHPExcel php" )->setCategory ( "Test result file" );
		$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A1', 'Index' )->setCellValue ( 'B1', 'Value' );
		
		$i = 2;
		foreach ( $client as $indxx_id => $index ) 
		{
			if (! empty ( $index ) && $index ['value'] && is_numeric ( $index ['value'] )) 
			{
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A' . $i, "." . $index ['code'] )->setCellValue ( 'B' . $i, $index ['value'] );
				$i ++;
			}
		}
		
		$objPHPExcel->getActiveSheet ()->setTitle ( 'values' );
		
		$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
		
		if ($client ['name'])
		{
			$objWriter->save ( "../files/output/ca-output/" . $client ['name'] . "/" . $client ['name'] . "-values-" . $date . ".xls" );
		}
		else 
		{
			$objWriter->save ( "../files/output/ca-output/values-" . $date . "-" . time () . ".xls" );
		}
	}
}
else 
{
	log_error("No data to generate excel files for clients");
	mail_exit(__FILE__, __LINE__);		
}
log_info("Publish XLS generation process finished.");

//saveProcess (2);

return;

/*TODO: Bypass FTP for test - This also needs to be discussed with Deepak since there is difference in new setup */
/* Bypass IVCHANGE, already done in closing file calcultion */
//$url = "index.php?module=calcftpclose";
//$url = "index.php?module=checkivchange";
//$url = "index.php?module=checkpvchange";
//$url = "index.php?module=calcweight";


$link = "<script type='text/javascript'>
window.open('" . $url . "');  
</script>";
echo $link;
?>