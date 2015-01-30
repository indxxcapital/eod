<?php 

require_once("main_configuration.php");

class Application extends Functions{ 
 	

	var $debugging = false;
	var $moduleClass = "";
	var $moduleClassFile = "";
	var $_baseTemplate = "main-template";
	var $_js = array();
	var $_css = array();
	var $_extraHead = array();
	var $validData=array();
	var $viewFields=array();
	var $_database="";
	var $db = ""; 
	var $gridItemDiabled=array("add"=>true,"edit"=>true,"view"=>true,"update"=>true,"delete"=>true,"status"=>true);
	var $siteconfig;
	var $gridButtons=array();
	
	
	
	var $URI=array("0"=>"module",
							 "1"=>"event",
							 "2"=>"id",
							 "3"=>"item",
							 );


		function __construct()
		{	
			/* TODO: We need to enable error handler for classes, log file path need to be enabled in constructor for this */
			//error_reporting(E_ALL);
			//set_error_handler("error_handler", E_ALL);
			//ini_set("display_errors", 1);
				
			$this->siteconfig = new INDXXConfig;
			
			$dbData['host']=$this->siteconfig->db_host;
			$dbData['user']=$this->siteconfig->db_user;
			$dbData['password']=$this->siteconfig->db_password;
			$dbData['name']=$this->siteconfig->db_name;
			
			
			//$this->_date=date("Y-m-d",strtotime(date("Y-m-d")));
			
			$this->tempFolder = '';
			
			$this->db = new Db($dbData,$this->objStart);
			$this->smarty = new Smarty;
			$this->smarty->compile_check = true;
			$this->smarty->debugging = $this->debugging;
		 	$this->smarty->template_dir = $this->siteconfig->base_path . 'templates'.'/'.$this->tempFolder;
			  
			$this->smarty->compile_dir = $this->siteconfig->base_path . 'templates_c'.'/'.$this->tempFolder;
			$this->smarty->cache_dir = $this->siteconfig->base_path . 'cache';
			$this->smarty->siteconfig = $this->siteconfig;
			$this->smarty->tempFolder = $this->tempFolder."";
			$this->smarty->assign("siteconfig",$this->siteconfig);
		   
		} 
		
		
		public function startApp()
		{
			
			if($_GET)
			{
				$_GET= $this->addslashes_deep($_GET);
			}
			if($_POST)
			{
				$_POST= $this->addslashes_deep($_POST);	 
			}

			
 		 	 
			
			$module=str_replace("_"," ",$_GET['module']);
			$module_name = ucwords($module);
		 	$this->moduleClassName = str_replace(" ","",$module_name);
			$this->moduleClassFile = strtolower($this->moduleClassName);
			
			$this->writeLog();
			
			//$_SESSION['currencyPrice']=$this->getCurrencyPrice($this->_date);
			
			 ////////////////////Start Rediret if host url is not equal to base url //////////////////////
			/*if("http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']!=$this->siteconfig->base_url."index.php")
			{
				if($_SERVER['QUERY_STRING']=="")
				{
					header("location:".$this->siteconfig->base_url);
				}
				else
				{
					header("location:".$this->siteconfig->base_url."index.php?".$_SERVER['QUERY_STRING']);
				}
				exit;
			}*/
			////////////////////End Rediret if host url is not equal to base url //////////////////////

			
			////////////////////Start Initiate Home Page if no controller  //////////////////////
			if($this->moduleClassName == "")
			{	
			
				 $this->moduleClassName ="Login";
				 $this->moduleClassFile ="login";
				 
				
			}
			////////////////////End Initiate Home Page if no controller  //////////////////////		
			
			//VERY IMPORTANT DO NOT REMOVE / ALTER
		//	$this->cleanUrl($siteconfig); // Making Url according to the framework 
			
		//	echo $this->moduleClassFile;
	//exit;
		 	////////////////////Start 404 Error page redirect if requested page not found //////////////////////
			if(!file_exists('classes/'.$this->moduleClassFile.'.class.php'))
			{
			/// die(__FILE__);
				$this->Redirect("index.php?module=error");
			}
			////////////////////End 404 Error page redirect if requested page not found //////////////////////
			
			
			
			////////////////////Start Calling Conroller //////////////////////
			/*if($_GET['lang']!="")
			{
			$_SESSION['lang'] = $_GET['lang'];	
			$lang=$_SESSION['lang'];
			 $langchangeurl=$this->siteconfig->base_url.'index.php?'.$_SERVER['QUERY_STRING'];
			 $langchangeurl=str_replace("&lang=$lang",'',$langchangeurl);
			$this->Redirect($langchangeurl);
			
			
			
			}
			if($_SESSION['lang']==""||($_SESSION['lang']!='es' && $_SESSION['lang']!='en' && $_SESSION['lang']!='de' && $_SESSION['lang']!='fr'))
			{
				$_SESSION['lang']='en';
			}*/
			$_SESSION['variable']=$this->setSessionvariable();
			if(empty($_SESSION['variable']))
			{
				$_SESSION['variable']=$this->setSessionvariable();
			}
			
			
			//echo $_SESSION['lang'];
			$app = new $this->moduleClassName($postArr);
			//$app->smarty->lang = $app->lang = $app->setLang($_SESSION['lang']);
			  $app->setdate();
			$this->event=$_GET['event'];
			
			
		 
			if($this->event=="")
			{
			
				$app->index($this);
			}
			else
			{ 
				
				if(!is_callable(array($app, $this->event)))
				{
					
					$this->Redirect($this->siteconfig->base_url."index.php?module=".$this->moduleClassFile);
					
				}
				
		 		 call_user_method($this->event,$app);
				 			
			}
		
		}	
	 
		
		public function show() {
		
		if($this->_breadcrumbshow){			
			$this->breadCrumbs();		
		}
	 	$this->createUserSession();
		
		
		
		if($_GET)
		{
			$_GET= $this->stripslashes_deep($_GET);
		}
		if($_POST)
		{
			$_POST= $this->stripslashes_deep($_POST);	 
		}
		
		if(isset($_SESSION['Message']))
		{
				
			$this->smarty->assign('Message', $_SESSION['Message']);
			$this->addCss('dynamic.css');
			
			$Message= $this->smarty->get_template_vars('Message');
		 
			 unset($_SESSION['Message']);
		}
     
	    $langchangeurl=$this->siteconfig->base_url.'index.php?'.$_SERVER['QUERY_STRING'];
		$this->smarty->assign('langchangeurl', $langchangeurl);
		$this->smarty->assign('seletecdlang', $_SESSION['lang']);
	 	$this->smarty->assign("rightPaging",$this->db->rightpaging());
		$this->smarty->assign('breadcrumbs', $this->_breadcrumbs);
		$this->smarty->assign('title', $this->_title);
		$this->smarty->assign('meta_description', $this->_meta_description);
		$this->smarty->assign('meta_keywords', $this->_meta_keywords);
		
		$this->smarty->assign('head_js', $this->_js);
		$this->smarty->assign('head_css', $this->_css);
		$this->smarty->assign('extraHead', $this->_extraHead);
		 
		$this->smarty->assign('BASE_URL', $this->siteconfig->base_url);
		$this->smarty->assign('ADMIN_BASE_URL', $this->siteconfig->base_url.'admin/');
		$this->smarty->assign('BASE_PATH', $this->siteconfig->base_path);
		$this->smarty->assign('ASSESTS_FOLDER', $this->tempFolder."/");
			$this->smarty->assign('sessData', $_SESSION);
	
		
		
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
	
	
		protected function setMessage($msg="",$type="")
		{
			unset($_SESSION['Message']);
			
			if($msg=="")
			{
				return false;
			}
			
			if($type=="")
			{
				$type = "success";
			}
			
			$_SESSION['Message']['type']=$type;
			$_SESSION['Message']['msg']=$msg;
			return true;
		}
		
		
		public function Redirect($url,$msg="",$type="")
		{

			if($url=="")
			{
				$url='index.php';
			
			}
			 $this->setMessage($msg,$type);
		 
			header("location:".$this->makeUrl($url));	
			exit;
		
		}	
		public function Redirect2($url,$msg="",$type="")
		{

			if($url=="")
			{
				$url='index.php';
			
			}
	
$link="<script type='text/javascript'>
window.open('".$url."');  
</script>";
echo $link;
			
			// $this->setMessage($msg,$type);
		 
		//	header("location:".$this->makeUrl($url));	
			exit;
		
		}
		
		protected function makeUrl($url)
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
		
		private function cleanUrl($siteconfig)
		{
		
		
 			if($this->siteconfig->rewrite==1)
			{
			 
				if(preg_match("/index.php/",$_SERVER['REQUEST_URI'],$match))
				{
				
					if(count($_GET)>1)
							{
								 
								foreach($_GET as $key => $value)
								{
									$key = strtolower($key);
									if($key!="module")
									{
										$extra.="/".$value;
									}
								
								}	
							}
 
					header("location:".$this->siteconfig->base_url.$_GET['module'].$extra);
				}
				else
				{		 
						$url=$this->trim_array(explode("/",$_SERVER['QUERY_STRING']));
			 
						if(count($url)>0)
						{
							
							$this->moduleClassName = $url[0];
							
							$this->moduleClassFile = strtolower($this->moduleClassName);
						}
						if(count($url)>1)
						{
						
							//$_GET['event'] = $url[1];
							foreach($this->URI as $key => $value){
							
							$_GET[$value] = $url[$key];
							
							}
						}
				}
			 
			}
			else
			{
		 				
				if(!preg_match("/index.php/",$_SERVER['REQUEST_URI'],$match))
				{		
					$url=explode("/",$_SERVER['QUERY_STRING']); 
					
					if(count($url)>0)
					{
						 
							
							foreach($url as $key => $value)
							{
								  $key = $this->URI[$key];
								 
								 if($key!="module")
								 {
								  	$event.= "&".$key."=".$value;
								 }
								 
							}		
					
					}
					if($url[0])
					{
						header("location:".$this->siteconfig->base_url."index.php?module=".$url[0].$event);
					}
				}
				
				 
			
			}
			
			 		
		}
}