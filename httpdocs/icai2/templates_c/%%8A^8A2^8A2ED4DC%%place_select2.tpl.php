<?php /* Smarty version 2.6.14, created on 2014-05-02 16:03:30
         compiled from C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/place_select2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/place_select2.tpl', 3, false),)), $this); ?>
<select class="span5"   tabindex="1"  name="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" id="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['feildValues']; ?>
>
	
	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['formParams']['options'],'selected' => $this->_tpl_vars['formParams']['value']), $this);?>

	
	
	 

</select>