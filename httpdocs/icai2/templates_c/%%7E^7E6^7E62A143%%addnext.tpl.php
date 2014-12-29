<?php /* Smarty version 2.6.14, created on 2014-06-18 10:07:01
         compiled from sl/addnext.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'field', 'sl/addnext.tpl', 22, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "notice.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<div class="row-fluid">
                    <div class="span22">
                        <div class="box box-magenta">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Select index for short and leveraged Index </h3>
                                <div class="box-tool">
                                
                                  <!--  <a href="#" data-action="collapse"><i class="icon-chevron-up"></i></a>
                                    <a href="#" data-action="close"><i class="icon-remove"></i></a>-->
                                </div>
                            </div>
                            <form class="form-wizard" method="post"> 
                            <div class="box-content done"  id="p_scents">
                                
                               <?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
             <?php if ($this->_tpl_vars['p']%2 == 0): ?>  <div class="controls step controls-row">
                                    <span class="formnumber"><?php echo $this->_tpl_vars['p']/2+1; ?>
</span>
            <?php endif; ?>                         <?php $this->_tag_stack[] = array('field', array('data' => $this->_tpl_vars['item'],'value' => $this->_tpl_vars['postData'])); $_block_repeat=true;smarty_block_field($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_field($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                                      
                <?php if ($this->_tpl_vars['p']%2 == 1): ?>  </div><?php endif; ?>                    
                 <?php endforeach; endif; unset($_from); ?>    
                            </div>
                            
                            <div class="box-content" >
                            <div class="form-actions">
                            <button class="btn btn-primary" name='submit' value="submit" type="submit"><i class="icon-ok"></i> Save</button>
                                <a href="index.php?module=csi"><button class="btn" type="button">Cancel</button></a>
                                    </div>
                            </div>
                          <!--  <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->
                        <input type="hidden" id="totalfields" name="totalfields" value="<?php echo $this->_tpl_vars['totalfields']; ?>
" />
                        </form>
                        </div>
                    </div>
                </div>