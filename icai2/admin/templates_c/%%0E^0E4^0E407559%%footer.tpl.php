<?php /* Smarty version 2.6.14, created on 2012-08-13 12:16:01
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'footer.tpl', 5, false),)), $this); ?>
<div id="footer">
  <div class="container_12">
    <div class="grid_12">
       
      <p>&copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
. <?php echo $this->_tpl_vars['SITE_TITLE']; ?>
</p>
    </div>
  </div>
  <div class="clear"></div>
</div>
