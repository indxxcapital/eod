<!-- BEGIN Main Content -->
{literal}
 <script type='text/javascript'>
 
 
 function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href='index.php?module=users&event=deleteassigned&id='+id;
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
 
</script>
 
 {/literal}
 
 {include file="notice.tpl"}
               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>My Index</h3>
                            </div>
                            <div class="box-content">
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                      <!--<a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
                                       <a class="btn btn-circle show-tooltip" title="Add new record" href="index.php?module=casecurities&event=addNew" style="margin-right:25px !important;"><i class="icon-plus"></i></a>
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
          <th style="width:18px"><input type="checkbox" /></th>
            <th>Name</th>
            <th>Code</th>
           
            <th style="width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
    	{foreach from=$indexarray item=point key=k}
        
        <tr>
           <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.id}" /> </td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
           
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View Corporate Actions" href="index.php?module=myindex&event=viewca&id={$point.id}"><i class="icon-zoom-in"></i></a>
                    
                    
                </div>
            </td>
        </tr>
        {/foreach}
      
    </tbody>
</table>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->