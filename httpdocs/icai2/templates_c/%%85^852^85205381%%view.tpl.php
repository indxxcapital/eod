<?php /* Smarty version 2.6.14, created on 2014-06-18 10:07:20
         compiled from sl/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'sl/view.tpl', 66, false),)), $this); ?>
<!-- BEGIN Main Content -->
       
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>Index Details </h3>
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['indxxdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td></td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
            
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                            
                                
                                <div class="clearfix"></div>
                                 <div class="box">
                                 <div class="box-title">
                                <h3><i class="icon-table"></i>Total <?php echo $this->_tpl_vars['indxxfactordatacount']; ?>
 Index Calculation factor found</h3>
                            </div>
                              </div>  
                                
                                <div class="clearfix"></div>
<table class="table table-advance">
    <thead>
        <tr>
           <th>#</th>
             <th>Name</th>
              <th>Code</th>
              <th>Adj. Factor</th>       
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         </tr>
    </thead>
    <tbody>
    
    <?php if (count($this->_tpl_vars['indxxfactordata']) > 0): ?>
    	<?php $_from = $this->_tpl_vars['indxxfactordata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
          <td><?php echo $this->_tpl_vars['k']+1; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['fraction']; ?>
</td>
 
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <?php else: ?>
        <tr>
        <td colspan="4" align="center">There is No Securities in this indxx.</td>
        </tr>
        <?php endif; ?>
    
    </tbody>
</table>

 <table class="table table-advance">   <tr><td>
 
 
 <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>

 <?php if ($this->_tpl_vars['indxxdata']['0']['status'] != 1): ?>
  <a href="index.php?module=sl&event=approve&id=<?php echo $this->_tpl_vars['indxxdata']['0']['id']; ?>
"><button class="btn btn-primary">Approve</button></a>
                                   
 <?php endif; ?>
 
 
   <a href="index.php?module=sl&event=delete&id=<?php echo $this->_tpl_vars['indxxdata']['0']['id']; ?>
"><button class="btn btn-inverse">Delete</button></a>
 
                                    <a href="index.php?module=sl"><button class="btn btn-inverse">Back</button></a>
                                   
                                    
                                    </td></tr>
                                    <?php endif; ?>
                                    
                                    
                                 <?php if ($this->_tpl_vars['sessData']['User']['type'] == 2): ?>
 

                                    
                                    <a href="index.php?module=sl"><button class="btn btn-inverse">Back</button></a>
                                 
                                    </td></tr>
                                    <?php endif; ?>
                                    
                                    
                                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == 3): ?>

                                   
                                    <a href="index.php?module=sl"><button class="btn btn-inverse">Back</button></a>
                                   
                                    </td></tr>
                                    <?php endif; ?>
                                    
                                    </table>

                            
                            
                           
                             
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->