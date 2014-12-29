<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i>View Security</h3>
                                                </div>
                            <div class="box-content">
                                 <form action="" class="form-horizontal">
                                
                                 
                                    <div class="control-group">
                                       <label class="control-label">Name</label>
                                       <div class="controls">
                                          <input type="text"  readonly type="text" class="input-xlarge" value="{$viewdata.name}" />
                                          
                                       </div>
                                    </div>
                                   
                                    <div class="control-group">
                                       <label class="control-label">Isin</label>
                                       <div class="controls">
                                          <input type="text" readonly type="text" class="input-xlarge" value="{$viewdata.isin}" />
                                          
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Ticker</label>
                                       <div class="controls">
                                          <input type="text" readonly type="text" class="input-xlarge" value="{$viewdata.ticker}" />
                                          
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Weight</label>
                                       <div class="controls">
                                          <input type="text" readonly type="text" class="input-xlarge" value="{$viewdata.weight}" />
                                          
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Index</label>
                                       <div class="controls">
                                          <input type="text" readonly type="text" class="input-xlarge" value="{$viewdata.indexname}" />
                                          
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Currency</label>
                                       <div class="controls">
                                          <input type="text" readonly type="text" class="input-xlarge" value="{$viewdata.curr}" />
                                          
                                       </div>
                                    </div>
                                   
                                    <div class="form-actions">
                                       <button type="button" class="btn" onclick="document.location.href='{$BASE_URL}index.php?module=casecurities';">Back</button>
                                    </div>
                                    
                                    
                               
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>