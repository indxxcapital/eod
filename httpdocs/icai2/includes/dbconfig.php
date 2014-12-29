<?php 
include('main_configuration.php');


$databasedetails=new INDXXConfig;
$db_host=$databasedetails->db_host;
$db_user=$databasedetails->db_user;
$db_password=$databasedetails->db_password;
$db_name=$databasedetails->db_name;


mysql_connect($db_host,$db_user,$db_password);
mysql_select_db($db_name);
//mysql_connect("localhost", 'admin_mci','Reset1105@@');
//mysql_select_db("admin_mci");
?>