<?php /* Smarty version 2.6.14, created on 2012-07-18 07:08:16
         compiled from formfields/file.tpl */ ?>
<span id="feildHtml_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
"><input type="file" name="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" id="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
"   class="<?php echo $this->_tpl_vars['Form_Params']['class']; ?>
" /><?php if ($this->_tpl_vars['Form_Params']['feild_note']): ?><br />
<?php echo $this->_tpl_vars['Form_Params']['feild_note'];  endif; ?></span> 
<?php if ($this->_tpl_vars['Form_Params']['value']): ?><br /> 

<?php if ($this->_tpl_vars['Form_Params']['feild_option']['type'] == 'image'): ?><BR /><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
media/<?php echo $this->_tpl_vars['Form_Params']['feild_option']['folder']; ?>
/orignal/<?php echo $this->_tpl_vars['Form_Params']['value']; ?>
"  width="50px" height="50px"/>
<?php else: ?>
<a href="index.php?module=ajax&event=downloadFile&folder=<?php echo $this->_tpl_vars['Form_Params']['feild_option']['folder']; ?>
&file=<?php echo $this->_tpl_vars['Form_Params']['value']; ?>
&type=<?php echo $this->_tpl_vars['Form_Params']['feild_option']['type']; ?>
" target="_blank"><?php echo $this->_tpl_vars['Form_Params']['value']; ?>
</a>
<?php endif; ?>

<?php endif; ?>
<span id="error_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['errorClass']; ?>
><?php echo $this->_tpl_vars['Form_Params']['errorMessage']; ?>
</span>