 <!-- BEGIN Main Content -->
 {include file="notice.tpl"}
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Select Securities To Replace </h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" enctype="multipart/form-data" class="form-horizontal">
                             
                       {if $cas|@count>0}
<table class="table table-advance" id="table1">
    <thead>
        <tr>
            <th style="width:18px"><input type="checkbox" /></th>
            <th>Name</th>
            <th>Isin</th>
            <th>Ticker</th>
          <th>Weight</th>
            <th>Currency</th>
            <th>DivCurrency</th>
            
            
           
        </tr>
    </thead>
    <tbody>
    	{foreach from=$cas item=point key=k}
        <tr>
            <td><input type="checkbox" id="checkboxid"  name="checkboxid[]" value="{$point.id}" /></td>
            <td>{$point.name}</td>
            <td>{$point.isin}</td>
            <td>{$point.ticker}</td>
            <td>{$point.weight}</td>
            <td>{$point.curr}</td>
              <td>{$point.divcurr}</td>
         
          
        </tr>
        {/foreach}
      
    </tbody>
</table>
{/if}
             
              
                 
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onClick="document.location.href='{$BASE_URL}index.php?module=replacerunningsecurities';">Back</button>
                                    </div>
                 
                 
                  
                  </form>
                            </div>
                        </div>
                    </div>
                </div>
                
 <!-- END Main Content -->