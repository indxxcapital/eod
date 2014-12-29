<?php /* Smarty version 2.6.14, created on 2014-07-01 11:44:26
         compiled from users/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'field', 'users/add.tpl', 15, false),)), $this); ?>
 <!-- BEGIN Main Content -->
  
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "notice.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Add New User</h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal">
                             
                              
    <?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
               <p>   <?php $this->_tag_stack[] = array('field', array('data' => $this->_tpl_vars['item'],'value' => $this->_tpl_vars['postData'])); $_block_repeat=true;smarty_block_field($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_field($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                </p>  <?php endforeach; endif; unset($_from); ?>
 <p>
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel" onClick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=users';" >Back</button>
                                       
                                    </div>
                 
                 
                  
                  </form>
                                 <!--<form action="#" class="form-horizontal">
                                    <div class="control-group">
                                       <label class="control-label">Index Name</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Index Code</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Investment Amount</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Divisor</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                        
                                       </div>
                                    </div>
                                    
                                    
                                    <div class="control-group">
                                       <label class="control-label">Type</label>
                                       <div class="controls">
                                          <select class="input-xlarge" tabindex="1">
                                             <option value="Category 1">Category 1</option>
                                             <option value="Category 2">Category 2</option>
                                             <option value="Category 3">Category 5</option>
                                             <option value="Category 4">Category 4</option>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    
                                    <div class="control-group">
                                       <label class="control-label">Currency</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          <span class="help-inline">Some hint here</span>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>-->
                            </div>
                        </div>
                    </div>
                </div>
                
 <!-- END Main Content -->