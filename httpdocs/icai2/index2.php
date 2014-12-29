<?php
//Set display error true. 
//header('Location: http://localhost/2013/ICAI/time/admin/index.php');
@ob_start();
header('Content-Type: text/html; charset=iso-8859-1');
ini_set('display_errors', "on");
//Report all error except notice//E_ALL ^ E_NOTICE
ini_set('error_reporting',2 );
ini_set('allow_call_time_pass_reference',true);
// Do not allow php_sess_id to be passed in the querystring and it's use for google search
ini_set('session.use_only_cookies', 1);
//Set the memory limit 
ini_set("memory_limit", "256M");
setlocale(LC_ALL,'en_IN');
putenv("TZ=Asia/Calcutta");
//date_default_timezone_set("Asia/Kolkata"); 
//echo date("Y-m-d H:i:s");
//exit;
//Start new sesstion
session_start();

ob_start ("ob_gzhandler");

include("includes/main_configuration.php");
$siteconfig = new INDXXConfig;

define("BASE_PATH", $siteconfig->base_path);
define("BASE_URL", $siteconfig->base_url);

define("COMMONINCLUDES", $siteconfig->base_path."core/");
define("CLASSES", $siteconfig->base_path."classes/");
define("BLOCKS", $siteconfig->base_path."blocks/");
define("INCLUDES", $siteconfig->base_path."includes");

//echo "<pre>";print_r($_SERVER);


include_once($siteconfig->base_path.'libs/smarty/Smarty.class.php');
set_include_path(CLASSES. PATH_SEPARATOR . COMMONINCLUDES. PATH_SEPARATOR . BLOCKS. PATH_SEPARATOR . INCLUDES);

$objStart = new Application();	
$objStart->startApp();
function __autoload($class_name) {
		 
		//$classname= str_replace("_","/",strtolower($class_name));
		$classname= strtolower($class_name);
		$filename =  $classname. '.class.php';
	  	include ($filename);
	
	}
	

?>