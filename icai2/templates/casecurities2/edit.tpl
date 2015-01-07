
{include file="notice.tpl"}

<br><br><br><br><br><br> 
 <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="thumb-pad2">
                <div class="thumbnail"> 
                <div class="caption">
                      
                    </div>
                   
                   
                   
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="thumb-pad2">
                <div class="thumbnail"> 
                <div class="caption">
                        <p class="title">Edit Securities</p>
                    </div>
              
                   
                    
                </div>
            </div>
        </div>  
        
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="thumb-pad2">
                <div class="thumbnail"> 
                <div class="caption">
                        <p class="title"></p>
                    </div>
              
                   
                    
                </div>
            </div>
        </div>  
<br />

<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            
                            <div class="box-content" style="background: #293b50 url({$BASE_URL}assets/New/img/pattern3.png) repeat !important;">
                                 <form action="" method="post" onsubmit="return ValidateForm();" id="contact-form" class="form-horizontal">
                                
                                 {foreach from=$fields key=p item=item}
               <p>   {field data=$item value=$postData}{/field}
                </p>  {/foreach}
                                   
                                    <div class="form-actions" style="margin: 0 390px 0px !important; background:none !important;">
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" name="cancel" id="cancel"  onclick="document.location.href='{$BASE_URL}index.php?module=casecurities2';">Back</button>
                                    </div>
                                    
                                    
                               
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>