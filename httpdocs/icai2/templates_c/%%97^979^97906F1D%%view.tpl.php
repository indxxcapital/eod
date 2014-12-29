<?php /* Smarty version 2.6.14, created on 2014-08-11 15:45:52
         compiled from issuetrack/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'issuetrack/view.tpl', 124, false),array('block', 'field', 'issuetrack/view.tpl', 161, false),)), $this); ?>
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
                                   
                                    <tbody>
                                    
                                   <tr>
                                   <td>
                                  <strong> Title</strong><br />
                                   <?php echo $this->_tpl_vars['userdata1']['title']; ?>

                                   </td>
                                   </tr>  
                                   <tr>
                                   <td>
                                  <strong> Submitted By</strong><br />
                                   <?php echo $this->_tpl_vars['userdata1']['username']; ?>
 at <?php echo $this->_tpl_vars['userdata1']['dateAdded']; ?>

                                   </td>
                                   </tr>  
                                     <tr>
                                   <td>
                                  <strong> Description</strong><br />
                                   <?php echo $this->_tpl_vars['userdata1']['content']; ?>

                                   </td>
                                   </tr>  
                                   <?php if ($this->_tpl_vars['userdata1']['file']): ?>
                                     <tr>
                                   <td>
                                  <strong> Attachment :</strong><br />
                                      <a  target="_blank" href="media/attachmentfile/<?php echo $this->_tpl_vars['userdata1']['file']; ?>
"><?php echo $this->_tpl_vars['userdata1']['file']; ?>
</a>
                                   </td>
                                   </tr> 
                                   <?php endif; ?>
                                   
                                   
                                   
                                   
                                   <?php if (count($this->_tpl_vars['usercomments']) > 0): ?>
                                     <tr>
                                   <td>
                                  <strong> Comments :</strong><br />
                                         <?php $_from = $this->_tpl_vars['usercomments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
                                         (<?php echo $this->_tpl_vars['item']['dateAdded']; ?>
)-<?php echo $this->_tpl_vars['item']['username']; ?>
-<?php echo $this->_tpl_vars['item']['comment']; ?>
 
                                         <?php endforeach; endif; unset($_from); ?>
                                     
                                     
                                     </td>
                                   </tr> 
                                   <?php endif; ?>
                                   
                                    </tbody>
                                </table>
                            
             
                                
                                



                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Add Your Comments</h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" class="form-horizontal">
                             
                              
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
index.php?module=issuetrack';" >Back</button>
                                       
                                    </div>
                 
                 
                  
                  </form>
                            </div>
                        </div>
                    </div>
                </div>

                
                
                  <!-- END Main Content -->