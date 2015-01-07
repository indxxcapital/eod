{include file='notice.tpl'}<!-- BEGIN Main Content -->
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
                                
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Identifier</th>
                                            <th>Type</th>
                                            <th>Company Name</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$viewdata item=point key=k}
        <tr>
             <td></td>
            <td>{$point.identifier}</td>
<!--            <td><a data-original-title="{$point.mnemonic}" data-content="{$sessData.variable[$point.mnemonic]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.mnemonic}</a></td>-->
            <td>{$sessData.variable[$point.mnemonic]}</td>
            <td>{$point.company_name}</td>
           
        </tr>
        {/foreach}
                                    
                                    
                                      
                                    </tbody>
                                </table>
                            {if $indxxd|@count>0}  <div class="box">  <div class="box-title">
                                Live Index
                            </div></div>
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$indxxd item=point key=k}
        <tr>
             <td>{$k+1}</td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
           
        </tr>
        {/foreach}
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                {/if}
                                
                            {if $indxxt|@count>0}      <div class="box">  <div class="box-title">
                                Upcoming Index
                            </div></div>
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>Indxx</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$indxxt item=point key=k}
        <tr>
             <td>{$k+1}</td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
           
        </tr>
        {/foreach}
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                {/if}
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                  
                                      
                                    </div>
                                
                                </div>
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
             <th style="width:18px"></th>
          
             <th>Field Name</th>
             <th>Field Name Meaning</th>
              <th>Field Value</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         
        </tr>
    </thead>
    <tbody>
    	{foreach from=$viewdata2 item=point key=k}
        <tr>
             <td></td>
          
<!--            <td><a data-original-title="{$point.field_name}" data-content="{$sessData.variable[$point.field_name]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.field_name}</a></td>-->
            <td>{$point.field_name}</td>
                        <td>{$sessData.variable[$point.field_name]}</td>
            
            <td>{$point.field_value}</td>
            <!--<td>{$point.eff_date}</td>
            <td>{$point.ann_date}</td>-->
           
        </tr>
        {/foreach}
      
    </tbody>
</table>

{if $viewdata3|@count>0}
            <div class="clearfix">Old Values </div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
             <th style="width:18px"></th>
          
             <th>Field Name</th>
             <th>Field Name Meaning</th>
              <th>Field Value</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         
        </tr>
    </thead>
    <tbody>
    	{foreach from=$viewdata3 item=point key=k}
    	{foreach from=$diffkey item=dif key=k2}



{if $k2==$k}

        <tr>
             <td></td>
          
<!--            <td><a data-original-title="{$point.field_name}" data-content="{$sessData.variable[$point.field_name]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.field_name}</a></td>-->
            <td>{$point.field_name}</td>
                        <td>{$sessData.variable[$point.field_name]}</td>
            
            <td>{$point.field_value}</td>
            <!--<td>{$point.eff_date}</td>
            <td>{$point.ann_date}</td>-->
           
        </tr>
        {/if}
        {/foreach}
        {/foreach}
      
    </tbody>
</table>
{/if}
                 <table class="table table-advance">   <tr><td>
                     <a href="index.php?module=myca"><button class="btn btn-inverse">Back</button></a>
                     
                 
                 
               {if $indxxd|@count>0 && $approveLive}
                  <a href="index.php?module=myca&event=approve&id={$smarty.get.id}">  <button class="btn btn-info">Approve For Live</button></a>
                 {/if}
              
                 {if  $viewdata.0.mnemonic=="SPIN"}
           
           <a href="index.php?module=myca&event=addStockforSpin&id={$smarty.get.id}">  <button class="btn btn-info">Stock Addition </button></a>
                 {/if}
                 
                
                 
                     {if $indxxt|@count>0 && $approveTemp}
                  <a href="index.php?module=myca&event=approvetemp&id={$smarty.get.id}">  <button class="btn btn-info">Approve For Upcomming</button></a>
                 {/if} 
                 
                 
                 
                  <!-- <a href="index.php?module=myca&event=notifyclient&id={$smarty.get.id}"><button class="btn btn-success">Notify to Client</button></a>-->
                      
                   {if $sessData.User.type=='1' }    <a href="index.php?module=myca&event=ignoreindex&id={$smarty.get.id}"><button class="btn btn-warning">Ignore Index</button></a>
                      
                     {if $indxxd|@count>0}   <a href="index.php?module=myca&event=edit&id={$smarty.get.id}"><button class="btn btn-info">Edit/Insert Value For Live Index</button></a>
{/if}                     {if $indxxt|@count>0}    <a href="index.php?module=myca&event=editfortemp&id={$smarty.get.id}"><button class="btn btn-info">Edit/Insert Value for Upcoming Index</button></a> 
                     {/if}
                        {if  $viewdata.0.mnemonic=="SPIN" ||$viewdata.0.mnemonic=="ACQUIS" ||$viewdata.0.mnemonic=="DELIST" }
           
           <a href="index.php?module=myca&event=adddividendplaceholder&id={$smarty.get.id}">  <button class="btn btn-info">Dividend Placeholder Request </button></a>
                 {/if}
                     
                     {/if}
                 
                 </td></tr>
                    </table>

                 
                             </div>
                             
                             
                             
                             
                             
                             
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->