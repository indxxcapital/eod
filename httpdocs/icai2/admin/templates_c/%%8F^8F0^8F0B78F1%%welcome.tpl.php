<?php /* Smarty version 2.6.14, created on 2012-08-13 12:16:11
         compiled from welcome.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'makeUrl', 'welcome.tpl', 8, false),)), $this); ?>
<div style="min-height:400px; text-align:center;">
<h2>Welcome to Admin Panel</h2>
<div class="container_12">
<div class="grid_7">
 
 <?php if ($this->_tpl_vars['transportPetComment'] > '0'): ?>
 
 <a href="<?php echo smarty_function_makeUrl(array('link' => "index.php?module=pettranscomment"), $this);?>
" class="dashboard-module"> <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/images/1322477591_Hourglass.png" width="64" height="64" alt="edit" /> <span><?php echo $this->_tpl_vars['transportPetComment']; ?>
 New comment<?php if ($this->_tpl_vars['transportPetComment'] > '1'): ?>(s)<?php endif; ?> on <br /><b>Pet Transport</b>.</span></a>
<?php endif; ?> 
 
<?php if ($this->_tpl_vars['urgentPetComment'] > '0'): ?>
<a href="<?php echo smarty_function_makeUrl(array('link' => "index.php?module=urgentpetscomment"), $this);?>
" class="dashboard-module"> <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/images/1322477591_Hourglass.png" width="64" height="64" alt="edit" /> <span><?php echo $this->_tpl_vars['urgentPetComment']; ?>
 New Comment
<?php if ($this->_tpl_vars['urgentPetComment'] > '1'): ?>(s)<?php endif; ?> on <br /><b>Urgent Pet</b>.</span> </a> 
<?php endif; ?>

    
</div>
</div>
</div>