<?php
class Calccashtemp extends Application 
{

	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */
		
		$datevalue2 = $this->_date;
				
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		if($_GET['DEBUG'])
			define("DEBUG", $_GET['DEBUG']);

		$this->log_info(log_file, "Cash index[upcoming] file generation process started.");	
		
		$final_array = array ();
		
		/* Fetch list of all upcoming cash indexes */
		$indxxs = $this->db->getResult("select * from tbl_cash_index_temp  where 1=1 ", true);
		if (!empty($indxxs)) 
		{
			foreach($indxxs as $row) 
			{
				if ($this->checkHoliday($row['zone'], $datevalue2)) 
				{
					$final_array[$row['id']] = $row;

					$client = $this->db->getResult("select ftpusername from tbl_ca_client where id='" . $row['client_id'] . "'", false, 1);
					$final_array[$row['id']]['client'] = $client['ftpusername'];

					/* Fetch last day cash index value */
					$cashindxx_value = $this->db->getResult("select indxx_value from tbl_cash_indxx_value_temp where indxx_id='" . $row['id'] . "' order by dateAdded desc ", false, 1);
					$final_array[$row['id']]['last_index_value'] = $cashindxx_value['indxx_value'];
					
					/* Fetch last 2 days values of T-Bills on which this index is based */
					$cashrates = $this->db->getResult("select price from tbl_cash_prices where isin like '%" . $row['isin'] . "%' order by date desc ", true, 2);
					$final_array[$row ['id']]['last_2_days_cash_rate'] = $cashrates;
				}
			}
		}
				
		/* Generate index value files for various upcoming Cash indexes */
		if (!empty($final_array)) 
		{
			file_put_contents ( '../files/output/backup/preCLOSECASH_tempdata' . date("Y-m-d-H-i-s") . '.json', json_encode($final_array));

			foreach($final_array as $key => $closeIndxx) 
			{
				$folder = null;
				if (!$closeIndxx['client'])
				{
					$folder = "../files/output/ca-output/";
					$file = $folder . "Closing-" . $closeIndxx['code'] . "-" . $datevalue2 . ".txt";
				}
				else
				{
					$folder = "../files/output/ca-output/" . $closeIndxx['client'] . "/";
					$file = $folder. "Closing-" . $closeIndxx['code'] . "-" . $datevalue2 . ".txt";
				}
				
				if (!file_exists($folder))
					mkdir($folder, 0777, true);
				
				$entry1 = 'Date' . ",";
				$entry1 .= date("Y-m-d", strtotime($datevalue2)) . ",\n";
				$entry1 .= 'INDEX VALUE' . ",";
				
				$entry4 = '';
				$index_value = 0;
				
				/* Calculate new value of index based on last value and last 2 days T-Bill prices */
				if (!empty($closeIndxx)) 					
					$index_value = $closeIndxx['last_index_value'] * ($closeIndxx['last_2_days_cash_rate'][0]['price'] / $closeIndxx['last_2_days_cash_rate'][1]['price']);
					
				$entry2 = number_format($index_value, 2, '.', '' ) . ",\n";
				
				/* Update DB with new index value */
				$insertQuery = 'INSERT into tbl_cash_indxx_value_temp (indxx_id, code, indxx_value, date) values 
							("' . $closeIndxx['id'] . '","' . $closeIndxx['code'] . '","' . number_format($index_value, 2, '.', '') . '","' . $datevalue2 . '")';
				$this->db->query($insertQuery);
				//TODO: Error handling here
				
				$open = fopen($file, "w+");
				if ($open)
				{
					if (fwrite($open, $entry1 . $entry2 . $entry3 . $entry4))
					{
						$this->log_info(log_file, "Cash index[upcoming] file written for client = " .$closeIndxx['code']);
					}
					else
					{
						$this->log_error(log_file, "Cash index[upcoming] file write failed for client = " .$closeIndxx['code']);
						$this->mail_exit(log_file, __FILE__, __LINE__);
					}
				}
				else
				{
					$this->log_error(log_file, "Cash index[upcoming] file open failed for client = " .$closeIndxx['code']);
						$this->mail_exit(log_file, __FILE__, __LINE__);
				}
			}
			file_put_contents ( '../files/output/backup/postOPENCASH_tempdata' . date ("Y-m-d-H-i-s") . '.json', json_encode ($final_array));

			unset($final_array);	
		}
		
		$this->log_info(log_file, "Cash index[upcoming] file generation process finished.");
		
		//$this->saveProcess(2);

		$this->Redirect("index.php?module=calclsc&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . log_file, "", "");
	}
}
?>