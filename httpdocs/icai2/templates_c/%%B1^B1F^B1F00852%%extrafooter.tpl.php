<?php /* Smarty version 2.6.14, created on 2014-04-23 17:56:54
         compiled from extrafooter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'extrafooter.tpl', 1, false),)), $this); ?>
<?php if (count($this->_tpl_vars['head_js']) > 0):  $_from = $this->_tpl_vars['head_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js']):
?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/<?php echo $this->_tpl_vars['js']; ?>
"></script>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if (count($this->_tpl_vars['head_css']) > 0):  $_from = $this->_tpl_vars['head_css']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css']):
?>
<link href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/<?php echo $this->_tpl_vars['css']; ?>
" rel="stylesheet" type="text/css" />
<?php endforeach; endif; unset($_from); ?> 
<?php endif; ?> 
<?php if (count($this->_tpl_vars['extraHead']) > 0):  $_from = $this->_tpl_vars['extraHead']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['script']):
 echo $this->_tpl_vars['script']; ?>

<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>