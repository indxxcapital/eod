<?php /* Smarty version 2.6.14, created on 2012-06-12 13:00:36
         compiled from formfields/textarea.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'editor', 'formfields/textarea.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['Form_Params']['editor']): ?>

<?php echo smarty_function_editor(array('id' => $this->_tpl_vars['Form_Params']['name'],'InstanceName' => $this->_tpl_vars['Form_Params']['name'],'width' => '740px','height' => '200px','Value' => $this->_tpl_vars['Form_Params']['value']), $this);?>

<?php else: ?>

<textarea name="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" id="<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php if ($this->_tpl_vars['Form_Params']['maxlength']): ?>maxlength="<?php echo $this->_tpl_vars['Form_Params']['maxlength']; ?>
"<?php endif; ?> class="<?php echo $this->_tpl_vars['Form_Params']['class']; ?>
"><?php echo $this->_tpl_vars['Form_Params']['value']; ?>
</textarea>
<?php endif; ?>
<?php if ($this->_tpl_vars['Form_Params']['feild_note']): ?><br />
<?php echo $this->_tpl_vars['Form_Params']['feild_note'];  endif; ?></span> 
<span id="error_<?php echo $this->_tpl_vars['Form_Params']['name']; ?>
" <?php echo $this->_tpl_vars['Form_Params']['errorClass']; ?>
><?php echo $this->_tpl_vars['Form_Params']['errorMessage']; ?>
</span>