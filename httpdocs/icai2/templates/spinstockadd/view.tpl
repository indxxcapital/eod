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
                                Spin off Stock  Addition Request
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Identifier</th>
                                            <th>Company Name</th>
                                            <th>Effective Date</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <tr>
             <td></td>
            <td>{$ca_data.identifier}</td>
<!--            <td><a data-original-title="{$point.mnemonic}" data-content="{$sessData.variable[$point.mnemonic]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.mnemonic}</a></td>-->
                 <td>{$ca_data.company_name}</td>
                  <td>{$ca_data.eff_date}</td>
        </tr>
                                        
                                    
                                      
                                    </tbody>
                                </table>
                         
                                
                    
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                  
                                      
                                    </div>
                                
                                </div>
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
             <th style="width:18px"></th>
          
             <th>Indxx Name</th>
             <th>Company Name</th>
              <th>Ticker</th>
                <th>ISIN</th>
                         <th>Currency</th>
                           <th>Div. Currency</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         
        </tr>
    </thead>
    <tbody>
    	{foreach from=$ca_values item=point key=k}
        <tr>
             <td></td>
          
<!--            <td><a data-original-title="{$point.field_name}" data-content="{$sessData.variable[$point.field_name]}" data-placement="top" data-trigger="hover" class="show-popover" href="#">{$point.field_name}</a></td>-->
            <td>{$point.indxx_name} ({$point.indxx_code})</td>
                        <td>{$point.name}</td>
            
            <td>{$point.ticker}</td>            <td>{$point.isin}</td>            <td>{$point.curr}</td>            <td>{$point.divcurr}</td>
            <!--<td>{$point.eff_date}</td>
            <td>{$point.ann_date}</td>-->
           
        </tr>
        {/foreach}
      
    </tbody>
</table>
     <table class="table table-advance">   <tr><td>
                     <a href="index.php?module=myca"><button class="btn btn-inverse">Back</button></a>
                     
                 
                 
               {if $ca_data.dbApprove==0 && $sessData.User.type==3}
                  <a href="index.php?module=spinstockadd&event=approve&id={$smarty.get.id}">  <button class="btn btn-info">Approve</button></a>
                 {/if}
                 </td></tr>
                    </table>

                 
                             </div>
                             
                             
                             
                             
                             
                             
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->