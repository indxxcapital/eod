<pre>
<?php
include("dbconfig.php");

/* TODO: See if we need to make this close, CA, open process specific */
define("date", '2014-12-20');
if (!DEBUG)
{
	if ($_GET['date'])
	{
		define("date", $_GET['date']);
	}
	else	
	{
		printf("Please define the revert date.\n");
		exit();
	} 
} 
printf("Reverting all data till %s (inclusive).\n", date);

//TODO: Revert backedup db?

/* Clean currency factor table */
mysql_query("DELETE FROM `tbl_curr_prices` WHERE `date` >= '" .date. "'");

if ($err = mysql_errno())
	printf("\t-Currency factor table clean query failed [error = %d]\n", $err);
else
	printf("\t+Currency factor table cleaned!\n");

/* Clean libor rate table */
mysql_query("DELETE FROM `tbl_libor_prices` WHERE `date` >= '" .date. "'");

if ($err = mysql_errno())
	printf("\t-Libor rate table clean query failed [error = %d]\n", $err);
else
	printf("\t+Libor rate table cleaned!\n");

/* Clean cash index table */
mysql_query("DELETE FROM `tbl_cash_prices` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Cash index table clean query failed [error = %d\n]", $err);
else
	printf("\t+Cash index table cleaned!\n");

/* Clean security price table */
mysql_query("DELETE FROM `tbl_prices_local_curr` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Security price table clean query failed [error = %d]\n", $err);
else
	printf("\t+Security price table cleaned!\n");

/* Clean converted security price table */
mysql_query("DELETE FROM `tbl_final_price` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Converted security price table clean query failed [error = %d]\n", $err);
else
	printf("\t+Converted security price table cleaned!\n");

/* Clean converted security price data - upcoming */
mysql_query("DELETE FROM `tbl_final_price_temp` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Converted security price[upcoming] table clean query failed [error = %d]\n", $err);
else
	printf("\t+Converted security price[upcoming] table cleaned!\n");

/* 
 * TODO: Indexes are disabled during convert price process - tbl_indxx and tbl_indxx_temp
 * Either enable them manually based on logs or restore DB. 
 * There is no way to recognise which entried were disabled during last run
 */

/* Clean calculated index values */
mysql_query("DELETE FROM `tbl_indxx_value` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Index value table clean query failed [error = %d]\n", $err);
else
	printf("\t+Index value table cleaned!\n");

/* Clean calculated upcoming index values */
mysql_query("DELETE FROM `tbl_indxx_value_temp` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Index value[upcoming] table clean query failed [error = %d]\n", $err);
else
	printf("\t+Index value[upcoming] table cleaned!\n");

/* 
 * TODO: Not cleaning the tbl_indxx_log and tbl_indxx_log_temp tables 
 * while closing file generation process. Check if this is needed.
 */

/* Clean cash index values */
mysql_query("DELETE FROM `tbl_cash_indxx_value` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Cash indexes table clean query failed [error = %d]\n", $err);
else
	printf("\t+Cash indexes table cleaned!\n");

/* Clean upcoming cash index values */
mysql_query("DELETE FROM `tbl_cash_indxx_value_temp` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Cash indexes[upcoming] table clean query failed [error = %d]\n", $err);
else
	printf("\t+Cash indexes[upcoming] table cleaned!\n");

/* Clean LSC index values */
mysql_query("DELETE FROM `tbl_indxx_lsc_value` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-LSC index table clean query failed [error = %d]\n", $err);
else
	printf("\t+LSC index table cleaned!\n");

/* Clean CSI index values */
mysql_query("DELETE FROM `tbl_indxx_cs_value` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-CSI index table clean query failed [error = %d]\n", $err);
else
	printf("\t+CSI index table cleaned!\n");

/* Clean SL index values */
mysql_query("DELETE FROM `tbl_indxx_sl_value` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-SL index table clean query failed [error = %d]\n", $err);
else
	printf("\t+SL index table cleaned!\n");

/* Clean opening value table */
mysql_query("DELETE FROM `tbl_indxx_value_open` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Opening value table clean query failed [error = %d]\n", $err);
else
	printf("\t+Opening value table cleaned!\n");

/* Clean opening value temp table */
mysql_query("DELETE FROM `tbl_indxx_value_open_temp` WHERE `date`  >= '" .date. "'");
if ($err = mysql_errno())
	printf("\t-Opening[upcoming] value table clean query failed [error = %d]\n", $err);
else
	printf("\t+Opening[upcoming] value table cleaned!\n");

/* This is not needed since process automatically does it */
if (false)
{
	/* Clean raw CA table */
	mysql_query("DELETE FROM `tbl_ca_plain_txt` WHERE `date`  >= '" .date. "'");
	if ($err = mysql_errno())
		printf("\t-CA plain text table clean query failed [error = %d]\n", $err);
	else
		printf("\t+CA plain text table cleaned!\n");
}

/* 
 * TODO: CA process:
 * Indexes are disabled during DVD currency check,
 * and many other places
 */

if (false)
{
	/* Clean weights table */
	mysql_query("DELETE FROM `tbl_weights` WHERE `date`  >= '" .date. "'");
	if ($err = mysql_errno())
		printf("\t-Security weights table clean query failed [error = %d]\n", $err);
	else
		printf("\t+Security weights table table cleaned!\n");
}
?>