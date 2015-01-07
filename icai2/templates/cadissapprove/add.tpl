 <!-- BEGIN Main Content -->
 {include file="notice.tpl"}
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Select Corporate Action To make Inactive </h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" class="form-horizontal">
                             
                       {if $cas|@count>0}
<table class="table table-advance" id="table1">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox" /></th>
            <th>Ticker</th>
            <th>Bloomberg Action ID</th>
            <th>Corporate action code</th>
          <th>Company Name</th>
            <th>Announce Date</th>
            <th>Effective Date</th>
            
            
           
        </tr>
    </thead>
    <tbody>
    	{foreach from=$cas item=point key=k}
        <tr>
            <td><input type="checkbox" id="checkboxid"  name="checkboxid[]" value="{$point.action_id}" /></td>
            <td>{$point.identifier}</td>
            <td>{$point.action_id}</td>
            <td>{$point.mnemonic}</td>
            <td>{$point.company_name}</td>
            <td>{$point.ann_date}</td>
              <td>{$point.eff_date}</td>
         
          
        </tr>
        {/foreach}
      
    </tbody>
</table>
{/if}
             
              
                 
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onClick="document.location.href='{$BASE_URL}index.php?module=caindex';">Back</button>
                                    </div>
                 
                 
                  
                  </form>
                            </div>
                        </div>
                    </div>
                </div>
                
 <!-- END Main Content -->