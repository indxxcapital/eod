<pre><?php
// date_default_timezone_set("Asia/Kolkata"); 
ini_set('max_execution_time',60*60);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
include('includes/main_configuration.php');


$databasedetails=new INDXXConfig;
 $db_host=$databasedetails->db_host;
 $db_user=$databasedetails->db_user;
 $db_password=$databasedetails->db_password;
 $db_name=$databasedetails->db_name;


//mysql_connect($db_host,$db_user,$db_password);
//mysql_select_db($db_name);

echo "\"C:\\Program Files (x86)\\Parallels\\Plesk\\MySQL\\bin\\mysqldump.exe\" --opt -h ".$db_host."  -u ".$db_user." -p ".$db_password." ".$db_name." > ../files2/backup/db-dump-".date("Y-m-d").".sql";
exec("\"C:\\Program Files (x86)\\Parallels\\Plesk\\MySQL\\bin\\mysqldump.exe\" --opt -h ".$db_host."  -u ".$db_user." -p ".$db_password." ".$db_name." > ../files2/backup/db-dump-".date("Y-m-d").".sql");
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

echo 'Page generated in '.$total_time.' seconds. ';
//saveProcess();
//mysql_close();