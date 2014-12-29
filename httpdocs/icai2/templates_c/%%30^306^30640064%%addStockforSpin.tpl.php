<?php /* Smarty version 2.6.14, created on 2014-09-19 14:50:02
         compiled from myca/addStockforSpin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'field', 'myca/addStockforSpin.tpl', 17, false),array('modifier', 'count', 'myca/addStockforSpin.tpl', 50, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "notice.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Edit Corporate Action Value</h3>
                                                </div>
                            <div class="box-content">
                                 <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal form-wizard" enctype="multipart/form-data">
                                 
                                  <div class="box-content done"  style="width:100%"  id="p_scents">
                                
                               <?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
             <?php if ($this->_tpl_vars['p']%7 == 0): ?>  <div class="step controls-row"   >
                                    <span class="formnumber" style="width:10px;" ><?php echo $this->_tpl_vars['p']/7+1; ?>
</span>
            <?php endif; ?>                         <?php $this->_tag_stack[] = array('field', array('data' => $this->_tpl_vars['item'],'value' => $this->_tpl_vars['postData'])); $_block_repeat=true;smarty_block_field($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_field($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                                      
                <?php if ($this->_tpl_vars['p']%7 == 6): ?>  </div><?php endif; ?>                    
                 <?php endforeach; endif; unset($_from); ?>    
                            </div>
                                     <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Identifier</th>
                                            <th>Type</th>
                                            <th>Company Name</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['viewdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td></td>
            <td><?php echo $this->_tpl_vars['point']['identifier']; ?>
</td>
<!--            <td><a data-original-title="<?php echo $this->_tpl_vars['point']['mnemonic']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['mnemonic']; ?>
</a></td>-->
            <td><?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['company_name']; ?>
</td>
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                      
                                    </tbody>
                                </table>
                            <?php if (count($this->_tpl_vars['indxxd']) > 0): ?>
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th width="20%">Live Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['indxxd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><input type="checkbox" id="checkboxid"  name="checkboxid[]" value="<?php echo $this->_tpl_vars['point']['indxx_id']; ?>
_<?php echo $_GET['id']; ?>
" /> </td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                 <?php endif; ?>
                                   <?php if (count($this->_tpl_vars['indxxu']) > 0): ?>
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th  width="20%">Upcoming Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['indxxu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><input type="checkbox" id="checkboxtempid"  name="checkboxtempid[]" value="<?php echo $this->_tpl_vars['point']['indxx_id']; ?>
_<?php echo $_GET['id']; ?>
" /> </td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
           
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                 <?php endif; ?>
                              
                                   
                                    <div class="form-actions">
                                     <button class="btn btn-primary"  id="addScnt" type="submit"><i class="icon-plus"></i> Add More</button>
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onclick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=myca&event=view&id=<?php echo $_GET['id']; ?>
';">Back</button>
                                    </div>
                                    
                                    
                               
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo '
<script type="text/javascript">

$(function() {
        var scntDiv = $(\'#p_scents\');
        var i = $(\'#p_scents div\').size() + 1;
        $(\'#addScnt\').click( function() {
             $(\'<div class="step  controls-row" > <span class="formnumber" style="width:10px;">\'+i+\'</span><input type="text" placeholder="Security Name" class="span3" name="name[\'+i+\']"><input type="text" name="isin[\'+i+\']" placeholder="Security ISIN" class="span2"><input  name="ticker[\'+i+\']" type="text" placeholder="Security Ticker" class="span2"><input type="hidden" placeholder="Share"  name="share[\'+i+\']" class="span2"><input name="curr[\'+i+\']" type="text" placeholder="Ticker Currency" class="span2"><input name="divcurr[\'+i+\']" type="text" placeholder="Dividend Currency" class="span2">\').appendTo(scntDiv);
                $(\'#totalfields\').val(i);
				i++;
                return false;
        });

});
</script>
'; ?>
   