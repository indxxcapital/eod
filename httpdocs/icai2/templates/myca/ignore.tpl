{include file='notice.tpl'}<!-- BEGIN Main Content -->
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
 $("#submit").click(function(){
	 
		
	 
 var checkedArray=Array();
 var checkedArray2=Array();
 var i=0;
  $('input[name="checkboxid"]:checked').each(function() {
i++;
checkedArray[i]=$(this).val();
});

 var j=0;
$('input[name="checkboxtempid"]:checked').each(function() {
j++;
checkedArray2[j]=$(this).val();
});

var parameters = {
  "array1":checkedArray,  "array2":checkedArray2
};


$.ajax({
    url : "index.php?module=myca&event=ignoreindex",
    type: "POST",
    data : parameters,
    success: function(data, textStatus, jqXHR)
    {
        //data - response from server
		alert("done");
		document.location.href='index.php?module=myca';
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
 alert("error");
    }
});




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
                             {if $indxxd|@count>0} <div class="box">
                            <div class="box-title">
                               Live Index </div>
                            </div>
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
             <td><input type="checkbox" id="checkboxid"  name="checkboxid" value="{$point.indxx_id}_{$smarty.get.id}" /> </td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
           
        </tr>
        {/foreach}
                                    
                                    
                                      
                                    </tbody>
                                </table>
                                
                                
                                {/if}
                                
                          {if $indxxt|@count>0}        <div class="box">
                            <div class="box-title">
                               Upcoming Index </div>
                            </div>
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
             <td><input type="checkbox" id="checkboxid"  name="checkboxtempid" value="{$point.indxx_id}_{$smarty.get.id}" /> </td>
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

                 <table class="table table-advance">   <tr><td>
                 
                 <a href="#"><button class="btn btn-info" id="submit">Submit</button></a>
                 
                     <a href="index.php?module=myca"><button class="btn btn-inverse">Back</button></a>
                     
                 
                 
                 
                 </td></tr>
                    </table>

                 </form>
                             </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->