<?php /* Smarty version 2.6.14, created on 2015-01-05 02:43:30
         compiled from viewca/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'viewca/view.tpl', 136, false),)), $this); ?>
<!-- BEGIN Main Content -->
 <?php echo '
 <script type=\'text/javascript\'>
 
   function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href=\'index.php?module=viewfields&event=delete&id=\'+id;
	}
	else{
	return false;
	}
 }
 
 



$(document).ready(function(){
 $("#deleteSelected").click(function(){
	 
	 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	 
	 
	 
 var checkedArray=Array();
 var i=0;
  $(\'input[name="checkboxid"]:checked\').each(function() {
i++;
checkedArray[i]=$(this).val();
});
var parameters = {
  "array1":checkedArray
};


$.ajax({
    url : "index.php?module=viewfields&event=deleteindex",
    type: "POST",
    data : parameters,
    success: function(data, textStatus, jqXHR)
    {
        //data - response from server
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
 
    }
});

}
	else{
	return false;
	}


});
	 
	 
	
	 
 
}); 
 
</script>
 
 '; ?>

               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                              <!--  <h3><i class="icon-table"></i>Fields</h3>-->
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Identifier</th>
                                            <th>Type</th>
                                            <th>Company Name</th>
                                           
                                            <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?><th style="width:150px">Action</th><?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['viewdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="<?php echo $this->_tpl_vars['point']['id']; ?>
" /></td>
            <td><?php echo $this->_tpl_vars['point']['identifier']; ?>
</td>
            <!--<td><a data-original-title="<?php echo $this->_tpl_vars['point']['mnemonic']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
</a></td>-->
            <td><?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['mnemonic']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['company_name']; ?>
</td>
            
            <!--<td><?php echo $this->_tpl_vars['point']['eff_date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['ann_date']; ?>
</td>-->
            <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="View" href="index.php?module=viewfields&event=view"><i class="icon-zoom-in"></i></a>-->
                    
                     
                    
                    <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=viewfields&event=edit&id=<?php echo $this->_tpl_vars['point']['fieldid']; ?>
"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip " title="Delete" href="#" id="a1" onclick="confirmdelete(<?php echo $this->_tpl_vars['point']['id']; ?>
)"><i class="icon-trash"></i></a>
                    
                    
                  
                </div>
            </td>
              <?php endif; ?>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                   <?php if (count($this->_tpl_vars['liveindxx']) > 0): ?>         
                               <h3>Live Index</h3>
                               
                          <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['liveindxx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr> <td>&nbsp;<?php echo $this->_tpl_vars['k']+1; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
       
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                       
                                    </tbody>
                                </table>
                                
                                <?php endif; ?>
                                <?php if (count($this->_tpl_vars['tempindxx']) > 0): ?>
                                   <h3>Upcomming Index</h3>
                               
                          <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['tempindxx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr> <td>&nbsp;<?php echo $this->_tpl_vars['k']+1; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
       
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                       
                                    </tbody>
                                </table>
                                <?php endif; ?>
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                    <a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
                                        <!--<a class="btn btn-circle show-tooltip" title="Add new record" href="index.php?module=casecurities&event=addNew" style="margin-right:25px !important;"><i class="icon-plus"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Edit selected" href="#"><i class="icon-edit"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Delete selected" href="#"><i class="icon-trash"></i></a>-->
                                    </div>
                                    <!--<div class="btn-group">
                                        <a class="btn btn-circle show-tooltip" title="Print" href="#"><i class="icon-print"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Export to PDF" href="#"><i class="icon-file-text-alt"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Export to Exel" href="#"><i class="icon-table"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn btn-circle show-tooltip" title="Refresh" href="#"><i class="icon-repeat"></i></a>
                                    </div>-->
                                </div>
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
             <th style="width:18px"><!--<input type="checkbox" />-->  &nbsp;</th>
          
             <th>Field Name</th>
             <th>Field Name Meaning</th>
              <th>Field Value</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
            <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?><th style="width:100px">Action</th><?php endif; ?>
        </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['viewdata2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><!--<input type="checkbox" id="checkboxid"  name="checkboxid" value="<?php echo $this->_tpl_vars['point']['id']; ?>
" />--> &nbsp;</td>
          
<!--            <td><a data-original-title="<?php echo $this->_tpl_vars['point']['field_name']; ?>
" data-content="<?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['field_name']]; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['field_name']; ?>
</a></td>-->
            <td><?php echo $this->_tpl_vars['point']['field_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['sessData']['variable'][$this->_tpl_vars['point']['field_name']]; ?>
</td>
            <?php if ($this->_tpl_vars['point']['syn']): ?><td><a data-original-title="<?php echo $this->_tpl_vars['point']['field_name']; ?>
" data-content="<?php echo $this->_tpl_vars['point']['syn']; ?>
" data-placement="top" data-trigger="hover" class="show-popover" href="#"><?php echo $this->_tpl_vars['point']['field_value']; ?>
</a></td><?php else: ?><td><?php echo $this->_tpl_vars['point']['field_value']; ?>
</td><?php endif; ?>
            <!--<td><?php echo $this->_tpl_vars['point']['eff_date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['ann_date']; ?>
</td>-->
            <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="View" href="index.php?module=viewfields&event=view"><i class="icon-zoom-in"></i></a>-->
                    
                     
                    
                    <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=viewfields&event=edit&id=<?php echo $this->_tpl_vars['point']['fieldid']; ?>
"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip " title="Delete" href="#" id="a1" onclick="confirmdelete(<?php echo $this->_tpl_vars['point']['id']; ?>
)"><i class="icon-trash"></i></a>
                    
                    
                  
                </div>
            </td>
              <?php endif; ?>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        
        
    </tbody>
</table>
<form method="post">

<input type="hidden" name="caid" value="<?php echo $this->_tpl_vars['viewdata']['0']['id']; ?>
" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['viewdata']['0']['action_id']; ?>
" />
<input type="hidden" name="status" value="<?php echo $this->_tpl_vars['viewdata']['0']['status']; ?>
" />
<input type="hidden" name="spcash" value="<?php echo $this->_tpl_vars['scflag']; ?>
" />
 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"  value="1"><i class="icon-ok"></i><?php if ($this->_tpl_vars['viewdata']['0']['status'] == 1): ?>Inactivate for All<?php else: ?> Activate for All<?php endif; ?></button>
                                      <?php if ($this->_tpl_vars['scflag'] && $this->_tpl_vars['sessData']['User']['type'] == '1'): ?> <button type="submit" class="btn btn-primary" name="scflagbtn" value="1" id="submit"><i class="icon-ok"></i> Convert To Special Cash</button> <?php endif; ?>
                                     <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1'): ?>   <button type="submit" class="btn btn-primary" name="iactive" value="1" id="submit"><i class="icon-ok"></i> Make Inactive for Index Wise</button>
                                      <?php endif; ?>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onClick="document.location.href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
index.php?module=upcomingca';">Back</button>
                                    </div>
                 </form>

                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->