<?php /* Smarty version 2.6.14, created on 2014-05-06 11:19:06
         compiled from C:/Inetpub/vhosts/indxx.secureserver.net/httpdocs/icai2/templates//formfields/file.tpl */ ?>
 <div class="control-group"><span id="feildHtml_<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
"> <label class="control-label"><?php echo $this->_tpl_vars['formParams']['feild_label'];  if ($this->_tpl_vars['formParams']['is_required'] == '1'): ?> <sup style="color:#F00;">*</sup><?php endif; ?>:</label><div class="controls"><input type="file" name="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" id="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
"   class="<?php echo $this->_tpl_vars['formParams']['class']; ?>
" /></div></span> <?php if ($this->_tpl_vars['formParams']['feild_note']): ?>
<span class="validation-note" style="margin-left:180px !important;"><?php echo $this->_tpl_vars['formParams']['feild_note']; ?>
</span><?php endif; ?>
<?php if ($this->_tpl_vars['formParams']['value']): ?><br /> 

<?php if ($this->_tpl_vars['formParams']['feild_option']['type'] == 'image'): ?><BR /><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
media/<?php echo $this->_tpl_vars['formParams']['feild_option']['folder']; ?>
/orignal/<?php echo $this->_tpl_vars['formParams']['value']; ?>
"  width="50%" height="50%"/>
<?php else: ?>
<a href="index.php?module=ajax&event=downloadFile&folder=<?php echo $this->_tpl_vars['formParams']['itemData']['feild_option']['folder']; ?>
&file=<?php echo $this->_tpl_vars['formParams']['value']; ?>
&type=<?php echo $this->_tpl_vars['formParams']['itemData']['feild_option']['type']; ?>
" target="_blank"><?php echo $this->_tpl_vars['formParams']['value']; ?>
</a>
<?php endif; ?>
<input type="checkbox" name="delete_file[]" value="<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" /> delete file<br />
<?php endif; ?>
<span id="error_<?php echo $this->_tpl_vars['formParams']['feild_code']; ?>
" <?php echo $this->_tpl_vars['formParams']['errorClass']; ?>
><?php echo $this->_tpl_vars['formParams']['errorMessage']; ?>
</span></div>