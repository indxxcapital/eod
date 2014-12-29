<?php
/******************************************
Module name : Config file
Parent module : None
Date created : 13th May 2010
Date last modified : 13th May 2010
Created by : Gaurav Sehdev
Last modified by : -
Comments : System config file . Here we set all configuration options and all constant variable
******************************************/
//Set display error true. 
@ob_start();
ini_set('display_errors', "on");
//Report all error except notice
//ini_set('error_reporting', E_ALL ^ E_NOTICE);
//ini_set('error_reporting', 1);
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

include("includes/main_configuration.php");
$siteconfig = new INDXXConfig;

define("BASE_PATH", $siteconfig->base_path);
define("BASE_URL", $siteconfig->base_url);

define("COMMONINCLUDES", $siteconfig->base_path."core/");
define("CLASSES", $siteconfig->base_path."classes/");
define("BLOCKS", $siteconfig->base_path."blocks/");
define("INCLUDES", $siteconfig->base_path."includes");


include_once($siteconfig->base_path.'libs/smarty/Smarty.class.php');



set_include_path(CLASSES. PATH_SEPARATOR . COMMONINCLUDES. PATH_SEPARATOR . BLOCKS. PATH_SEPARATOR . INCLUDES);
$_GET['module']= "cron";

$objStart = new Application();	
$objStart->startApp();
function __autoload($class_name) {
		 
		//$classname= str_replace("_","/",strtolower($class_name));
		$classname= strtolower($class_name);
		$filename =  $classname. '.class.php';
	  	include ($filename);
	
	}
?>