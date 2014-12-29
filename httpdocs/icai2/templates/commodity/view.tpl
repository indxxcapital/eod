<!-- BEGIN Main Content -->




<div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i></h3>
                            </div>
                            <div class="box-content">
                                <div class="btn-toolbar pull-right clearfix">
                                    <div class="btn-group">
                                    
                                    <a class="btn btn-circle show-tooltip" title="Assign new index" href="index.php?module=assignindex&id={$sessData.Delete.UserId}"><i class="icon-plus"></i></a>
                                     <a class="btn btn-circle show-tooltip" title="Delete selected" id="deleteSelected" href="#"><i class="icon-trash"></i></a>
                                        
                                        <!--<a class="btn btn-circle show-tooltip" title="Print" href="#"><i class="icon-print"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Export to Excel" href="index.php?module=users&event=exportExcel"><i class="icon-table"></i></a>-->
                                    </div>
                                        <!--<a class="btn btn-circle show-tooltip" title="Edit selected" href="#"><i class="icon-edit"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Delete selected" href="#"><i class="icon-trash"></i></a>-->
                                    </div>
                                    <div class="btn-group">
                                        
                                        <!--<a class="btn btn-circle show-tooltip" title="Export to PDF" href="#"><i class="icon-file-text-alt"></i></a> <a class="btn btn-circle show-tooltip" title="Print" href="#"><i class="icon-print"></i></a>
                                        <a class="btn btn-circle show-tooltip" title="Export to Excel" href="#"><i class="icon-table"></i></a>
                                        
                                    <!--<div class="btn-group">
                                        <a class="btn btn-circle show-tooltip" title="Refresh" href="#"><i class="icon-repeat"></i></a>
                                    </div>-->
                                </div>
                                <div class="clearfix"></div>
<table class="table table-advance" id="table1">
    <thead>
        <tr>
            <th>Name</th>
            <th >Code</th>
        </tr>
    </thead>
    <tbody>
    	
        <tr>
            <td>{$tickerdata.name}</td>
                       <td>{$tickerdata.code}</td>

        </tr>
    
    
    </tbody>
</table>


<form method="post">

<input type="hidden" name="id" value="{$tickerdata.id}" />


 <label>&nbsp;</label>
                 <div class="form-actions">
                                   { if $tickerdata.status==0 &&  $sessData.User.type==1}  
                                    <input type="hidden" name="statusfield" value="1" />
                                  <input type="hidden" name="status" value="{$tickerdata.status}" />
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"  value="1"><i class="icon-ok"></i>
                                      Approve </button>{/if}
                                     { if $tickerdata.dbstatus==0 &&  $sessData.User.type==3} 
                                          <input type="hidden" name="dbstatusfield" value="1" /> 
                                     <input type="hidden" name="dbstatus" value="{$tickerdata.status}" />
                                       <button type="submit" class="btn btn-primary" name="submit" id="submit"  value="1"><i class="icon-ok"></i>
                                      Approve </button>{/if}
                                      
                                       <button type="button" class="btn" name="cancel" id="cancel"  onClick="document.location.href='{$BASE_URL}index.php?module=commodityticker';">Back</button>
                                    </div>
                 </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->