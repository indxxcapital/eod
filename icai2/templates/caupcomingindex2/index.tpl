<!-- BEGIN Main Content -->

{if $smarty.get.calcindxx_id}
 <script type='text/javascript'>
window.open('http://97.74.65.118/icai/index.php?module=calcindxxclosingid&id='+{$smarty.get.calcindxx_id},'Share','toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,history=yes,resizable=yes');
</script>

{/if}


 {literal}
<style>
.table-advance tbody>tr:nth-child(odd)>td, .table-advance tbody>tr:nth-child(odd)>th {
background: #293b50 url('assets/New/img/pattern.png') repeat !important;
}
.table-advance tbody>tr:nth-child(even)>td, .table-advance tbody>tr:nth-child(even)>th {
background: #e5e9f4 url('Assets/New/img/pattern2.png') repeat !important;
}
.table-advance thead {
background: #e5e9f4 url('Assets/New/img/pattern2.png') repeat !important;
border-left: 4px solid #e5e9f4 url('Assets/New/img/pattern2.png') repeat !important;
}
.table{
	border-collapse:inherit !important;	
}

.table.fill-head thead{
background: #e5e9f4 url('Assets/New/img/pattern2.png') repeat !important;
border-left: 4px solid #e5e9f4 url('Assets/New/img/pattern2.png') repeat !important;	
}
.table-striped > tbody > tr:nth-child(odd) > td, .table-striped > tbody > tr:nth-child(odd) > th {
background: #293b50 url('assets/New/img/pattern.png') repeat !important;	
color:#888 !important;
}
</style>
{/literal}
 

 {literal}
 <script type='text/javascript'>
 
 
 function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href='index.php?module=caupcomingindex2&event=delete&id='+id;
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
    url : "index.php?module=caupcomingindex2&event=deleteindex",
    type: "POST",
    data : parameters,
    success: function(data, textStatus, jqXHR)
    {
	  window.location.href='index.php?module=caupcomingindex2';
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
               {include file='notice.tpl'}
               
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
                            
                            <div class="box-content" style="background: #293b50 url({$BASE_URL}assets/New/img/pattern3.png) repeat !important;">
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
            <th>DB Status</th>
              <th>SignOff </th>
              <th>Running </th>
            <th>Admin Signoff </th>
            
            
            <th style="width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
    	{foreach from=$indexdata item=point key=k}
        <tr>
            <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.id}" /></td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
            <td>{$point.indexname}</td>
            <td>{$point.curr}</td>
            <td>{$point.dateStart}</td>
            
            <td>{if $point.status==0}<span class="label label-important">No</span>{else}<span class="badge badge-success">Yes</span>{/if}</td>
             <td>{if $point.dbusersignoff==0}<span class="label label-important">No</span>{else}<span class="badge badge-success">Yes</span>{/if}</td>
              <td>{if $point.usersignoff==0}<span class="label label-important">No</span>{else}<span class="badge badge-success">Yes</span>{/if}</td>  <td>{if $point.runindex==0}<span class="label label-important">No</span>{else}<span class="badge badge-success">Yes</span>{/if}</td>
              <td>{if $point.finalsignoff==0}<span class="label label-important">No</span>{else}<span class="badge badge-success">Yes</span>{/if}</td>
            <td>
                <div class="btn-group" style="width:145px !important;">
                
                
                
                    <a class="btn btn-small show-tooltip" title="View" href="index.php?module=caindex2&event=viewupcoming&id={$point.id}"><i class="icon-zoom-in"></i></a>
                    <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=caupcomingindex2&event=editfornext&id={$point.id}"><i class="icon-edit"></i></a>
                    
                   <!-- index.php?module=caindex2&event=delete&id={$point.id}-->
                    <a class="btn btn-small btn-danger show-tooltip " title="Delete" href="#" id="a1" onclick="confirmdelete({$point.id})"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        {/foreach}
       <!-- 
       <a class="btn btn-small show-tooltip" title="CalcShare" href="index.php?module=caindex2&event=calcshare&id={$point.id}"><i class="icon-repeat"></i></a>
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