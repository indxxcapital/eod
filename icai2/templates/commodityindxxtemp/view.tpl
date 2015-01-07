<!-- BEGIN Main Content -->
       
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>Index Details </h3>
                            </div>
                            
                           
                            
                            
                            
                            
                            
                            <div class="box-content">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                             <th>Start Date</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {foreach from=$indxxdata item=point key=k}
        <tr>
             <td></td>
            <td>{$point.name}</td>
            <td>{$point.code}</td>
              <td>{$point.datestart}</td>
        </tr>
        {/foreach}
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                            
                                
                                <div class="clearfix"></div>
                                 <div class="box">
                                 <div class="box-title">
                                <h3><i class="icon-table"></i>Total {$indxxfactordatacount} Index Calculation factor found</h3>
                            </div>
                              </div>  
                                
                                <div class="clearfix"></div>
<table class="table table-advance">
    <thead>
        <tr>
           <th>#</th>
             <th>Name</th>
              
              <th>Adj. Factor</th>       
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         </tr>
    </thead>
    <tbody>
    
    {if $indxxfactordata|@count>0}
    	{foreach from=$indxxfactordata item=point key=k}
        <tr>
          <td>{$k+1}</td>
            <td>{$point.name}</td>
          
            <td>{$point.weight}</td>
 
        </tr>
        {/foreach}
        {else}
        <tr>
        <td colspan="4" align="center">There is No Securities in this indxx.</td>
        </tr>
        {/if}
    
    </tbody>
</table>

 <table class="table table-advance">   <tr><td>
 
 
 {if $sessData.User.type==1}

 {if $indxxdata.0.status!=1}
  <a href="index.php?module=commodityindxxtemp&event=approve&id={$indxxdata.0.id}"><button class="btn btn-primary">Approve</button></a>
                                   
 {/if}
 
 
   <a href="index.php?module=commodityindxxtemp&event=delete&id={$indxxdata.0.id}"><button class="btn btn-inverse">Delete</button></a>
 
                                    <a href="index.php?module=commodityindxxtemp"><button class="btn btn-inverse">Back</button></a>
                                   
                                    
                                    </td></tr>
                                    {/if}
                                    
                                    
                                 {if $sessData.User.type==2}
 

                                    
                                    <a href="index.php?module=commodityindxxtemp"><button class="btn btn-inverse">Back</button></a>
                                 
                                    </td></tr>
                                    {/if}
                                    
                                    
                                    {if $sessData.User.type==3}

                                   
                                    <a href="index.php?module=commodityindxxtemp"><button class="btn btn-inverse">Back</button></a>
                                   
                                    </td></tr>
                                    {/if}
                                    
                                    </table>

                            
                            
                           
                             
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->