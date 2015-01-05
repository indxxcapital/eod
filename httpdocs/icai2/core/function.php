<?php 
include("includes/dbconfig.php");

function qry_insert($table, $data)
    {
        $qry = array();
        if (is_array($qry) === true)
        {
            $qry['query'] = 'INSERT ';
           

            foreach ($data as $key => $value)
            {
                $data[$key] = $key . ' = ' . $value;
            }

            $qry['query'] .= 'INTO ' . $table . ' SET ' . implode(', ', $data);
        }
//	echo implode('', $qry).";";
    mysql_query(implode('', $qry).";");
	return mysql_insert_id();
}




function qry_update($table, $data,$whereData)
    {
        $qry = array();
        $whereQuery='';
		if (is_array($qry) === true)
        {
            $qry['query'] = 'UPDATE ';
           

            foreach ($data as $key => $value)
            {
                $data[$key] = $key . ' = ' . $value;
            }

            $qry['query'] .= ' ' . $table . ' SET ' . implode(', ', $data);
			
			if(!empty($whereData))
			{
			$whereQuery=' where 1=1 ';
			
			foreach ($whereData as $key => $value)
            {
                $whereQuery.= " AND ".$key . ' = ' . $value;
            }

			}
			
        }
//		implode('', $qry).$whereQuery.";";
  mysql_query(implode('', $qry).$whereQuery.";");
	return mysql_insert_id();
}




function qry_delete($table,$whereData=array())
    {
        $qry = array();
        $whereQuery='';
		if (is_array($qry) === true)
        {
            $qry['query'] = 'DELETE ';
           

        $qry['query'] .= ' FROM ' . $table;
			
			if(!empty($whereData))
			{
			$whereQuery=' where ';
			
			foreach ($whereData as $key => $value)
            {
				
                $whereQuery.= $key . ' = ' . $value." AND ";
            }

			}
			
        }
		
	//	$whereQuery.=l
		
$query=	implode('', $qry).$whereQuery."";
$query=substr($query,0,strlen($query)-4);

   mysql_query($query);
	return mysql_insert_id();}

function delete_old_ca(){
//	echo "in delete";
mysql_query('delete  from tbl_ca ');
mysql_query('delete  from tbl_ca_values');
return true;
}
function delete_plain_ca(){
mysql_query('TRUNCATE TABLE tbl_ca_plain_txt ');
return true;

}
function selectrow($fieldsarray, $table, $datafields=array())
{
    //The required fields can be passed as an array with the field names or as a comma separated value string
    if(is_array($fieldsarray))
    {
        $fields = implode(", ", $fieldsarray);
    }
    else
    {
        $fields = $fieldsarray;
    }
   $whereQuery='';
   if(!empty($fields))
   {
	$whereQuery.=' WHERE  1=1 ';
	//print_r($fields);
	//exit;
	foreach($datafields as $key=>$value)
	{
	$whereQuery.=" AND ".$key." = '".$value."' ";
	
	}
	}
   
   
   
    //performs the query
	//echo "SELECT $fields FROM $table $whereQuery";
	//exit;
	
    $result = mysql_query("SELECT $fields FROM $table $whereQuery") ;
   
    $num_rows = mysql_num_rows($result);
       
    //if query result is empty, returns NULL, otherwise, returns an array containing the selected fields and their values
    if($num_rows == NULL)
    {
        return NULL;
    }
  
	else
    {
        while($row=mysql_fetch_assoc($result))
       {
		  $queryresult[]=$row;
		}
		 return $queryresult;
    }
}

