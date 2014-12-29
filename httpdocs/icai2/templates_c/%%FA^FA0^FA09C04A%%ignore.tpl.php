<?php /* Smarty version 2.6.14, created on 2014-10-16 12:45:43
         compiled from myca/ignore.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'myca/ignore.tpl', 174, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'notice.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><!-- BEGIN Main Content -->
 <?php echo '
 <script type=\'text/javascript\'>
 
 
 function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href=\'index.php?module=users&event=deleteassigned&id=\'+id;
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
    url : "index.php?module=users&event=deleteassignedindex",
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



$(document).ready(function(){
 $("#submit").click(function(){
	 
		
	 
 var checkedArray=Array();
 var checkedArray2=Array();
 var i=0;
  $(\'input[name="checkboxid"]:checked\').each(function() {
i++;
checkedArray[i]=$(this).val();
});

 var j=0;
$(\'input[name="checkboxtempid"]:checked\').each(function() {
j++;
checkedArray2[j]=$(this).val();
});

var parameters = {
  "array1":checkedArray,  "array2":checkedArray2
};


$.ajax({
    url : "index.php?module=myca&event=ignoreindex",
    type: "POST",
    data : parameters,
    success: function(data, textStatus, jqXHR)
    {
        //data - response from server
		alert("done");
		document.location.href=\'index.php?module=myca\';
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
 alert("error");
    }
});




});
	 
	 
	
	 
 
}); 


  
  
 
</script>
 
 '; ?>

               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
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
                             <?php if (count($this->_tpl_vars['indxxd']) > 0): ?> <div class="box">
                            <div class="box-title">
                               Live Index </div>
                            </div>
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['indxxd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="<?php echo $this->_tpl_vars['point']['indxx_id']; ?>
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
                                
                          <?php if (count($this->_tpl_vars['indxxt']) > 0): ?>        <div class="box">
                            <div class="box-title">
                               Upcoming Index </div>
                            </div>
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['indxxt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td><input type="checkbox" id="checkboxid"  name="checkboxtempid" value="<?php echo $this->_tpl_vars['point']['indxx_id']; ?>
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
                                
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                  
                                      
                                    </div>
                                
                                </div>
                                <div class="clearfix"></div>

                 <table class="table table-advance">   <tr><td>
                 
                 <a href="#"><button class="btn btn-info" id="submit">Submit</button></a>
                 
                     <a href="index.php?module=myca"><button class="btn btn-inverse">Back</button></a>
                     
                 
                 
                 
                 </td></tr>
                    </table>

                 </form>
                             </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->