<pre>
<?php
include("dbconfig.php");

define("date", '2014-08-27');

$query = "DELETE FROM `tbl_curr_prices` WHERE `date` = '" .date. "'";
mysql_query($query);

if ($err = mysql_errno())
	echo "MYSQL query failed [error=" .$err. "] - currency factor clean" . PHP_EOL;
else
	echo "Currency factor cleaned" . PHP_EOL;


$query = "DELETE FROM `tbl_libor_prices` WHERE `date` = '" .date. "'";
mysql_query($query);

if ($err = mysql_errno())
	echo "MYSQL query failed [error=" .$err. "] - libor rate clean" . PHP_EOL;
else
	echo "Libor rate cleaned" . PHP_EOL;


$query = "DELETE FROM `tbl_cash_prices` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "MYSQL query failed [error=" .$err. "] - cash index clean" . PHP_EOL;
else
	echo "Cash index cleaned" . PHP_EOL;


$query = "DELETE FROM `tbl_prices_local_curr` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "MYSQL query failed [error=" .$err. "] - Price table clean" . PHP_EOL;
else
	echo "Price table cleaned" . PHP_EOL;


$query = "DELETE FROM `tbl_final_price` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "MYSQL query failed [error=" .$err. "] - Final price table clean" . PHP_EOL;
else
	echo "Final price table cleaned" . PHP_EOL;




?>