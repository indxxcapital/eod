<?php
class Calccash extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{	
		$datevalue2 = date('Y-m-d', strtotime($this->_date) - 86400);
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
		{
			define("DEBUG", $_GET['DEBUG']);
			//$this->log_info(log_file, "Executing closing file generation process in DEBUG mode");
		
			if($_GET['date'])
			{
				$datevalue2 = $_GET['date'];
			}
			else
			{
				$this->log_info(log_file, "No date provided in DEBUG mode");
				exit();
			}
		}
		
		$this->log_info(log_file, "Cash index file generation process started.");
		$final_array = array();
		
		$indxxs = $this->db->getResult("select * from tbl_cash_index  where 1=1 ", true);
		
		if (!empty($indxxs)) 
		{	
			foreach($indxxs as $row) 
			{
				if ($this->checkHoliday($row['zone'], $datevalue2))
				{
					$final_array[$row ['id']] = $row;
					
					$client = $this->db->getResult("select ftpusername from tbl_ca_client where id = '" . $row['client_id'] . "'", false, 1);
					$final_array[$row['id']]['client'] = $client['ftpusername'];
					
					$cashindxx_value = $this->db->getResult("select indxx_value from tbl_cash_indxx_value  where indxx_id='" . $row ['id'] . "' order by dateAdded desc ", false, 1);
					$final_array [$row ['id']] ['last_index_value'] = $cashindxx_value ['indxx_value'];
					
					$cashrates = $this->db->getResult("select price from tbl_cash_prices where isin like '%" . $row['isin'] . "%' order by date desc ", true, 2);
					$final_array[$row['id']]['last_2_days_cash_rate'] = $cashrates;
				}
			}
		}
				
		if (!empty($final_array)) 
		{
			file_put_contents('../files/output/pre-CloseCasahData' . date("Y-m-d-H-i-s") . '.json', json_encode ($final_array));

			foreach ($final_array as $key => $closeIndxx)
			{
				if (!$closeIndxx ['client'])
					$file = "../files/output/Closing-" . $closeIndxx['code'] . "-" . $datevalue2 . ".txt";
				else
					$file = "../files/output/" . $closeIndxx['client'] . "/Closing-" . $closeIndxx['code'] . "-" . $datevalue2 . ".txt";
								
				$entry1 = 'Date' . ",";
				$entry1 .= date ( "Y-m-d", strtotime($datevalue2)) . ",\n";
				$entry1 .= 'INDEX VALUE' . ",";
				
				$entry4 = '';
				$index_value = 0;
				
				if (!empty($closeIndxx)) 					
					$index_value = $closeIndxx['last_index_value'] * ($closeIndxx['last_2_days_cash_rate'][0]['price'] / $closeIndxx['last_2_days_cash_rate'][1]['price']);
				
				$entry2 = number_format($index_value, 2, '.', '' ) . ",\n";
				
				$insertQuery = 'INSERT into tbl_cash_indxx_value (indxx_id, code, indxx_value, date) values 
								("' . $closeIndxx['id'] . '","' . $closeIndxx['code'] . '","' . number_format($index_value, 2, '.', '' ) . '","' . $datevalue2 . '")';
				$this->db->query($insertQuery );
				//TODO: Error handling here
				
				$open = fopen($file, "w+");
				if ($open)
				{
					if (fwrite($open, $entry1 . $entry2 . $entry3 . $entry4 ))
						$this->log_info(log_file, "Cash index file written for client = " .$closeIndxx['code']);
					else
						$this->log_error(log_file, "Cash index file write failed for client = " .$closeIndxx['code']);
				}
				else
				{
					$this->log_error(log_file, "Cash index file open failed for client = " .$closeIndxx['code']);
				}
			}
			file_put_contents ( '../files/output/post-OpenCashData' . date("Y-m-d-H-i-s") . '.json', json_encode ($final_array));
		}

		$this->log_info(log_file, "Cash index file generation process finished.");
		
		//$this->saveProcess ( 2 );
		if (DEBUG)
		{
			$this->Redirect2("index.php?module=calccashtemp&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . log_file, "", "");
		}
		else
		{
			//$this->Redirect2("index.php?module=calccashtemp&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . log_file, "", "");
			log_error("Unable to locate upcoming cash index module.");
			exit();
		}
	}
}
?>