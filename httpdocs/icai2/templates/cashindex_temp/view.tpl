
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i>Cash Index</h3>
                            </div>
                            <div class="box-content">
                                
                                    
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        
    </thead>
    <tbody>
    
        <tr>
     
            <td>Name</td>
            <td>{$data.name}</td>
          </tr><tr>   <td>Code</td>
            <td>{$data.code}</td>
           </tr><tr>
            <td>ISIN</td>
            <td>{$data.isin}</td>
           </tr><tr>
            <td>Ticker</td>
            <td>{$data.ticker}</td> </tr><tr><td>
         {if $sessData.User.type==3}    <button type="button" class="btn" name="cancel" id="cancel" onClick="document.location.href='{$BASE_URL}index.php?module=cashindextemp&event=approve&id={$data.id}';" >Approve</button>
        {/if}  
        </td><td>  <button type="button" class="btn" name="cancel" id="cancel" onClick="document.location.href='{$BASE_URL}index.php?module=cashindextemp';" >Back</button>
        </td></tr>
     
    </tbody>
</table>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->