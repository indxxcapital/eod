<?php 

class validate{
	
	var $fields = array();
	var $messages = "";
	var $check_4html = false;
	var $language;
 
	function validation() {
		$status = 0; 
		
			foreach ($this->fields as $key => $val) {
			$this->messages="";
				if ($this->check_4html) {
				 
				
					if(!is_array($val['value']) && $val['type']!="password")
					{
						if (!$this->check_html_tags($val['value'], $key)) {
							$status++;
					
						}	
					}
				}
				
				}
		
		foreach ($this->fields as $key => $val) {

			switch ($val['type']) {
				case "email":
				if (!$this->check_email($val['value'], $key, $val['required'])) {
					$status++;
				}
				break;
				case "phone":
				if (!$this->check_phone($val['value'], $key, $val['required'])) {
					$status++;
				}
				break;
				case "numeric":
				//case "phone":
				if (!$this->check_num_val($val['value'], $key, $val['length'], $val['required'])) {
					$status++;
				}
				break;
				case "match":
			 
				if (!$this->check_match_val($val['value'], $key, $val['match'], $val['required'])) {
					$status++;
				}
				break;
				case "decimal":
				if (!$this->check_decimal($val['value'], $key, '', $val['required'])) {
					$status++;
				}
				break;
				case "date":
				if (!$this->check_date($val['value'], $key, $val['version'], $val['required'])) {
					$status++;
				}
				break;
				case "weburl":
				if (!$this->check_url($val['value'], $key, $val['required'])) {
					$status++;
				}
				break;
				case "text":
				case "password":
				if (!$this->check_text($val['value'], $key, $val['length'], $val['required'])) {
					$status++;
				}
				break;
				case "onlyif":
				
				if (!$this->check_text_onlyif($val['value'], $key, $val['length'], $val['required'],$val['extravalue'])) {
					$status++;
				}
				break;
				case "checkbox":
				case "radio":
				if (!$this->check_check_box($val['value'], $key, $val['length'], $val['required'])) {
					$status++;
				}
				break;
				
				case "file":

				if (!$this->check_file($key, $val['required'] ,$val['extravalue'])) {
					$status++;
				}
				
				/*if (!$this->check_check_box($val['value'], $key, $val['element'])) {
					$status++;
				}*/
			} 
			
		}
	
		if ($status == 0) {
			return true;
		} else {
			//$this->messages = $this->error_text(0);
			return false;
		}
	}

 	function check_file($field, $req = "n",$extra)
	{
		 
		$filepath = $_FILES[$field]['name'];
		if ($filepath == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			$path_info = pathinfo($filepath);
			$extension=strtolower($path_info['extension']); 
			$valid = explode(",",$extra);
			if(!in_array($extension,$valid))
			{
			
				$this->messages = $this->error_text(17, $field,$extra);
				return false;
			}
			else
			{
				return true;
			}
			
		}
	}
	
