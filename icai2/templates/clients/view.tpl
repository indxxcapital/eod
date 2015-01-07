<!-- BEGIN Main Content -->

{literal}
 <script type='text/javascript'>
 
 
 function confirmdelete(id,userid)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href='index.php?module=clients&event=deleteassigned&id='+id+'&userid='+userid;
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
 var user_id=$("#user_id").val();
 var i=0;
  $('input[name="checkboxid"]:checked').each(function() {
i++;
checkedArray[i]=$(this).val();
});
var parameters = {
  "array1":checkedArray
};


$.ajax({
    url : "index.php?module=clients&event=deleteassignedindex&user_id="+user_id,
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
 
 {/literal}



<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>Client : {$viewdata.0.username}</h3>
                            </div>
                            <div class="box-content">
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                    
                                    <a class="btn btn-circle show-tooltip" title="Assign new index" href="index.php?module=assignclientindex&id={$viewdata.0.userid}"><i class="icon-plus"></i></a>
                                     <a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
                                        
                                        <!--<a class="btn btn-circle show-tooltip" title="Print" href="#"><i class="icon-print"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Export to Excel" href="index.php?module=users&event=exportExcel"><i class="icon-table"></i></a>-->
                                    </div>
                                        <!--<a class="btn btn-circle show-tooltip" title="Edit selected" href="#"><i class="icon-edit"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Delete selected" href="#"><i class="icon-trash"></i></a>-->
                                    </div>
                                    <div class="btn-group">
                                        
                                        <!--<a class="btn btn-circle show-tooltip" title="Export to PDF" href="#"><i class="icon-file-text-alt"></i></a> <a class="btn btn-circle show-tooltip" title="Print" href="#"><i class="icon-print"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Export to Excel" href="#"><i class="icon-table"></i></a>
                                        
                                    <!--<div class="btn-group">
                                        <a class="btn btn-circle show-tooltip" title="Refresh" href="#"><i class="icon-repeat"></i></a>
                                    </div>-->
                                </div>
                                <div class="clearfix"></div>
                                <input type="hidden" id="user_id" value="{$smarty.get.id}" />
                                
<table class="table table-advance" id="table1">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox" /></th>
            <th>Index</th>
            <th style="width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
    	{foreach from=$viewdata item=point key=k}
        {if !empty($point)}
        <tr>
            <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.indexid}" /></td>
            <td>{$point.indexname}</td>
           
            <td>
                <div class="btn-group">
                    <!--a class="btn btn-small show-tooltip" title="View Indexes" href="index.php?module=users&event=view&id={$point.userid}"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="#"><i class="icon-edit"></i></a>-->
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#" id="a1" onclick="confirmdelete({$point.indexid},{$point.userid})"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
     	{/if}
        {/foreach}
       <!-- <tr>
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