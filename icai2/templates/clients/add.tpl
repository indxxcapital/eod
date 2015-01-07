 <!-- BEGIN Main Content -->
  
 {include file="notice.tpl"}
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>Add New Client</h3>
                            </div>
                            <div class="box-content">
                             <form action="" method="post" onsubmit="return ValidateForm();" class="form-horizontal">
                             
                              
    {foreach from=$fields key=p item=item}
               <p>   {field data=$item value=$postData}{/field}
                </p>  {/foreach}
 <p>
                 <label>&nbsp;</label>
                 <div class="form-actions">
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel" onClick="document.location.href='{$BASE_URL}index.php?module=clients';" >Back</button>
                                       
                                    </div>
                 
                 
                  
                  </form>
                                 <!--<form action="#" class="form-horizontal">
                                    <div class="control-group">
                                       <label class="control-label">Index Name</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Index Code</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Investment Amount</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Divisor</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                        
                                       </div>
                                    </div>
                                    
                                    
                                    <div class="control-group">
                                       <label class="control-label">Type</label>
                                       <div class="controls">
                                          <select class="input-xlarge" tabindex="1">
                                             <option value="Category 1">Category 1</option>
                                             <option value="Category 2">Category 2</option>
                                             <option value="Category 3">Category 5</option>
                                             <option value="Category 4">Category 4</option>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    
                                    <div class="control-group">
                                       <label class="control-label">Currency</label>
                                       <div class="controls">
                                          <input type="text" placeholder="xlarge" class="input-xlarge" />
                                          <span class="help-inline">Some hint here</span>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>-->
                            </div>
                        </div>
                    </div>
                </div>
                
 <!-- END Main Content -->