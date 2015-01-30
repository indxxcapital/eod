<?php
class Checkcavalue extends Application 
{
	function __construct() 
	{
		parent::__construct ();
	}
	
	function index() 
	{
		//$time = explode ( ' ', microtime () );
		//$curr_time = $time [1] + $time [0];
		
		/* TODO: Convert all getresult calls into mysql calls, paging isn;t needed */

		$datevalue2 = $this->_date;
		
		if($_GET['log_file'])
			define("log_file", $_GET['log_file']);
		
		$this->log_info(log_file, "CA checkcavalue process started");
		
		$checkArray = array ();
		$checkArray ['DVD_CASH'] 	= array('CP_NET_AMT','CP_GROSS_AMT', 'CP_DVD_CRNCY', 'CP_DVD_TYP');
		$checkArray ['CHG_NAME'] 	= array('CP_OLD_NAME', 'CP_NEW_NAME');
		$checkArray ['CHG_ID'] 		= array('CP_OLD_ISIN', 'CP_NEW_ISIN');
		$checkArray ['SPIN'] 		= array('CP_ADJ');
		$checkArray ['DVD_STOCK'] 	= array('CP_AMT');
		$checkArray ['STOCK_SPLT'] 	= array('CP_ADJ');
		$checkArray ['RIGHTS_OFFER'] = array ('CP_RATIO', 'CP_ADJ', 'CP_PX', 'CP_CRNCY');
		
		$text = '';
		
		$query = "select distinct ind.id as ind_id, it.ticker, ca.identifier, ca.action_id, ca.id, ca.mnemonic, ca.company_name, ca.eff_date, ca.currency    
				from tbl_indxx ind join tbl_holidays hds on hds.zone_id=ind.zone 
				join tbl_indxx_ticker it on it.indxx_id=ind.id 
				join tbl_ca ca on ca.identifier=it.ticker 
				where ind.status='1' and ind.usersignoff='1' and ind.dbusersignoff='1' and ind.submitted='1' 
				and hds.date!='" .$datevalue2. "' and eff_date='" .$datevalue2 ."'";
		$res = mysql_query($query);
		if (($err_code = mysql_errno()))
		{
			$this->log_error(log_file, "Mysql query failed, error code " . $err_code . ". Exiting CA process.");
			$this->mail_exit(log_file, __FILE__, __LINE__);
		}
		
		while (false != ($ca =mysql_fetch_assoc($res)))
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
		mysql_free_result($res);

		//echo "text = " .$text. "<br>";
		//$time = explode ( ' ', microtime () );
		//$end_time = $time [1] + $time [0];
		//echo "Time taken = " .round(($end_time - $curr_time), 4) . "<br>";
		//return;
		
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
			
			/* TODO: Send this mail to generic ID */
			mail ( $to, $subject, $message, $headers );
		}

		$this->log_info(log_file, "CA checkcavalue process finished");
		
		//$this->saveProcess ( 1 );
		$this->Redirect("index.php?module=calcspinstockadd&date=" .$datevalue2. "&log_file=" . basename(log_file), "", "" );
	}
}
?>