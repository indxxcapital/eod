<?php /* Smarty version 2.6.14, created on 2014-06-10 14:56:28
         compiled from replacerunning/add2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'replacerunning/add2.tpl', 12, false),)), $this); ?>
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
                                <h3><i class="icon-reorder"></i>Select Securities To Replace </h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" class="form-horizontal">
                             
                       <?php if (count($this->_tpl_vars['cas']) > 0): ?>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox" /></th>
            <th>Name</th>
            <th>Isin</th>
            <th>Ticker</th>
          <th>Weight</th>
            <th>Currency</th>
            <th>DivCurrency</th>
            
            
           
        </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['cas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
            <td><input type="checkbox" id="checkboxid"  name="checkboxid[]" value="<?php echo $this->_tpl_vars['point']['id']; ?>
" /></td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['isin']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['ticker']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['weight']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['curr']; ?>
</td>
              <td><?php echo $this->_tpl_vars['point']['divcurr']; ?>
</td>
         
          
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      
    </tbody>
</table>
<?php endif; ?>
             
              
                 
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onClick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=replacerunningsecurities';">Back</button>
                                    </div>
                 
                 
                  
                  </form>
                            </div>
                        </div>
                    </div>
                </div>
                
 <!-- END Main Content -->