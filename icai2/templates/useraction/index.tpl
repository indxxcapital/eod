<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Run Your Action</h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal">
                             
                              
    {foreach from=$fields key=p item=item}
               <p>   {field data=$item value=$postData}{/field}
                </p>  {/foreach}
 <p>
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="ca"  value='ca' id="submit"><i class="icon-ok"></i> Run Corporate action</button>
                                       <button type="submit" class="btn btn-primary" name="open"  value='opening' id="submit"><i class="icon-ok"></i> Run Opening</button>
                                         <button type="submit" class="btn btn-primary" name="close"  value='closing' id="submit"><i class="icon-ok"></i> Run Closing</button>
                                       
                                       
                                    </div>
                 
                 
                  
                  </form>