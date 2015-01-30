<pre><?php
//include("function.php");

function disable_index($index_id, $table)
{
	$res = mysql_query("select name, code from ".$table. " where dateStart='" .date. "' and id='" .$index_id. "'");
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	$chkindexstartdate = mysql_fetch_assoc($res);
	if (! empty ( $chkindexstartdate['name'] ) || ! empty ( $chkindexstartdate['code'] ))
	{
		/* TODO: See how this will be reverted in the revert process */
		mysql_query ( "update " .$table. " set status='0' where id='" . $index_id . "'" );
		if (($err_code = mysql_errno()))
		{
			log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
			mail_skip(__FILE__, __LINE__);
		}
			
		log_error("Disabling index (name=" .$chkindexstartdate['name']. ")(id=" .$index_id. 
				")(code=" .$chkindexstartdate['code']. ") due to currency mismatch in CA.");
		mail_skip(__FILE__, __LINE__);
	}
	mysql_free_result($res);
}

function check_dvd_currency()
{
	log_info("Currency check for DVD securities started");

	$query = "Select it.ticker, it.curr, it.divcurr, it.indxx_id, ca.currency, ca.action_id, ca.id, cv.field_name, cv.field_value  
			from tbl_indxx_ticker it join tbl_ca ca on ca.identifier = it.ticker 
			left join tbl_ca_values cv on cv.ca_action_id=ca.action_id 
			where ca.mnemonic = 'DVD_CASH' and cv.field_name='CP_DVD_CRNCY'";
	$res = mysql_query($query);

	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	while (false != ($ca = mysql_fetch_assoc($res)))
	{
		// Make sure security currency and CA currency are same
		if ($ca ['curr'] != $ca ['currency'])
		{
			log_error("Security:" .$ca ['ticker']. " [Default price currency=" .$ca['curr']. "][BBG CA currency=" . $ca['currency'] . "]");
			disable_index($ca ['indxx_id'], "tbl_indxx");
		}

		if ($ca ['divcurr'] != $ca['field_value'])
		{
			log_error("Security:" .$ca ['ticker']. " [Default divident currency=" .$ca['divcurr']. "][BBG CA currency=" . $ca['field_value']. "]");
			disable_index($ca ['indxx_id'], "tbl_indxx");
		}

	}
	mysql_free_result($res);

	log_info("Currency check for DVD securities finshed");

	check_dvd_currency_temp();
}

function check_dvd_currency_temp()
{
	log_info("Currency check for upcoming DVD securities started");

	$query = "Select it.ticker, it.curr, it.divcurr, it.indxx_id, ca.currency, ca.action_id, ca.id, cv.field_name, cv.field_value 
			from tbl_indxx_ticker_temp it join tbl_ca ca on ca.identifier = it.ticker 
			left join tbl_ca_values cv on cv.ca_action_id=ca.action_id 
			where ca.mnemonic = 'DVD_CASH' and cv.field_name='CP_DVD_CRNCY'";	
	$res = mysql_query($query);
	
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}

	while (false != ($ca = mysql_fetch_assoc($res)))
	{
		// Make sure security currency and CA currency are same
		if ($ca ['curr'] != $ca ['currency'])
		{
			log_error("Security:" .$ca ['ticker']. " [Default price currency=" .$ca['curr']. "][BBG CA currency=" . $ca['currency'] . "]");
			disable_index($ca ['indxx_id'], "tbl_indxx_temp");
		}
		
		if ($ca ['divcurr'] != $ca['field_value'])
		{
			log_error("Security:" .$ca ['ticker']. " [Default divident currency=" .$ca['divcurr']. "][BBG CA currency=" . $ca['field_value']. "]");
			disable_index($ca ['indxx_id'], "tbl_indxx_temp");
		}
	}
	mysql_free_result($res);

	log_info("Currency check for upcoming DVD securities done");
	
	notify_ticker_change();
}

