<?php
class Replacecash extends Application 
{

	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		/* TODO: This logic can be optimized more */
		
		$datevalue = date ( "Y-m-d" );
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
		{
			define("DEBUG", $_GET['DEBUG']);
		
			if($_GET['date'])
			{
				$datevalue = $_GET['date'];
			}
			else
			{
				$this->log_error(log_file, "No date provided in DEBUG mode");
				$this->mail_exit(log_file, __FILE__, __LINE__);
			}
		}
		$this->log_info(log_file, "CA replacecash process started");
		
		$indexdata = $this->db->getResult ( "select * from tbl_cash_index_temp where status='1' and db_approve='1'  and dateStart='" . $datevalue . "' ", true );
		
		if (! empty ( $indexdata )) 
		{	
			foreach ( $indexdata as $index ) 
			{	
				$indexvalues = $this->db->getResult ( "select * from tbl_cash_indxx_value_temp where indxx_id='" . $index ['id'] . "' ", false, 1 );
				
				$oldindexdata = $this->db->getResult ( "select * from tbl_cash_index where code='" . $index ['code'] . "' ", false, 1 );
				if (! empty ( $oldindexdata )) 
				{
					$insertShareQuery = "update into tbl_cash_index set ticker='" . $index ['ticker'] . "',isin='" . $index ['isin'] . "' where code='" . $index ['code'] . "' ";					
					$this->db->query ( $insertShareQuery );
				} 
				else 
				{
					$this->db->query ( "insert into tbl_cash_index set name='" . mysql_real_escape_string ( $index ['name'] ) . "',code='" . mysql_real_escape_string ( $index ['code'] ) . "',ticker='" . mysql_real_escape_string ( $index ['ticker'] ) . "',isin='" . mysql_real_escape_string ( $index ['isin'] ) . "',zone='" . mysql_real_escape_string ( $index ['zone'] ) . "',client_id='" . mysql_real_escape_string ( $index ['client_id'] ) . "',base_value='" . mysql_real_escape_string ( $index ['base_value'] ) . "' ,dateStart='" . mysql_real_escape_string ( $index ['dateStart'] ) . "'" );
					$insert_id = mysql_insert_id ();
					
					$this->db->query ( "INSERT into tbl_cash_indxx_value set  indxx_id='" . $insert_id . "',code='" . mysql_real_escape_string ( $index ['code'] ) . "',date='" . $indexvalues ['date'] . "',indxx_value='" . mysql_real_escape_string ( $indexvalues ['indxx_value'] ) . "'" );					
					$this->db->query ( $insertShareQuery );
				}
				
				$this->db->query ( "delete from tbl_cash_index_temp where indxx_id='" . $index ['id'] . "'" );
			}
		}

		$this->log_info(log_file, "CA replacecash process finished");
		
		//$this->saveProcess ( 1 );
		if (DEBUG)
		{
			$this->Redirect("index.php?module=calcftpca&DEBUG=" .DEBUG. "&date=" .$datevalue. "&log_file=" . basename(log_file), "", "" );
		}
		else
		{
			//$this->Redirect("index.php?module=calcftpca&DEBUG=" .DEBUG. "&date=" .$datevalue. "&log_file=" . basename(log_file), "", "" );
			log_error("Unable to locate calcftpca index module.");
			mail_exit(__FILE__, __LINE__);
		}		
	}
}