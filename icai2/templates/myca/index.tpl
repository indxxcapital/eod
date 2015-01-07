<!-- BEGIN Main Content -->
{include file='notice.tpl'}
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



$(document).ready(function(){
 $("#adminapproval").click(function(){
	 
	 var temp=confirm("Are you sure you want to approve these records ")
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
  $('input[name="checkboxid"]:checked').each(function() {
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
  $('input[name="checkboxid"]:checked').each(function() {
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
 
 {/literal}
 
 {include file="notice.tpl"}
               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>Corporate Actions {if $indxxData.name} of {$indxxData.name}({$indxxData.code}){/if}</h3>
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
          <th style="width:18px"><input type="checkbox" /></th>
            <th>Identifier</th>
            <th>Type</th>
            <th>Company Name</th>
            <th>Effective Date</th>
            <!--<th>Announce Date</th>-->
             <th>Status</th>
             <th>Approved</th>
           
              <!-- <th>Notified to client</th>-->
            <th style="width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
    	{foreach from=$ca_array item=point key=k}
        <tr>
           <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.id}_{$point.identifier}_{$point.action_id}" /> </td>
            <td  {if $point.valuechange=="yes"} style="color:#F00"{/if}>{$point.identifier}</td>
<!--            <td><a data-original-title="{$point.mnemonic}" data-content="{$sessData.variable[$point.mnemonic]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.mnemonic}</a></td>-->
            <td  {if $point.valuechange=="yes"} style="color:#F00"{/if}>{if $point.notregularcash}{$sessData.variable[$point.mnemonic]}<sup>*</sup>{else}{$sessData.variable[$point.mnemonic]}{/if}</td>
            <td  {if $point.valuechange=="yes"} style="color:#F00"{/if}>{$point.company_name}</td>
            <td  {if $point.valuechange=="yes"} style="color:#F00"{/if}>{$point.eff_date}</td>
            <!--<td>{$point.ann_date}</td>-->
             <td >{if $point.status=='0'}<span class="label label-important">Inactive!</span>{else}<span class="badge badge-success">Active</span>{/if}</td>
             
              <td>{if $point.approved=='1'}<span class="label label-success">Approved</span>{else}<span class="badge badge-important">Not Approved</span>{/if}</td>
           
             <!-- <td>{if $point.notifiedtoclient==0}<span class="label label-important">Pending!</span>{else}<span class="badge badge-success">Notified</span>{/if}</td>-->
            <td>
                <div class="btn-group">
                    <a class="btn btn-small show-tooltip" title="View All Fields" href="index.php?module=myca&event=view&id={$point.id}"><i class="icon-zoom-in"></i></a>
                    
                    
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