function notify_ticker_change()
{
	log_info("Notify for ticker changes started");
	
	$res = mysql_query("select company_name, action_id, identifier, eff_date from tbl_ca where mnemonic = 'CHG_TKR'");	
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}

	while (false != ($ca = mysql_fetch_assoc($res)))
	{
		if (strtotime($ca['eff_date']) >= strtotime (date)) 
		{
			log_warning("Ticker for CA with identifier = " .$ca['identifier']. ", company = " .$ca['company_name']. 
				" and action_id = " .$ca['action_id']. " will be changed on " .date('Y-m-d', strtotime($ca['eff_date'])));

			echo "Ticker for CA with identifier = " .$ca['identifier']. ", company = " .$ca['company_name'].
			" and action_id = " .$ca['action_id']. " will be changed on " .date('Y-m-d', strtotime($ca['eff_date']));
				
			mail_skip(__FILE__, __LINE__);
		}
	}
	mysql_free_result($res);
	
	log_info("Notify for ticker changes done");
	
	misc_notification();
}

function misc_notification()
{
	$userArray 		= array ();
	$dbuserArray 	= array ();
	$IndxxArray 	= array ();
	
	$dbusermsg 			= '';
	$adminmsg 			= '';
	$assignedusermsg 	= '';

	log_info("Misc notification process started");

	$website = "http://"  .gethostbyname(gethostname()). "/eod/icai2/index.php";

	$dayesagodate = date ('Y-m-d', strtotime(date. '+2 days'));
	
	$result1 = mysql_query('Select *  from tbl_ca_user where status = "1"');
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while(false != ($row = mysql_fetch_assoc($result1))) 
	{
		$user = $userArray [$row ['id']];
		
		$user['name'] 	= $row ['name'];
		$user['email'] 	= $row ['email'];
		$user['type'] 	= $row ['type'];
	}
	mysql_free_result($result1);
	
	$result2 = mysql_query('Select *  from tbl_database_users where status = "1"');
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while(false!= ($row = mysql_fetch_assoc($result2))) 
	{
		$user = $dbuserArray [$row ['id']];
		
		$user['name'] 	= $row ['name'];
		$user['email'] 	= $row ['email'];
		$user['type'] 	= 3;
	}
	mysql_free_result($result2);
	
	$result3 = mysql_query('Select * from tbl_indxx_temp where dateStart between "' . date . '" and "' . $dayesagodate . '"');
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while (false != ($row = mysql_fetch_assoc ( $result3))) 
	{
		$IndxxArray [$row ['id']] = $row;

		$indxx_user_name_array = array ();
		$indxx_user_id_array = array ();
		
		$indxxuserResponce = mysql_query("Select user_id from tbl_assign_index_temp where indxx_id='" . $row ['id'] . "'" );
		if (($err_code = mysql_errno()))
		{
			log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
			mail_exit(__FILE__, __LINE__);
		}
		
		while (false != ($employee = mysql_fetch_assoc ( $indxxuserResponce))) 
		{
			if ($userArray [$employee ['user_id']] ['name']) 
			{
				$indxx_user_name_array [] = $userArray [$employee ['user_id']] ['name'];
				$indxx_user_id_array [] = $employee ['user_id'];
			}
		}
		mysql_free_result($indxxuserResponce);
		
		$IndxxArray [$row ['id']] ['employees'] = implode ( ',', $indxx_user_name_array );
		$IndxxArray [$row ['id']] ['employeesid'] = $indxx_user_id_array;
	}
	mysql_free_result($result3);
	
	$result4 = mysql_query('Select * from tbl_ca where eff_date = "' . date. '" and status="0" ');
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while (false != ($row = mysql_fetch_assoc($result4)))
			$adminmsg .= "Today's Inactive Corporate Action : " . $row ['identifier'] . " (" . $row ['company_name'] . " , " . $row ['mnemonic'] . ")<br>";

	mysql_free_result($result4);
	
	$result5 = mysql_query("Select * from tbl_indxx_ticker where status='0' union 
							Select * from tbl_indxx_ticker_temp where status='0'");
	if (($err_code = mysql_errno()))
	{
		log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
		mail_exit(__FILE__, __LINE__);
	}
	
	while (false != ($row = mysql_fetch_assoc ( $result5 ))) 
	{
		$usersdata = mysql_query ( "Select user_id from tbl_assign_index_temp where indxx_id='" . $row ['indxx_id'] . "' union Select user_id from tbl_assign_index where indxx_id='" . $row ['indxx_id'] . "'" );
		if (($err_code = mysql_errno()))
		{
			log_error("Mysql query failed, error code " . $err_code . ". Exiting CA process.");
			mail_exit(__FILE__, __LINE__);
		}
			
		while ( $userss = mysql_fetch_assoc ( $usersdata ) ) 
		{
			$adminmsg .= 'Inactive Ticker : ' . $row ['ticker'] . "(" . $row ['name'] . ")<br>";
			$userArray [$userss ['user_id']] ['mailmessage'] [] = 'Inactive Ticker : ' . $row ['ticker'] . "(" . $row ['name'] . ")<br>";
		}
		mysql_free_result($userss);
	}
	mysql_free_result($result5);	
	
	if (!empty($IndxxArray)) 
	{
		foreach ( $IndxxArray as $indxx ) 
		{
			if (!$indxx ['submitted']) 
			{		
				if (!empty( $indxx ['employees'] )) 
				{
					$adminmsg .= "Indxx Added But Not Submitted : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>) by assigned members ( ' . $indxx ['employees'] . ' ).  <br> ';
	
					foreach ( $indxx ['employeesid'] as $id ) 
						$userArray [$id] ['mailmessage'] [] = 'Index Submission Required for : ' . $indxx ['name'] . "(" . $indxx ['code'] . ")";
				}
			}
	
			if (!$indxx ['status'])
				$adminmsg .= "Approval Required : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>)   <br> ';
	
			if (!$indxx ['dbusersignoff']) 
			{
				$adminmsg .= "Request File Creation Pending : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>) by Database Users<br> ';
				$dbusermsg .= "Request File Creation Pending : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>) <br>';
					
				if (! empty ( $indxx ['employeesid'] )) 
				{
					foreach ( $indxx ['employeesid'] as $id )
						$userArray [$id] ['mailmessage'] [] = "Request File Creation Pending : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>) by Database Users<br> ';
				}
			}
	
			if (!$indxx ['usersignoff']) 
			{
				$adminmsg .= "User Signoff Required : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>)  by assigned members ( ' . $indxx ['employees'] . ')  <br> ';
					
				if (! empty ( $indxx ['employeesid'] ))
				{
					foreach ( $indxx ['employeesid'] as $id )
						$userArray [$id] ['mailmessage'] [] = 'Index Signoff Required for : ' . $indxx ['name'] . "(" . $indxx ['code'] . ")";
				}
			}
	
			if (!$indxx ['runindex']) 
			{
				$adminmsg .= "Index Run Required : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>)  by assigned members ( ' . $indxx ['employees'] . ')  <br> ';
					
				if (! empty ( $indxx ['employeesid'] )) 
				{
					foreach ( $indxx ['employeesid'] as $id )
						$userArray [$id] ['mailmessage'] [] = 'Index Run Required for : ' . $indxx ['name'] . "(" . $indxx ['code'] . ")";
				}
			}
	
			if (!$indxx ['finalsignoff'])
			{
				$adminmsg .= "Final Sign Off Required for : " . $indxx ['name'] . '(<strong>' . $indxx ['code'] . '</strong>)<br> ';
					
				if (! empty ( $indxx ['employeesid'] )) 
				{
					foreach ( $indxx ['employeesid'] as $id )
						$userArray [$id] ['mailmessage'] [] = 'Final Sign Off Pending for : ' . $indxx ['name'] . "(<strong>" . $indxx ['code'] . "</strong>) by admin<br>";
				}
			}
			unset($indxx);
		}
		unset($IndxxArray);
	}
	
	$sub = 'ICAI Notification';
	
	if ($dbusermsg != '') 
	{
		foreach ( $dbuserArray as $dbuser ) 
		{
			$msg = 'Hi ' . $dbuser ['name'] . ',<br>' . $dbusermsg . 'Please visit ' . $website . ' to Update. <br>Thanks';
	
			// To send HTML mail, the Content-type header must be set
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
			// Additional headers
			$headers .= 'To: ' . $dbuser ['name'] . ' <' . $dbuser ['email'] . '>' . "\r\n";
			$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n" . "CC: indexing@indxx.com,dbajpai@indxx.com,jsharma@indxx.com" . "\r\n";
	
			if (mail ( $dbuser ['email'], $sub, $msg, $headers )) 
				log_info("Misc notifications mail sent to " . $dbuser ['name']);
			else
				log_warning("Misc notifications mail failed for " . $dbuser ['name']);
		}
	}
	unset($dbuserArray);
	
	if ($adminmsg) 
	{
		foreach ( $userArray as $user ) 
		{
			if ($user ['type'] == 1) 
			{
				$msg = 'Hi ' . $user ['name'] . ',<br>' . $adminmsg . ' <br>Please visit ' . $website . '  to Update. <br>Thanks';
					
				// To send HTML mail, the Content-type header must be set
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
				// Additional headers
				$headers .= 'To: ' . $user ['name'] . ' <' . $user ['email'] . '>' . "\r\n";
				$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n" . "CC: indexing@indxx.com,dbajpai@indxx.com,jsharma@indxx.com" . "\r\n";

				if (mail ( $user ['email'], $sub, $msg, $headers ))
					log_info("Misc notifications mail sent to " . $user ['email']);
				else
					log_warning("Misc notifications mail failed for " . $user ['email']);				
			}
		}
	
		if (!DEBUG)
		{
			$str = file_get_contents ( "https://voiceapi.mvaayoo.com/voiceapi/SendVoice?user=dbajpai@indxx.com:Reset930&da=918860427207,919654735363,919868915460,919999646314,919990350993&campaign_name=try&voice_file=53c757f695722.wav" );
			//echo $str;
		}
	}
	
	if (! empty ( $userArray )) 
	{
		foreach ( $userArray as $users ) 
		{
			if (! empty ( $users ['mailmessage'] )) 
			{
				$msg = implode ( '<br>', $users ['mailmessage'] ) . "<br>";
				$msg = 'Hi ' . $users ['name'] . ',<br>' . $msg . 'Please visit ' . $website . ' to Update. <br>Thanks';
					
				// To send HTML mail, the Content-type header must be set
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
				// Additional headers
				$headers .= 'To: ' . $users ['name'] . ' <' . $users ['email'] . '>' . "\r\n";
				$headers .= 'From: Indexing <indexing@indxx.com>' . "\r\n" . "CC: indexing@indxx.com,dbajpai@indxx.com,jsharma@indxx.com" . "\r\n";

				if (mail ( $users ['email'], $sub, $msg, $headers ))
					log_info("Misc notifications mail sent to " . $users['email']);
				else
					log_warning("Misc notifications mail failed for " . $users['email']);
				
			}
		}
	}
	unset($userArray);
	
	log_info("Misc notification process finished");
	
	if (!DEBUG)
		webopen("http://191.238.229.176/eod/icai2/index.php?module=calcdelisttemp&date=" .date. "&log_file=" . basename(log_file));
	else
		webopen("http://localhost/eod/icai2/index.php?module=calcdelisttemp&date=" .date. "&log_file=" . basename(log_file));	
}
?>