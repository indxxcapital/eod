<?php
@ob_start();
ini_set('display_errors', "on");
//Report all error except notice
ini_set('error_reporting', 2);
ini_set('allow_call_time_pass_reference',true);
// Do not allow php_sess_id to be passed in the querystring and it's use for google search
ini_set('session.use_only_cookies', 1);
//Set the memory limit 
ini_set("memory_limit", "256M");
setlocale(LC_ALL,'en_IN');
putenv("TZ=Asia/Calcutta");
//Start new sesstion
session_start();
ob_start ("ob_gzhandler");
include("../includes/main_configuration.php");
$siteconfig = new INDXXConfig;
define("COMMONINCLUDES", $siteconfig->base_path."core/");
define("CLASSES", $siteconfig->base_path."admin/classes/");
define("BASE_URL", $siteconfig->base_url);
$siteconfig->helper = $siteconfig->base_path."helper/";
include_once($siteconfig->base_path.'libs/smarty/Smarty.class.php');
set_include_path(CLASSES. PATH_SEPARATOR . COMMONINCLUDES);
$app = new Backend($_REQUEST,$siteconfig);	
function __autoload($class_name) {
		 
		$classname= str_replace("_","/",strtolower($class_name));
		$filename =  $classname. '.class.php';
	  	include ($filename);
	}
?>