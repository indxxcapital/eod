<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Run Your Index : {$indxx.name} ({$indxx.code})</h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal">
                             <input type='hidden' name='id' value ="{$smarty.get.id}">
                              
    {foreach from=$fields key=p item=item}
               <p>   {field data=$item value=$postData}{/field}
                </p>  {/foreach}
 <p>
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="db"  value='db' id="submit"><i class="icon-ok"></i>Run Index</button>
                                       
                                       
                                    </div>
                 
                 
                  
                  </form>