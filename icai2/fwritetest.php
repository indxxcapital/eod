<?php
$myfile = fopen("templates_c/%%AB^AB1^AB11093F%%login-template.tpl.php", "r") or die("Unable to open file!");
echo fread($myfile,filesize("templates_c/%%AB^AB1^AB11093F%%login-template.tpl.php"));
fclose($myfile);
?>