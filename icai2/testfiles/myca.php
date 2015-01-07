<pre><?php
 date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("../core/function.php");

// $date=date("Y-m-d",strtotime(date("Y-m-d"))-86400);

$id=1;



$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo 'Page generated in '.$total_time.' seconds. ';
echo '<script>document.location.href="http://97.74.65.118/icai/index.php?module=calcindxxopening";</script>';

?>

