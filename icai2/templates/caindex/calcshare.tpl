<!-- BEGIN Main Content -->

{include file="notice.tpl"}
 {literal}
 <script type='text/javascript'>
 
   function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ! All index related data will be deleted!")
  if(temp)
   {	
	
	window.location.href='index.php?module=caupcomingindex&event=delete&id='+id;
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
    url : "index.php?module=caupcomingindex&event=deleteindex",
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
                                <h3><i class="icon-table"></i>Share Details </h3>
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Investment Ammount</th>
                                            <th>Initial Divisor</th>
                                            <th>Currency</th>
                                            <th>Type</th>
                                            <th>Start Date</th>
                                           
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$viewindexdata item=point key=k}
        <tr>
             <td></td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
            <td>{$point.investmentammount}</td>
            <td>{$point.divisor}</td>
                <td>{$point.curr}</td>
                    <td>{$point.indexname}</td>
                     <td>{$point.dateStart}</td>
          
            
        </tr>
        {/foreach}
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                            
                                
                                <div class="clearfix"></div>
                                 <div class="box">
                                 <div class="box-title">
                                <h3><i class="icon-table"></i>Total {$totalindexSecurityrows} securities found</h3>
                            </div>
                              </div>  
                                
                                <div class="clearfix"></div>
<table class="table table-advance">
    <thead>
        <tr>
              <th>Ticker</th>
              <th>ISIN</th>       
               <th>Weight</th>
              <th>Share</th>
              <th>Last Price</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         </tr>
    </thead>
    <tbody>
    
    {if $sharedata|@count>0}
    	{foreach from=$sharedata item=point key=k}
        <tr>
            <td>{$point.ticker}</td>
            <td>{$point.isin}</td>
             <td>{$point.weight}</td>
            <td>{$point.share}</td>
            <td>{$point.finalprice}</td>

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
 
 

<a href="index.php?module=caindex&event=download&id={$smarty.get.id}">   <button class="btn btn-primary">Download</button></a>
                                   
                                    <a href="index.php?module=caupcomingindex"><button class="btn btn-inverse">Back</button></a>
                                    <!--  <button class="btn btn-warning">Warning</button>
                                    <button class="btn btn-danger">Delete Index</button>
                                    <button class="btn btn-success">Success</button>-->
                                    
                                    </td></tr>
                                   
                                    
                                    </table>

                            
                            
                           
                             
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->