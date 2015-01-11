<?php 
include('input_files.php');

if(DEBUG == 1)
{
	class INDXXConfig {
		var $base_path='C:/wamp/www/eod/icai2/';
		var $base_url='http://localhost/eod/icai2/';
		var $db_host='localhost';
		var $db_user='admin_icai2';
		var $db_password='Reset1105@@';
		var $db_name='admin_icai2';
		var $site_title='ICAI';
		var $admin_title='ICAI';
		var $default_meta_description='ICAI admin panel';
		var $default_meta_keyword='ICAI description';
		var $admin_email='amitmahajan86@gmail.com';
		var $mail_from='amitmahajan.hec@gmail.com';
		var $from_name='info';
		var $paging='8';
	}
}
else
{
	class INDXXConfig {
	//var $base_path='/home/pdo/public_html/time/';
	var $base_path="C:/Inetpub/vhosts/icalc/icai2/";
	//var $base_url='http://www.processdo.com/time/';
	var $base_url='http://174.36.193.130/icai2/';
	var $db_host='localhost:3306';
	var $db_user='admin_icai2';
	var $db_password='Reset1105@@';
	var $db_name='admin_icai2';
	var $site_title='icai';
	var $admin_title='icai';
	var $default_meta_description='icai Admin Panel';
	var $default_meta_keyword='icai Description';
	var $admin_email='deepakb48@gmail.com';
	var $mail_from='info@indxx.com';
	var $from_name='info';
	var $paging='8';
	}
}
?>