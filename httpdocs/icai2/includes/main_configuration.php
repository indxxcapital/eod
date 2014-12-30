<?php
define("DEBUG", 1);

if(DEBUG == 1)
{
	class INDXXConfig {
		var $base_path='C:/wamp/www/eod/httpdocs/icai2/';
		var $base_url='http://localhost/eod/httpdocs/icai2/';
		var $db_host='localhost:3306';
		var $db_user='admin_icai2';
		var $db_password='Reset1105@@';
		var $db_name='admin_icai2';
		var $site_title='icai';
		var $admin_title='icai';
		var $default_meta_description='icai Admin Panel';
		var $default_meta_keyword='icai Description';
		var $admin_email='amitmahajan86@gmail.com';
		var $mail_from='amitmahajan.hec@gmail.com';
		var $from_name='info';
		var $paging='8';
	}
}
else
{
	class INDXXConfig {
		var $base_path='C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/';
		var $base_url='http://97.74.65.118/icai2/';
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