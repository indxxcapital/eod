<?php /* Smarty version 2.6.14, created on 2012-08-13 12:16:01
         compiled from main-template.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'main-template.tpl', 26, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['admin_title']; ?>
 <?php if ($this->_tpl_vars['title'] != ""): ?>- <?php echo $this->_tpl_vars['title'];  endif; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/grid.css" media="screen" />
<!-- IE Fixes for the Fluid 960 Grid System -->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/ie6.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/ie.css" media="screen" /><![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/styles.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/theme-blue.css" media="screen" />
<script language="javascript" src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/js/jquery-1.3.2.min.js"></script>
<script language="javascript" src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/js/ajax.js"></script>



<?php if ($this->_tpl_vars['meta_description'] != ""): ?>
<meta name="description" content="<?php echo $this->_tpl_vars['meta_description']; ?>
" />
<?php endif;  if ($this->_tpl_vars['meta_keywords'] != ""): ?>
<meta name="keywords" content="<?php echo $this->_tpl_vars['meta_keywords']; ?>
" />
<?php endif; ?>

<?php if (count($this->_tpl_vars['head_css']) > 0):  $_from = $this->_tpl_vars['head_css']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css']):
?>
	<link href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/css/<?php echo $this->_tpl_vars['css']; ?>
" rel="stylesheet" type="text/css" />
<?php endforeach; endif; unset($_from);  endif; ?>

<?php if (count($this->_tpl_vars['head_js']) > 0):  $_from = $this->_tpl_vars['head_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js']):
?>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/js/<?php echo $this->_tpl_vars['js']; ?>
"></script>
<?php endforeach; endif; unset($_from);  endif; ?>


<?php if (count($this->_tpl_vars['extraHead']) > 0):  $_from = $this->_tpl_vars['extraHead']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['script']):
 echo $this->_tpl_vars['script']; ?>

<?php endforeach; endif; unset($_from);  endif; ?>
<script language="javascript">
var BASEURL = '<?php echo $this->_tpl_vars['BASE_URL']; ?>
';
</script>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="container_12"> 
	
	<?php if (count($this->_tpl_vars['AdminMessage']) > 0): ?><div> <span class="notification n-<?php echo $this->_tpl_vars['AdminMessage']['type']; ?>
"><?php echo $this->_tpl_vars['AdminMessage']['msg']; ?>
</span></div><?php endif; ?>
  
  <?php echo $this->_tpl_vars['body']; ?>

  <div class="clear"></div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>