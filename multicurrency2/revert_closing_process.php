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

/* Clean calculated upcoming index values */
$query = "DELETE FROM `tbl_indxx_value_temp` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Upcoming index value clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Upcoming index value table cleaned!" . PHP_EOL;

/* TODO: Not cleaning the tbl_indxx_log and tbl_indxx_log_temp tables whle closing file generation process */

/* Clean cash index values */
$query = "DELETE FROM `tbl_cash_indxx_value` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Cash index value clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Cash index value table cleaned!" . PHP_EOL;

/* Clean upcoming cash index values */
$query = "DELETE FROM `tbl_cash_indxx_value_temp` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "Cash index[upcoming] value clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "Cash index[upcoming] value table cleaned!" . PHP_EOL;

/* Clean LSC index values */
$query = "DELETE FROM `tbl_indxx_lsc_value` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "LSC index value clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "LSC index value table cleaned!" . PHP_EOL;

/* Clean CSI index values */
$query = "DELETE FROM `tbl_indxx_cs_value` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "CSI index value clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "CSI index value table cleaned!" . PHP_EOL;

/* Clean CSI index values */
$query = "DELETE FROM `tbl_indxx_sl_value` WHERE `date`  = '" .date. "'";
mysql_query($query);
if ($err = mysql_errno())
	echo "SL index value clean query failed [error=" .$err. "]." . PHP_EOL;
else
	echo "SL index value table cleaned!" . PHP_EOL;

if (false)
{
	/* Clean weights table */
	$query = "DELETE FROM `tbl_weights` WHERE `date`  = '" .date. "'";
	mysql_query($query);
	if ($err = mysql_errno())
		echo "Security weights table value clean query failed [error=" .$err. "]." . PHP_EOL;
	else
		echo "Security weights table value table cleaned!" . PHP_EOL;
}
?>