	function check_phone($phonenumber, $field, $req = "y") {
		if ($phonenumber == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			 
			 
			 
			 
			$numbersOnly = ereg_replace("[^0-9]", "", $phonenumber);
			$numberOfDigits = strlen($numbersOnly);
			if ($numberOfDigits == 8 or $numberOfDigits == 10 or $numberOfDigits == 11) {
				return true;
			} else {
				 
				if(ereg('^[2-9]{1}[0-9]{2}-[0-9]{3}-[0-9]{4}$', $phonenumber))
				return true;
				else
				{
				$this->messages = $this->error_text(11, $field);
				return false;
				} 
			}
			
			
		}
	}
		
	
	function add_text_field($name, $val, $type = "text", $required = "y",$label,$blankCondition,$modalcount ='',$fileval = "") {
$this->fields = array();

		$validate_setting_type=explode("|",$type);
					$type=$validate_setting_type[0];
					
					 
					if($type=="minimum")
					{
						$type="text";
						$length=$validate_setting_type[1];
					}
					else if($type=="match")
					{
					 	$this->fields[$name]['match'] = $validate_setting_type[1];
					 
					}else if($type == "onlyif"){
						$this->fields[$name]['extravalue'] = $validate_setting_type[1]."|".$validate_setting_type[2];
					}
					else if($type == "file"){

						$this->fields[$name]['extravalue'] = $validate_setting_type[1];
					}
				
		if($blankCondition['feild_code'] != ''){
			if($_POST[$blankCondition['feild_code']]  != $blankCondition['match_value']){
			
				$checkExtra = 1;
			}
		}
		if($checkExtra == ""){	
			$this->fields[$name]['value'] = $val;
			$this->fields[$name]['fileval'] = $fileval;
			$this->fields[$name]['type'] = $type;
			$this->fields[$name]['required'] = $required;
			$this->fields[$name]['length'] = $length;
			$this->fields[$name]['label'] = $label;
			
		}else{
			$this->fields[$name]['value'] = $val;
			$this->fields[$name]['fileval'] = $fileval;
			$this->fields[$name]['type'] = $type;
			$this->fields[$name]['required_check'] = $blankCondition;
			$this->fields[$name]['required'] = $required;
			$this->fields[$name]['length'] = $length;
			$this->fields[$name]['label'] = $label;
		
		}
			//print_r($this->fields);
		
	}
	/*
	function add_num_field($name, $val, $type = "number", $required = "y", $decimals = 0, $length = 0) {
		$this->fields[$name]['value'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
		$this->fields[$name]['decimals'] = $decimals;
		$this->fields[$name]['length'] = $length;
	}
	function add_link_field($name, $val, $type = "email", $required = "y") {
		$this->fields[$name]['value'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
	}
	function add_date_field($name, $val, $type = "date", $version = "us", $required = "y") {
		$this->fields[$name]['value'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['version'] = $version;
		$this->fields[$name]['required'] = $required;
	}
	function add_check_box($name, $element_name, $type = "checkbox", $required_value = "") {
		$this->fields[$name]['value'] = $required_value;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['element'] = $element_name;
	}*/
	function check_url($url_val, $field, $req = "y") {
 
 		$url_val = strtolower($url_val);
		if ($url_val == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			//$url_pattern = "http\:\/\/[[:alnum:]\-\.]+(\.[[:alpha:]]{2,4})+";
			$url_pattern = "(http|https|ftp)\:\/\/[[:alnum:]\-\.]+(\.[[:alpha:]]{2,4})+";
			$url_pattern .= "(\/[\w\-]+)*"; // folders like /val_1/45/
			$url_pattern .= "((\/[\w\-\.]+\.[[:alnum:]]{2,5})?"; // filename like index.(s)html
			$url_pattern .= "|"; // end with filename or ?
			$url_pattern .= "\/?)"; // trailing slash or not
			
			
			/*$url_pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
			if(!preg_match($url_pattern, $url_val)){
					$this->messages = $this->error_text(14, $field);
					return false;
			}else{
				return true;
			}*/
			
			$error_count = 0;
			if (strpos($url_val, "?")) {
				$url_parts = explode("?", $url_val);
				if (!preg_match("/^".$url_pattern."$/", $url_parts[0])) {
					$error_count++;
				}
				if (!preg_match("/^(&?[\w\-]+=\w*)+$/", $url_parts[1])) {
					$error_count++;
				}
			} else {
			 
				if (!preg_match("/^".$url_pattern."$/", $url_val)) {
					$error_count++;
				}
			}
			if ($error_count > 0) {
					$this->messages = $this->error_text(14, $field);
					return false;
			} else {
				return true;
			}
		}
	}
	function check_num_val($num_val, $field, $num_len = 0, $req = "n") {
		if ($num_val == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			$pattern = ($num_len == 0) ? "/^\-?[0-9]*$/" : "/^\-?[0-9]{0,".$num_len."}$/";
			if (preg_match($pattern, $num_val)) {
				return true;
			} else {
				$this->messages = $this->error_text(12, $field);
				return false;
			}
		}
	}
	
