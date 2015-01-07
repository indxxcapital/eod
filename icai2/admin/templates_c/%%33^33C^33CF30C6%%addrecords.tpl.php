<?php /* Smarty version 2.6.14, created on 2013-05-22 11:53:42
         compiled from grid/addrecords.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'updateid', 'grid/addrecords.tpl', 28, false),array('modifier', 'replace', 'grid/addrecords.tpl', 31, false),)), $this); ?>
<div class="container_12"><div class="grid_12">
 
                <div class="module">
                     <h2><span><?php echo $this->_tpl_vars['title']; ?>
</span></h2>
                                
                     <div class="module-body">
                    
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "grid/addform.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div>

</div>

<script language="javascript">

<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['item']['feildOptions']['onChange']): ?>
var <?php echo $this->_tpl_vars['item']['feild_code']; ?>
 = '<?php echo $this->_tpl_vars['postData'][$this->_tpl_vars['item']['feild_code']]; ?>
';


if(<?php echo $this->_tpl_vars['item']['feild_code']; ?>
!="")
<?php echo '
{
'; ?>
	
<?php ob_start();  echo ((is_array($_tmp=$this->_tpl_vars['item']['feildOptions']['onChange'])) ? $this->_run_mod_handler('updateid', true, $_tmp) : smarty_modifier_updateid($_tmp));  $this->_smarty_vars['capture']['ajaxCurrentValue'] = ob_get_contents(); ob_end_clean(); ?>

<?php ob_start();  echo $this->_tpl_vars['item']['feild_code']; ?>
 , '<?php echo $this->_tpl_vars['postData'][$this->_smarty_vars['capture']['ajaxCurrentValue']]; ?>
'<?php $this->_smarty_vars['capture']['ajaxChange'] = ob_get_contents(); ob_end_clean();  echo ((is_array($_tmp=$this->_tpl_vars['item']['feildOptions']['onChange'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'this.value', $this->_smarty_vars['capture']['ajaxChange']) : smarty_modifier_replace($_tmp, 'this.value', $this->_smarty_vars['capture']['ajaxChange'])); ?>

<?php echo '
}
'; ?>

<?php endif;  endforeach; endif; unset($_from); ?>
</script>