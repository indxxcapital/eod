<!-- BEGIN Main Content -->
 {literal}
 <script type='text/javascript'>
 
   function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	
	window.location.href='index.php?module=viewfields&event=delete&id='+id;
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
 
 {/literal}
               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                              <!--  <h3><i class="icon-table"></i>Fields</h3>-->
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Identifier</th>
                                            <th>Type</th>
                                            <th>Company Name</th>
                                           
                                            {if $sessData.User.type==1}<th style="width:150px">Action</th>{/if}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$viewdata item=point key=k}
        <tr>
             <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.id}" /></td>
            <td>{$point.identifier}</td>
            <!--<td><a data-original-title="{$point.mnemonic}" data-content="{$sessData.variable[$point.mnemonic]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$sessData.variable[$point.mnemonic]}</a></td>-->
            <td>{$sessData.variable[$point.mnemonic]}</td>
            <td>{$point.company_name}</td>
            
            <!--<td>{$point.eff_date}</td>
            <td>{$point.ann_date}</td>-->
            {if $sessData.User.type==1}
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="View" href="index.php?module=viewfields&event=view"><i class="icon-zoom-in"></i></a>-->
                    
                     
                    
                    <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=viewfields&event=edit&id={$point.fieldid}"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip " title="Delete" href="#" id="a1" onclick="confirmdelete({$point.id})"><i class="icon-trash"></i></a>
                    
                    
                  
                </div>
            </td>
              {/if}
        </tr>
        {/foreach}
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                   {if $liveindxx|@count>0}         
                               <h3>Live Index</h3>
                               
                          <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$liveindxx item=point key=k}
        <tr> <td>&nbsp;{$k+1}</td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
       
        </tr>
        {/foreach}
                                    
                                    
                                       
                                    </tbody>
                                </table>
                                
                                {/if}
                                {if $tempindxx|@count>0}
                                   <h3>Upcomming Index</h3>
                               
                          <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$tempindxx item=point key=k}
        <tr> <td>&nbsp;{$k+1}</td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
       
        </tr>
        {/foreach}
                                    
                                    
                                       
                                    </tbody>
                                </table>
                                {/if}
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                    <a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
                                        <!--<a class="btn btn-circle show-tooltip" title="Add new record" href="index.php?module=casecurities&event=addNew" style="margin-right:25px !important;"><i class="icon-plus"></i></a>
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
             <th style="width:18px"><!--<input type="checkbox" />-->  &nbsp;</th>
          
             <th>Field Name</th>
             <th>Field Name Meaning</th>
              <th>Field Value</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
            {if $sessData.User.type==1}<th style="width:100px">Action</th>{/if}
        </tr>
    </thead>
    <tbody>
    	{foreach from=$viewdata2 item=point key=k}
        <tr>
             <td><!--<input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.id}" />--> &nbsp;</td>
          
<!--            <td><a data-original-title="{$point.field_name}" data-content="{$sessData.variable[$point.field_name]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.field_name}</a></td>-->
            <td>{$point.field_name}</td>
                        <td>{$sessData.variable[$point.field_name]}</td>
            {if $point.syn}<td><a data-original-title="{$point.field_name}" data-content="{$point.syn}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.field_value}</a></td>{else}<td>{$point.field_value}</td>{/if}
            <!--<td>{$point.eff_date}</td>
            <td>{$point.ann_date}</td>-->
            {if $sessData.User.type==1}
            <td>
                <div class="btn-group">
                    <!--<a class="btn btn-small show-tooltip" title="View" href="index.php?module=viewfields&event=view"><i class="icon-zoom-in"></i></a>-->
                    
                     
                    
                    <a class="btn btn-small show-tooltip" title="Edit" href="index.php?module=viewfields&event=edit&id={$point.fieldid}"><i class="icon-edit"></i></a>
                    <a class="btn btn-small btn-danger show-tooltip " title="Delete" href="#" id="a1" onclick="confirmdelete({$point.id})"><i class="icon-trash"></i></a>
                    
                    
                  
                </div>
            </td>
              {/if}
        </tr>
        {/foreach}
        
        
    </tbody>
</table>
<form method="post">

<input type="hidden" name="caid" value="{$viewdata.0.id}" />
<input type="hidden" name="id" value="{$viewdata.0.action_id}" />
<input type="hidden" name="status" value="{$viewdata.0.status}" />
<input type="hidden" name="spcash" value="{$scflag}" />
 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"  value="1"><i class="icon-ok"></i>{ if $viewdata.0.status==1}Inactivate for All{else} Activate for All{/if}</button>
                                      {if $scflag &&  $sessData.User.type=='1'} <button type="submit" class="btn btn-primary" name="scflagbtn" value="1" id="submit"><i class="icon-ok"></i> Convert To Special Cash</button> {/if}
                                     {if $sessData.User.type=='1' }   <button type="submit" class="btn btn-primary" name="iactive" value="1" id="submit"><i class="icon-ok"></i> Make Inactive for Index Wise</button>
                                      {/if}
                                       <button type="button" class="btn" name="cancel" id="cancel"  onClick="document.location.href='{$BASE_URL}index.php?module=upcomingca';">Back</button>
                                    </div>
                 </form>

                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->