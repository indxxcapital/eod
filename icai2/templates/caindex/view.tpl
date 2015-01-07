<!-- BEGIN Main Content -->
 {literal}
 <script type='text/javascript'>
 
   function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ! All index related data will be deleted!")
  if(temp)
   {	
	
	window.location.href='index.php?module=caindex&event=delete&id='+id;
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
    url : "index.php?module=caindex&event=deleteindex",
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
           <th>#</th>
             <th>Name</th>
              <th>Ticker</th>
              <th>ISIN</th>       
               <th>Weight</th>
              <th>Currency</th>  <th>Div Currency</th><th style="width:100px">Submit adjustment factor</th>
              
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         </tr>
    </thead>
    <tbody>
    
    {if $indexSecurity|@count>0}
    	{foreach from=$indexSecurity item=point key=k}
        <tr>
          <td>{$k+1}</td>
            <td>{$point.name}</td>
            <td>{$point.ticker}</td>
            <td>{$point.isin}</td>
            <td>{$point.weight}</td>
            <td>{$point.curr}</td>
             <td>{$point.divcurr}</td>
             <td>
             <div class="btn-group">
                    
                    <a class="btn btn-small show-tooltip" title="Adj Factor" href="index.php?module=caindex&event=subadjfactor&id={$point.id}&indxx_id={$smarty.get.id}"><i class="icon-edit"></i></a>
                    
                  
                </div></td>

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

 
                                    <a href="index.php?module=caindex"><button class="btn btn-inverse">Back</button></a>
                                   
                                    
                                    </td></tr>
                                    {/if}
                                    
                                    
                                 {if $sessData.User.type==2}
 

                                    
                                    <a href="index.php?module=caindex"><button class="btn btn-inverse">Back</button></a>
                                 
                                    </td></tr>
                                    {/if}
                                    
                                    
                                    {if $sessData.User.type==3}

                                   
                                    <a href="index.php?module=caindex"><button class="btn btn-inverse">Back</button></a>
                                   
                                    </td></tr>
                                    {/if}
                                    
                                    </table>

                            
                            
                           
                             
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->