	function check_match_val($num_val, $field, $match = 0, $req = "n") {
 

		if ($num_val == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
 
 
			if ($_POST[$match]==$num_val) {
				return true;
			} else {
				$this->messages = $this->error_text(16, $field);
				return false;
			}
		}
	}
	function check_text($text_val, $field, $text_len = 0, $req = "y") {
	

		if($_POST['other_'.$field]!="")
		{		
		
				$_POST[$field] =  "otherOption";
				$text_val = $_POST['other_'.$field];
		}
		
		
		if (empty($text_val) ) {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true; // in case only the text length is validated
			}
		} else {
		
			if ($text_len != 0) {
				if (strlen($text_val) < $text_len) {
					$this->messages = $this->error_text(13, $field , $text_len);
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
			
			
		}
	}
	function check_text_onlyif($text_val, $field, $text_len = 0, $req = "y",$extraval='') {
	
		if($_POST['other_'.$field]!="")
		{		
		
				$_POST[$field] =  "otherOption";
				$text_val = $_POST['other_'.$field];
		}
		$extravaluearr = explode("|",$extraval);
	
		$sourcevalue = explode(":",$extravaluearr[1]);
		if(in_array($_POST[$extravaluearr[0]],$sourcevalue)){
	
			if (empty($text_val) ) {
				if ($req == "y") {
					$this->messages = $this->error_text(1, $field);
					return false;
				} else {
					return true; // in case only the text length is validated
				}
			} else {
			
				if ($text_len != 0) {
					if (strlen($text_val) < $text_len) {
						$this->messages = $this->error_text(13, $field , $text_len);
						return false;
					} else {
						return true;
					}
				} else {
					return true;
				}
				
				
			}
		}else{
			return true;
		}
	
	}
	function check_check_box($text_val, $field, $text_len = 0, $req = "y") {
	
		if (empty($text_val)) {
			if ($req == "y") {
				$this->messages = $this->error_text(12, $field);
				return false;
			} else {
				return true; // in case only the text length is validated
			}
		} else {
			if ($text_len > 0) {
				if (strlen($text_val) > $text_len) {
					$this->messages = $this->error_text(13, $field);
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		}
	}
	/*function check_check_box($req_value, $field, $element) {
	 
		if (empty($_REQUEST[$element])) {
			$this->messages = $this->error_text(12, $field);
			return false;
		} else {
			if (!empty($req_value)) {
				if ($req_value != $_REQUEST[$element]) {
					$this->messages = $this->error_text(12, $field);
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		}
	}*/
	function check_decimal($dec_val, $field, $decimals="2", $req = "n") {
	$decimals="2";
	
		if ($dec_val == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			$pattern = "/^[-]*[0-9][0-9]*\.[0-9]{".$decimals."}$/";
		 
			if (preg_match($pattern, $dec_val)) {
				return true;
			} else {
			
			if ($this->check_num_val($dec_val, $field, '', $req)) {
				return true;
				}
			}
		}
	}
	function indexOf($needle, $haystack) {
	
        for($i = 0,$z = count($haystack); $i < $z; $i++){
                if ($haystack[$i] == $needle) {  //finds the needle
                        return $i;
                }
        }
        return false;
}
	function check_date($date, $field, $version = "us", $req = "n") { 
 
	$monthNames = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		if ($date == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			$date_parts = explode("-", $date);
			$month = $date_parts[1];
			if ($version != "eu") {
		 
				$pattern = "/^(0?[1-9]|[1-2][0-9]|3[0-1])[-](.*)[-](.*)$/";
				$day = $date_parts[0];
				$year = $date_parts[2];
			} else {
				$pattern = "/^(19|20)[0-9]{2}[-](0?[1-9]|1[0-2])[-](0?[1-9]|[1-2][0-9]|3[0-1])$/";
				$day = $date_parts[2];
				$year = $date_parts[0];
			}
			 
			preg_match($pattern, $date,$matches);
			 
			  $day =$matches[1];
			  $month =$this->indexOf($matches[2],$monthNames)+1;
			  $year =$matches[3];
	 
			if (preg_match($pattern, $date) && checkdate(intval($month), intval($day), $year)) {
				return true;
			} else {
				$this->messages = $this->error_text(10, $field);
				return false;
			}
		}
	}
	function check_email($mail_address, $field, $req = "y") {
		if ($mail_address == "") {
			if ($req == "y") {
				$this->messages = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			if (preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,}$/i", $mail_address)) {
				return true;
			} else {
				$this->messages = $this->error_text(11, $field);
				return false;
			}
		}
	}
	function check_html_tags($value, $field) {
		

		$_POST[$field] = functions::webpage2txt($value);
 		$this->fields[$field]['value'] = htmlspecialchars($_POST[$field]);
 
		//return true;
		
		
		if (preg_match("/<[a-z1-6]+((\s[a-z]{2,}=['\"]?(.*)['\"]?)+(\s?\/)?)*>(<\/[a-z1-6]>)?/i", $value)) {
			$this->messages = $this->error_text(15, $field);
			return false;
		}else if (preg_match("/<[a-z1-6]+((\s[a-z]{2,}=['\"]?(.*)['\"]?)+(\s?\/)?)* >(<\/[a-z1-6]>)?/i", $value)) {
			$this->messages = $this->error_text(15, $field);
			return false;
		}
		else if (preg_match("/< [a-z1-6]+((\s[a-z]{2,}=['\"]?(.*)['\"]?)+(\s?\/)?)* >(<\/[a-z1-6]>)?/i", $value)) {
			$this->messages = $this->error_text(15, $field);
			return false;
		} else {
			return true;
		}
	}
	function create_msg() {
		$the_msg =  $this->messages;
 
		return $the_msg;
	}
	function error_text($num, $fieldname = "" , $text_len = "") {
		 
		switch ($this->language) {
			case "de":
			$msg[0]  = "Verbessern Sie bitte folgende Fehler:";
			$msg[1]  = "Das Feld <b>".$fieldname."</b> ist leer.";
			$msg[10] = "Das Datum im Feld <b>".$fieldname."</b> ist ung&uuml;tig.";
			$msg[11] = "Die Email Adresse im Feld <b>".$fieldname."</b> ist ung&uuml;ltig.";
			$msg[12] = "Der Wert im Feld <b>".$fieldname."</b> ist ung&uuml;ltig.";
			$msg[13] = "Der Text im Feld <b>".$fieldname."</b> ist zu lang.";
			$msg[14] = "Die internetadresse im Feld <b>".$fieldname."</b> ist ung&uuml;ltig.";
			$msg[15] = "Das Feld <b>".$fieldname."</b> enth&auml;lt html-Zeichen, die sind nicht erlaubt.";
			break;
			case "nl":
			$msg[0] = "Corrigeer de volgende fouten:";
			$msg[1] = "Het veld <b>".$fieldname."</b> mag niet leeg zijn.";
			$msg[10] = "Het datum in veld <b>".$fieldname."</b> is niet geldig.";
			$msg[11] = "Het e-mail adres in veld <b>".$fieldname."</b> is niet geldig.";
			$msg[12] = "De waarde van veld <b>".$fieldname."</b> is niet geldig.";
			$msg[13] = "De tekst in veld <b>".$fieldname."</b> is te lang.";
			$msg[14] = "De internetadres in het veld <b>".$fieldname."</b> is niet geldig.";
			$msg[15] = "In het veld <b>".$fieldname."</b> is html-code, dit is niet toegestaan.";
			break;
			case "dk":
			$msg[0] = "Ret følgende fejl:";
			$msg[1] = "Feltet <b>".$fieldname."</b> er tomt.";
			$msg[10] = "Datoen i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[11] = "E-mail-adressen i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[12] = "Værdien i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[13] = "Teksten i feltet <b>".$fieldname."</b> er for lang.";
			$msg[14] = "URL'en i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[15] = "Feltet <b>".$fieldname."</b> indeholder HTML-koder, hvilket ikke er tilladt.";
			break;
			case "es":
			$msg[0] = "Por favor corrija los siguientes errores:";
			$msg[1] = "El campo <b>".$fieldname."</b> est&aacute; vac&iacute;o.";
			$msg[10] = "La fecha del campo <b>".$fieldname."</b> no es v&aacute;lida.";
			$msg[11] = "La direcci&oacute;n de correo electr&oacute;nico del campo <b>".$fieldname."</b> no es v&aacute;lida.";
			$msg[12] = "El valor en el campo <b>".$fieldname."</b> no es v&aacute;lido.";
			$msg[13] = "El texto en el campo <b>".$fieldname."</b> es demasiado largo.";
			$msg[14] = "La URL en el campo <b>".$fieldname."</b> no es v&aacute;lida.";
			$msg[15] = "Hay c&oacute;digo HTML en el campo <b>".$fieldname."</b>, esto no est&aacute; permitido.";
            break;
			case "pl":
            $msg[0] = "Wystapily nastepujace bledy w formularzu:";
			$msg[1] = "Pole <b>".$fieldname."</b> jest puste.";
			$msg[10] = "Data w polu <b>".$fieldname."</b> nie jest poprawna.";
			$msg[11] = "Adres e-mail w polu <b>".$fieldname."</b> nie jest poprawny.";
			$msg[12] = "Wartosc w polu <b>".$fieldname."</b> nie jest poprawna.";
			$msg[13] = "Text w polu <b>".$fieldname."</b> jest za dlugi.";
			$msg[14] = "Adres strony w polu <b>".$fieldname."</b> nie jest poprawny.";
			$msg[15] = "W polu <b>".$fieldname."</b> znaleziono kod HTML, nie jest to dozwolone.";
			break;
			case "cz":
			$msg[0] = "Opravte prosím následující chyby:";
			$msg[1] = "Pole <b>".$fieldname."</b> je prázdné";
			$msg[10] = "Datum v poli <b>".$fieldname."</b> není ve správném formátu";
			$msg[11] = "E-mailová adresa v poli <b>".$fieldname."</b> není platná adresa";
			$msg[12] = "Hodnota v poli <b>".$fieldname."</b> není správná";
			$msg[13] = "Text v poli <b>".$fieldname."</b> je p&#345;íliš dlouhý";
			$msg[14] = "Odkaz v poli <b>".$fieldname."</b> není správn&#283; zapsán";
			$msg[15] = "V poli <b>".$fieldname."</b> se vyskytuje nepovolený HTML kód";
			break;
			case "pt":
			$msg[0] = "Por favor corrija o seguinte:";
			$msg[1] = "O campo em <b>".$fieldname."</b> está vazio.";
			$msg[10] = "A data no campo <b>".$fieldname."</b> não é válida.";
			$msg[11] = "O endereço de E-Mail no campo <b>".$fieldname."</b> não é válido.";
			$msg[12] = "O valor no campo <b>".$fieldname."</b> não é válido.";
			$msg[13] = "O texto no campo <b>".$fieldname."</b> é longo demais.";
			$msg[14] = "O url no campo <b>".$fieldname."</b> não é válido.";
			$msg[15] = "Há códigos de HTML no campo <b>".$fieldname."</b>, que não são permitidos.";
			break;
			default:
			$msg[0] = "Please correct the following error(s):";
			$msg[1] = "The field <b>".$fieldname."</b> is empty.";
			$msg[10] = "The date in field <b>".$fieldname."</b> is not valid.";
			$msg[11] = "Invalid <b>".$fieldname."</b> address.";
			$msg[12] = "The value in field <b>".$fieldname."</b> is not valid.";
			$msg[13] = "<b>".$fieldname."</b> must be minimum ".$text_len." character.";
			$msg[14] = "Invalid <b>".$fieldname."</b> address.";
			$msg[15] = "There is html code in field <b>".$fieldname."</b>, this is not allowed.";
			$msg[16] = "<b>".$fieldname."</b> does not match.";
			$msg[17] = "Please select a <b>".$text_len."</b> file to upload.";
			$msg[18] = "Invalid <b>".$fieldname;
		}
		return $msg[$num];
	}
}
?>
