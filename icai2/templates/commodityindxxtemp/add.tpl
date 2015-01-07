 <!-- BEGIN Main Content -->
 {include file="notice.tpl"}
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Add New Commodity Index </h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal">
                             
                              
    {foreach from=$fields key=p item=item}
               <p>   {field data=$item value=$postData}{/field}
                </p>  {/foreach}
 <p>
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="saveandnext" value="saveandnext" id="submit"><i class="icon-ok"></i> Save and next</button>
                                    
                                       <button type="button" class="btn" name="cancel" id="cancel"  onClick="document.location.href='{$BASE_URL}index.php?module=commodityindxxtemp';">Back</button>
                                    </div>
                 
                 
                  
                  </form>
                               
                            </div>
                        </div>
                    </div>
                </div>
                
 <!-- END Main Content -->