<?php /* Smarty version 2.6.14, created on 2013-05-22 11:54:28
         compiled from formfields/multiselect.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'formfields/multiselect.tpl', 4, false),)), $this); ?>

<select class="<?php echo $this->_tpl_vars['Form_Params']['class']; ?>
" multiple="multiple"  name="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
[]" id="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php if ($this->_tpl_vars['Form_Params']['onChange']): ?>onchange="<?php echo $this->_tpl_vars['Form_Params']['onChange']; ?>
"<?php endif; ?>>
	
	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['Form_Params']['options'],'selected' => $this->_tpl_vars['Form_Params']['value']), $this);?>

	
	
	 

</select>
<span id="error_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['errorClass']; ?>
><?php echo $this->_tpl_vars['Form_Params']['errorMessage']; ?>
</span>