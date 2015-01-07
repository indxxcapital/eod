<!-- BEGIN Main Content -->
{include file="notice.tpl"}
{literal}
<script type='text/javascript'>
 
 
 function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href='index.php?module=clients&event=delete&id='+id;
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
  $('input[name="checkboxid"]:checked').each(function() {
i++;
checkedArray[i]=$(this).val();
});
var parameters = {
  "array1":checkedArray
};


$.ajax({
    url : "index.php?module=clients&event=deleteindex",
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
                                <h3><i class="icon-table"></i>Clients</h3>
                            </div>
                            <div class="box-content">
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                    {if $sessData.User.type=='1'}
                                        <a class="btn btn-circle show-tooltip" title="Add new record" href="index.php?module=clients&event=addNew"><i class="icon-plus"></i></a>
                                        <!--<a class="btn btn-circle show-tooltip" title="Print" href="#"><i class="icon-print"></i></a>-->
                                        <a class="btn btn-circle show-tooltip" title="Export to Excel" href="index.php?module=clients&event=exportExcel"><i class="icon-table"></i></a>
                                         <a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
                                      {/if}  
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
<table class="table table-advance" id="table1">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox" /></th>
            <th>Name</th>
            <th>FTP Username</th>
            <th>Email</th>
           {if $sessData.User.type=='1'}<th>Index</th>{/if}
            <th style="width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
    	{foreach from=$userdata item=point key=k}
        
        <tr>
            <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.userid}" /></td>
            <td>{$point.username}</td><td>{$point.ftpusername}</td>
            <td>{$point.email}</td>
            {if $sessData.User.type=='1'}<td><a href="index.php?module=clients&event=view&id={$point.userid}" style=" color:#888888 !important">{$point.indexes}</a></td>{/if}
           
           
           {if $sessData.User.type=='1'}
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="View Indexes" href="index.php?module=users&event=view&id={$point.userid}"><i class="icon-zoom-in"></i></a>-->
                    <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=clients&event=edit&id={$point.userid}"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip" title="Delete" href="#" id="a1" onclick="confirmdelete({$point.userid})"><i class="icon-trash"></i></a>
                </div>
            </td>
            {/if}
        </tr>
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