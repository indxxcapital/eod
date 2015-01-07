<?php /* Smarty version 2.6.14, created on 2013-05-22 11:39:01
         compiled from formfields/select.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'formfields/select.tpl', 4, false),)), $this); ?>
<span id="feild_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
">
<select class="<?php echo $this->_tpl_vars['Form_Params']['class']; ?>
"  name="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" id="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['feildValues']; ?>
>
	
	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['Form_Params']['options'],'selected' => $this->_tpl_vars['Form_Params']['value']), $this);?>

	
	
	 

</select>
</span>
<span id="extra_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" style="display:none"></span>
<span id="error_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['errorClass']; ?>
><?php echo $this->_tpl_vars['Form_Params']['errorMessage']; ?>
</span>