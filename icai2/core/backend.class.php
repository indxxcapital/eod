<?php


class Backend extends Functions{ 	
	var $debugging= false;
	var $viewFields=array();
	var $gridItemDiabled=array("add"=>true,"edit"=>true,"view"=>true,"update"=>true,"delete"=>true,"status"=>true);
	var $gridButtons=array();
	
	function __construct($postArr,$siteconfig)
		{	 

			$dbData['host']=$siteconfig->db_host;
			$dbData['user']=$siteconfig->db_user;
			$dbData['password']=$siteconfig->db_password;
			$dbData['name']=$siteconfig->db_name;
			
			$module=str_replace("_"," ",$_GET['module']);
			$module_name = ucwords($module);
		 	$this->moduleClassName = str_replace(" ","",$module_name);
			$this->moduleClassFile = strtolower($this->moduleClassName);
			if($_SESSION['lang']=="")
			{
				$_SESSION['lang']="en";
			}
			if($_GET)
			{
				$_GET= $this->addslashes_deep($_GET);
			}
			if($_POST)
			{
				 
				$_POST= $this->addslashes_deep($_POST);
				 
			}
			
	
			if("http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']!=$siteconfig->base_url."admin/index.php")
				{
					if($_SERVER['QUERY_STRING']=="")
					{
						header("location:".$siteconfig->base_url."admin");
					}
					else
					{
						header("location:".$siteconfig->base_url."admin/index.php?".$_SERVER['QUERY_STRING']);
					}
					exit;
				}
			
			if($this->moduleClassName == "" || !file_exists('classes/'.$this->moduleClassFile.'.class.php'))
			{
				$this->moduleClassName ="Home";
			}
			
			$this->objStart = new $this->moduleClassName($postArr);
			$this->objStart->smarty = new Smarty;
			$this->objStart->smarty->compile_check = true;
			$this->objStart->smarty->debugging = $this->debugging;
			$this->objStart->smarty->assign('SITE_URL', $siteconfig->base_url);
			
			$this->objStart->smarty->assign("fileAccess",$_SESSION['Admin']['access']);
			$siteconfig->site_url = $siteconfig->base_url;
			$siteconfig->site_url_front = $siteconfig->base_url;
			$siteconfig->base_url = $siteconfig->base_url.'admin/';
			$this->objStart->baseUrl = $siteconfig->base_url;
			$this->objStart->smarty->template_dir = $siteconfig->base_path . 'admin/templates';
			$this->objStart->smarty->compile_dir = $siteconfig->base_path . 'admin/templates_c';
			$this->objStart->smarty->cache_dir = $siteconfig->base_path . 'admin/cache';
			$this->objStart->smarty->siteconfig = $siteconfig;
			$this->objStart->siteconfig=$siteconfig;
			 
			$this->objStart->db = new Db($dbData,$this->objStart);
			$this->objStart->smarty->assign("admin_title",$siteconfig->admin_title);
			
  
			if(isset($_SESSION['AdminMessage']))
			{
				$this->objStart->smarty->assign('AdminMessage', $_SESSION['AdminMessage']);
				unset($_SESSION['AdminMessage']);
			}
			 
			if($_SESSION['Admin']['uid']!="")
			{
			$this->objStart->smarty->assign("Admin",$_SESSION['Admin']);
			}
			
			$this->event=$postArr['event'];
			
			if($this->event=="")
			{
			
				$this->objStart->index($this);
			}
			else
			{ 
			
		 		// call_user_method($this->event,$this->objStart);
				  call_user_func(array($this->objStart, $this->event));

			
			}
			
			 		
			
		 
		} 
		
		
		protected function checkAdminSession()
		{	 

			if($_SESSION['Admin']['uid']=="" || !is_array($_SESSION['Admin'])) 
			{
				session_destroy();
				$this->adminRedirect('','error','Please Login');	

			}
			$mapClass= array("uploadjobs"=>"jobs");
			

			$trackback = debug_backtrace();

			$currentClass= strtolower($trackback[1]['class']);
            $currentClass;
			$checkCurrentClass= $currentClass;
			if($mapClass[$checkCurrentClass]!="")
			{
				$checkCurrentClass =$mapClass[$checkCurrentClass];	
			}
			
			
			 $currentAccess = $_SESSION['Admin']['access'][$checkCurrentClass];
		

			if(($currentAccess=='0')&&( $_SESSION['Admin']['uid']!='1'))
			{		
				$this->adminRedirect('index.php?module=welcome','error','You do not have access');	
			}
			else if($currentAccess==1)
			{
					
				$this->gridItemDiabled=array("add"=>false,"edit"=>false,"view"=>true,"update"=>false,"delete"=>false,"status"=>false);
				
				$event = strtolower($_GET['event']);
				
				$readModules = array("","index","view");
				if(!in_array($event,$readModules))
				{

					$this->adminRedirect('index.php?module=welcome','error','You do not have access');	
				}
				
			}
			 
		}
		
		protected function makeUrladmin($url)
		{
			  $url = str_replace($this->siteconfig->base_url,"",$url);
		 	
 			if($this->siteconfig->rewrite==1)
			{
				if(preg_match("/index.php/",$url,$match))
				{
					$tempUrl = str_replace("index.php?","",$url);
					$tempUrl = str_replace("&amp;","&",$tempUrl);
					$tempUrl = explode("&",$tempUrl);
					
					$queryString="";
					$extraString="";
					foreach($tempUrl as $uri)
					{
					 
						$uriTemp = explode("=",$uri);
						$key= strtolower($uriTemp[0]);
						$queryString[$key]=$uriTemp[1];
						if($key!="module" && $key!="event")
						{
							$extraString.="/".$uriTemp[1];
						}
		  			}
					$url = $queryString['module']."/".$queryString['event'].$extraString; 
				}
				
			} 	
		 	  	$url = $this->siteconfig->base_url.$url;
			 
			return $url;
		
		}
		
		
		protected function setMessage($msg="",$type="")
		{
			if($msg=="")
			{
				return false;
			}
			
			if($type=="")
			{
				$type = "success";
			}
			
			$_SESSION['AdminMessage']['type']=$type;
			$_SESSION['AdminMessage']['msg']=$msg;
			
			return true;
		}
		
		protected function adminRedirect($url,$type="",$msg="")
		{
			unset($_SESSION['AdminMessage']);
			
			if($type=="")
			{
				$type = "success";
			}
			
			if($url=="")
			{
				$url='index.php';
			
			}
			
			if($type!="" && $msg!="")
			{
				$_SESSION['AdminMessage']['type']= $type;
				$_SESSION['AdminMessage']['msg'] = $msg;
			}
			 
			header("location:".$url);	
			exit;
		
		}
		
		
		function viewFeilds($feild_label,$feild_code)
		{
		$viewFields['feild_label']=$feild_label;
		$viewFields['feild_code']=$feild_code;		
		 
		$this->viewFields[] =  $viewFields;
		
	}
	
		protected function intialzeTabs()
		{
			 $this->tabsKeys = array_keys($this->tab);
			 
			 
			 foreach($this->tabsKeys as $key)
			 {
			
				for($i=0;$i<count($this->tab[$key]['validData']);$i++)
				{
					$this->tab[$key]['validData'][$i]['tabKey']=$key;
				
				}

			 	$this->validData = array_merge($this->validData ,$this->tab[$key]['validData']);
				
			 
			 }
		
		}
		
		
		protected function makeAddFormTabs()
		{
			
			 $this->trackback = debug_backtrace();
			 $this->_bodyTemplate="tabgrid/addrecords";
			 $this->smarty->assign("currentClass",strtolower($this->trackback[1]['class']));
			 $this->smarty->assign("currentFunction",$this->trackback[1]['function']);			
			 $this->getValidFeilds();

 			//	$this->pr($this->tab);
			 $this->smarty->assign("tabKeys",$this->tabsKeys);
			 $this->smarty->assign("fields",$this->tab);
			 $this->smarty->assign("fieldsCount",round(count($this->validData)/2));
			 $this->show();
		}
	
		protected function makeEditTabForm()
		{
			 $this->getValidFeilds();
			 $this->trackback = debug_backtrace();
			 $this->_bodyTemplate="tabgrid/editrecords";
			 $this->smarty->assign("currentClass",strtolower($this->trackback[1]['class']));
			 $this->smarty->assign("currentFunction",$this->trackback[1]['function']);
			 $this->smarty->assign("tabKeys",$this->tabsKeys);
			 $this->smarty->assign("fields",$this->tab);
			 $this->smarty->assign("fieldsCount",round(count($this->validData)/2));
			 $this->show();
			
		}	
		
		
		
		protected function makeAddForm()
		{
			 $this->getValidFeilds();
			 $this->trackback = debug_backtrace();
			 $this->_bodyTemplate="grid/addrecords";
			 $this->smarty->assign("currentClass",strtolower($this->trackback[1]['class']));
			 $this->smarty->assign("currentFunction",$this->trackback[1]['function']);
			 $this->smarty->assign("fields",$this->validData);
			 
			 $this->smarty->assign("fieldsCount",round(count($this->validData)/2));
			 $this->show();
		}
		
		protected function saveRecord()
		{
			 
		
			
			
			foreach($this->validData as $feilds)
			{	
				if(!strstr($feilds['validate'],"match|")){
					
					if($feilds['feild_type']=="date")
					{
						$keys[]="`".$feilds['feild_code']."`";
						 
						$values[]="'".$_POST[$feilds['feild_code']]."'";	
					}
					else
					{
						$keys[]="`".$feilds['feild_code']."`";
						$values[]="'".$_POST[$feilds['feild_code']]."'";
					}
				}
			}
		
			 //echo "INSERT INTO ".$this->_table." (" .implode(",",$keys)." ) VALUES (".implode(",",$values).")";
			//exit;
			if($this->db->insert("INSERT INTO ".$this->_table." (" .implode(",",$keys)." ) VALUES (".implode(",",$values).")"))
			{ 
		
				$this->setMessage("Record added successfully");
				return true;
			}
			else
			{
				$this->setMessage("Record could not be saved","error");
				return false;
				
			}
			
	 
		}
		
			protected function backVariables()
		{
			if($_GET['pagegroup']=="")
			 {
					$_GET['pagegroup']= 1;
			 }
			 if($_GET['sortby']=="")
			 {
					$_GET['sortby']= "";
			 }
			 if($_GET['sortDirection']=="")
			 {
					$_GET['sortDirection']= "";
			 }
			 if($_GET['sortDirection']=="")
			 {
					$_GET['sortDirection']= "";
			 }
			 
			 
			 $hiddenVarsSystem = array("module","event");
			 foreach($_GET as $key=>$val)
			 {
				 if(!in_array($key,$hiddenVarsSystem))
				 {
					if(is_array($val))
					{
						 foreach($val as $keysub=>$valsub)
			 			 {
							 $parmes.="&".$key."[".$keysub."]=".$valsub;
						 }
					}
					else
					{
						$parmes.="&".$key."=".$val;
					}
				 }
				 
			 }
			// print_r($_GET);
			 //print_r($parmes);
			 //exit;
			 
			 $this->smarty->assign("backVars",$parmes);	
			 $this->smarty->assign("hiddenVarsSystem",$hiddenVarsSystem);
			 
			 $hiddenVarsSystem = array("module","event","sortby","sortDirection","submit_frm","limit","change_selection","page","pagegroup","counter_start","with_selected");
			 
			 foreach($_GET as $key=>$val)
			 {
				 if(!in_array($key,$hiddenVarsSystem) && !preg_match('/check_/',$key))
				 {
					if(!is_array($val))
					{
						 $extraVars[$key]  = $val;
					}
					 
				 }
				 
			 }
			 //$this->pr($extraVars,true);
			 $this->smarty->assign("panelHiddenVar",$extraVars);	
			 
			 
			 
		}
		
		protected function makeEditForm()
		{
			 $this->getValidFeilds();
			 $this->trackback = debug_backtrace();
			 $this->_bodyTemplate="grid/editrecords";
			 $this->smarty->assign("currentClass",strtolower($this->trackback[1]['class']));
			 $this->smarty->assign("currentFunction",$this->trackback[1]['function']);
			  $this->backVariables();

			  
			 $this->smarty->assign("fields",$this->validData);
			 $this->smarty->assign("fieldsCount",round(count($this->validData)/2));
			 $this->show();
		}
		
		
		protected function updateRecord()
		{	//	 echo "<pre>", print_r($_POST);   exit;
		
		if(!is_array($_POST['delete_file']))
		{
			$_POST['delete_file'] = array();	
		}
		
			foreach($this->validData as $feilds)
			{	
			
				if(!strstr($feilds['validate'],"match|")){
						 
					if($feilds['is_required']!="2" || ($feilds['is_required']=="2" && $_POST[$feilds['feild_code']]!="") || in_array($feilds['feild_code'],$_POST['delete_file']) )
					{
					 	
						
						if($feilds['feild_type']=="date")
						{
							 
							$keys[]="`".$feilds['feild_code']."` = '".$_POST[$feilds['feild_code']]."' ";
						}
						else
						{
							$keys[]="`".$feilds['feild_code']."` = '".$_POST[$feilds['feild_code']]."' ";
						}
						
						
						
					}
					
				}
			}
			
			 
		
	   			//echo  "update ".$this->_table." SET " .implode(",",$keys)." where ".$this->_keyId." = '".$_POST['id']."'";
			//exit;
			 $this->db->query("update ".$this->_table." SET " .implode(",",$keys)." where ".$this->_keyId." = '".$_POST['id']."'");
			
			$_SESSION['AdminMessage']['type']="success";
			$_SESSION['AdminMessage']['msg']="Record updated successfully";				
				
		}
		
		
		protected function makeGrid()
		{
			 $this->addCss("tablesorter.css");
			 
			 $this->trackback = debug_backtrace();
			 
			 $this->smarty->assign("currentClass",strtolower($this->trackback[1]['class']));
			 $this->smarty->assign("currentFunction",$this->trackback[1]['function']);
			 $this->smarty->assign("searchVars",$_GET['searchFeilds']);
			  $this->smarty->assign("hiddenVarsSystem",array("DisplayRecords","searchFeilds","counter_start","with_selected","sortby","sortDirection","submit_frm","limit","change_selection","module","event","event","pagegroup","page"));
			 $this->smarty->assign("parentClass",$this->_parentClass);
			   $this->backVariables();
			if($this->_table!="")
			{ 
			
			foreach( $_GET as $key=>$value)
				{
				
					if(is_array($_GET[$key]))
					{
					
						foreach( $_GET[$key] as $key1=>$value1)
						{
						$str = $str."&".$key."[".$key1."]=".$value1;
						
						}
						
					
					
					}
					else
					{	 
						if($key =="module"){}
						else if($key =="change_selection"){}
						else if($key =="with_selected"){}						
						else if ($key=="page"){
						
							if($value>1)	 
							{
								$str = $str."&".$key."=".($value-1);
							}
							else
							{
								$str = $str."&".$key."=".$value;
							}
							
							 
							
						}				
						else
						$str = $str."&".$key."=".$value;
					}
				}

				
				if($this->_statusField=="")
				{
					$this->_statusField="status";
				}
				if($this->_keyId=="")
				{
					$this->_keyId="id";
				}
				
					$change_selection=$_REQUEST['change_selection'];	
			
				if($change_selection==1) {
				$selection=$_REQUEST['with_selected'];
				//echo "<pre>" , print_r($_REQUEST);
				switch($selection)	{
					case 0: $query="UPDATE ".$this->_table." SET ".$this->_statusField." = '0' WHERE ".$this->_keyId." =";  
							$display_msg="Record updated successfully.";	
							
							break;
							
					case 1: $query="UPDATE ".$this->_table." SET ".$this->_statusField." = '1' WHERE ".$this->_keyId." ="; 
							$display_msg="Record updated successfully.";	
							
							break;
							
					case 4: 
					
						$query="DELETE FROM ".$this->_table." WHERE ".$this->_keyId." =";  
						$display_msg="Record deleted successfully.";
					
							break;
				}
				// echo $query; exit;
				 $counter_start=0;
				 $counter_end=$_REQUEST['limit'];
					
				for($i=$counter_start;$i<=$counter_end;$i++) {
				 $checkbox=$_REQUEST['check_'.$i];
				 
				   //Code to activate the user and send themail	
				  
				 if($this->_table=="tbl_user"  && $selection==1)
					{
						
					if($checkbox!=""){
						$userid = $checkbox;
						$userdata=$this->db->getResult("select name,email,password from tbl_user where id='".$userid."'");						
						if(is_array($userdata)&& count($userdata)>0){
							################# SEND Activation EMAIL ##########						
							$fromname = $this->siteconfig->from_name;
							$fromemail = $this->siteconfig->mail_from;							
							$data['NAME'] 	 = $userdata['name'];
							$data['PASSWORD'] =$userdata['password'];
							$data['EMAIL']  = $userdata['email'];
							$data['SITENAME']  = $this->siteconfig->site_title;								 
							 $this->SendMailId('4', $data, $userdata['email'], $fromname,$fromemail);		
							
							######################################################	
						}
					}
				}
				 				 if($checkbox!='') {
					if(($this->_table=="tbl_admin"  && $selection==0)&&( $checkbox==1 || $checkbox==$_SESSION['Admin']['uid']))
					{
				 		$msgType="error";
							$display_msg="Selected Admin user can not be inactive ";
					}
					elseif($this->_table=="tbl_admin_group" && ($checkbox==2 || $checkbox==3 || $checkbox==4 || $checkbox==5 ) && $selection==4)
					{
				 		$msgType="error";
							$display_msg="This Admin group can not be deleted  ";
					}
					elseif(($this->_table=="tbl_admin" &&  $selection==4)&&( $checkbox==1 || $checkbox==$_SESSION['Admin']['uid']))
					{
				 		$msgType="error";
							$display_msg="Selected Admin user can not be deleted ";
					}else{
						$this->db->query($query."'$checkbox'");
						}
				  }
				}
				 
				$this->adminRedirect("index.php?module=".strtolower($this->trackback[1]['class']).$str,$msgType,$display_msg);
				exit;
			
				}
				
			}
			
			$this->_bodyTemplate="grid/panel";
			
			$this->smarty->assign("tabHeading",$this->tabHeading);
			 
			$this->smarty->assign("gridItemDiabled",$this->gridItemDiabled);
			if($this->sql)
			{
				
				if($_REQUEST['DisplayRecords']!="")
				{
				$_SESSION['DisplayRecords']=$_REQUEST['DisplayRecords'];
				}
				if($_SESSION['DisplayRecords']=="")
				{
				$this->limit=10;
				$_SESSION['DisplayRecords']=$DisplayRecords;
				}
				else
				{
				$this->limit=$_SESSION['DisplayRecords'];
				}
				
				
				
				if($this->in_array_r($_GET['sortby'],$this->tabHeading))
				{
					
					$this->sortby =  $_GET['sortby'];
					
					if($_GET['sortDirection']=="up" || $_GET['sortDirection']=="down")
					{
						
						if($_GET['sortDirection']=="up")
						{
							$this->sortDirection =  "asc";
						}
						else
						{
							$this->sortDirection =  "desc";
						}
						
					}
					else
					{
						$_GET['sortDirection']="up";
						$this->sortDirection =  "asc";
					}
					
					
				}
				else if($this->sortby=="")
				{
					$this->sortby = $this->_keyId;
					$this->sortDirection = "desc";
				}
				 
				
				if($this->sortby!="" && $this->sortDirection!="")
				{
				
					$this->orderby= " order by ".$this->sortby." ".$this->sortDirection;
				}
				$this->db->getResult($this->sql);
				$Master_Num_Rows=$this->db->mysqlrows;
				
				if(isset($_REQUEST['page']) && $_REQUEST['page']!='1')
				{
					$page=$_REQUEST[page];
					$start=$this->limit*($page-1)+1;
				}
				else
				{
					$page=1;
					$k=1*($page-1)+1;
					$start="1";
				}
				
				$data= $this->db->getResult($this->sql.$this->orderby,true,$this->limit);
				
				$this->smarty->assign("rightPaging",$this->db->rightpaging());
			//	echo "<pre>"; print_r($data);
			
			
				
			
			 
			if($page>1 && $this->db->mysqlrows==0)
			{
				

			header("location:index.php?module=".strtolower($this->trackback[1]['class']).$str);
			exit;
			}

			
				
							$start_record=$start;
							$end_record=$this->limit*$page;
							if($end_record>$Master_Num_Rows)$end_record=$Master_Num_Rows;
							 
							$end_record-$start_record>=1?$record="records":$record="record";
							$Master_Num_Rows>1?$record2="records":$record2="record";
							 
				$this->smarty->assign("gridDisplayRecords","Displaying $start_record-$end_record $record out of [$Master_Num_Rows] $record2");
				
				
				
			
			
			}
			$this->smarty->assign("gridData",$data);
			$this->smarty->assign("sortby",$this->sortby);
			$this->smarty->assign("sortDirection",$_GET['sortDirection']);
			$this->smarty->assign("DisplayRecords",$this->limit);
			$this->smarty->assign("page",$_GET['page']);
			$this->smarty->assign("pagegroup",$_GET['pagegroup']);
			$this->smarty->assign("gridHeading",$this->_title);
			$this->smarty->assign("displayPaging",$this->db->rightpaging());
			$this->smarty->assign("gridButtons",$this->addButtonGrid);
			
		}
		
 	

			public function show() 
			{
		
		 	
		
		
			$this->smarty->assign('title', $this->_title);
			$this->smarty->assign('meta_description', $this->_meta_description);
			$this->smarty->assign('meta_keywords', $this->_meta_keywords);
			
			$this->smarty->assign('head_js', $this->_js);
			$this->smarty->assign('head_css', $this->_css);
			$this->smarty->assign('extraHead', $this->_extraHead);
			 
			$this->smarty->assign('BASE_URL', $this->siteconfig->base_url);
			$this->smarty->assign('BASE_PATH', $this->siteconfig->base_path);
			$this->smarty->assign('SITE_TITLE', $this->siteconfig->site_title);
			 
			if($this->_bodyTemplate && is_readable($this->smarty->template_dir."/".$this->_bodyTemplate.".tpl")) 
					$this->smarty->assign('body', $this->smarty->fetch($this->_bodyTemplate.".tpl"));
			else 
					$this->smarty->assign('body', '');
			
			
			if(!is_readable($this->smarty->template_dir."/".$this->_baseTemplate.".tpl"))
			{
				$this->_baseTemplate= 'main-template';
			}
			
				
				 
			$this->smarty->display($this->_baseTemplate.".tpl");
		
	}	
	
	
	function deleteAdmin(){
		$this->sql= "select count(*) as Total_admin from tbl_admin where  tbl_admin.system ='1'";
		$data= $this->db->getResult($this->sql);
		if($data['Total_admin'] ==1)
		{
			return false;
			}
		else
		{
			return true;
		}

}
		protected function returnbackVariables()
		{
			if($_GET['pagegroup']=="")
			 {
					$_GET['pagegroup']= 1;
			 }
			 if($_GET['sortby']=="")
			 {
					$_GET['sortby']= "";
			 }
			 if($_GET['sortDirection']=="")
			 {
					$_GET['sortDirection']= "";
			 }
			 if($_GET['sortDirection']=="")
			 {
					$_GET['sortDirection']= "";
			 }
			 
			 if($_GET['DisplayRecords']=="")
			 {
					$_GET['DisplayRecords']= 50;
			 }
			 $hiddenVarsSystem = array("module","event","id");
			 foreach($_GET as $key=>$val)
			 {
				 if(!in_array($key,$hiddenVarsSystem))
				 {
					if(is_array($val))
					{
						 foreach($val as $keysub=>$valsub)
			 			 {
							 $parmes.="&".$key."[".$keysub."]=".$valsub;
						 }
					}
					else
					{
						$parmes.="&".$key."=".$val;
					}
				 }
				 
			 }
			 return $parmes;	
		}
	
}