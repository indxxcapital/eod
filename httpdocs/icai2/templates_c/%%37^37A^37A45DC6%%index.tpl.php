<?php /* Smarty version 2.6.14, created on 2014-07-01 15:58:20
         compiled from delistrunning/index.tpl */ ?>
<!-- BEGIN Main Content -->

<?php if ($_GET['calcindxx_id']): ?>
 <script type='text/javascript'>
window.open('http://97.74.65.118/icai/index.php?module=calcindxxclosingid&id='+<?php echo $_GET['calcindxx_id']; ?>
,'Share','toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,history=yes,resizable=yes');
</script>

<?php endif; ?>

 <?php echo '
 <script type=\'text/javascript\'>
 
 
 function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href=\'index.php?module=delistrunningsecurities&event=delete&id=\'+id;
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
    url : "index.php?module=delistrunningsecurities&event=deleteindex",
    type: "POST",
    data : parameters,
    success: function(data, textStatus, jqXHR)
    {
	  window.location.href=\'index.php?module=delistrunningsecurities\';
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
$this->_smarty_include(array('smarty_include_tpl_file' => 'notice.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Index</h3>
                            </div>
                            <div class="box-content">
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                        <a class="btn btn-circle show-tooltip" title="Add new record" href="index.php?module=delistrunningsecurities&event=addNew" ><i class="icon-plus"></i></a>
                                        <!--<a class="btn btn-circle show-tooltip" title="Edit selected" href="#"><i class="icon-edit"></i></a>-->
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
            <th>Start Date</th>
            <th>Notified to admin</th>
            <th>Admin Status</th>
            <th>DB Status</th>
            
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
            <td><?php echo $this->_tpl_vars['point']['startdate']; ?>
</td>
            
            <td><?php if ($this->_tpl_vars['point']['status'] == 0): ?><span class="label label-important">No</span><?php else: ?><span class="badge badge-success">Yes</span><?php endif; ?></td>
            
            <td><?php if ($this->_tpl_vars['point']['adminapprove'] == 0): ?><span class="label label-important">No</span><?php else: ?><span class="badge badge-success">Yes</span><?php endif; ?></td>
             <td><?php if ($this->_tpl_vars['point']['dbapprove'] == 0): ?><span class="label label-important">No</span><?php else: ?><span class="badge badge-success">Yes</span><?php endif; ?></td>
             
            <td>
                <div class="btn-group">
                
                
                
                    <a class="btn btn-small show-tooltip" title="View" href="index.php?module=delistrunningsecurities&event=viewupcoming&id=<?php echo $this->_tpl_vars['point']['id']; ?>
"><i class="icon-zoom-in"></i></a>
                   <!-- <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=delistrunningsecurities&event=editfornext&id=<?php echo $this->_tpl_vars['point']['id']; ?>
"><i class="icon-edit"></i></a>-->
                    
                   <!-- index.php?module=caindex&event=delete&id=<?php echo $this->_tpl_vars['point']['id']; ?>
-->
                    <a class="btn btn-small btn-danger show-tooltip " title="Delete" href="#" id="a1" onclick="confirmdelete(<?php echo $this->_tpl_vars['point']['id']; ?>
)"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
       <!-- 
       <a class="btn btn-small show-tooltip" title="CalcShare" href="index.php?module=caindex&event=calcshare&id=<?php echo $this->_tpl_vars['point']['id']; ?>
"><i class="icon-repeat"></i></a>
       <tr>
            <td><input type="checkbox" /></td>
            <td>Trident</td>
            <td><a href="#">AOL browser (AOL desktop)</a></td>
            <td>Win XP</td>
            <td class="text-center">6</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr class="table-flag-orange">
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td><span class="label label-success">Not Bad</span> Firefox 1.5</td>
            <td>Win 98+ / OSX.2+</td>
            <td class="text-center">1.8</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td>Netscape Navigator 9</td>
            <td>Win 98+ / OSX.2+</td>
            <td class="text-center">1.8</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td>Seamonkey 1.1</td>
            <td>Win 98+ / OSX.2+</td>
            <td class="text-center">1.8</td>
            <td><span class="label label-warning">B</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td>Mozilla 1.8</td>
            <td>Win 98+ / OSX.1+</td>
            <td class="text-center">1.8</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr class="table-flag-blue">
            <td><input type="checkbox" /></td>
            <td>Trident</td>
            <td><span class="label label-warning">So crazy!</span> <a href="#">Internet Explorer 6</a></td>
            <td>Win 98+</td>
            <td class="text-center">6</td>
            <td><span class="label label-important">C</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr class="table-flag-red">
            <td><input type="checkbox" /></td>
            <td>Presto</td>
            <td>Opera 7.5</td>
            <td>Win 95+ / OSX.2+</td>
            <td class="text-center">-</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr class="table-flag-red">
            <td><input type="checkbox" /></td>
            <td>Presto</td>
            <td><span class="label label-info">It's Opera!</span> Opera 8.0</td>
            <td>Win 95+ / OSX.2+</td>
            <td class="text-center">-</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td><a href="#">Mozilla 1.0</a></td>
            <td>Win 95+ / OSX.1+</td>
            <td class="text-center">1</td>
            <td><span class="label label-warning">B</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td>Mozilla 1.1</td>
            <td>Win 95+ / OSX.1+</td>
            <td class="text-center">1.1</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr class="table-flag-blue">
            <td><input type="checkbox" /></td>
            <td>Misc</td>
            <td>IE Mobile</td>
            <td>Windows Mobile 6</td>
            <td class="text-center">-</td>
            <td><span class="label label-important">C</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td><a href="#">Mozilla 1.2</a></td>
            <td>Win 95+ / OSX.1+</td>
            <td class="text-center">1</td>
            <td><span class="label label-warning">B</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr class="table-flag-red">
            <td><input type="checkbox" /></td>
            <td>Presto</td>
            <td>Opera 7.7</td>
            <td>Win 95+ / OSX.2+</td>
            <td class="text-center">-</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Gecko</td>
            <td>Mozilla 1.7</td>
            <td>Win 98+ / OSX.1+</td>
            <td class="text-center">1.8</td>
            <td><span class="label label-success">A</span></td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View" href="#"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>-->
    </tbody>
</table>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->