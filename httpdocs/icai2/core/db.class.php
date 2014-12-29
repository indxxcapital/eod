<?php
/************************************************************
Author			: Prakash Gupta
Project 			: Olive
Purpose			: This file contains functions for database connectivity and error handling.
Organization		: E2 Solutions
Created On		: 15/06/2006
Modified By		:
Modified On		: 

****************************************************************
*/

class Db {
	var $host; 
	var $database; 
	var $username; 
	var $password; 
	var $mysqlrows;
	var $lastQuery;
	var $lastInsertedId;
	var $affectedRows;

	function Db($arg,$obj){
	 	$this->host = $arg['host'];
		$this->database = $arg['name'];
		$this->username = $arg['user'];
		$this->password = $arg['password'];
		$this->Obj=$obj;
		
		$this->dbh = mysql_connect($this->host, $this->username, $this->password);		
		mysql_select_db($this->database, $this->dbh);
	}
	
	
	function stripslashes_deep($value)
	{
 		
		if(is_array($value)) 
		{
			$val = "";
			
			foreach($value as $key => $keyvalue)
			{
				$val[$key] =stripslashes($keyvalue);
			}
			$value=$val;
			 
		}
		else
		{
		
		$value =  stripslashes($value);
	 	
		}
		return $value;
	}
	
 
	
	function getResult($sql,$array=false,$items=0)
	{
		//echo $sql;
		 $this->lastQuery= $sql;
		if($items>0)
		{
		$query=mysql_query($this->dopaging($sql,$items));
		
	 
	
		}
		else
		{
		$query=mysql_query($sql);
		}
		$this->mysqlrows=mysql_num_rows($query);
		if($this->mysqlrows==0)
		{
			return NULL;
			
		}
		 
		if($this->mysqlrows==1)
		{
				$result=mysql_fetch_assoc($query);
		
			if($array==true)
			{
				return array($this->stripslashes_deep($result));
			}
			else
			{
				return $this->stripslashes_deep($result);
			}
			
		}
		else
		{
			$array=array();
			while($result=mysql_fetch_assoc($query))
			{
			
				array_push($array,$this->stripslashes_deep($result));
			}
			 
			return $array;
		}
	}	
	
	
		function dopaging($sql,$limit = 15,$numrecords=0)
		{
			//include_once("pager.class.php");
			global $clspg;
			global $pages;
			$clspg = new Pager;
			$start = $clspg->findStart($limit); 
			$temp = mysql_query($sql) or die(mysql_error());
			$numrows = mysql_num_rows($temp);
			if ($numrecords == 0)
			$pages = $clspg->findPages($numrows, $limit);
			else{
			if ($numrows > $numrecords)   
			$pages = $clspg->findPages($numrecords, $limit);
			else
			$pages = $clspg->findPages($numrows, $limit);
			}
			if ($numrecords == 0)
			$sql1 = $sql . " LIMIT " . $start. ", ". $limit ;
			else{
			if (($start + $limit) > $numrecords) 
			$sql1 = $sql . " LIMIT " . $start. ", ". ($numrecords - $start);
			else
			$sql1 = $sql . " LIMIT " . $start. ", ". $limit ;
			}
			return $sql1;
		}
		
		function rightpaging()
		{
			global $clspg;
			global $pages;
			$pagelist = "";
			if ($clspg != "")
			if ($pages > 1)
			$pagelist = $clspg->pageList($_GET['page'], $pages);
			return $pagelist;
		}
	 
	 
		function insert($sql)
		{
			$this->lastQuery= $sql;
			
		 	if(mysql_query($sql))
			{
		 		$this->lastInsertedId= mysql_insert_id();
				return true;
			}
			
			return false;
		}
		
		function query($sql)
		{
		 	$this->lastQuery= $sql;
			
		 	if($query=mysql_query($sql))
			{
		 		
				return $query;
			}
			
			if(mysql_insert_id())
			{
				$this->lastInsertedId= mysql_insert_id();
			}
			
			if(mysql_affected_rows())
			{
				$this->affectedRows= mysql_affected_rows();
			}
			
			
			return false;
		  
		}
	 
	
}
 
?>