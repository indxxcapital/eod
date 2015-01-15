<?php
class Calcdp extends Application 
{

	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		/* TODO: This logic can be optimized more */
		
		$datevalue2 = $this->_date;
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
			define("DEBUG", $_GET['DEBUG']);

		$this->log_info(log_file, "CA dp process started");
		$final_array = array ();
		
		$indxxs = $this->db->getResult ( "select id from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' and ireturn='2'", true );
		
		if (! empty ( $indxxs )) 
		{	
			foreach ( $indxxs as $row ) 
			{
				if ($this->checkHoliday ( $row ['zone'], $datevalue2 )) 
				{
					$final_array [$row ['id']] = $row;
					
					$indxx_value = $this->db->getResult ( "select * from tbl_indxx_value where indxx_id='" . $row ['id'] . "' and date like '" . date ( "Y-m", strtotime ( $datevalue2 ) ) . "%'", true );
					
					if (empty ( $indxx_value ))
					{
						$lastindxx_value = $this->db->getResult ( "select * from tbl_indxx_value where indxx_id='" . $row ['id'] . "' order by date desc ", false, 1 );
						$final_array [$row ['id']] ['index_value'] = $lastindxx_value;
						
						$dividend_total_value = $this->db->getResult ( "select sum(dividend*share) as dividendmarketcap from tbl_dividend_ph where indxx_id='" . $row ['id'] . "'  and date like '" . date ( "Y-m", strtotime ( $datevalue2 . " -1 month" ) ) . "%' ", false, 1 );

						$final_array [$row ['id']] ['dividendmarketcap'] = $dividend_total_value ['dividendmarketcap'];
					}
				}
			}
		}
		
		if (! empty ( $final_array )) 
		{
			foreach ( $final_array as $key => $closeIndxx ) 
			{
				if (! empty ( $closeIndxx ['index_value'] ) && $closeIndxx ['dividendmarketcap'])
					$newDivisor = $closeIndxx ['index_value'] ['newdivisor'] - ($closeIndxx ['dividendmarketcap'] / $closeIndxx ['index_value']);
				
				$insertlogQuery = 'update tbl_indxx_value set  newdivisor="' . $newDivisor . '", olddivisor="' . $newDivisor . '" where indxx_id="' . $closeIndxx ['id'] . '" and id="' . $closeIndxx ['index_value'] ['id'] . '"';
				$this->db->query ( $insertlogQuery );
			}
		}
		$this->log_info(log_file, "CA dp process finished");
		
		//$this->saveProcess ( 1 );
		if (DEBUG)
		{
			$this->Redirect("index.php?module=replaceindex&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
		}
		else
		{
			//$this->Redirect("index.php?module=replaceindex&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
			log_error("Unable to locate replaceindex index module.");
			mail_exit(__FILE__, __LINE__);
		}
	}
}
?>