<?php /* Smarty version 2.6.14, created on 2014-08-01 13:55:29
         compiled from caindex2/viewupcoming.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'caindex2/viewupcoming.tpl', 218, false),)), $this); ?>
<!-- BEGIN Main Content -->
<?php echo '
<style>
.table-advance tbody>tr:nth-child(odd)>td, .table-advance tbody>tr:nth-child(odd)>th {
background: #293b50 url(\'assets/New/img/pattern.png\') repeat !important;
}
.table-advance tbody>tr:nth-child(even)>td, .table-advance tbody>tr:nth-child(even)>th {
background: #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
}
.table-advance thead {
background: #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
border-left: 4px solid #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
}
.table{
	border-collapse:inherit !important;	
}

.table.fill-head thead{
background: #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;
border-left: 4px solid #e5e9f4 url(\'Assets/New/img/pattern2.png\') repeat !important;	
}
.table-striped > tbody > tr:nth-child(odd) > td, .table-striped > tbody > tr:nth-child(odd) > th {
background: #293b50 url(\'assets/New/img/pattern.png\') repeat !important;	
color:#888 !important;
}
</style>
'; ?>

 <?php echo '
 <script type=\'text/javascript\'>
 
   function confirmdelete(id)
 {

 var temp=confirm("Are you sure you want to delete this record ! All index related data will be deleted!")
  if(temp)
   {	
	
	window.location.href=\'index.php?module=caupcomingindex2&event=delete&id=\'+id;
	}
	else{
	return false;
	}
 }
 
 



$(document).ready(function(){
 $("#deleteSelected").click(function(){
	 
	 var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	 
	 
	 
 var checkedArray=Array();
 var i=0;
  $(\'input[name="checkboxid"]:checked\').each(function() {
i++;
checkedArray[i]=$(this).val();
});
var parameters = {
  "array1":checkedArray
};


$.ajax({
    url : "index.php?module=caupcomingindex2&event=deleteindex",
    type: "POST",
    data : parameters,
    success: function(data, textStatus, jqXHR)
    {
        //data - response from server
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
 
    }
});

}
	else{
	return false;
	}


});
	 
	 
	
	 
 
}); 
 
</script>
 
 '; ?>

 
<br><br><br><br><br><br> <br><br><br> 
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
                        <p class="title">Index Details</p>
                    </div>
              
                   
                    
                </div>
            </div>
        </div>  
 
               
<div class="row-fluid">
                    <div class="span12">
                        <div class="box">                            
                            <div class="box-content" style="background: #293b50 url(<?php echo $this->_tpl_vars['BASE_URL']; ?>
assets/New/img/pattern3.png) repeat !important;">
                            
                            <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Investment Ammount</th>
                                           
                                            <th>Currency</th>
                                            <th>Type</th>
                                            <th>Start Date</th> <th>Calc Date</th>
                                           
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $_from = $this->_tpl_vars['viewindexdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
             <td></td>
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['code']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['investmentammount']; ?>
</td>
        
                <td><?php echo $this->_tpl_vars['point']['curr']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['point']['indexname']; ?>
</td>
                     <td><?php echo $this->_tpl_vars['point']['dateStart']; ?>
</td>
              <td><?php echo $this->_tpl_vars['point']['calcdate']; ?>
</td>
            
        </tr>
        <?php endforeach; endif; unset($_from); ?>
                                    
                                    
                                       
                                    </tbody>
                                </table>
                            
                            
                                
                                <div class="clearfix"></div>
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
                        <p class="title">Total <?php echo $this->_tpl_vars['totalindexSecurityrows']; ?>
 securities found</p>
                    </div>
              
                </div>
            </div>
        </div> 
                                
                                   
                                   
                                
                                <div class="clearfix"></div>
<table class="table table-advance">
    <thead>
        <tr>
          
             <th>Name</th>
              <th>Ticker</th>
              <th>ISIN</th>       
               <th>Weight</th>
              <th>Ticker Currency</th> 
              <th>Dividend Currency</th>
            <!--<th>Effective Date</th>
            <th>Announce Date</th>-->
         </tr>
    </thead>
    <tbody>
    
    <?php if (count($this->_tpl_vars['indexSecurity']) > 0): ?>
    	<?php $_from = $this->_tpl_vars['indexSecurity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
        <tr>
          
            <td><?php echo $this->_tpl_vars['point']['name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['ticker']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['isin']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['weight']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['curr']; ?>
</td>
            <td><?php echo $this->_tpl_vars['point']['divcurr']; ?>
</td>

        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <?php else: ?>
        <tr>
        <td colspan="5" align="center">There is No Securities in this indxx.</td>
        </tr>
        <?php endif; ?>
    
    </tbody>
</table>

 <table class="table table-advance">   <tr><td style="background:none !important; border-top:none !important;">

 <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>
 <?php if ($this->_tpl_vars['viewadmindata']['0']['isAdmin'] == 1): ?>

 <?php if ($this->_tpl_vars['viewindexdata']['0']['submitted'] == 0 && $this->_tpl_vars['viewindexdata']['0']['status'] == 0): ?>
 <a href="index.php?module=caindex2&event=submitapprove&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"><button class="btn btn-success">Submit & Approve</button></a><?php endif; ?>
 
 <?php endif; ?>
 

 <?php if ($this->_tpl_vars['viewindexdata']['0']['status'] == 0): ?>
 <a href="index.php?module=caindex2&event=approvetemp&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"><button class="btn btn-success">Approve</button></a> <?php endif; ?>
 
<?php if ($this->_tpl_vars['viewindexdata']['0']['submitted'] == 0): ?>
 <a href="index.php?module=caindex2&event=reject&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"><button class="btn btn-warning">Reject</button></a><?php endif; ?>
                              
                              
                              
                                    <?php if ($this->_tpl_vars['viewindexdata']['0']['submitted'] == 1 && $this->_tpl_vars['viewindexdata']['0']['status'] == 1 && $this->_tpl_vars['viewindexdata']['0']['usersignoff'] == 1 && $this->_tpl_vars['viewindexdata']['0']['dbusersignoff'] == 1 && $this->_tpl_vars['viewindexdata']['0']['runindex'] == 1 && $this->_tpl_vars['viewindexdata']['0']['finalsignoff'] == 0): ?>
       <a href="index.php?module=caindex2&event=finalsignoff&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"><button class="btn btn-success">Final Signoff</button></a><?php endif; ?>

                              
                                    <a href="#"><button class="btn btn-danger" onclick="confirmdelete(<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
)" id="a1">Delete Index</button></a>
                                    
                                    
                                    
                                    
                                    
  <a href="index.php?module=caindex2&event=exportupcomming&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"><button class="btn btn-warning">Export Index</button></a>
                                    <a href="index.php?module=caupcomingindex2"><button class="btn btn-inverse">Back</button></a>
                                   
                                    
                                    </td></tr>
                                  <?php endif; ?>
                                    
                                 <?php if ($this->_tpl_vars['sessData']['User']['type'] == 2): ?>
 
 <!--<a href="index.php?module=caindex2&event=addSecurity&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
">   <button class="btn btn-primary">Add Securities</button></a>-->

 <?php if ($this->_tpl_vars['viewindexdata']['0']['submitted'] == 0): ?>
 <a href="index.php?module=caindex2&event=subindextemp&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"> <button class="btn btn-success">Submit Index</button></a><?php endif; ?>
  <?php if ($this->_tpl_vars['viewindexdata']['0']['submitted'] == 1 && $this->_tpl_vars['viewindexdata']['0']['usersignoff'] == 0 && $this->_tpl_vars['viewindexdata']['0']['dbusersignoff'] == 1): ?>
                                   <a href="index.php?module=caindex2&event=signofftemp&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
">  <button class="btn btn-info">Sign Off </button></a><?php endif; ?>
                                   <?php if ($this->_tpl_vars['viewindexdata']['0']['submitted'] == 1 && $this->_tpl_vars['viewindexdata']['0']['usersignoff'] == 1 && $this->_tpl_vars['viewindexdata']['0']['dbusersignoff'] == 1 && $this->_tpl_vars['viewindexdata']['0']['runindex'] == 0 && $this->_tpl_vars['viewindexdata']['0']['rebalance'] == 0): ?>
                                   <a href="index.php?module=calcindxxclosingid&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
">  <button class="btn btn-info">Run Index</button></a><?php endif; ?>
                                   
                                   
                               
                           <a href="index.php?module=caindex2&event=exportupcomming&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"><button class="btn btn-warning">Export Index</button></a>    
                                    <a href="index.php?module=caupcomingindex2"><button class="btn btn-inverse">Back</button></a>
                                    <!-- <button class="btn btn-warning">Warning</button>
                                    <button class="btn btn-danger">Delete Index</button>
                                    <button class="btn btn-success">Success</button>
                                    -->
                                    </td></tr>
                                    <?php endif; ?>
                                    
                                    
                                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == 3): ?>
                                    
<?php if ($this->_tpl_vars['viewindexdata']['0']['submitted'] == 0): ?> <a href="index.php?module=caindex2&event=rejectbydbuser&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
"><button class="btn btn-warning">Reject</button></a>   <?php endif; ?>               
 
 <?php if ($this->_tpl_vars['viewindexdata']['0']['dbusersignoff'] == 0): ?><a href="index.php?module=caindex2&event=subrequesttemp&id=<?php echo $this->_tpl_vars['viewindexdata']['0']['id']; ?>
">   <button class="btn btn-primary">Request File Status</button></a><?php endif; ?>
                                   
                                    <a href="index.php?module=caupcomingindex2"><button class="btn btn-inverse">Back</button></a>
                                    <!--  <button class="btn btn-warning">Warning</button>
                                    <button class="btn btn-danger">Delete Index</button>
                                    <button class="btn btn-success">Success</button>-->
                                    
                                    </td></tr>
                                    <?php endif; ?>
                                    
                                    </table>

                            
                            
                           
                             
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                  <!-- END Main Content -->