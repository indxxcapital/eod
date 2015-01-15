<?php
class Checkcavalue extends Application 
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
		
		$this->log_info(log_file, "CA checkcavalue process started");

		$this->_title = $this->siteconfig->site_title;
		$this->_meta_description = $this->siteconfig->default_meta_description;
		$this->_meta_keywords = $this->siteconfig->default_meta_keyword;
				
		$checkArray = array ();
		$checkArray ['DVD_CASH'] 	= array('CP_NET_AMT','CP_GROSS_AMT', 'CP_DVD_CRNCY', 'CP_DVD_TYP');
		$checkArray ['CHG_NAME'] 	= array('CP_OLD_NAME', 'CP_NEW_NAME');
		$checkArray ['CHG_ID'] 		= array('CP_OLD_ISIN', 'CP_NEW_ISIN');
		$checkArray ['SPIN'] 		= array('CP_ADJ');
		$checkArray ['DVD_STOCK'] 	= array('CP_AMT');
		$checkArray ['STOCK_SPLT'] 	= array('CP_ADJ');
		$checkArray ['RIGHTS_OFFER'] = array ('CP_RATIO', 'CP_ADJ', 'CP_PX', 'CP_CRNCY');

		$text = '';
		
		$final_array = array ();
		
		$indxxs = $this->db->getResult ( "select * from tbl_indxx  where status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1' ", true );
		
		if (! empty ( $indxxs )) 
		{
			foreach ( $indxxs as $row ) 
			{
				if ($this->checkHoliday ( $row ['zone'], $datevalue2 )) 
				{
					$final_array [$row ['id']] = $row;
					
					$query = "SELECT  it.ticker  FROM `tbl_indxx_ticker` it where it.indxx_id='" . $row ['id'] . "'";
					
					$indxxprices = $this->db->getResult ( $query, true );

					if (! empty ( $indxxprices )) 
					{
						foreach ( $indxxprices as $key => $indxxprice ) 
						{
							$ca_query = "select identifier, action_id, id, mnemonic, company_name, eff_date, currency from tbl_ca cat where  eff_date='" . $datevalue2 . "' and identifier='" . $indxxprice ['ticker'] . "' ";							
							$cas = $this->db->getResult ( $ca_query, true );
							
							if (! empty ( $cas )) 
							{
								foreach ( $cas as $cakey => $ca ) 
								{	
									if (array_key_exists ( $ca ['mnemonic'], $checkArray )) 
									{
										foreach ( $checkArray [$ca ['mnemonic']] as $fieldname ) 
										{
											$ca_value_query = "Select id from tbl_ca_values where ca_id='" . $ca ['id'] . "'  and ca_action_id='" . $ca ['action_id'] . "' and field_name='" . $fieldname . "' ";

											$ca_values = $this->db->getResult ( $ca_value_query );
											if (count ( $ca_values ) <= 0)
												$text .= $ca ['company_name'] . "(" . $ca ['identifier'] . ")=>" . $_SESSION ['variable'] [$ca ['mnemonic']] . "=>" . $_SESSION ['variable'] [$fieldname] . "=>" . $fieldname . "<br>";
										}
									}
								}
							}
							$indxxprices [$key] ['ca'] = $cas;
						}
					}
				}
			}
		}

		if ($text != '' && $text) 
		{
			$useremails = $this->db->getResult ( "select email from tbl_ca_user where 1=1", true );
			$emailids = array ();

			foreach ( $useremails as $key => $users ) 
			{
				$emailids [] = $users ['email'];
			}
			
			$to = implode ( ',', $emailids );
			
			$from = "Indexing <indexing@indxx.com>";
			$subject = "Softlayer - Corporate Actions Value Not Inserted";
			
			$message = 'Hi <br>';
			$message .= 'Values for following corporate actions has not been inserted :<br>';
			$message .= $text;
			$message .= 'Thanks.';
			
			$headers = "From: $from" . "\r\n" . "CC: indexing@indxx.com" . "\r\n";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			mail ( $to, $subject, $message, $headers );
		}

		$this->log_info(log_file, "CA checkcavalue process finished");
		
		//$this->saveProcess ( 1 );
		if (DEBUG)
		{
			$this->Redirect("index.php?module=calcspinstockadd&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
		}
		else
		{
			//$this->Redirect("index.php?module=calcspinstockadd&DEBUG=" .DEBUG. "&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
			log_error("Unable to locate calcspinstockadd index module.");
			mail_exit(__FILE__, __LINE__);
		}
	}
}
?>