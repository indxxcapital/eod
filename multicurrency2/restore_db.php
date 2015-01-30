<pre>
<?php

include("function.php");

/* Enable error capturing in log files and display the same in browser */
error_reporting(E_ALL);
//set_error_handler("error_handler", E_ALL);

/* Execution time for the script. Must be defined based on performance and load. */
ini_set('max_execution_time', 60 * 60);
ini_set("memory_limit", "1024M");

if (!$_GET['DBNAME'])
	$_GET['DBNAME'] = "admin_icai22014-12-20-1422033425.sql";

$command ='';
if (DEBUG)
{
	ini_set("display_errors", 1);
	
	$restore_file = "C:/wamp/www/eod/files/db-backup/"  .$_GET['DBNAME'];
	$command = "C:/wamp/bin/mysql/mysql5.6.17/bin/mysql.exe -u" .$db_user. " -p" .$db_password.  " " .$db_name. "  <  " .$restore_file;
}
else
{
	ini_set("display_errors", 0);
	
	$restore_file = "C:/xampp/htdocs/eod/files/db-backup/"  .$_GET['DBNAME'];
	$command = "C:/xampp/mysql/bin/mysql.exe -u" .$db_user. " -p" .$db_password.  " " .$db_name. "  <  " .$restore_file;
	
}

//echo $command . "<br>";

$res=0;
system($command, $res);
if ($res)
{
	echo "Error[code = " .$res. "] while taking DB restore. Exiting process";
	return false;
}
else
{
	echo "Database restored";
	return true;
}
?>