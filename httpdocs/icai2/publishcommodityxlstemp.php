<?php 
 date_default_timezone_set("Asia/Kolkata"); 
include("core/function.php");
require_once 'PHPExcel/Classes/PHPExcel.php';

$query="Select distinct (client_id) from tbl_commodity_indxx_temp where status='1' ";
$date=date("Y-m-d");
//$date="2014-05-01";


$array=array();
$res1=mysql_query($query);
if(mysql_num_rows($res1)>0)
{
while($client=mysql_fetch_assoc($res1))
{	
$res3=mysql_query("Select ftpusername from tbl_ca_client where id='".$client['client_id']."'");
$clientname=mysql_fetch_assoc($res3);
$array[$client['client_id']]['name']=$clientname['ftpusername'];

$indexQuery='select id,code from tbl_commodity_indxx_temp where client_id="'.$client['client_id'].'"';
$res2=mysql_query($indexQuery);

if(mysql_num_rows($res2)>0)
{
while($indxx=mysql_fetch_assoc($res2))
{
$array[$client['client_id']][$indxx['id']]['code']=$indxx['code'];
//$array[$client['client_id']]['code']=$indxx['code'];
$res4=mysql_query("select value from tbl_commodity_index_values_temp where indxx_id='".$indxx['id']."' and date='".$date."'");

if(mysql_num_rows($res4)>0)
{
$value=mysql_fetch_assoc($res4);
if($value['value'])
{
$array[$client['client_id']][$indxx['id']]['value']=$value['value'];
}


}



}

}

}
}

//print_r($array);

if(!empty($array))
{
foreach($array as $client_id=>$client)
{

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Deepak bajpai")
							 ->setLastModifiedBy("Deepak bajpai")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A1', 'Index')
            ->setCellValue('B1', 'Value');
			
	$i=2;		
foreach($client as $indxx_id=>$index)
{
if(!empty($index) && $index['value'] && is_numeric($index['value']))
{
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A'.$i,$index['code'])

			->setCellValue('B'.$i,$index['value']) ;
			$i++;

}
}			

$objPHPExcel->getActiveSheet()->setTitle('values');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

if($client['name'])
$objWriter->save("../files2/ca-output_upcomming/".$client['name']."/".$client['name']."-commodity-values-".$date.".xls");
else
{
$objWriter->save("../files2/ca-output_upcomming/commodity-values-".$date."-".time().".xls");

}


}	

}
else{
mail("dbajpai@indxx.com,jsharma@indxx.com","Temp Commodity Value not available", "Temp Commodity Values not available");
}
saveProcess(3);
//exit;

echo '<script>document.location.href="http://97.74.65.118/icai2/index.php?module=uploadetfs";</script>';


?>