<?php

class Functions extends Models {

	//For production mode make this 0, set this to 0 in input_file.php too
	var $DEBUG = 0;
	var $debugging = true;
	var $moduleClass = "";
	var $moduleClassFile = "";
	var $_baseTemplate = "main-template";
	var $_js = array ();
	var $_css = array ();
	var $_extraHead = array ();
	var $validData = array ();
	var $_breadcrumbs = array ();
	var $_breadcrumbsHome = 1;
	var $_breadcrumbshow = 1;
	var $_date = '';

	var $logs_folder = "../files/logs/";
	var $email_errors = null;

	function do_init()
	{		
		/* Execution time for the script. Must be defined based on performance and load. */
		ini_set('max_execution_time', 60 * 60);
		ini_set("memory_limit", "1024M");

		if ($this->DEBUG)
		{
			date_default_timezone_set("Asia/Kolkata");
			$this->email_errors	= "amitmahajan86@gmail.com";
		}
		else
		{
			date_default_timezone_set("America/New_York");	
			//$this->email_errors	= "amitmahajan86@gmail.com";
			$this->email_errors = "icalc@indxx.com";
		}			
	}
	
	function setdate() {
		/* Define date for fetching input files and manipulations */
		if ($_GET['date'])
			$this->_date = $_GET['date'];
		else
			$this->_date = date("Y-m-d");
		
		$this->do_init();
	}
	function setLang($lang = "en") {
		
		// $this->_date='2013-12-09';
		$langFile = $this->siteconfig->base_path . "lang/" . $lang . "/application.lang.ini";
		
		if (file_exists ( $langFile )) {
			
			$fh = fopen ( $langFile, 'r' );
			$content = explode ( "\n", fread ( $fh, filesize ( $langFile ) ) );
			foreach ( $content as $string ) {
				$data = explode ( ":", $string );
				$langData [$data [0]] = $data [1];
			}
		}
		
		$langFile = $this->siteconfig->base_path . "lang/" . $lang . "/" . strtolower ( get_class ( $this ) ) . ".lang.ini";
		
		if (file_exists ( $langFile )) {
			
			$fh = fopen ( $langFile, 'r' );
			$content = explode ( "\n", fread ( $fh, filesize ( $langFile ) ) );
			foreach ( $content as $string ) {
				$data = explode ( ":", $string );
				$langData [$data [0]] = $data [1];
			}
		}
		
		return $langData;
	}
	function l($string) {
		
		// echo $string;
		if ($this->lang [$string] != "") {
			$string = $this->lang [$string];
		}
		
		return trim ( $string );
	}
	protected function addJs($js) {
		if (is_array ( $js )) {
			$this->_js = array_merge ( $this->_js, $js );
		} else {
			array_push ( $this->_js, $js );
		}
		$this->_js = array_unique ( $this->_js );
	}
	protected function addCss($css) {
		if (is_array ( $css )) {
			$this->_css = array_merge ( $this->_css, $css );
		} else {
			array_push ( $this->_css, $css );
		}
		$this->_css = array_unique ( $this->_css );
	}
	protected function addHead($text) {
		if (is_array ( $text )) {
			$this->_extraHead = array_merge ( $this->_extraHead, $text );
		} else {
			array_push ( $this->_extraHead, $text );
		}
	}
	protected function validate($feild_code, $feild_type, $is_required, $validate_type, $feild_label, $function = "", $onChange = "", $value = "", $editor = "", $required_check = "") {
		$validData ['feild_code'] = $feild_code;
		$validData ['feild_type'] = $feild_type;
		$validData ['is_required'] = $is_required;
		$validData ['validate'] = $validate_type;
		$validData ['feild_label'] = ucwords ( strtolower ( $feild_label ) );
		$validData ['model'] = $function;
		$validData ['onChange'] = $onChange;
		$validData ['value'] = $value;
		$validData ['editor'] = $editor;
		$validData ['required_check'] = $required_check;
		$this->validData [] = $validData;
	}
	protected function getValidFeildsold($function = "Form") {
		$function = ucfirst ( str_replace ( " ", "", $function ) );
		/*
		 * echo "<pre>";
		 * print_r($this->validData);
		 * exit;
		 */
		
		if ($function == "Form") {
			$data = $this->validData;
			
			$feildName = "fields";
		} else {
			$data = $this->validData [$function];
			$feildName = "fields" . $function;
		}
		// $data = $this->validData;
		
		// $javascript = "alert('Gaurav');\n";
		
		if ($data) {
			foreach ( $data as $value ) {
				
				if ($value ['grouped'] != "") {
					if (empty ( $grouped [$value ['grouped']] )) {
						$feildsData [] = $value;
					}
					$grouped [$value ['grouped']] [] = $value;
				} else {
					$feildsData [] = $value;
				}
				
				if ($value ['error_label'] == "") {
					$errorLabel = $value ['feild_label'];
				} else {
					$errorLabel = $value ['error_label'];
				}
				
				if ((trim ( $value ['validate'] ) != "" || $value ['is_required'] != 0)) {
					
					if ($value ['feild_type'] == "select" || $value ['feild_type'] == "radio" || $value ['feild_type'] == "checkbox" || $value ['feild_type'] == "select-user" || $value ['feild_type'] == "select-user-edit" || $value ['feild_type'] == "multiselect") {
						$type = "Select";
					} elseif ($value ['feild_type'] == "checkbox_adop") {
						$type = "Check";
					} elseif ($value ['feild_type'] == "file") {
						$type = "Browse";
					} else {
						$type = "Enter";
					}
					
					if ($value ['feild_type'] == "radio") {
						$value ['validate'] = "radio";
					}
					
					if ($value ['feild_type'] == "checkbox") {
						$value ['validate'] = "checkbox";
					}
					if ($value ['feild_type'] == "checkbox-adop") {
						$value ['validate'] = "checkbox";
					}
					if ($value ['feild_type'] == "file-resume") {
						$value ['validate'] = "file";
					}
					if ($value ['feild_type'] == "select-user") {
						$value ['validate'] = "select";
					}
					if ($value ['feild_type'] == "select-user-edit") {
						$value ['validate'] = "select";
					}
					
					if (is_array ( $value ['required_check'] )) {
						
						$javascript .= "var requiredCheck = {code : \"" . $value ['required_check'] ['feild_code'] . "\",matchValue : \"" . $value ['required_check'] ['match_value'] . "\",matchType : \"" . $value ['required_check'] ['match_type'] . "\"};\n";
						// $javascript.= "alert(requiredCheck.code);\n";
						/*
						 * $javascript.= "var Array".$value['feild_code']." = new Array();\n";
						 * $javascript.= $value['feild_code']." = \"hello\"\n";
						 */
						
						$blankCondition = "requiredCheck";
					} else {
						$blankCondition = "\"\"";
					}
					
					if ($value ['editor'] == 1) {
						
						$javascript .= "\tvar Editor" . $value ['feild_code'] . " = CKEDITOR.instances." . $value ['feild_code'] . ";\n\tEditor" . $value ['feild_code'] . ".resetDirty();\n\n";
						
						if ($value ['is_required'] == 1) {
							$javascript .= "\tif(!checkfeildEditor(\"" . $value ['feild_code'] . "\",\" " . $this->l ( "Please" ) . " " . $this->l ( $type ) . " " . $errorLabel . "\",Editor" . $value ['feild_code'] . ".getData()))\n\t{\n\t\terror = 1 ;\n\t}\n\n";
						}
					} else {
						
						/* $javascript.="\tif(!checkfeild(\"".$value['feild_code']."\",\"Please ".$type." ".$errorLabel ."\",\"".$value['is_required']."\",\"".trim($value['validate'])."\"))\n\t{\n\t\terror = 1 ;\n\t}\n\n"; */
						if (is_array ( $value ['validate'] )) {
							$vi = 1;
							
							$javascript .= "\tif(";
							foreach ( $value ['validate'] as $validateConditions ) {
								$javascript .= "!checkfeild(\"" . $value ['feild_code'] . "\",\" " . $this->l ( "Please" ) . " " . $this->l ( $type ) . " " . $errorLabel . "\",\"" . $value ['is_required'] . "\",\"" . trim ( $validateConditions ) . "\" ," . $blankCondition . ")";
								if ($vi < sizeof ( $value ['validate'] )) {
									$javascript .= " && ";
								}
								$vi ++;
							}
							$javascript .= ")\n\t{\n\t\terror = 1 ;\n\t}\n\n";
						} else {
							
							$javascript .= "\tif(!checkfeild(\"" . $value ['feild_code'] . "\",\" " . $this->l ( "Please" ) . " " . $this->l ( $type ) . " " . $errorLabel . ".\",\"" . $value ['is_required'] . "\",\"" . trim ( $value ['validate'] ) . "\" ," . $blankCondition . "))\n\t{\n\t\terror = 1 ;\n\t}\n\n";
						}
					}
				}
				
				if ($value ['feildOptions'] ['onChange']) {
					$this->addJs ( array (
							'ajax.js' 
					) );
				}
			}
		}
		
		if (! empty ( $grouped )) {
			$this->smarty->assign ( "groupedFeilds", $grouped );
		}
		
		$this->smarty->assign ( $feildName, $feildsData );
		
		$this->smarty->assign ( "fieldsCount", round ( count ( $data ) / 2 ) );
		
		if ($this->customJsAdd != "") {
			$javascript = $javascript . "\n\n" . $this->customJsAdd;
		}
		
		$validate = "<script langauge=\"javascript\">\nfunction Validate" . $function . "()\n{\n\tvar error=0;\n\n" . $javascript . "\n\tif(error)\n\t{\n\t\t return false;\n\t}\n\telse\n\t{
\t\t  return true;\n\t}\n}\n</script>";
		
		$this->addJs ( array (
				'validation.js' 
		) );
		$this->addCss ( 'dynamic.css' );
		$this->addHead ( $validate );
	}
	protected function getValidFeilds($function = "Form") {
		$function = ucfirst ( str_replace ( " ", "", $function ) );
		/*
		 * echo "<pre>";
		 * print_r($this->validData);
		 * exit;
		 */
		
		if ($function == "Form") {
			$data = $this->validData;
			
			$feildName = "fields";
		} else {
			$data = $this->validData [$function];
			$feildName = "fields" . $function;
		}
		// $data = $this->validData;
		
		// $javascript = "alert('Gaurav');\n";
		
		if ($data) {
			foreach ( $data as $value ) {
				
				if ($value ['grouped'] != "") {
					if (empty ( $grouped [$value ['grouped']] )) {
						$feildsData [] = $value;
					}
					$grouped [$value ['grouped']] [] = $value;
				} else {
					$feildsData [] = $value;
				}
				
				if ($value ['error_label'] == "") {
					$errorLabel = $value ['feild_label'];
				} else {
					$errorLabel = $value ['error_label'];
				}
				
				if (trim ( $value ['validate'] != "" || $value ['is_required'] != 0 )) {
					
					if ($value ['feild_type'] == "select" || $value ['feild_type'] == "radio" || $value ['feild_type'] == "checkbox" || $value ['feild_type'] == "file" || $value ['feild_type'] == "multiselect") {
						$type = "Select";
					} else {
						$type = "Enter";
					}
					
					if ($value ['feild_type'] == "radio") {
						$value ['validate'] = "radio";
					}
					
					if ($value ['feild_type'] == "checkbox") {
						$value ['validate'] = "checkbox";
					}
					
					if (is_array ( $value ['required_check'] )) {
						
						$javascript .= "var requiredCheck = {code : \"" . $value ['required_check'] ['feild_code'] . "\",matchValue : \"" . $value ['required_check'] ['match_value'] . "\",matchType : \"" . $value ['required_check'] ['match_type'] . "\"};\n";
						// $javascript.= "alert(requiredCheck.code);\n";
						/*
						 * $javascript.= "var Array".$value['feild_code']." = new Array();\n";
						 * $javascript.= $value['feild_code']." = \"hello\"\n";
						 */
						
						$blankCondition = "requiredCheck";
					} else {
						$blankCondition = "\"\"";
					}
					
					if ($value ['editor'] == 1) {
						
						$javascript .= "\tvar Editor" . $value ['feild_code'] . " = CKEDITOR.instances." . $value ['feild_code'] . ";\n\tEditor" . $value ['feild_code'] . ".resetDirty();\n\n";
						
						if ($value ['is_required'] == 1) {
							$javascript .= "\tif(!checkfeildEditor(\"" . $value ['feild_code'] . "\",\"Please " . $type . " " . $errorLabel . "\",Editor" . $value ['feild_code'] . ".getData()))\n\t{\n\t\terror = 1 ;\n\t}\n\n";
						}
					} else {
						
						/* $javascript.="\tif(!checkfeild(\"".$value['feild_code']."\",\"Please ".$type." ".$errorLabel ."\",\"".$value['is_required']."\",\"".trim($value['validate'])."\"))\n\t{\n\t\terror = 1 ;\n\t}\n\n"; */
						if (is_array ( $value ['validate'] )) {
							$vi = 1;
							
							$javascript .= "\tif(";
							foreach ( $value ['validate'] as $validateConditions ) {
								$javascript .= "!checkfeild(\"" . $value ['feild_code'] . "\",\"Please " . $type . " " . $errorLabel . "\",\"" . $value ['is_required'] . "\",\"" . trim ( $validateConditions ) . "\" ," . $blankCondition . ")";
								if ($vi < sizeof ( $value ['validate'] )) {
									$javascript .= " && ";
								}
								$vi ++;
							}
							$javascript .= ")\n\t{\n\t\terror = 1 ;\n\t}\n\n";
						} else {
							
							$javascript .= "\tif(!checkfeild(\"" . $value ['feild_code'] . "\",\"Please " . $type . " " . $errorLabel . "\",\"" . $value ['is_required'] . "\",\"" . trim ( $value ['validate'] ) . "\" ," . $blankCondition . "))\n\t{\n\t\terror = 1 ;\n\t}\n\n";
						}
					}
				}
				
				if ($value ['feildOptions'] ['onChange']) {
					$this->addJs ( array (
							'ajax.js' 
					) );
				}
			}
		}
		
		if (! empty ( $grouped )) {
			$this->smarty->assign ( "groupedFeilds", $grouped );
		}
		
		$this->smarty->assign ( $feildName, $feildsData );
		
		$this->smarty->assign ( "fieldsCount", round ( count ( $data ) / 2 ) );
		
		if ($this->customJsAdd != "") {
			$javascript = $javascript . "\n\n" . $this->customJsAdd;
		}
		
		$validate = "<script langauge=\"javascript\">\nfunction Validate" . $function . "()\n{\n\tvar error=0;\n\n" . $javascript . "\n\tif(error)\n\t{\n\t\t return false;\n\t}\n\telse\n\t{
\t\t  return true;\n\t}\n}\n</script>";
		
		$this->addJs ( array (
				'validation.js',
				'formValidator.js' 
		) );
		$this->addCss ( 'css/dynamic.css' );
		$this->addHead ( $validate );
	}
	protected function validatPost($feildArray = "") {
		include_once ("validate.class.php");
		$validate = new validate ();
		$validate->check_4html = true;
		
		if ($feildArray == "") {
			$data = $this->validData;
		} else {
			$data = $this->validData [$feildArray];
		}
		
		$data = $this->validData;
		$extraInsert = array ();
		$javascript = "";
		// echo "<pre>"; print_r($data); exit;
		foreach ( $data as $value ) {
			
			$_POST [$value ['feild_code']] = $_POST [$value ['feild_code']];
			
			if ($value ['editor'] == 1 || $value ['feild_type'] == "textarea") {
				$validate->check_4html = false;
			} else {
				$validate->check_4html = true;
			}
			
			if ($value ['is_required'] == 1) {
				$is_required = "y";
			} else {
				$is_required = "n";
			}
			
			if ($value ['feild_type'] == "password") {
				$validate_setting = "password";
			} else if ($value ['validate'] == "") {
				$validate_setting = "text";
			} else {
				$validate_setting = $value ['validate'];
			}
			
			$validate->add_text_field ( $value ['feild_code'], $_POST [$value ['feild_code']], $validate_setting, $is_required, $value ['feild_label'], $value ['required_check'] );
			
			if (! $validate->validation ()) {
				// $this->error[$value['feild_code']]= str_replace($value['feild_code'],$value['feild_label'],$validate->create_msg());
				$_POST ['error'] [$value ['feild_code']] = str_replace ( $value ['feild_code'], $value ['feild_label'], $validate->create_msg () );
			}
			
			if (! strstr ( $value ['validate'], "match|" ) && $value ['skip'] != "1") {
				
				$extraInsert [] = $value;
			}
		}
		
		$this->smarty->assign ( "postData", $_POST );
		
		if (count ( $_POST ['error'] ) > 0) {
			
			$this->smarty->assign ( "error", $this->error );
			$this->smarty->assign ( "postData", $_POST );
			$this->setMessage ( $this->l ( "There was some error in your input" ), "error" );
			return false;
		} else {
			
			foreach ( $extraInsert as $feilds ) {
				$checkExtra = "";
				$extraKeys = "";
				$extraValues = "";
				if (! strstr ( $feilds ['validate'], "match|" ) && $feilds ['feild_code'] != "StoreId") {
					
					if (trim ( addslashes ( $_POST ["other_" . $feilds ['feild_code']] ) ) != "") {
						
						if ($feilds ['otherKey'] != "") {
							
							if ($_POST ["inserted_" . $feilds ['otherID']] != "") {
								$perentId = trim ( addslashes ( $_POST ["inserted_" . $feilds ['otherID']] ) );
							} else {
								$perentId = trim ( addslashes ( $_POST [$feilds ['otherID']] ) );
							}
							$checkExtra = " and " . $feilds ['otherKey'] . " = '" . $perentId . "'";
							
							$extraKeys = "," . $feilds ['otherKey'];
							$extraValues = ", '" . $perentId . "' ";
						}
						echo "select * from  " . $feilds ['otherTable'] . " where " . $feilds ['otherFeildName'] . " = '" . trim ( addslashes ( $_POST ["other_" . $feilds ['feild_code']] ) ) . "'" . $checkExtra;
						$chk = $this->db->getResult ( "select * from  " . $feilds ['otherTable'] . " where " . $feilds ['otherFeildName'] . " = '" . trim ( addslashes ( $_POST ["other_" . $feilds ['feild_code']] ) ) . "'" . $checkExtra );
						
						if ($this->db->mysqlrows == 0) {
							
							mysql_query ( "insert into " . $feilds ['otherTable'] . " (" . $feilds ['otherFeildName'] . ",status" . $extraKeys . ") VALUES ('" . trim ( addslashes ( $_POST ["other_" . $feilds ['feild_code']] ) ) . "','1'" . $extraValues . ")" );
							$id = mysql_insert_id ();
						} else {
							
							$id = $chk ['id'];
						}
						
						$_POST ["inserted_" . $feilds ['feild_code']] = $id;
						$_POST [$feilds ['feild_code']] = $id;
						
						$values [] = "'" . $id . "'";
					} else {
						
						$values [] = "'" . trim ( addslashes ( $_POST [$feilds ['feild_code']] ) ) . "'";
					}
					
					$keys [] = $feilds ['feild_code'];
				}
			}
			
			return true;
		}
	}
	function trim_array($array, $remove_null_number = true) {
		$new_array = array ();
		
		$null_exceptions = array ();
		
		foreach ( $array as $key => $value ) {
			$value = trim ( $value );
			
			if ($remove_null_number) {
				$null_exceptions [] = '0';
			}
			
			if (! in_array ( $value, $null_exceptions ) && $value != "") {
				$new_array [] = $value;
			}
		}
		return $new_array;
	}
	protected function SendMailId($mailId, $data, $to, $fromname = "", $fromemail = "", $attachment = "") {
		// echo ++$this->_mailcount;
		$email = $this->db->getResult ( "select * from tbl_emails where id = '" . $mailId . "' " );
		
		$subject = $email ['mailSubject'];
		$body = $email ['mailBody'];
		
		$replcements = explode ( "\n", $email ['parameters'] );
		
		foreach ( $replcements as $replcement ) {
			$replcement = trim ( $replcement );
			preg_match ( "/{(.*)}/", $replcement, $match );
			$body = str_replace ( $replcement, $data [strtoupper ( $match [1] )], $body );
		}
		
		// require_once(BASE_PATH.'/libs/mailer/class.phpmailer.php');
		require_once ($this->siteconfig->base_path . '/libs/mailer/class.phpmailer.php');
		$mail = new PHPMailer ();
		// $mail->SMTPDebug = 2;
		// echo $siteconfig->smtp_enable;
		if ($siteconfig->smtp_enable == "1") {
			$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent
			$mail->IsSMTP (); // telling the class to use SMTP
			$mail->Host = $siteconfig->smtp_host;
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->Port = $siteconfig->smtp_port; // set the SMTP port for the GMAIL server
			$mail->Username = $siteconfig->smtp_user; // SMTP account username
			$mail->Password = $siteconfig->smtp_password; // SMTP account password
			echo "test";
		} else {
			$mail->Host = 'localhost'; // "mail.autobulls.com";
			$mail->SMTPAuth = false; // enable SMTP authentication
			$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent
		}
		
		// get the template html folder
		$templateFormat = file_get_contents ( $this->siteconfig->base_path . 'assets/mail/mailer.html' );
		$imagePath = $this->siteconfig->base_path . 'assets/images/';
		$templateFormat = str_replace ( '{IMAGE_PATH}', $imagePath, $templateFormat );
		$body = str_replace ( '{BODY}', $body, $templateFormat );
		
		// echo $body ;exit;
		if ($fromname != "" && $fromemail != "") {
			$mail->SetFrom ( $fromemail, $fromname );
		} else {
			
			$mail->SetFrom ( $siteconfig->admin_email, $siteconfig->from_name );
		}
		
		$address = $to;
		$mail->AddAddress ( $address, "" );
		$mail->Subject = $subject;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML ( $body );
		// echo $body;die;
		if (is_array ( $attachment )) {
			$attachment = $this->trim_array ( $attachment );
		}
		if (! empty ( $attachment )) {
			foreach ( $attachment as $attachments ) {
				$mail->AddAttachment ( $attachments );
			}
		}
		
		return $mail->Send ();
	}

	protected function SendMail($to,$subject,$body,$attachment,$fromname="",$fromemail="")
	{
		if (!$this->DEBUG)
		{
			require_once($this->siteconfig->base_path.'mailer/index.php');
			sendmail($to,$subject,$body);
		}
	}
	protected function SendMail_old($to, $subject, $body, $attachment, $fromname = "", $fromemail = "") {
		
		// get the template html folder
		$templateFormat = file_get_contents ( $this->siteconfig->base_path . 'assets/mail/mailer.html' );
		$imagePath = $this->siteconfig->base_url . 'assets/' . $this->tempFolder . '/images/';
		$templateFormat = str_replace ( '{IMAGE_PATH}', $imagePath, $templateFormat );
		$body = str_replace ( '{BODY}', $body, $templateFormat );
		
		// require_once(BASE_PATH.'libs/mailer/class.phpmailer.php');
		require_once ($this->siteconfig->base_path . '/libs/mailer/class.phpmailer.php');
		
		$mail = new PHPMailer ();
		
		if ($siteconfig->smtp_enable == "1") {
			$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent
			$mail->IsSMTP (); // telling the class to use SMTP
			$mail->Host = $siteconfig->smtp_host;
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->Port = $siteconfig->smtp_port; // set the SMTP port for the GMAIL server
			$mail->Username = $siteconfig->smtp_user; // SMTP account username
			$mail->Password = $siteconfig->smtp_password; // SMTP account password
		} else {
			$mail->Host = 'localhost'; // "mail.autobulls.com";
			$mail->SMTPAuth = false; // enable SMTP authentication
			$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent
		}
		
		if ($fromname != "" && $fromemail != "") {
			$mail->SetFrom ( $fromemail, $fromname );
		} else {
			
			$mail->SetFrom ( $siteconfig->admin_email, $siteconfig->from_name );
		}
		
		$address = $to;
		$mail->AddAddress ( $address, "" );
		$mail->Subject = $subject;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML ( $body );
		
		if (is_array ( $attachment )) {
			$attachment = $this->trim_array ( $attachment );
		}
		if (! empty ( $attachment )) {
			foreach ( $attachment as $attachments ) {
				$mail->AddAttachment ( $attachments );
			}
		}
		return $mail->Send ();
	}
	protected function in_array_r($needle, $haystack) {
		$found = false;
		
		foreach ( $haystack as $item ) {
			
			if (is_array ( $item )) {
				if (in_array ( $needle, $item )) {
					return true;
				}
			} else {
				if ($item == $needle) {
					return true;
				}
			}
		}
	}
	protected function makeView() {
		
		// $this->smarty->assign("title","View ".$this->_section);
		$this->trackback = debug_backtrace ();
		$this->_bodyTemplate = "grid/view";
		$this->smarty->assign ( "currentClass", strtolower ( $this->trackback [1] ['class'] ) );
		$this->smarty->assign ( "currentFunction", $this->trackback [1] ['function'] );
		$this->smarty->assign ( "viewData", $this->viewData );
		$this->smarty->assign ( "viewTopData", $this->viewTopData );
		$this->smarty->assign ( "viewBottomData", $this->viewBottomData );
		$this->smarty->assign ( "fields", $this->viewFields );
		$this->smarty->assign ( "fieldsCount", round ( count ( $this->viewFields ) / 2 ) );
		$this->smarty->assign ( "sortby", $_GET ['sortby'] );
		$this->smarty->assign ( "sortDirection", $_GET ['sortDirection'] );
		$this->smarty->assign ( "DisplayRecords", $_GET ['DisplayRecords'] );
		$this->smarty->assign ( "page", $_GET ['page'] );
		$this->smarty->assign ( "pagegroup", $_GET ['pagegroup'] );
		$this->smarty->assign ( "editID", $this->id );
		
		$this->smarty->assign ( "gridButtons", $this->gridButtons );
		$this->show ();
	}
	protected function addButtons($label, $action) {
		$gridButtons ['label'] = $label;
		$gridButtons ['action'] = $action;
		$this->gridButtons [] = $gridButtons;
	}
	protected function stripslashes_deep($value) {
		if (is_array ( $value )) {
			$val = "";
			foreach ( $value as $key => $keyvalue ) {
				
				if (is_array ( $_REQUEST [$key] )) {
					
					$val [$key] = $this->stripslashes_deep ( $_REQUEST [$key] );
				} else {
					$val [$key] = trim ( $keyvalue );
					
					$val [$key] = stripslashes ( $keyvalue );
				}
			}
			$value = $val;
		} else {
			
			$value = stripslashes ( $value );
		}
		return $value;
	}
	protected function addslashes_deep($value) {
		if (is_array ( $value )) {
			$val = "";
			foreach ( $value as $key => $keyvalue ) {
				
				if (is_array ( $_REQUEST [$key] )) {
					
					$val [$key] = $this->addslashes_deep ( $_REQUEST [$key] );
				} else {
					$val [$key] = trim ( $keyvalue );
					if (get_magic_quotes_gpc () != 1) {
						$val [$key] = addslashes ( $keyvalue );
					}
				}
			}
			$value = $val;
		} else {
			$value = trim ( $value );
			if (get_magic_quotes_gpc () != 1) 

			{
				$value = addslashes ( $value );
			}
		}
		return $value;
	}
	protected function createLinkId($link) {
		$link = stripslashes ( $link );
		$patterns [0] = '/_/';
		$patterns [1] = '/@/';
		$patterns [2] = '/&/';
		$patterns [3] = '/!/';
		$patterns [4] = '/\#/';
		$patterns [5] = '/\$/';
		$patterns [6] = '/\%/';
		$patterns [7] = '/\^/';
		$patterns [8] = '/\*/';
		$patterns [9] = '/\(/';
		$patterns [10] = '/\)/';
		$patterns [11] = '/,/';
		$patterns [12] = '/\"/';
		$patterns [13] = '/ /';
		$patterns [14] = '/\//';
		$patterns [15] = '/\//';
		$patterns [16] = '/:/';
		$patterns [17] = '/;/';
		$patterns [18] = '/\?/';
		$patterns [19] = '/{/';
		$patterns [20] = '/}/';
		$patterns [21] = '/\|/';
		$patterns [22] = '/\</';
		$patterns [23] = '/\>/';
		$patterns [24] = '/\[/';
		$patterns [25] = '/\]/';
		$patterns [26] = '/\~/';
		$patterns [27] = '/\'/';
		$patterns [28] = '/\\//';
		$patterns [29] = '/\./';
		
		$replacements = '-';
		$link = preg_replace ( $patterns, $replacements, stripslashes ( $link ) );
		$link = preg_replace ( '/-----/', '-', $link );
		$link = preg_replace ( '/----/', '-', $link );
		$link = preg_replace ( '/---/', '-', $link );
		$link = preg_replace ( '/--/', '-', $link );
		
		if (substr ( $link, strlen ( $link ) - 1 ) == "-") {
			$link = substr ( $link, 0, strlen ( $link ) - 1 );
		}
		$link = preg_replace ( '/\'/', '', $link );
		$link = preg_replace ( '/-/', ' ', $link );
		$link = preg_replace ( '/ /', '-', $link );
		
		return $link;
	}
	
	// Function for show the selected value of combo box
	function makeOptions($arr_name, $sel_val = "") {
		$mkcmbo .= "<option value=''>Select</option>";
		if (count ( $arr_name ) > 0) {
			foreach ( $arr_name as $val ) {
				
				if ($val ['id'] == $sel_val) {
					$mkcmbo .= "<option value='" . $val ['id'] . "' selected>" . $val ['value'] . "</option>";
				} else {
					$mkcmbo .= "<option value='" . $val ['id'] . "'>" . $val ['value'] . "</option>";
				}
			}
		}
		return $mkcmbo;
	}
	function getShortingOrder() {
		return array (
				"" => "Name",
				"1" => "City",
				"2" => "State",
				"3" => "Country" 
		);
	}
	function GetPosition() {
		return array (
				"top" => "Top",
				"bottom" => "Bottom" 
		);
	}
	function GetAddPage() {
		return array (
				"home" => "Home",
				"about-us" => "About Us",
				"return-policy" => "Return Policy",
				"gift-cards-inside" => "Gift Cards Inside",
				"magazine" => "Magazine",
				"community" => "Community",
				"terms-of-use" => "Terms Of Use",
				"privacy-policy" => "Privacy Policy",
				"spam-policy" => "Spam Policy",
				"spam-policy" => "Spam Policy",
				"returns-policy" => "Returns Policy",
				"business-opportunity" => "Business Opportunity",
				"sustainability" => "Sustainability",
				"career" => "Career",
				"investors" => "Investors",
				"SignIn" => "Sign In",
				"SignUp" => "Sign Up",
				"products" => "Products Listing",
				"productsview" => "Product Details",
				"cart" => "Cart",
				"checkout" => "Checkout",
				"myprofile" => "My Account",
				"myreferrals" => "My Referrals",
				"mypointtracker" => "My Point Tracker",
				"refertofriend" => "Refer to friend" 
		);
	}
	function GetStatus() {
		return array (
				"1" => "Active",
				"0" => "Inactive" 
		);
	}
	function GetOrderStatus() {
		return array (
				"0" => "Incomplete",
				"1" => "Shieeped",
				"2" => "Complete",
				"3" => "Regected" 
		);
	}
	function GetPaymentStatus() {
		return array (
				"0" => "Paid",
				"1" => "Unpaid" 
		);
	}
	function GetYesNo() {
		return array (
				"0" => "No",
				"1" => "Yes" 
		);
	}
	function GetCountries() {
		$query = $this->db->getResult ( "select * from tbl_countries  order by name ASC", true );
		$ShowCountry [""] = "Select";
		if (is_array ( $query )) {
			foreach ( $query as $data ) {
				$ShowCountry [$data [id]] = $data [name];
			}
		}
		// print_r($ShowCountry);
		return $ShowCountry;
	}
	
	// functio to get list of countries
	/*
	 * function GetCategoryList()
	 * {
	 *
	 * $query	=	$this->db->getResult("select * from tbl_category order by categoryName ASC",true);
	 * $ShowCategory[""]	=	"Select";
	 * if(is_array($query) ){
	 * foreach($query as $data){
	 * $ShowCategory[$data[id]]	=	$data['categoryName'];
	 * }
	 * }
	 *
	 * return $ShowCategory;
	 * }
	 */
	function GetBrands() {
		$query = $this->db->getResult ( "select * from tbl_brand WHERE status='1' order by id ASC", true );
		$ShowBrand [""] = "Select";
		if (is_array ( $query )) {
			foreach ( $query as $data ) {
				$ShowBrand [$data [id]] = $data ['brandName'];
			}
		}
		
		return $ShowBrand;
	}
	function GetCategory() {
		$query = $this->db->getResult ( "select * from tbl_category WHERE status='1' AND cat_name!= 'Catalog' order by id ASC", true );
		$ShowCategory [""] = "Select";
		if (is_array ( $query )) {
			foreach ( $query as $data ) {
				$ShowCategory [$data [id]] = $data ['cat_name'];
			}
		}
		
		return $ShowCategory;
	}
	function GetOccasion() {
		$query = $this->db->getResult ( "select * from tbl_occasion WHERE status='1' AND occasionname!= 'Catalog' order by id ASC", true );
		$ShowOccasion [""] = "Select";
		if (is_array ( $query )) {
			foreach ( $query as $data ) {
				$ShowOccasion [$data [id]] = $data ['occasionname'];
			}
		}
		
		return $ShowOccasion;
	}
	function GetLocation() {
		$query = $this->db->getResult ( "select * from tbl_location WHERE status='1' AND locationName!= 'Catalog' order by id ASC", true );
		$ShowLocation [""] = "Select";
		if (is_array ( $query )) {
			foreach ( $query as $data ) {
				$ShowLocation [$data [id]] = $data ['locationName'];
			}
		}
		
		return $ShowLocation;
	}
	function GetGifts() {
		$query = $this->db->getResult ( "select * from tbl_gifts WHERE status='1' AND giftname!= 'Catalog' order by id ASC", true );
		$ShowGifts [""] = "Select";
		if (is_array ( $query )) {
			foreach ( $query as $data ) {
				$ShowGifts [$data [id]] = $data ['giftname'];
			}
		}
		
		return $ShowGifts;
	}
	function GetHoliday() {
		$query = $this->db->getResult ( "select * from tbl_holiday WHERE status='1' AND holidayname!= 'Catalog' order by id ASC", true );
		$Showholiday [""] = "Select";
		if (is_array ( $query )) {
			foreach ( $query as $data ) {
				$Showholiday [$data [id]] = $data ['holidayname'];
			}
		}
		
		return $ShowHoliday;
	}
	
	function get_opening_logs_file()
	{
		/* Check if log folder exists, if not create it. */
		if (! file_exists ( $this->logs_folder ))
			mkdir ( $this->logs_folder, 0777, false );
		
		$opening_process_logs = "opening_process_logs_" .date('Y-m-d_H-i-s', $_SERVER ['REQUEST_TIME']) . ".txt";
		return $opening_process_logs;
	}
	/* Logging mechanisms */
	function log_error($log_file, $text) {
		/* Check if log folder exists, if not create it. */
		if (! file_exists ( $this->logs_folder ))
			mkdir ( $this->logs_folder, 0777, false );
		
		file_put_contents ( $this->logs_folder . $log_file, "ERROR: " . $text . "\n", FILE_APPEND );
	}
	function log_warning($log_file, $text) {
		/* Check if log folder exists, if not create it. */
		if (! file_exists ( $this->logs_folder ))
			mkdir ( $this->logs_folder, 0777, false );
		
		file_put_contents ( $this->logs_folder . $log_file, "WARNING: " . $text . "\n", FILE_APPEND );
	}
	function log_info($log_file, $text) {
		/* Check if log folder exists, if not create it. */
		if (! file_exists ( $this->logs_folder ))
			mkdir ( $this->logs_folder, 0777, false );
		
		file_put_contents ( $this->logs_folder . $log_file, "INFO: " . $text . "\n", FILE_APPEND );
	}
	
	/* TODO: Add check for type of process here as we did in function.php */
	function mail_exit($log_file, $file, $line)
	{
		include_once 'mailer/index.php';
				
		$this->log_error($log_file, "Sending email for abrupt process exit at file=" .$file. " and line=" .$line);

		if (!$this->DEBUG)
			sendmail($this->email_errors, "EoD process existed with error.",
			"Please check log[" .$log_file. "] file for more info.");
		exit();
	}
	
	function mail_info($log_file, $info)
	{
		include_once 'mailer/index.php';
			
		$this->log_info($log_file, "Sending email for info - " .$info);
	
		if (!$this->DEBUG)
			sendmail($this->email_errors, "EoD information.", $info);
	}
	
	function mail_skip($log_file, $file, $line)
	{
		include_once 'mailer/index.php';
				
		$this->log_warning($log_file, "Sending email for anomoly at file=" .$file. " and line=" .$line);

		if (!$this->DEBUG)
			sendmail($this->email_errors, "EoD process encountered anomaly.",
				"Please check log[" .$log_file. "] file for more info.");
	}
	
	function exec_mysql_query($query, $log_file, $func, $line)
	{
		$res = mysql_query($query);
		if ($err_code = mysql_errno())
		{
			$this->log_error($log_file, "MYSQL error, code " . $err_code . ". Exiting process.");
			$this->mail_exit($log_file, $func, $line);
		}
		
		return $res;
	}
	
	function writeLog() {
		$iplog_folder = '../files/iplog/';
		/* Check if iplog folder exists, if not create it. */
		if (! file_exists ($iplog_folder))
			mkdir ($iplog_folder, 0777, false );
			
			// $this->pr($_SERVER,true);
		$iplogfile = $iplog_folder .'iplog-' . date ( "Y-m-d" ) . '.txt';
		$ipaddress = $_SERVER ['REMOTE_ADDR'];
		$webpage = $_SERVER ['SCRIPT_NAME'];
		$timestamp = date ( 'm/d/Y h:i:s' );
		$browser = $_SERVER ['REQUEST_URI'] . " ";
		
		if (! empty ( $_SESSION ['User'] ))
			$browser .= implode ( ',', $_SESSION ['User'] );
		$fp = fopen ( $iplogfile, 'a+' );
		chmod ( $iplogfile, 0777 );
		fwrite ( $fp, '[' . $timestamp . ']: ' . $ipaddress . ' ' . $webpage . ' ' . $browser . "\r\n" );
		fclose ( $fp );
	}
	function GetPages() {
		$query = $this->db->getResult ( "select * from tbl_pages order by id ASC", true );
		if (is_array ( $query )) {
			
			foreach ( $query as $data ) {
				$Showpages [$data [pageName]] = $data [pageName];
			}
		}
		// print_r($ShowCountry);
		return $Showpages;
	}
	function GetUser() {
		$query = $this->db->getResult ( "select * from tbl_user order by id ASC", true );
		if (is_array ( $query )) {
			
			foreach ( $query as $data ) {
				$Showpages [$data [id]] = $data [username];
			}
		}
		// print_r($ShowCountry);
		return $Showpages;
	}
	function GetGender() {
		return array (
				"m" => "Male",
				"f" => "Female" 
		);
	}
	function GetAge() {
		return array (
				"" => "Select",
				"0-5" => "0-5",
				"5-10" => "5-10",
				"5-10" => "5-10",
				"10-15" => "10-15",
				"15-20" => "15-20",
				"20-25" => "20-25",
				"25-30" => "25-30" 
		);
	}
	function SpayedNeutered() {
		return array (
				"1" => "Spayed",
				"0" => "Neutered" 
		);
	}
	
	// Function for show the users in drop down
	function showUser() {
		$query = $this->db->getResult ( "select userName, id from tbl_users where status = '1' AND delete_status='0' order by userName ASC", true );
		foreach ( $query as $data ) {
			$ShowUsers [$data [id]] = $data [userName];
		}
		
		return $ShowUsers;
	}
	function IsYesNo() {
		return array (
				"1" => "Yes",
				"2" => "No" 
		);
	}
	function getYearList($start, $limit = "10", $sort = "desc") {
		$end = $start - $limit;
		$years [""] = "Select";
		if ($sort == "asc") {
			
			for($i = $end; $i <= $start; $i ++) {
				
				$years [$i] = $i;
			}
		} else {
			
			for($i = $start; $i >= $end; $i --) {
				$years [$i] = $i;
			}
		}
		
		return $years;
	}
	
	// # function to get categoryes name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function GetFactoryList($addSelectFirst = '') {
		$lang = $_SESSION ['lang'];
		
		if ($lang == 'es') {
			
			$sql_Data = "select id , if(tbl_factory.factory_name_es !='',factory_name_es,factory_name_en) as factory_name from tbl_factory where status='1' order by factory_name ASC";
		} elseif ($lang == 'de') {
			
			$sql_Data = "select id , if(tbl_factory.factory_name_de !='',factory_name_de,factory_name_en) as factory_name    from tbl_factory  where status='1' order by factory_name ASC";
		} elseif ($lang == 'fr') {
			
			$sql_Data = "select id , if(tbl_factory.factory_name_fr !='',factory_name_fr,factory_name_en) as factory_name    from tbl_factory  where status='1' order by factory_name ASC";
		} elseif ($lang == 'en') {
			
			$sql_Data = "select id , factory_name_en as factory_name  from tbl_factory where  status='1' order by factory_name ASC";
		}
		$query = $this->db->getResult ( $sql_Data, true );
		
		if (! empty ( $addSelectFirst )) {
			$ShowList [""] = "Select";
		}
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [factory_name];
			}
		}
		
		return $ShowList;
	}
	// # function to get categoryes name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function GetProducttypelist($addSelectFirst = '') {
		$lang = $_SESSION ['lang'];
		
		if ($lang == 'es') {
			
			$sql_Data = "select id , if(tbl_producttype.prtype_name_es!='',prtype_name_es ,prtype_name_en) as prtype_name    from tbl_producttype where  status='1' order by prtype_name ASC";
		} elseif ($lang == 'de') {
			
			$sql_Data = "select id , if(tbl_producttype.prtype_name_de !='',prtype_name_de,prtype_name_en) as prtype_name    from tbl_producttype  where status='1' order by prtype_name ASC";
		} elseif ($lang == 'fr') {
			
			$sql_Data = "select id , if(tbl_producttype.prtype_name_fr !='',prtype_name_fr,prtype_name_en) as prtype_name    from tbl_producttype  where status='1' order by prtype_name ASC";
		} elseif ($lang == 'en') {
			
			$sql_Data = "select id , prtype_name_en as prtype_name  from tbl_producttype where  status='1' order by prtype_name ASC";
		}
		
		$query = $this->db->getResult ( $sql_Data, true );
		
		if (! empty ( $addSelectFirst )) {
			$ShowList [""] = $this->l ( "Select" );
		}
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [prtype_name];
			}
		}
		// echo "test";die;
		// print_r($ShowList);die;
		return $ShowList;
	}
	// # function to get categoryes name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function GetPacklist($addSelectFirst = '') {
		$query = $this->db->getResult ( "select id, pack_name_en  from tbl_pack where  status='1' order by pack_name_en ASC ", true );
		
		if (! empty ( $addSelectFirst )) {
			$ShowList [""] = "Select";
		}
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [pack_name_en];
			}
		}
		return $ShowList;
	}
	
	// //////////GetProducttypelist///////////
	function GetProductlenghtunit($addSelectFirst = '') {
		$query = $this->db->getResult ( "select id, length_unit   from tbl_lengthunit  order by length_unit  ASC ", true );
		
		if (! empty ( $addSelectFirst )) {
			$ShowList [""] = "Select";
		}
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [length_unit];
			}
		}
		return $ShowList;
	}
	// //////////GetProducttypelist///////////
	function GetProductweightunit($addSelectFirst = '') {
		$query = $this->db->getResult ( "select id, weight_unit   from tbl_weightunit  order by weight_unit  ASC ", true );
		
		if (! empty ( $addSelectFirst )) {
			$ShowList [""] = "Select";
		}
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [weight_unit];
			}
		}
		return $ShowList;
	}
	function GetCountryName($countryid) {
		$sql = "select countryName from tbl_countries where id='" . $countryid . "'";
		$country = $this->db->getResult ( $sql );
		$country ['countryName'];
	}
	
	// # function to get states name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function GetStates($countryid = '') {
		$sql = "select id, name  from tbl_states where 1=1";
		if ($countryid != '') {
			$sql .= "  and countryID ='$countryid'";
		}
		$sql .= " order by name ASC";
		$query = $this->db->getResult ( $sql, true );
		
		$ShowList [""] = "Select";
		
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [name];
			}
		}
		$ShowList ["otherOption"] = "Other";
		return $ShowList;
	}
	
	// # function to get states name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function GetCity() {
		$sql = "select id, name  from tbl_city where 1=1";
		$sql .= " order by name ASC";
		$query = $this->db->getResult ( $sql, true );
		
		$ShowList [""] = "Select";
		
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [name];
			}
		}
		// $ShowList["otherOption"] = "Other";
		return $ShowList;
	}
	function Getservices() {
		$sql = "select id, name  from tbl_service where 1=1";
		$sql .= " order by name ASC";
		$query = $this->db->getResult ( $sql, true );
		
		// $ShowList[""] = "Select";
		
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [name];
			}
		}
		// $ShowList["otherOption"] = "Other";
		return $ShowList;
	}
	
	// # function to get states name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function GetUserType() {
		$sql = "select id, name  from tbl_usertype  where status='1'  ";
		
		$sql .= " order by name ASC";
		$query = $this->db->getResult ( $sql, true );
		
		$ShowList [""] = "Select";
		
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [name];
			}
		}
		$ShowList ["otherOption"] = "Other";
		return $ShowList;
	}
	// # function to get states name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function GetUserCategory() {
		$sql = "select id, name  from tbl_usercategory  where status='1'  ";
		
		$sql .= " order by name ASC";
		$query = $this->db->getResult ( $sql, true );
		
		$ShowList [""] = "Select";
		
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [name];
			}
		}
		$ShowList ["otherOption"] = "Other";
		return $ShowList;
	}
	// # function to get active brands name array
	// # @parms : optional if provided then add "select" at the first position in the array
	// # @ return array
	function getActiveBrands($addSelectFirst = '') {
		$query = $this->db->getResult ( "select id, brandName  from tbl_brands  where  status='1' order by brandName ASC ", true );
		
		if (! empty ( $addSelectFirst )) {
			$ShowList [""] = "Select";
		}
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data ['brandName'];
			}
		}
		return $ShowList;
	}
	function getUserTypes($addSelectFirst = '') {
		if (! empty ( $addSelectFirst )) {
			$userTypeArr [""] = "Select";
		}
		$userTypeArr ["C"] = "Customer";
		$userTypeArr ["R"] = "Reseller";
		
		return $userTypeArr;
	}
	protected function in_array_search($needle, $haystack) {
		$found = false;
		
		if (is_array ( $haystack )) {
			
			foreach ( $haystack as $item ) {
				
				if (is_array ( $item )) {
					
					for($i = 0; $i < count ( $item ); $i ++) {
						if ($i < count ( $item ) - 1) {
							$needalArray [$i] = $i;
						} else {
							$needalArray [$needle] = $needle;
						}
					}
					
					$data = array_map ( array (
							$this,
							__FUNCTION__ 
					), array_keys ( $needalArray ), array_values ( $item ) );
					if (in_array ( "1", $data )) {
						return true;
					}
				} else {
					
					if ($item == $needle) {
						
						return true;
					}
				}
			}
		}
	}
	function upload($obj) {
		$dir_dest = $this->siteconfig->base_path . "media/" . $obj ['folder'];
		$handle = new Upload ( $_FILES [$obj ['file']] );
		
		if ($obj ['thumb_name'] == "") {
			
			$obj ['thumb_name'] = "thumb";
		}
		
		if (! is_dir ( $dir_dest )) {
			mkdir ( $dir_dest );
			chmod ( $dir_dest, 0777 );
		}
		
		if (! is_writable ( $dir_dest )) {
			chmod ( $dir_dest, 0777 );
		}
		
		if ($obj ['type'] == 'image') {
			if (! is_dir ( $dir_dest . "/orignal" )) {
				mkdir ( $dir_dest . "/orignal" );
				chmod ( $dir_dest . "/orignal", 0777 );
			}
			
			if (! is_dir ( $dir_dest . "/" . $obj ['thumb_name'] )) {
				mkdir ( $dir_dest . "/" . $obj ['thumb_name'] );
				chmod ( $dir_dest . "/" . $obj ['thumb_name'], 0777 );
			}
			
			if (! is_writable ( $dir_dest . "/" . $obj ['thumb_name'] )) {
				chmod ( $dir_dest . "/" . $obj ['thumb_name'], 0777 );
			}
			
			if (! is_writable ( $dir_dest . "/orignal" )) {
				chmod ( $dir_dest . "/orignal", 0777 );
			}
			
			if ($handle->uploaded) {
				if ($obj ['onlythumb'] != 1) {
					
					if ($obj ['resize'] == 1) {
						$handle->image_resize = true;
						
						if ($obj ['crop'] == "") {
							if ($obj ['ratio_h'] == 1) {
								$handle->image_ratio_y = true;
							} else if ($obj ['ratio_w'] == 1) {
								$handle->image_ratio_x = true;
							} else {
								$handle->image_ratio = true;
							}
						}
						
						if ($obj ['w'] != "") {
							$handle->image_x = $obj ['w'];
						}
						if ($obj ['h'] != "") {
							$handle->image_y = $obj ['h'];
						}
						if ($obj ['crop']) {
							
							$handle->image_ratio_crop = $obj ['crop'];
						}
					}
					
					if ($handle->image_src_x > 1024) {
						$handle->image_resize = true;
						$handle->image_ratio_y = true;
						$handle->image_x = '1024';
						$handle->image_y = '1024';
					}
					if ($handle->image_src_x < $obj ['w'] && $obj ['w'] != "") {
						$obj ['w'] = $handle->image_src_x;
						$handle->image_x = $handle->image_src_x;
						$obj ['crop'] = "";
					}
					if ($handle->image_src_y < $obj ['h'] && $obj ['h'] != "") {
						$obj ['h'] = $handle->image_src_y;
						$handle->image_y = $handle->image_src_y;
						$obj ['crop'] = "";
					}
					if ($handle->image_src_x < $obj ['w'] && $obj ['w'] != "") {
						$obj ['w'] = $handle->image_src_x;
						$handle->image_x = $handle->image_src_x;
						$obj ['crop'] = "";
					}
					
					$handle->Process ( $dir_dest . "/orignal" );
					
					if ($handle->processed) {
						$info = getimagesize ( $handle->file_dst_pathname );
						$return ['size'] = round ( filesize ( $handle->file_dst_pathname ) / 256 ) / 4;
						$return ['name'] = $handle->file_dst_name;
						$return ['width'] = $info [0];
						$return ['height'] = $info [1];
					}
				}
				
				if ($obj ['createThumb'] == 1) {
					$handle->image_resize = true;
					
					if ($obj ['crop'] == "") {
						if ($obj ['ratio_h'] == 1) {
							$handle->image_ratio_y = true;
						} else if ($obj ['ratio_w'] == 1) {
							$handle->image_ratio_x = true;
						} else {
							$handle->image_ratio = true;
						}
					}
					
					if ($obj ['w'] != "") {
						$handle->image_x = $obj ['w'];
					}
					if ($obj ['h'] != "") {
						$handle->image_y = $obj ['h'];
					}
					if ($obj ['crop']) {
						$handle->image_ratio_crop = $obj ['crop'];
					}
					
					$handle->Process ( $dir_dest . "/" . $obj ['thumb_name'] );
					if ($handle->processed) {
						$info = getimagesize ( $handle->file_dst_pathname );
						$return ['thumb_size'] = round ( filesize ( $handle->file_dst_pathname ) / 256 ) / 4;
						$return ['thumb_name'] = $handle->file_dst_name;
						$return ['thumb_width'] = $info [0];
						$return ['thumb_height'] = $info [1];
					}
				}
				
				// $handle-> Clean();
			}
		} else {
			
			if ($handle->uploaded) {
				
				$handle->Process ( $dir_dest );
				
				if ($handle->processed) {
					
					$return ['size'] = round ( filesize ( $handle->file_dst_pathname ) / 256 ) / 4;
					$return ['name'] = $handle->file_dst_name;
				}
				
				// $handle-> Clean();
			}
		}
		
		return $return;
	}
	function newUpload($obj) {
		if ($obj ['src'] != "") {
			$handle = new Upload ( $obj ['src'] );
		} else {
			$handle = new Upload ( $_FILES [$obj ['file']] );
		}
		
		$dir_dest = $this->siteconfig->base_path . "media/" . $obj ['folder'];
		
		if (! is_dir ( $dir_dest )) {
			mkdir ( $dir_dest );
			chmod ( $dir_dest, 0777 );
		}
		
		if (! is_writable ( $dir_dest )) {
			chmod ( $dir_dest, 0777 );
		}
		
		if ($obj ['type'] == 'image') {
			if (! is_dir ( $dir_dest . "/orignal" )) {
				echo "ss";
				mkdir ( $dir_dest . "/orignal" );
				chmod ( $dir_dest . "/orignal", 0777 );
			}
			
			if (! is_dir ( $dir_dest . "/" . $obj ['thumb_name'] )) {
				mkdir ( $dir_dest . "/" . $obj ['thumb_name'] );
				chmod ( $dir_dest . "/" . $obj ['thumb_name'], 0777 );
			}
			
			if (! is_writable ( $dir_dest . "/" . $obj ['thumb_name'] )) {
				chmod ( $dir_dest . "/" . $obj ['thumb_name'], 0777 );
			}
			
			if (! is_writable ( $dir_dest . "/orignal" )) {
				chmod ( $dir_dest . "/orignal", 0777 );
			}
			
			if ($handle->image_src_x > 1024) {
				$handle->image_resize = true;
				$handle->image_ratio_y = true;
				$handle->image_x = '1024';
				$handle->image_y = '1024';
			}
			
			if ($handle->image_src_y < $obj ['h'] && $obj ['h'] != "") {
				$obj ['h'] = $handle->image_src_y;
				$handle->image_y = $handle->image_src_y;
				$obj ['crop'] = "";
			}
			if ($handle->image_src_x < $obj ['w'] && $obj ['w'] != "") {
				$obj ['w'] = $handle->image_src_x;
				$handle->image_x = $handle->image_src_x;
				$obj ['crop'] = "";
			}
			
			if ($handle->uploaded) {
				if ($obj ['src'] == "") {
					if ($obj ['onlythumb'] != 1) {
						$handle->Process ( $dir_dest . "/orignal" );
						
						if ($handle->processed) {
							$info = getimagesize ( $handle->file_dst_pathname );
							$return ['size'] = round ( filesize ( $handle->file_dst_pathname ) / 256 ) / 4;
							$return ['name'] = $handle->file_dst_name;
							$return ['width'] = $info [0];
							$return ['height'] = $info [1];
						}
					}
				}
				if ($obj ['resize'] == 1) {
					$handle->image_resize = true;
					
					if ($obj ['crop'] == "") {
						if ($obj ['ratio_h'] == 1) {
							$handle->image_ratio_y = true;
						} else if ($obj ['ratio_w'] == 1) {
							$handle->image_ratio_x = true;
						} else {
							$handle->image_ratio = true;
						}
					}
					
					if ($obj ['w'] != "") {
						$handle->image_x = $obj ['w'];
					}
					if ($obj ['h'] != "") {
						$handle->image_y = $obj ['h'];
					}
					if ($obj ['crop']) {
						$handle->image_ratio_crop = $obj ['crop'];
					}
					
					$handle->Process ( $dir_dest . "/" . $obj ['thumb_name'] );
					
					if ($handle->processed) {
						$info = getimagesize ( $handle->file_dst_pathname );
						$return ['thumb_size'] = round ( filesize ( $handle->file_dst_pathname ) / 256 ) / 4;
						$return ['thumb_name'] = $handle->file_dst_name;
						$return ['thumb_width'] = $info [0];
						$return ['thumb_height'] = $info [1];
					}
				}
				
				// $handle-> Clean();
			}
		} else {
			
			if ($handle->uploaded) {
				
				$handle->Process ( $dir_dest );
				
				if ($handle->processed) {
					
					$return ['size'] = round ( filesize ( $handle->file_dst_pathname ) / 256 ) / 4;
					$return ['name'] = $handle->file_dst_name;
				}
				
				// $handle-> Clean();
			}
		}
		
		return $return;
	}
	
	/*
	 * function upload($obj)
	 * {
	 *
	 * $dir_dest = $this->siteconfig->base_path."media/".$obj['folder'];
	 * if($obj['filetype']=="resize" && $obj['src']!="")
	 * {
	 * $handle = new Upload($obj['src']);
	 * }
	 * else
	 * {
	 * $handle = new Upload($_FILES[$obj['file']]);
	 * }
	 *
	 * if($obj['thumb_name']=="")
	 * {
	 *
	 * $obj['thumb_name'] = "thumb";
	 * }
	 *
	 *
	 *
	 * if(!is_dir($dir_dest)){
	 * mkdir($dir_dest);
	 * chmod($dir_dest,0777);
	 *
	 * }
	 *
	 * if(!is_writable($dir_dest)){
	 * chmod($dir_dest,0777);
	 *
	 * }
	 *
	 * if($obj['type']=='image')
	 * {
	 *
	 * if(!is_dir($dir_dest."/orignal")){
	 * mkdir($dir_dest."/orignal");
	 * chmod($dir_dest."/orignal",0777);
	 *
	 * }
	 *
	 *
	 *
	 * if(!is_dir($dir_dest."/".$obj['thumb_name'])){
	 * mkdir($dir_dest."/".$obj['thumb_name']);
	 * chmod($dir_dest."/".$obj['thumb_name'],0777);
	 *
	 * }
	 *
	 * if(!is_writable($dir_dest."/".$obj['thumb_name'])){
	 * chmod($dir_dest."/".$obj['thumb_name'],0777);
	 *
	 * }
	 *
	 *
	 *
	 *
	 *
	 * if(!is_writable($dir_dest."/orignal")){
	 * chmod($dir_dest."/orignal",0777);
	 *
	 * }
	 *
	 *
	 *
	 *
	 * if ($handle->uploaded) {
	 * if($obj['onlythumb']!=1)
	 * {
	 *
	 * if($obj['resize']==1)
	 * {
	 * $handle->image_resize = true;
	 *
	 * if($obj['crop']=="")
	 * {
	 * if($obj['ratio_h']==1)
	 * {
	 * $handle->image_ratio_y = true;
	 * }
	 * else if($obj['ratio_w']==1)
	 * {
	 * $handle->image_ratio_x = true;
	 * }
	 * else
	 * {
	 * $handle->image_ratio = true;
	 * }
	 * }
	 *
	 *
	 * if($obj['w']!="")
	 * {
	 * $handle->image_x = $obj['w'];
	 *
	 * }
	 * if($obj['h']!="")
	 * {
	 * $handle->image_y = $obj['h'];
	 *
	 * }
	 * if($obj['crop'])
	 * {
	 * $handle->image_ratio_crop = $obj['crop'];
	 * }
	 * }
	 * else
	 * {
	 * $handle->image_resize = true;
	 * $handle->image_x = 800;
	 * $handle->image_y = 600;
	 * $handle->image_ratio = true;
	 *
	 * }
	 *
	 *
	 *
	 *
	 * $handle->Process($dir_dest."/orignal");
	 *
	 * if ($handle->processed) {
	 * $info = getimagesize($handle->file_dst_pathname);
	 * $return['size']= round(filesize($handle->file_dst_pathname)/256)/4;
	 * $return['name']= $handle->file_dst_name;
	 * $return['width']= $info[0];
	 * $return['height']= $info[1];
	 * }
	 * }
	 *
	 * if($obj['createThumb']==1)
	 * {
	 * $handle->image_resize = true;
	 *
	 * if($obj['crop']=="")
	 * {
	 * if($obj['ratio_h']==1)
	 * {
	 * $handle->image_ratio_y = true;
	 * }
	 * else if($obj['ratio_w']==1)
	 * {
	 * $handle->image_ratio_x = true;
	 * }
	 * else
	 * {
	 * $handle->image_ratio = true;
	 * }
	 * }
	 *
	 *
	 * if($obj['w']!="")
	 * {
	 * $handle->image_x = $obj['w'];
	 *
	 * }
	 * if($obj['h']!="")
	 * {
	 * $handle->image_y = $obj['h'];
	 *
	 * }
	 * if($obj['crop'])
	 * {
	 * $handle->image_ratio_crop = $obj['crop'];
	 * }
	 *
	 *
	 * $handle->Process($dir_dest."/".$obj['thumb_name']);
	 * if ($handle->processed) {
	 * $info = getimagesize($handle->file_dst_pathname);
	 * $return['thumb_size']= round(filesize($handle->file_dst_pathname)/256)/4;
	 * $return['thumb_name']= $handle->file_dst_name;
	 * $return['thumb_width']= $info[0];
	 * $return['thumb_height']= $info[1];
	 *
	 * }
	 *
	 * }
	 *
	 * //$handle-> Clean();
	 * }
	 *
	 *
	 * }
	 * else
	 * {
	 *
	 * if ($handle->uploaded) {
	 *
	 * $handle->Process($dir_dest);
	 *
	 * if ($handle->processed) {
	 *
	 * $return['size']= round(filesize($handle->file_dst_pathname)/256)/4;
	 * $return['name']= $handle->file_dst_name;
	 * }
	 *
	 *
	 * //$handle-> Clean();
	 * }
	 *
	 * }
	 *
	 * return $return;
	 *
	 * }
	 */
	
	// function to delete file from destination folder
	function deleteFile($obj) {
		$destinationFolder = $this->siteconfig->base_path . "media/" . $obj ['folder']; // destination folder name
		$fileName = $obj ['name']; // file name
		$filePath = $destinationFolder . "/" . $fileName;
		if (file_exists ( $filePath )) {
			@unlink ( $filePath );
		}
	}
	function pr($data, $die = false) {
		if (is_array ( $data )) {
			echo "<pre>";
			print_r ( $data );
			echo "</pre>";
		} else {
			echo $data;
		}
		
		if ($die == true) {
			exit ();
		}
	}
	function breadCrumbs() {
		$this->trackback = debug_backtrace ();
		$this->smarty->assign ( "currentClass", strtolower ( $this->trackback [2] ['class'] ) );
		$this->smarty->assign ( "currentFunction", $this->trackback [2] ['function'] );
		
		$link ['name'] = ucwords ( $this->trackback [2] ['class'] );
		$link ['url'] = $this->makeUrl ( "index.php?module=" . strtolower ( $this->trackback [2] ['class'] ) );
		$this->addLink ( $link );
		
		if ($this->_breadcrumb_title != "") {
			$link2 ['name'] = $this->_breadcrumb_title;
		} else {
			$link2 ['name'] = $this->_title;
		}
		
		// $link['url']=$this->makeUrl("index.php?module=".strtolower($this->trackback[2]['class'])."event=".strtolower($this->trackback[2]['function']));
		$this->addLink ( $link2 );
	}
	function addLink($url) {
		// $this->_breadcrumbs = $this->trim_array($this->_breadcrumbs);
		if ($this->_breadcrumbsHome) {
			$this->_breadcrumbs [0] ['name'] = "Home";
			$this->_breadcrumbs [0] ['url'] = $this->siteconfig->base_url;
		}
		
		array_push ( $this->_breadcrumbs, $url );
	}
	static function webpage2txt($document) {
		$search = array (
				'@<script[^>]*?>.*?</script>@si', // Strip out javascript
				'@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
				'@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
				'@<[\/\!]*?[^<>]*?@si', // Strip out HTML tags
				'@<![\s\S]*?-[ \t\n\r]*>@', // Strip multi-line comments including CDATA
				'/\s{2,}/' 
		)
		;
		
		$text = preg_replace ( $search, "\n", $document );
		
		$pat [0] = "/^\s+/";
		$pat [2] = "/\s+\$/";
		$rep [0] = "";
		$rep [2] = " ";
		
		$text = preg_replace ( $pat, $rep, trim ( $text ) );
		$text = str_replace ( "&nbsp;", " ", $text );
		return $text;
	}
	function GetPettype() {
		$compArray = $this->db->getResult ( "select * from tbl_pettype  where status='1'" );
		$ShowList = array ();
		$ShowList [''] = 'Select';
		foreach ( $compArray as $data ) {
			$ShowList [$data ['id']] = $data ['pettype_name'];
		}
		
		return $ShowList;
	}
	function GetBreed($pettype_id = '') {
		$sql = "select id, breed_name  from tbl_breed  where status='1' AND delete_status='0' ";
		if ($pettype_id != '') {
			$sql .= "  and pettype_id ='$pettype_id'";
		}
		$sql .= " order by breed_name ASC";
		$query = $this->db->getResult ( $sql, true );
		
		$ShowList [""] = "Select";
		
		if (is_array ( $query ) > 0) {
			foreach ( $query as $data ) {
				$ShowList [$data [id]] = $data [breed_name];
			}
		}
		return $ShowList;
	}
	
	// function to check the existing field
	protected function checkDuplicate($fieldname, $fieldvalue) {
		$strQuery = "select id from tbl_admin where  " . $fieldname . " = '" . $fieldvalue . "' ";
		if (! empty ( $_GET ['id'] )) {
			$strQuery .= " AND " . $this->_keyId . "!=" . $_GET ['id'] . " ";
		}
		$queryData = $this->db->getResult ( $strQuery );
		if (is_array ( $queryData )) {
			return false;
		} else {
			return true;
		}
	}
	function checkExistingEmail($table, $fieldname, $fieldvalue = '') {
		$strQuery = "select * from " . $table . " where " . $fieldname . " = '" . $fieldvalue . "' ";
		
		$this->db->getResult ( $strQuery );
		$this->db->mysqlrows;
		if ($this->db->mysqlrows > 0) {
			return 0;
		} else {
			return 1;
		}
	}
	function showdob($time) 

	{
		$timediff = time () - strtotime ( $time );
		$yeartime = 365 * 30 * 24 * 60 * 60;
		$year = floor ( $timediff / (365 * 30 * 24 * 60 * 60) );
		
		$monthtime = $timediff % (365 * 30 * 24 * 60 * 60);
		$moth = floor ( $monthtime / (30 * 24 * 60 * 60) );
		$datetime = $monthtime % (30 * 24 * 60 * 60);
		$day = floor ( $datetime / (24 * 60 * 60) );
		
		$showtime = '';
		if ($year > 0) {
			$showtime .= $year . ' years ';
		}
		if ($moth > 0) {
			if ($year > 0) {
				$showtime . ' & ';
			}
			$showtime .= $moth . ' months ';
		}
		if ($day > 0) {
			if ($moth > 0) {
				$showtime . ' & ';
			}
			// $showtime.=$day.'Days ';
		}
		
		return $showtime;
	}
}
?>