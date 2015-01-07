<?php
include_once("../../config.php");


$sql = "SELECT  SL.var_store_name, SL.int_id,Sl.var_manager , ST.var_state_code AS stateShortName, CT.var_name AS cityName  
				FROM tbl_store_location AS SL, tbl_state AS ST, tbl_city CT  
				WHERE SL.chr_status='1' AND SL.sint_state=ST.int_id AND SL.int_city=CT.int_id  ORDER BY SL.var_store_name ASC";
$query = mysql_query($sql);
 

$stIdArr = array();
$stNameArr = array();
$stCodeArr = array();

while($res=mysql_fetch_array($query))
{
	
	array_push($stIdArr, $res['int_id']);
	array_push($stCodeArr, $res['var_manager']);
	
	$name = '';
	
	$name = ucfirst(strtolower($res['var_store_name']));
	 
	
	 
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
		if (strtolower(substr(utf8_decode($stNameArr[$i]),0,$len)) == $input || strtolower(substr(utf8_decode($stCodeArr[$i]),0,$len)) == $input )
		{
			$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($stNameArr[$i]), "info"=>htmlspecialchars($stIdArr[$i]), "type"=>htmlspecialchars($stCodeArr[$i]) );
			
		}
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