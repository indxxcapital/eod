<?php
class Calccapub extends Application 
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
		
		$this->log_info(log_file, "CA file generation process started");
		
		/* Fetch list of all live indexes */
		$indxx = $this->db->getResult ( "select * from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' ", true );

		$clients = array ();
		$array = array ();
		
		if (! empty ( $indxx )) 
		{
			foreach ( $indxx as $ind ) 
			{
				$this->log_info(log_file, "Processing index = " . $ind['id']);
				$client = $this->db->getResult ( "select ftpusername from tbl_ca_client where id='" . $ind ['client_id'] . "'", false, 1 );
				
				$entry = '';
				$entry1 = '';
				$entry .= 'Index Name' . ";";
				$entry .= $ind ['name'] . ";";
				$entry .= "\n";
				$entry .= 'Security Ticker' . ";";
				$entry .= 'Company Ticker' . ";";
				$entry .= 'ISIN' . ";";
				$entry .= 'Action' . ";";
				$entry .= 'Ex Date' . ";";
				$entry .= 'Amount' . ";";
				$entry .= 'Currency;';
				$entry .= 'Further Details;';
				$entry .= 'Factor;';
				$entry .= "\n";
				$entry1 .= 'Index Name' . ";";
				$entry1 .= 'Security Ticker' . ";";
				$entry1 .= 'Company Ticker' . ";";
				$entry1 .= 'ISIN' . ";";
				$entry1 .= 'Action' . ";";
				$entry1 .= 'Ex Date' . ";";
				$entry1 .= 'Amount' . ";";
				$entry1 .= 'Currency;';
				$entry1 .= 'Further Details;';
				$entry1 .= 'Factor;';
				$entry1 .= "\n";
				$clients [$client ['ftpusername']] ['heading'] = $entry1;

				/* Fetch list of securities for this index */
				$indxxticker = $this->db->getResult ( "select distinct(ticker) as indxxticker from tbl_indxx_ticker where indxx_id ='" . $ind ['id'] . "'", true );

				/* Fetch CAs for each security for today's date */
				if (! empty ( $indxxticker )) 
				{
					foreach ( $indxxticker as $ticker ) 
					{
						$castr = $this->getCaStr3 ( $ticker ['indxxticker'], $datevalue2 );
						
						$this->log_info(log_file, $castr);
						$entry .= $castr;
						$clients [$client ['ftpusername']] ['value'] .= $this->getCaStr3 ( $ticker ['indxxticker'], $datevalue2, $ind ['name'] );
					}
				}
				
				if ($client ['ftpusername'])
				{
					$output_folder = "../files/output/ca-output/" . $client ['ftpusername']. "/";
					if(!file_exists($filename))
						mkdir($output_folder, 0777, true);

					$file = $output_folder . "ca-" . $ind ['code'] . "-" . $datevalue2 . ".txt";
				}
				else
				{
					$output_folder = "../files/output/ca-output/";
					if(!file_exists($filename))
						mkdir($output_folder, 0777, true);
					
					$file = $output_folder. "ca-" . $ind ['code'] . "-" . $datevalue2 . ".txt";
				}
					
				/* Generate CA file */
				$open = fopen ( $file, "w+" );
				if ($open) 
				{
					if (fwrite ( $open, $entry )) 
					{
						$this->log_info(log_file, "CA output file written for index = " .$ind['code']);
					}
					else 
					{
						$this->log_error(log_file, "Unable to write CA output file = " .$file. " for index = " .$ind['code']);
						$this->mail_exit(log_file, __FILE__, __LINE__);
					}
				}
				else
				{
					$this->log_error(log_file, "Unable to open CA output file = " .$file.  " for index = " .$ind['code']);
					$this->mail_exit(log_file, __FILE__, __LINE__);
				}
			}
		}
		
		if (! empty ( $clients )) 
		{
			foreach ( $clients as $clientname => $caclients ) 
			{
				$output_folder = "../files/output/ca-output/" . $clientname. "/";
				if(!file_exists($filename))
					mkdir($output_folder, 0777, true);
				
				$file2 = $output_folder. "composit-ca-" . $datevalue2 . ".txt";
				
				$open2 = fopen ( $file2, "w+" );
				if ($open2) 
				{
					if (fwrite ( $open2, $caclients ['heading'] . $caclients ['value'] )) 
					{
						$this->log_info(log_file, "CA composite output file written");						
					}
					else
					{
						$this->log_error(log_file, "Unable to write CA composite output file = " .$file2);
						$this->mail_exit(log_file, __FILE__, __LINE__);
					}
				}
				else
				{
					$this->log_error(log_file, "Unable to open CA composite output file = " .$file2);
					$this->mail_exit(log_file, __FILE__, __LINE__);
				}
			}
		}
		
		$this->log_info(log_file, "CA file generation process finished");
				
		//$this->saveProcess ( 1 );
		$this->Redirect("index.php?module=checkcavalue&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
	}
}
?>