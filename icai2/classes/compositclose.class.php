<?php
class Compositclose extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}

	function index() 
	{		
		$date = date('Y-m-d', strtotime($this->_date) - 86400);

		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
		{
			define("DEBUG", $_GET['DEBUG']);
			//$this->log_info(log_file, "Executing closing file generation process in DEBUG mode");
		
			if($_GET['date'])
			{
				$date = $_GET['date'];
			}
			else
			{
				$this->log_info(log_file, "No date provided in DEBUG mode");
				exit();
			}
		}
		
		$this->log_info(log_file, "Composite closing file generation process started.");
		
		$clientData = $this->db->getResult("select id, ftpusername from tbl_ca_client where status = '1'" );
		
		if (!empty($clientData)) 
		{
			foreach ($clientData as $client) 
			{
				$file = "../files/output/" . $client ['ftpusername'] . "/compositclosing-" . $date . ".txt";

				$entry1 = "Date" . "," . $date . ",\r\n";
				$entry1 .= "Name,Code,Market Value,Index value,\r\n";
				
				$indexes = $this->db->getResult ("select id, name, code from tbl_indxx where client_id = '" . $client ['id'] . "'", true );

				if (!empty($indexes)) 
				{
					foreach ($indexes as $index) 
					{
						$data = $this->db->getResult ("select market_value,indxx_value from tbl_indxx_value where indxx_id='" . $index ['id'] . "' and date='" . $date . "'");
						$entry1 .= $index ['name'] . ',' . $index ['code'] . ',' . $data ['market_value'] . ',' . $data ['indxx_value'] . ",\r\n";
					}
				}
				
				$open = fopen ($file, "w+");

				if($open) 
				{
					if (fwrite ($open, $entry1)) 
						$this->log_info(log_file, "Composite file written for client = " .$client['ftpusername']);
					else
						$this->log_error(log_file, "Composite file write failed for client = " .$client['ftpusername']);
				}
				else
				{
					$this->log_error(log_file, "Composite file open failed for client = " .$client['ftpusername']);
				}
			}
		}
		//mysql_free_result($clientData);
		
		$this->log_info(log_file, "Composite closing file generation process finished.");

		//$this->saveProcess(2);		
		
		if (DEBUG)
		{
			$this->Redirect2("index.php?module=calccash&DEBUG=" .DEBUG. "&date=" .$date. "&log_file=" . log_file, "", "");
		}
		else
		{
			//$this->Redirect2("index.php?module=calccash&DEBUG=" .DEBUG. "&date=" .$date. "&log_file=" . log_file, "", "");
			log_error("Unable to locate cash index module.");
			exit();
		}
	}
}
?>