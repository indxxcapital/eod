<?php 
include("dbconfig.php");

function qry_insert($table, $data)
{
	$qry = array();
	
	if (is_array($qry) == true)
	{
		$qry['query'] = 'INSERT ';

		foreach ($data as $key => $value)
			$data[$key] = $key . ' = ' . $value;

		$qry['query'] .= 'INTO ' . $table . ' SET ' . implode(', ', $data);
	}

	//echo implode('', $qry).";";
	mysql_query(implode('', $qry).";");
}

function selectrow($fieldsarray, $table, $datafields = array())
{
    //The required fields can be passed as an array with the field names or as a comma separated value string
    if(is_array($fieldsarray))
		$fields = implode(", ", $fieldsarray);
    else
    	$fields = $fieldsarray;

    $whereQuery='';
    
    if(!empty($fields))
    {
		$whereQuery.=' WHERE  1=1 ';
		//print_r($fields);
		//exit;

		foreach($datafields as $key=>$value)
			$whereQuery.=" AND ".$key." = '".$value."' ";
	}
   
    //performs the query
	//echo "SELECT $fields FROM $table $whereQuery" . "\n";
	//exit;
	
    $result = mysql_query("SELECT $fields FROM $table $whereQuery");
    $num_rows = mysql_num_rows($result);
       
    //if query result is empty, returns NULL, otherwise, 
    //returns an array containing the selected fields and their values
    if($num_rows == NULL)
    {
        return NULL;
    }  
	else
    {
    	while($row=mysql_fetch_assoc($result))
			$queryresult[]=$row;

    	return $queryresult;
    }
}

function getCurrency($date)
{
	$currencyarray=array();
	
	$query="select tc.*,cp.price,cp.currency,cp.curr_id,cp.date from tbl_currency tc left join tbl_curr_prices cp on tc.id=cp.curr_id where cp.date='$date'";
	$res=mysql_query($query);

	if(mysql_num_rows($res) > 0)
	{
		while($row = mysql_fetch_assoc($res))
		{
			//print_r($row);
			if($row['price'] == '')
				$row['price'] = 1;	

			$currencyarray[$row['id']] = $row['price'];
		}	
		
		return $currencyarray;
	}
}

function getCurrencyNew($date)
{
	$currencyarray = array();

	$query = "select *  from tbl_currency ";
	$res = mysql_query($query);

	if(mysql_num_rows($res) > 0)
	{
		while($row = mysql_fetch_assoc($res))
		{
			//print_r($row);
			$query2='Select * from tbl_curr_prices where curr_id="'.$row['id'].'" and date ="'.$date.'"';
			$res2=mysql_query($query2);

			if(mysql_num_rows($res2) > 0)
			{
				$row2=mysql_fetch_assoc($res2);
				$currencyarray[$row['id']]=$row2['price'];
			}
			else
			{
				$currencyarray[$row['id']]=1;
			}
		}	
		
		return $currencyarray;
	}
}

function getPriceforCurrency($ticker, $date)
{
	$query = "SELECT price  FROM `tbl_curr_prices` WHERE 
			`currencyticker` LIKE '".strtoupper($ticker)."%' AND `date` = '$date'";
	$res = mysql_query($query);
	$err_code = mysql_errno();
	
	if ($err_code)
		goto error;

	if(false != ($row = mysql_fetch_assoc($res)))
	{
		if($row['price'])
			return $row['price'];
	}

error:
	log_error("Unable to currency factor for ticker = " . $ticker .
				". MYSQL error code = " . $err_code . ". Exiting closing file processing.");
	mail(email_errors, "Unable to currency factor for ticker = " . $ticker . ".",
			"MYSQL error code " . $err_code . ".");
	exit();
}

function saveProcess($type = 0)
{
	//print_r($_SERVER);

	$query="Insert into tbl_system_progress (url,type,path,stime)  values ('".mysql_real_escape_string($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'])."','".$type."','".mysql_real_escape_string($_SERVER['SCRIPT_FILENAME'])."','".date("Y-m-d H:i:s",$_SERVER['REQUEST_TIME'])."')";
	mysql_query($query);
}

function webopen($url)
{
	$link="<script type='text/javascript'>
	window.open('".$url."');  
	</script>";
	echo $link;
}

function get_time()
{
	$time = explode(' ', microtime());
	$curr_time = $time[1] + $time[0];
	return $curr_time;
}

/*
 * Paths where input files fetched from Bloomberg:
 * a) Corporate actions
 * b) Cash Index
 * c) LIBOR rate
 * d) Currency factor
 * e) Price file
 * f) Adjusted benchmark index
 */
function get_input_file($file, $date)
{
	$currency_factor = "../files/input/curr1.csv.".date("Ymd", strtotime($date));
	$libor_rate = "../files/input/libr.csv.".date("Ymd", strtotime($date));
	$cash_index = "../files/input/cashindex.csv.".date("Ymd", strtotime($date));
	$price_file = "../files/input/multicurr.csv.".date("Ymd", strtotime($date));
	
	//echo "Request for input file: " . $file . "[" . $file . "]" . PHP_EOL;
	
	switch ($file)
	{
		case "CURRENCY_FACTOR":
			return $currency_factor;
		case "LIBOR_RATE":
			return $libor_rate;
		case "CASH_INDEX":
			return $cash_index;			
		case "PRICE_FILE":
			return $price_file;
	}
}

/* Logging mechanisms */
function prepare_logfile()
{
	$logs_folder = "../files/logs/";
	
	/* Check if log folder exists, if not create it. */
	if (!file_exists($logs_folder))
		mkdir($logs_folder, 0777, false);

	$log_file = $logs_folder . "logs_" . date('Y-m-d_H-i-s', $_SERVER['REQUEST_TIME']) . ".txt";
	return $log_file;
}

function log_error($text)
{
	file_put_contents(log_file, "ERROR: " . $text . "\n", FILE_APPEND);
}

function log_warning($text)
{
	file_put_contents(log_file, "WARNING: " . $text . "\n", FILE_APPEND);
}

function log_info($text)
{
	file_put_contents(log_file, "INFO: " . $text . "\n", FILE_APPEND);
}
?>