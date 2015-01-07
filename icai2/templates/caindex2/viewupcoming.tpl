<!-- BEGIN Main Content -->
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

 var temp=confirm("Are you sure you want to delete this record ! All index related data will be deleted!")
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
 
<br><br><br><br><br><br> <br><br><br> 
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
                        <p class="title">Index Details</p>
                    </div>
              
                   
                    
                </div>
            </div>
        </div>  
 
               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">                            
                            <div class="box-content" style="background: #293b50 url({$BASE_URL}assets/New/img/pattern3.png) repeat !important;">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Investment Ammount</th>
                                           
                                            <th>Currency</th>
                                            <th>Type</th>
                                            <th>Start Date</th> <th>Calc Date</th>
                                           
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$viewindexdata item=point key=k}
        <tr>
             <td></td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
            <td>{$point.investmentammount}</td>
        
                <td>{$point.curr}</td>
                    <td>{$point.indexname}</td>
                     <td>{$point.dateStart}</td>
              <td>{$point.calcdate}</td>
            
        </tr>
        {/foreach}
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                            
                                
                                <div class="clearfix"></div>
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
                        <p class="title">Total {$totalindexSecurityrows} securities found</p>
                    </div>
              
                </div>
            </div>
        </div> 
                                
                                   
                                   
                                
                                <div class="clearfix"></div>
<table class="table table-advance">
    <thead>
        <tr>
          
             <th>Name</th>
              <th>Ticker</th>
              <th>ISIN</th>       
               <th>Weight</th>
              <th>Ticker Currency</th> 
              <th>Dividend Currency</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         </tr>
    </thead>
    <tbody>
    
    {if $indexSecurity|@count>0}
    	{foreach from=$indexSecurity item=point key=k}
        <tr>
          
            <td>{$point.name}</td>
            <td>{$point.ticker}</td>
            <td>{$point.isin}</td>
            <td>{$point.weight}</td>
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

 <table class="table table-advance">   <tr><td style="background:none !important; border-top:none !important;">

 {if $sessData.User.type==1}
 {if $viewadmindata.0.isAdmin==1}

 {if $viewindexdata.0.submitted==0 && $viewindexdata.0.status==0}
 <a href="index.php?module=caindex2&event=submitapprove&id={$viewindexdata.0.id}"><button class="btn btn-success">Submit & Approve</button></a>{/if}
 
 {/if}
 

 {if $viewindexdata.0.status==0 }
 <a href="index.php?module=caindex2&event=approvetemp&id={$viewindexdata.0.id}"><button class="btn btn-success">Approve</button></a> {/if}
 
{if $viewindexdata.0.submitted==0}
 <a href="index.php?module=caindex2&event=reject&id={$viewindexdata.0.id}"><button class="btn btn-warning">Reject</button></a>{/if}
                              
                              
                              
                                    {if $viewindexdata.0.submitted==1 && $viewindexdata.0.status==1  &&  $viewindexdata.0.usersignoff==1   &&  $viewindexdata.0.dbusersignoff==1   && $viewindexdata.0.runindex==1 && $viewindexdata.0.finalsignoff==0}
       <a href="index.php?module=caindex2&event=finalsignoff&id={$viewindexdata.0.id}"><button class="btn btn-success">Final Signoff</button></a>{/if}

                              
                                    <a href="#"><button class="btn btn-danger" onclick="confirmdelete({$viewindexdata.0.id})" id="a1">Delete Index</button></a>
                                    
                                    
                                    
                                    
                                    
  <a href="index.php?module=caindex2&event=exportupcomming&id={$viewindexdata.0.id}"><button class="btn btn-warning">Export Index</button></a>
                                    <a href="index.php?module=caupcomingindex2"><button class="btn btn-inverse">Back</button></a>
                                   
                                    
                                    </td></tr>
                                  {/if}
                                    
                                 {if $sessData.User.type==2}
 
 <!--<a href="index.php?module=caindex2&event=addSecurity&id={$viewindexdata.0.id}">   <button class="btn btn-primary">Add Securities</button></a>-->

 {if $viewindexdata.0.submitted==0}
 <a href="index.php?module=caindex2&event=subindextemp&id={$viewindexdata.0.id}"> <button class="btn btn-success">Submit Index</button></a>{/if}
  {if $viewindexdata.0.submitted==1 && $viewindexdata.0.usersignoff==0 && $viewindexdata.0.dbusersignoff==1}
                                   <a href="index.php?module=caindex2&event=signofftemp&id={$viewindexdata.0.id}">  <button class="btn btn-info">Sign Off </button></a>{/if}
                                   {if $viewindexdata.0.submitted==1 && $viewindexdata.0.usersignoff==1 && $viewindexdata.0.dbusersignoff==1 && $viewindexdata.0.runindex==0 && $viewindexdata.0.rebalance==0}
                                   <a href="index.php?module=calcindxxclosingid&id={$viewindexdata.0.id}">  <button class="btn btn-info">Run Index</button></a>{/if}
                                   
                                   
                               
                           <a href="index.php?module=caindex2&event=exportupcomming&id={$viewindexdata.0.id}"><button class="btn btn-warning">Export Index</button></a>    
                                    <a href="index.php?module=caupcomingindex2"><button class="btn btn-inverse">Back</button></a>
                                    <!-- <button class="btn btn-warning">Warning</button>
                                    <button class="btn btn-danger">Delete Index</button>
                                    <button class="btn btn-success">Success</button>
                                    -->
                                    </td></tr>
                                    {/if}
                                    
                                    
                                    {if $sessData.User.type==3}
                                    
{if $viewindexdata.0.submitted==0} <a href="index.php?module=caindex2&event=rejectbydbuser&id={$viewindexdata.0.id}"><button class="btn btn-warning">Reject</button></a>   {/if}               
 
 {if $viewindexdata.0.dbusersignoff==0}<a href="index.php?module=caindex2&event=subrequesttemp&id={$viewindexdata.0.id}">   <button class="btn btn-primary">Request File Status</button></a>{/if}
                                   
                                    <a href="index.php?module=caupcomingindex2"><button class="btn btn-inverse">Back</button></a>
                                    <!--  <button class="btn btn-warning">Warning</button>
                                    <button class="btn btn-danger">Delete Index</button>
                                    <button class="btn btn-success">Success</button>-->
                                    
                                    </td></tr>
                                    {/if}
                                    
                                    </table>

                            
                            
                           
                             
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->