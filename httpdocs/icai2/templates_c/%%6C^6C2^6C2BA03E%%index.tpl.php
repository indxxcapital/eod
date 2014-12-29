<?php /* Smarty version 2.6.14, created on 2014-09-11 12:04:29
         compiled from spinstockadd/index.tpl */ ?>
<!-- BEGIN Main Content -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'notice.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
 $("#adminapproval").click(function(){
	 
	 var temp=confirm("Are you sure you want to approve these records ")
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
    url : "index.php?module=myca&event=approveassigned",
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
 $("#notifyadmin").click(function(){
	 
	 var temp=confirm("Are you sure you want to notify admin for these records ")
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
    url : "index.php?module=myca&event=notifyadminassigned",
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
 $("#notifyclient").click(function(){
	 
	 var temp=confirm("Are you sure you want to notify client for these records ")
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
    url : "index.php?module=myca&event=notifyclientassigned",
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

 
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "notice.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>Spin off Stock Addition Request</h3>
                            </div>
                            <div class="box-content">
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                 
                                     <!--   <a class="btn btn-circle show-tooltip" title="Notify Client" id="notifyclient" href="#"><i class="icon-user"></i></a>-->
                                        
                                     <a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
                                     
                                      <!-- <a class="btn btn-circle show-tooltip" title="Add new record" href="index.php?module=casecurities&event=addNew" style="margin-right:25px !important;"><i class="icon-plus"></i></a>
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
          <th style="width:18px"></th>
            <th>Identifier</th>
            
            <th>Company Name</th>
            <th>Effective Date</th>
            <!--<th>Announce Date</th>-->
             <th>Approved</th>
           
              <!-- <th>Notified to client</th>-->
            <th style="width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['ca_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
           <td># </td>
            <td  <?php if ($this->_tpl_vars['point']['valuechange'] == 'yes'): ?> style="color:#F00"<?php endif; ?>><?php echo $this->_tpl_vars['point']['identifier']; ?>
</td>
<!--        -->
            <td  <?php if ($this->_tpl_vars['point']['valuechange'] == 'yes'): ?> style="color:#F00"<?php endif; ?>><?php echo $this->_tpl_vars['point']['company_name']; ?>
</td>
            <td  <?php if ($this->_tpl_vars['point']['valuechange'] == 'yes'): ?> style="color:#F00"<?php endif; ?>><?php echo $this->_tpl_vars['point']['eff_date']; ?>
</td>
            <!--<td><?php echo $this->_tpl_vars['point']['ann_date']; ?>
</td>-->
          
             
              <td><?php if ($this->_tpl_vars['point']['dbApprove'] == '1'): ?><span class="label label-success">Approved</span><?php else: ?><span class="badge badge-important">Not Approved</span><?php endif; ?></td>
           
             <!-- <td><?php if ($this->_tpl_vars['point']['notifiedtoclient'] == 0): ?><span class="label label-important">Pending!</span><?php else: ?><span class="badge badge-success">Notified</span><?php endif; ?></td>-->
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View All Fields" href="index.php?module=spinstockadd&event=view&id=<?php echo $this->_tpl_vars['point']['id']; ?>
"><i class="icon-zoom-in"></i></a>
                    
                    
                </div>
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      
    </tbody>
</table>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->