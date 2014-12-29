<?php /* Smarty version 2.6.14, created on 2014-08-01 12:43:31
         compiled from C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/select2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/select2.tpl', 8, false),)), $this); ?>
<div class="holder">
                           <div class="form-div-1 clearfix" style=" width:550px !important; padding-left:420px !important;">
                                   
                                    <label class="name"><?php echo $this->_tpl_vars['formParams']['feild_label'];  if ($this->_tpl_vars['formParams']['is_required'] == '1'): ?> <sup style="color:#F00;">*</sup><?php endif; ?>:</label></div>
                            <div class="form-div-2 clearfix">
<select class="input-xlarge" style=" width:249px !important" tabindex="1"  name="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" id="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['feildValues']; ?>
>
	
	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['formParams']['options'],'selected' => $this->_tpl_vars['formParams']['value']), $this);?>

	
	
	 

</select><span class="empty-message"><?php echo $this->_tpl_vars['formParams']['errorMessage']; ?>
</span>
                            </div>
                            </div>