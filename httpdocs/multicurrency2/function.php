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
	//echo "SELECT $fields FROM $table $whereQuery";
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

function getPriceforCurrency($ticker,$date)
{
	$query = "SELECT price  FROM `tbl_curr_prices` WHERE `currencyticker` LIKE '".strtoupper($ticker)."%' AND `date` = '$date'";
	$res = mysql_query($query);

	if(mysql_num_rows($res) > 0)
	{
		$row = mysql_fetch_assoc($res);

		if($row['price'])
		{
			return $row['price'];
		}
		else
		{
			echo "Price Not Available for Currency Ticker ".$ticker." of date.".$date."<br>" ;
			exit;
		}
	}
	else
	{
		echo "Price Not Available for Currency Ticker ".$ticker." of date.".$date."<br>" ;
		exit;
	}
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
	$currency_factor = "../files/ca-input/curr1.csv.".date("Ymd", strtotime($date));
	$libor_rate = "../files/ca-input/libr.csv.".date("Ymd", strtotime($date));
	$cash_index = "../files/ca-input/cashindex.csv.".date("Ymd", strtotime($date));
	$price_file = "../files/ca-input/multicurr.csv.".date("Ymd", strtotime($date));
	
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
?>