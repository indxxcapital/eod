<?php /* Smarty version 2.6.14, created on 2014-08-01 12:27:31
         compiled from caindex2/index.tpl */ ?>
<!-- BEGIN Main Content -->
 
 <?php echo '
<style>
.table-advance tbody>tr:nth-child(odd)>td, .table-advance tbody>tr:nth-child(odd)>th {
background: #293b50 url(\'assets/New/img/pattern.png\') repeat !important;
}
.table-advance tbody>tr:nth-child(even)>td, .table-advance tbody>tr:nth-child(even)>th {
background: #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
}
.table-advance thead {
background: #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
border-left: 4px solid #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
}
.table{
	border-collapse:inherit !important;	
}

.table.fill-head thead{
background: #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
border-left: 4px solid #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;	
}
.table-striped > tbody > tr:nth-child(odd) > td, .table-striped > tbody > tr:nth-child(odd) > th {
background: #293b50 url(\'assets/New/img/pattern.png\') repeat !important;	
color:#888 !important;
}
</style>
'; ?>

 
 <?php echo '
 <script type=\'text/javascript\'>
 
 
 function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href=\'index.php?module=caindex2&event=delete&id=\'+id;
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
    url : "index.php?module=caindex2&event=deleteindex",
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

 <br><br><br><br><br>  
 <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="thumb-pad2">
                <div class="thumbnail"> 
                <div class="caption">
                      
                    </div>
                   
                   
                   
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="thumb-pad2">
                <div class="thumbnail"> 
                <div class="caption">
                        <p class="title">Index</p>
                    </div>
              
                   
                    
                </div>
            </div>
        </div>            
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-content" style="background: #293b50 url(<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/New/img/pattern3.png) repeat !important;">
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                        <!-- <a class="btn btn-circle show-tooltip" title="Add new record" href="index.php?module=caindex2&event=addNew" ><i class="icon-plus"></i></a>
                                       <a class="btn btn-circle show-tooltip" title="Edit selected" href="#"><i class="icon-edit"></i></a>-->
                                        <a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
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
                                <div id="Div" class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox" /></th>
            <th>Name</th>
            <th>Ticker</th>
            <th>Type</th>
            
            <th>Currency</th>
            <th>Start Date</th>
            <th>Approved</th>
            <th>Request File Status</th>
              <th>User Status </th>
            
            
            <th style="width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['indexdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
            <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="<?php echo $this->_tpl_vars['point']['id']; ?>
" /></td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['indexname']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['curr']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['dateStart']; ?>
</td>
            
            <td><?php if ($this->_tpl_vars['point']['status'] == 0): ?><span class="label label-important">Not approved!</span><?php else: ?><span class="badge badge-success">Approved</span><?php endif; ?></td>
             <td><?php if ($this->_tpl_vars['point']['dbusersignoff'] == 0): ?><span class="label label-important">Not Prepared!</span><?php else: ?><span class="badge badge-success">Prepared</span><?php endif; ?></td>
              <td><?php if ($this->_tpl_vars['point']['usersignoff'] == 0): ?><span class="label label-important">Not Signed Off!</span><?php else: ?><span class="badge badge-success">Signed Off</span><?php endif; ?></td>
            <td style="width:145px !important;">
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="index.php?module=caindex2&event=view&id=<?php echo $this->_tpl_vars['point']['id']; ?>
"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=caindex2&event=editfornext&id=<?php echo $this->_tpl_vars['point']['id']; ?>
"><i class="icon-edit"></i></a>
                    
                   <!-- index.php?module=caindex2&event=delete&id=<?php echo $this->_tpl_vars['point']['id']; ?>
-->
                    <a class="btn btn-small btn-danger show-tooltip " title="Delete" href="#" id="a1" onClick="confirmdelete(<?php echo $this->_tpl_vars['point']['id']; ?>
)"><i class="icon-trash"></i></a>
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