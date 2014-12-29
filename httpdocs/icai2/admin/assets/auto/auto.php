<?php
include_once("../../config.php");


$sql = "SELECT int_id, var_fname, var_lname, var_email FROM tbl_store_owner WHERE chr_status='1' ORDER BY var_lname ASC";
$query = mysql_query($sql);
 

$stIdArr = array();
$stNameArr = array();
$stCodeArr = array();

while($res=mysql_fetch_array($query))
{
	
	array_push($stIdArr, $res['int_id']);
	array_push($stCodeArr, $res['var_email']);
	
	$name = '';
	
	$fname = ucfirst(strtolower($res['var_fname']));
	$lname = ucfirst(strtolower($res['var_lname']));
	
	$name = $lname.', '.$fname;
	
	array_push($stNameArr, $name);	
}

//echo "<pre>";print_r($stNameArr);exit;

$input = strtolower($_GET['input'] );
$len = strlen($input);

$aResults = array();

if ($len)
{
	for ($i=0;$i<count($stNameArr);$i++)
	{
		if (strtolower(substr(utf8_decode($stNameArr[$i]),0,$len)) == $input)
			$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($stNameArr[$i]), "info"=>htmlspecialchars($stIdArr[$i]), "type"=>htmlspecialchars($stCodeArr[$i]) );
	}
}


header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header ("Pragma: no-cache"); // HTTP/1.0



if (isset($_REQUEST['json']))
{
	
	
	header("Content-Type: application/json");

	echo "{\"results\": [";
	$arr = array();
	for ($i=0;$i<count($aResults);$i++)
	{
		$arr[] = "{\"id\": \"".$aResults[$i]['info']."\", \"value\": \"".$aResults[$i]['value']." (".$aResults[$i]['type'].")\", \"info\": \"\"}";
	}
	echo implode(", ", $arr);
	echo "]}";
}
else
{
	header("Content-Type: text/xml");

	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
	for ($i=0;$i<count($aResults);$i++)
	{
		echo "<rs id=\"".$aResults[$i]['info']."\" >".$aResults[$i]['value']."</rs>";
	}
	echo "</results>";
}

exit;
?>