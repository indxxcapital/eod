<?php /* Smarty version 2.6.14, created on 2014-07-01 12:30:01
         compiled from C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/textarea.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'editor', 'C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/textarea.tpl', 3, false),)), $this); ?>
 <div class="control-group"><label class="control-label"><?php echo $this->_tpl_vars['formParams']['feild_label'];  if ($this->_tpl_vars['formParams']['is_required'] == '1'): ?> <sup style="color:#F00;">*</sup><?php endif; ?>:</label><div class="controls"><?php if ($this->_tpl_vars['Form_Params']['editor']): ?>

<?php echo smarty_function_editor(array('id' => $this->_tpl_vars['formParams']['feild_code'],'Instancefeild_code' => $this->_tpl_vars['formParams']['feild_code'],'width' => '740px','height' => '200px','Value' => $this->_tpl_vars['formParams']['value']), $this);?>

<?php else: ?>

<textarea name="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" id="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" style="height: 175px;width: 700px;" class="<?php echo $this->_tpl_vars['formParams']['class']; ?>
"><?php echo $this->_tpl_vars['formParams']['value']; ?>
</textarea>
<?php endif; ?></div>
<?php if ($this->_tpl_vars['formParams']['feild_note']): ?><br />
<?php echo $this->_tpl_vars['formParams']['feild_note'];  endif; ?></span> 
<span id="error_<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" <?php echo $this->_tpl_vars['formParams']['errorClass']; ?>
><?php echo $this->_tpl_vars['formParams']['errorMessage']; ?>
</span>