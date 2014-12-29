<!-- BEGIN Main Content -->
 {literal}
 <script type='text/javascript'>
 
   function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ! All index related data will be deleted!")
  if(temp)
   {	
	
	window.location.href='index.php?module=delisttempupcoming&event=delete&id='+id;
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
    url : "index.php?module=delisttempupcoming&event=deleteindex",
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
                                <h3><i class="icon-table"></i>Index Details </h3>
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>New Start Date</th>
                                           
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$viewindexdata item=point key=k}
                                   
        <tr>
             <td></td>
            <td>{$point.indexname}</td>
            <td>{$point.code}</td>
                     <td>{$point.startdate}</td>
          
            
        </tr>
        {/foreach}
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                            
                                
                                <div class="clearfix"></div>
                                 <div class="box">
                                 <div class="box-title">
                                <h3><i class="icon-table"></i>Total {$total1} securities to be delisted</h3>
                            </div>
                              </div>  
                                
                                <div class="clearfix"></div>
<table class="table table-advance">
    <thead>
        <tr>
          
             <th>Name</th>
              <th>Ticker</th>
              <th>ISIN</th>       
              <th>Ticker Currency</th> 
              <th>Dividend Currency</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         </tr>
    </thead>
    <tbody>
    
    {if $securitytobedelisted|@count>0}
    	{foreach from=$securitytobedelisted item=point key=k}
        <tr>
          
            <td>{$point.name}</td>
            <td>{$point.ticker}</td>
            <td>{$point.isin}</td>
            <td>{$point.curr}</td>
            <td>{$point.divcurr}</td>

        </tr>
        {/foreach}
        {else}
        <tr>
        <td colspan="5" align="center">There is No Securities in this indxx.</td>
        </tr>
        {/if}
    
    </tbody>
</table>

 <table class="table table-advance">   <tr><td>
 
 
 {if $sessData.User.type==1}

 <!--{if $viewindexdata.0.submitted==0 && $viewindexdata.0.status==0}

 <a href="index.php?module=caindex&event=submitapprove&id={$viewindexdata.0.id}"><button class="btn btn-success">Submit & Approve</button></a>{/if}-->
 {if $viewindexdata.0.adminapprove==0}
 <a href="index.php?module=delisttempupcoming&event=approvetemp&id={$viewindexdata.0.id}"><button class="btn btn-success">Approve</button></a> {/if}
 

                                    <a href="index.php?module=delisttempupcoming"><button class="btn btn-inverse">Back</button></a>
                                   
                                    
                                    </td></tr>
                                  {/if}
                                    
                                 {if $sessData.User.type==2}
 
 <!--<a href="index.php?module=caindex&event=addSecurity&id={$viewindexdata.0.id}">   <button class="btn btn-primary">Add Securities</button></a>-->
 <!--{if $viewadmindata.0.isAdmin==0}
 {if $viewindexdata.0.submitted==0}
 <a href="index.php?module=caindex&event=subindextemp&id={$viewindexdata.0.id}"> <button class="btn btn-success">Submit Index</button></a>{/if}
  {if $viewindexdata.0.submitted==1 && $viewindexdata.0.usersignoff==0 && $viewindexdata.0.dbusersignoff==1}
                                   <a href="index.php?module=caindex&event=signofftemp&id={$viewindexdata.0.id}">  <button class="btn btn-info">Sign Off </button></a>{/if}
                                   {if $viewindexdata.0.submitted==1 && $viewindexdata.0.usersignoff==1 && $viewindexdata.0.dbusersignoff==1 && $viewindexdata.0.runindex==0}
                                   <a href="index.php?module=calcindxxclosingid&id={$viewindexdata.0.id}">  <button class="btn btn-info">Run Index</button></a>{/if}
                                   
                                   
                               
                           {/if}     
                           <a href="index.php?module=caindex&event=exportupcomming&id={$viewindexdata.0.id}"><button class="btn btn-warning">Export Index</button></a>    -->
                                    <a href="index.php?module=delisttempupcoming"><button class="btn btn-inverse">Back</button></a>
                                   
                                    </td></tr>
                                    {/if}
                                    
                                    
                                    {if $sessData.User.type==3}
 
 {if $viewindexdata.0.dbapprove==0 && $viewindexdata.0.adminapprove==1}<a href="index.php?module=delisttempupcoming&event=dbapprove&id={$viewindexdata.0.id}">   <button class="btn btn-primary">Approve</button></a>{/if}
                                   
                                    <a href="index.php?module=delisttempupcoming"><button class="btn btn-inverse">Back</button></a>
                                    
                                    
                                    </td></tr>
                                    {/if}
                                    
                                    </table>

                            
                            
                           
                             
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->