function selectrow2($fieldsarray, $table, $datafields=array())
{
    //The required fields can be passed as an array with the field names or as a comma separated value string
    if(is_array($fieldsarray))
    {
        $fields = implode(", ", $fieldsarray);
    }
    else
    {
        $fields = $fieldsarray;
    }
   $whereQuery='';
   if(!empty($fields))
   {
	$whereQuery.=' WHERE  1=1 ';
	//print_r($fields);
	//exit;
	foreach($datafields as $key=>$value)
	{
	$whereQuery.=" AND ".$key." = '".$value."' ";
	
	}
	}
   
   
   
    //performs the query
	//echo "SELECT $fields FROM $table $whereQuery";
	//exit;
	
    $result = mysql_query("SELECT $fields FROM $table $whereQuery") ;
   
    $num_rows = mysql_num_rows($result);
       
    //if query result is empty, returns NULL, otherwise, returns an array containing the selected fields and their values
    if($num_rows == NULL)
    {
        return NULL;
    }
  
	else
    {
        while($row=mysql_fetch_assoc($result))
       {
		  $queryresult[$row['field_name']]=$row['field_value'];
		}
		 return $queryresult;
    }
}
function getCurrency($date)
{
		$currencyarray=array();
		 $query="select tc.*,cp.price,cp.currency,cp.curr_id,cp.date from tbl_currency tc left join tbl_curr_prices cp on tc.id=cp.curr_id where cp.date='$date'";
		$res=mysql_query($query);
		if(mysql_num_rows($res)>0)
		{
			while($row=mysql_fetch_assoc($res))
			{
				//print_r($row);
				if($row['price']=='')
				{
					$row['price']=1;	
				} 
					$currencyarray[$row['id']]=$row['price'];
			}	
			return $currencyarray;
		}
}
function getCurrencyNew($date)
{
		$currencyarray=array();
		 $query="select *  from tbl_currency ";
		$res=mysql_query($query);
		if(mysql_num_rows($res)>0)
		{
			while($row=mysql_fetch_assoc($res))
			{
				//print_r($row);
				$query2='Select * from tbl_curr_prices where curr_id="'.$row['id'].'" and date ="'.$date.'"';
				$res2=mysql_query($query2);
				if(mysql_num_rows($res2)>0)
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
function getIndxx($ticker)
{
$query='Select indxx_id from tbl_indxx_ticker where ticker="'.$ticker.'"';
$res=mysql_query($query);
$array=array();

if(mysql_num_rows($res)>0)
{
while($row=mysql_fetch_assoc($res))
{
$array[]=$row['indxx_id'];
}
}
return $array;
//print_r($array);
//exit;
}


function getIndxxUsertemp($ticker)
{
$query='Select user_id from tbl_assign_index_temp where indxx_id="'.$ticker.'"';
$res=mysql_query($query);
$array=array();

if(mysql_num_rows($res)>0)
{
while($row=mysql_fetch_assoc($res))
{
$array[]=$row['user_id'];

}
}
return array_unique($array);
//print_r($array);
//exit;
}

function array_values_recursive($array)
{
    $arrayValues = array();

    foreach ($array as $value)
    {
        if (is_scalar($value) OR is_resource($value))
        {
             $arrayValues[] = $value;
        }
        elseif (is_array($value))
        {
             $arrayValues = array_merge($arrayValues, array_values_recursive($value));
        }
    }

    return $arrayValues;
}


function backup_tables1($tables = '*')
    {
   
    //get all of the tables
    if($tables == '*') {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result)) {
    $tables[] = $row[0];
    }
    } else {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
    }	
    //cycle through
    foreach($tables as $table) {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);	
    //$return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    for ($i = 0; $i < $num_fields; $i++) {
    while($row = mysql_fetch_row($result)) {
    $return.= 'INSERT INTO '.$table.' VALUES(';
    for($j=0; $j<$num_fields; $j++) {
    $row[$j] = addslashes($row[$j]);
    $row[$j] = str_replace("\n","\\n",$row[$j]);
    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
    if ($j<($num_fields-1)) { $return.= ','; }
    }
    $return.= ");\n";
    }
    }
    $return.="\n\n\n";
    }
    


$zip = new ZipArchive();
$res = $zip->open('../files2/backup/db-backup-1-'.date("Y-m-d").'.sql.zip', ZipArchive::CREATE);
if ($res === TRUE) {
    $zip->addFromString('db-backup-1-'.date("Y-m-d").'.sql', $return);
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}




//save file
//    $handle = fopen('../files/backup/db-backup-'.date("Y-m-d").'.sql','w+');
//    fwrite($handle,$return);
//    fclose($handle);

    }

function backup_tables2($tables = '*')
    {
   
    //get all of the tables
    if($tables == '*') {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result)) {
    $tables[] = $row[0];
    }
    } else {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
    }	
    //cycle through
    foreach($tables as $table) {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);	
    //$return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    for ($i = 0; $i < $num_fields; $i++) {
    while($row = mysql_fetch_row($result)) {
    $return.= 'INSERT INTO '.$table.' VALUES(';
    for($j=0; $j<$num_fields; $j++) {
    $row[$j] = addslashes($row[$j]);
    $row[$j] = str_replace("\n","\\n",$row[$j]);
    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
    if ($j<($num_fields-1)) { $return.= ','; }
    }
    $return.= ");\n";
    }
    }
    $return.="\n\n\n";
    }
    


$zip = new ZipArchive;
$res = $zip->open('../files2/backup/db-backup-2-'.date("Y-m-d").'.sql.zip', ZipArchive::CREATE);
if ($res === TRUE) {
    $zip->addFromString('db-backup-2-'.date("Y-m-d").'.sql', $return);
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}




//save file
//    $handle = fopen('../files/backup/db-backup-'.date("Y-m-d").'.sql','w+');
//    fwrite($handle,$return);
//    fclose($handle);

    }
function total_ca_lines(){
 $query='Select count(id) as trows from tbl_ca_plain_txt ';
$res=mysql_query($query);
$row=mysql_fetch_assoc($res);

return $row['trows'];

}

function mysqldumps()
{

}
function saveProcess($type=0)
{
//print_r($_SERVER);

$query="Insert into tbl_system_progress (url,type,path,stime)  values ('".mysql_real_escape_string($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'])."','".$type."','".mysql_real_escape_string($_SERVER['SCRIPT_FILENAME'])."','".date("Y-m-d H:i:s",$_SERVER['REQUEST_TIME'])."')";
mysql_query($query);
}


?>