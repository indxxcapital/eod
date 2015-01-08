<pre>
<?php
include("dbconfig.php");

if (DEBUG)
{
	define("date", '2014-08-27');
}
else
{
	if ($_GET['date'])
	{
		define("date", $_GET['id']);
	}
	else	
	{
		echo "Please define the revert date." . PHP_EOL;
		exit();
	} 
} 

/* Clean currency factor data */
$query = "DELETE FROM `tbl_curr_prices` WHERE `date` = '" .date. "'";
mysql_query($query);

if ($err = mysql_errno())
	echo "Currency factor clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Currency factor cleaned!" . PHP_EOL;

/* Clean libor rate data */
$query = "DELETE FROM `tbl_libor_prices` WHERE `date` = '" .date. "'";
mysql_query($query);

if ($err = mysql_errno())
	echo "Libor rate clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Libor rate cleaned!" . PHP_EOL;

/* Clean cash index data */
$query = "DELETE FROM `tbl_cash_prices` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Cash index clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Cash index cleaned!" . PHP_EOL;

/* Clean security price data */
$query = "DELETE FROM `tbl_prices_local_curr` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Price clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Price table cleaned!" . PHP_EOL;

/* Clean converted security price data */
$query = "DELETE FROM `tbl_final_price` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Converted price clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Converted price table cleaned!" . PHP_EOL;

/* Clean converted security price data - upcoming */
$query = "DELETE FROM `tbl_final_price_temp` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Converted price[upcoming] clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Converted price[upcoming] table cleaned!" . PHP_EOL;

/* Clean calculated index values */
$query = "DELETE FROM `tbl_indxx_value` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Index value clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Index value table cleaned!" . PHP_EOL;

?>