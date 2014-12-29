<?php /* Smarty version 2.6.14, created on 2014-04-23 17:56:54
         compiled from notice.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'notice.tpl', 1, false),)), $this); ?>
<?php if (count($this->_tpl_vars['Message']) > 0): ?> 	
<div class="alert alert-<?php echo $this->_tpl_vars['Message']['type']; ?>
">
                                                                      <p><?php echo $this->_tpl_vars['Message']['msg']; ?>
</p>
                                </div>

<?php endif; ?>