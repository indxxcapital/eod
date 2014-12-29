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
                                   
                                    <tbody>
                                    
                                   <tr>
                                   <td>
                                  <strong> Title</strong><br />
                                   {$userdata1.title}
                                   </td>
                                   </tr>  
                                   <tr>
                                   <td>
                                  <strong> Submitted By</strong><br />
                                   {$userdata1.username} at {$userdata1.dateAdded}
                                   </td>
                                   </tr>  
                                     <tr>
                                   <td>
                                  <strong> Description</strong><br />
                                   {$userdata1.content}
                                   </td>
                                   </tr>  
                                   {if $userdata1.file}
                                     <tr>
                                   <td>
                                  <strong> Attachment :</strong><br />
                                      <a  target="_blank" href="media/attachmentfile/{$userdata1.file}">{$userdata1.file}</a>
                                   </td>
                                   </tr> 
                                   {/if}
                                   
                                   
                                   
                                   
                                   {if $usercomments|@count>0}
                                     <tr>
                                   <td>
                                  <strong> Comments :</strong><br />
                                         {foreach from=$usercomments key=p item=item}
                                         ({$item.dateAdded})-{$item.username}-{$item.comment} 
                                         {/foreach}
                                     
                                     
                                     </td>
                                   </tr> 
                                   {/if}
                                   
                                    </tbody>
                                </table>
                            
             
                                
                                



                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Add Your Comments</h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" class="form-horizontal">
                             
                              
    {foreach from=$fields key=p item=item}
               <p>   {field data=$item value=$postData}{/field}
                </p>  {/foreach}
 <p>
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel" onClick="document.location.href='{$BASE_URL}index.php?module=updaterequest';" >Back</button>
                                       
                                    </div>
                 
                 
                  
                  </form>
                            </div>
                        </div>
                    </div>
                </div>

                
                
                  <!-- END Main Content -->