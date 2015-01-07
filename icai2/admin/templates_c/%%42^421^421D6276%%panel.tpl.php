<?php /* Smarty version 2.6.14, created on 2013-05-22 11:38:58
         compiled from grid/panel.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strstr', 'grid/panel.tpl', 179, false),array('modifier', 'count', 'grid/panel.tpl', 205, false),array('modifier', 'is_array', 'grid/panel.tpl', 232, false),)), $this); ?>
<?php echo '
<script language="javascript">


function sort_col(string) {

document.frm.page.value="1";
document.frm.pagegroup.value="1";

if(document.frm.sortby.value==string)
{
	if(document.frm.sortDirection.value=="up")
	{
		document.frm.sortDirection.value="down";
	}
	else
	{
		document.frm.sortDirection.value="up";
		
	}
}
else
{
	document.frm.sortDirection.value="up";
}

	var sortby=document.frm.sortby.value=string;
	
	
	go(\'sort_col\');
}

function go(string) {
	//
	
	//var records=jQuery(\'#DisplayRecords\').value;
	var records=document.frm.DisplayRecords.value;
	//alert(records);
//	var olderdisplayvalue=document.frm.olderdisplayvalue.value;
	
	if(IsNumeric(records)){
		if(records>0) {
			//form is valid, so take actions if any befor submitting it
			//the following if conditions are reserved for future use
			if(string==\'Move_To_Previous_Page\')document.frm.submit();
			if(string==\'Move_To_Next_Page\')document.frm.submit();
			if(string==\'with_selected_function\')document.frm.submit();
			if(string==\'ShowThisPage\')document.frm.submit();
			if(string==\'sort_col\')document.frm.submit();
			if(string==\'submit\')document.frm.submit();
			if((string==\'sponsor\')||(string==\'rockman\')) {
				if(check_date()) return true;
				else return false;
			}
			
			if(string==\'DisplayRecordsGo\') {
				//document.frm.ShowThisPage.value=0;
				//document.frm.checkval.value=1;
				document.frm.submit();
			}
		} 
		//else {alert(\'Please enter a valid number of records per page\'); document.frm.DisplayRecords.value=olderdisplayvalue; return false;}
	} else  { alert(\'Please enter a valid number of records per page\'); document.frm.DisplayRecords.value=olderdisplayvalue; return false;}
}
function IsNumeric(sText)
{
  //alert(sText);
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;

 
   for ( i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }

function check_all() {
	
	var counter=document.frm.counter_start.value;
	var counter_end=document.frm.limit.value;
	counter_end=(counter*1)+(counter_end*1);
	//alert("counter="+counter+" end="+counter_end);
	
	var i=0;
	for (i=counter;i<=counter_end;i++) {
		var checkbox=\'check_\'+i;
		try {
			document.getElementById(checkbox).checked=true;
		}catch(e){}
	}
}

function uncheck_all() {
    var counter=document.frm.counter_start.value;
	var counter_end=document.frm.limit.value;
	counter_end=(counter*1)+(counter_end*1);
    var i=0;
	for (i=counter;i<=counter_end;i++) {
		var checkbox=\'check_\'+i;
		try {
			document.getElementById(checkbox).checked=false;
		}catch(e){}
	}
}

function with_selected_function() {
	var counter=document.frm.counter_start.value;
	var counter_end=document.frm.limit.value;
	counter_end=(counter*1)+(counter_end*1);
	var i=0,checked;
	for (i=counter;i<=counter_end;i++) {
		var checkbox=\'check_\'+i;
		try {
			if(document.getElementById(checkbox).checked) checked=true;
		}catch(e){}
	}
	if(checked) {
		var selected_value=document.getElementById(\'with_selected\').value;
		if(selected_value==4) {
			var temp=confirm("Are you sure you want to delete");
			if(temp) {
				document.frm.change_selection.value=1;
				go(\'with_selected_function\');
			}else {document.getElementById(\'with_selected\').value=\'\';uncheck_all();}
		} else {
				document.frm.change_selection.value=1;
				go(\'with_selected_function\');
		}
	} else { alert("Please Select at least 1 item."); }
}

function updateRecord(id,status,chkid)
{

	document.getElementById(\'check_\'+chkid).checked=true

	document.frm.change_selection.value=1;
	
	
	document.getElementById(\'with_selected\').value = status;
	
	go(\'with_selected_function\');


  // window.location="manage-banner.php?" + id;
}
function delete_member(id,status,chkid) {
	
  var temp=confirm("Are you sure you want to delete this record ")
  if(temp)
   {	
	  updateRecord(id,status,chkid)
  }
}


</script>
'; ?>

<form action="index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
" method="get" name="frm" onSubmit="go('DisplayRecordsGo')">
   		  <input type="hidden" id="sortby" name='sortby' value="<?php echo $this->_tpl_vars['sortby']; ?>
">
		  <input type="hidden" id="sortDirection" name='sortDirection' value="<?php echo $this->_tpl_vars['sortDirection']; ?>
">
          <input type="hidden" id='submit_frm' name='submit_frm' value="">
          <input type="hidden" id="limit" name='limit' value="<?php echo $this->_tpl_vars['DisplayRecords']; ?>
">

          <input type="hidden" id="change_selection" name="change_selection" value="">
		  <input type="hidden" id="module" name="module" value="<?php echo $this->_tpl_vars['currentClass']; ?>
">
		  <input type="hidden" id="event" name="event" value="<?php echo $this->_tpl_vars['currentFunction']; ?>
">
		  <input type="hidden" id="page" name="page" value="<?php echo $this->_tpl_vars['page']; ?>
">
		  <input type="hidden" id="pagegroup" name="pagegroup" value="<?php echo $this->_tpl_vars['pagegroup']; ?>
">
		  <?php $_from = $_GET; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['HiddenVars']):
?>
          <?php if (! in_array ( $this->_tpl_vars['key'] , $this->_tpl_vars['hiddenVarsSystem'] ) && ! ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('strstr', true, $_tmp, 'check_') : strstr($_tmp, 'check_')) && ! ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('strstr', true, $_tmp, 'display') : strstr($_tmp, 'display'))): ?>
          	<input type="hidden" name="<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['HiddenVars']; ?>
">
          <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>
		  <?php if ($this->_tpl_vars['panelHiddenVar']): ?>
			<?php $_from = $this->_tpl_vars['panelHiddenVar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenVars']):
?>
				 <input type="hidden" name="<?php echo $this->_tpl_vars['HiddenVars']['name']; ?>
" value="<?php echo $this->_tpl_vars['HiddenVars']['value']; ?>
">
		
          <?php endforeach; endif; unset($_from); ?>
		  
		  <?php endif; ?>

                
                
      <div class="bottom-spacing">
        <!-- Button -->
     <?php if ($this->_tpl_vars['gridItemDiabled']['add']): ?>
	 	<?php if ($this->_tpl_vars['addNewLink']): ?>
		<div class="float-right"> <a href="<?php echo $this->_tpl_vars['addNewLink']; ?>
" class="button"> <span>Add New <img src="assets/images/plus-small.gif" width="12" height="9" alt="New article" /></span> </a> </div>
		<?php else: ?>
	    <div class="float-right"> <a href="index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
&event=addNew" class="button"> <span>Add New <img src="assets/images/plus-small.gif" width="12" height="9" alt="New article" /></span> </a>
        <?php if ($this->_tpl_vars['currentClass'] == 'ccharacteristics' || $this->_tpl_vars['currentClass'] == 'cbreakdown' || $this->_tpl_vars['currentClass'] == 'cconstituents'): ?>
        <a href="index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
&event=upload" class="button"> <span>Upload CSV <img src="assets/images/plus-small.gif" width="12" height="9" alt="Upload" /></span> </a> 
	<?php endif; ?></div>
    	<?php endif; ?>
	 <?php endif; ?>
	<?php if (count($this->_tpl_vars['gridData']) > 0): ?> 
        <div  style='float:left;'>
           <?php echo $this->_tpl_vars['gridDisplayRecords']; ?>
 | Show
          <input type="text" id="DisplayRecords" name='DisplayRecords' value="<?php echo $this->_tpl_vars['DisplayRecords']; ?>
" size=2 style="height:13px;font-size:12px;">
          records per page  &nbsp;
          <div class="float-right"> <a href="javascript:void(0)" onClick="javascript:go('DisplayRecordsGo');" class="button"> <span>Go&nbsp;</span> </a></div>
          
       
		  
        </div>
	<?php endif; ?>
        <br />
      </div>
      <div class="module">
        <h2><span><?php echo $this->_tpl_vars['gridHeading']; ?>
</span></h2>
        <div class="module-table-body">
          
		 
		  <table id="myTable" class="tablesorter">
<thead>
<tr>
<?php if ($this->_tpl_vars['gridItemDiabled']['status'] || $this->_tpl_vars['gridItemDiabled']['delete']): ?>
<td></td>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['tabHeading']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['heading']):
?>

<td><?php if (((is_array($_tmp=$this->_tpl_vars['heading']['search'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
	 <?php ob_start(); ?>1<?php $this->_smarty_vars['capture']['searcEnabled'] = ob_get_contents(); ob_end_clean(); ?> 
<?php if ($this->_tpl_vars['heading']['search']['type'] == 'text'): ?>
<input type="text" name="searchFeilds[<?php echo $this->_tpl_vars['heading']['search']['name']; ?>
]" class="input-long" style="width:98%" value="<?php echo $this->_tpl_vars['searchVars'][$this->_tpl_vars['heading']['search']['name']]; ?>
" />
<?php endif; ?>

<?php if ($this->_tpl_vars['heading']['search']['type'] == 'select'): ?>
<select  name="searchFeilds[<?php echo $this->_tpl_vars['heading']['search']['name']; ?>
]" class="input-long" style="width:98%">
<option value="">All</option>
<?php $_from = $this->_tpl_vars['heading']['search']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['z'] => $this->_tpl_vars['searchVal']):
?>
<option value="<?php echo $this->_tpl_vars['z']; ?>
" <?php if ($this->_tpl_vars['searchVars'][$this->_tpl_vars['heading']['search']['name']] == $this->_tpl_vars['z'] && $this->_tpl_vars['searchVars'][$this->_tpl_vars['heading']['search']['name']] != ""): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['searchVal']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select>
</td>
<?php endif; ?>

<?php endif; ?></td>
<?php endforeach; endif; unset($_from); ?>
<td align="center"><?php if ($this->_smarty_vars['capture']['searcEnabled'] == 1): ?><input type="submit" name="search" value="Search" class="submit-gray"/><?php endif; ?></td>
</tr>

<tr>
<?php if ($this->_tpl_vars['gridItemDiabled']['status'] || $this->_tpl_vars['gridItemDiabled']['delete']): ?>
<th width="20" style="text-align:center;">#</th>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['tabHeading']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['heading']):
?>
<th title="<?php if ($this->_tpl_vars['heading']['tooltip'] != ''):  echo $this->_tpl_vars['heading']['tooltip'];  else:  echo $this->_tpl_vars['heading']['title'];  endif; ?>" style="cursor:pointer;"  <?php if ($this->_tpl_vars['heading']['sortby']): ?>class="header<?php if ($this->_tpl_vars['heading']['sortby'] == $this->_tpl_vars['sortby']):  if ($this->_tpl_vars['sortDirection'] == 'up'): ?> headerSortUp<?php else: ?> headerSortDown<?php endif;  endif; ?>" onclick="javascript:sort_col('<?php echo $this->_tpl_vars['heading']['sortby']; ?>
');"<?php endif; ?>><?php echo $this->_tpl_vars['heading']['title']; ?>
</th>
<?php endforeach; endif; unset($_from); ?>
<th <?php if ($this->_tpl_vars['currentClass'] == 'newslettercontent'): ?> width="180px"<?php else: ?> width="70px"<?php endif; ?>>Action</th>
</tr>
</thead>
 <?php if (count($this->_tpl_vars['gridData']) > 0): ?> 
<tbody>
         <input type='hidden' id='counter_start' name='counter_start' value='0'>
	<?php $_from = $this->_tpl_vars['gridData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['dataList']):
?>	

			 <?php ob_start();  if ($this->_tpl_vars['k'] % 2 == 0): ?>even<?php else: ?>odd<?php endif;  $this->_smarty_vars['capture']['classornot'] = ob_get_contents(); ob_end_clean(); ?> 
              <tr class="<?php echo $this->_smarty_vars['capture']['classornot']; ?>
">
               <?php if ($this->_tpl_vars['gridItemDiabled']['status'] || $this->_tpl_vars['gridItemDiabled']['delete']): ?> <td class="align-center"><input name='check_<?php echo $this->_tpl_vars['k']; ?>
' id='check_<?php echo $this->_tpl_vars['k']; ?>
' type='checkbox' style='size:10px;border:0px;' value='<?php echo $this->_tpl_vars['dataList']['id']; ?>
'>
				</td><?php endif; ?>
				
				<?php $_from = $this->_tpl_vars['tabHeading']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['heading']):
?>
           
                	<td><?php if ($this->_tpl_vars['heading']['coloum_type'] == 'image'): ?>
                    <img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
media/<?php echo $this->_tpl_vars['heading']['folder']; ?>
/thumb/<?php echo $this->_tpl_vars['dataList'][$this->_tpl_vars['heading']['coloum']]; ?>
" />
                    <?php else:  echo $this->_tpl_vars['dataList'][$this->_tpl_vars['heading']['coloum']];  endif; ?></td>
				
				<?php endforeach; endif; unset($_from); ?>
				
                
                
                
                
                <?php if ($this->_tpl_vars['currentClass'] == 'urgentpets' || $this->_tpl_vars['currentClass'] == 'urgentpetinfo'): ?>
                <td align="center" style="width:90px;">
                <?php elseif ($this->_tpl_vars['currentClass'] == 'pettransport'): ?>
                <td align="center" style="width:150px;">
                <?php else: ?>
                <td align="center">
                <?php endif; ?>
                              <?php $_from = $this->_tpl_vars['gridButtons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p'] => $this->_tpl_vars['item']):
?>
                   
                    <a href="index.php?module=<?php echo $this->_tpl_vars['item']['module'];  if ($this->_tpl_vars['item']['event']): ?>&event=<?php echo $this->_tpl_vars['item']['event'];  endif;  $_from = $this->_tpl_vars['item']['id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subIds'] => $this->_tpl_vars['subId']):
?>&<?php echo $this->_tpl_vars['subIds']; ?>
=<?php echo $this->_tpl_vars['dataList'][$this->_tpl_vars['subId']];  endforeach; endif; unset($_from); ?>" class='a2'><?php echo $this->_tpl_vars['item']['title']; ?>
 <?php if ($this->_tpl_vars['item']['title']): ?>|<?php endif; ?>
                    
                    		</a>	 
					<?php endforeach; endif; unset($_from); ?>
			 <?php ob_start();  if ($this->_tpl_vars['dataList']['status'] == '0'): ?>minus-circle.gif<?php else: ?>tick-circle.gif<?php endif;  $this->_smarty_vars['capture']['statusImage'] = ob_get_contents(); ob_end_clean(); ?> 	
			 <?php ob_start();  if ($this->_tpl_vars['dataList']['status'] == '0'): ?>1<?php else: ?>0<?php endif;  $this->_smarty_vars['capture']['statusCurrent'] = ob_get_contents(); ob_end_clean(); ?> 	
			
			<?php if ($this->_tpl_vars['gridItemDiabled']['status']): ?> 	
				<a href="javascript:updateRecord('<?php echo $this->_tpl_vars['dataList']['id']; ?>
','<?php echo $this->_smarty_vars['capture']['statusCurrent']; ?>
','<?php echo $this->_tpl_vars['k']; ?>
')" class='a2'><img src="assets/images/<?php echo $this->_smarty_vars['capture']['statusImage']; ?>
" width="16" height="16"  /></a> 
				 
			<?php endif; ?>	
				
				<?php if ($this->_tpl_vars['gridItemDiabled']['edit']): ?>
					<?php if ($this->_tpl_vars['editLink']): ?>
					<a href="<?php echo $this->_tpl_vars['editLink'];  echo $this->_tpl_vars['dataList']['id'];  echo $this->_tpl_vars['backVars']; ?>
"><img src="assets/images/pencil.gif" width="16" height="16" alt="edit" title="edit" /></a>
					<?php else: ?>
					<a href="index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
&event=edit&edit=1&id=<?php echo $this->_tpl_vars['dataList']['id'];  echo $this->_tpl_vars['backVars']; ?>
"><img src="assets/images/pencil.gif" width="16" height="16" alt="edit" title="edit" /></a>
					<?php endif; ?>
				<?php endif; ?>
				
				<?php if ($this->_tpl_vars['gridItemDiabled']['view']): ?><a href="index.php?module=<?php echo $this->_tpl_vars['currentClass']; ?>
&event=view&id=<?php echo $this->_tpl_vars['dataList']['id']; ?>
&filter=<?php echo $this->_tpl_vars['filter']; ?>
&DisplayRecords=<?php echo $this->_tpl_vars['DisplayRecords']; ?>
&ShowThisPage=<?php echo $this->_tpl_vars['ShowThisPage']; ?>
&sortby=<?php echo $this->_tpl_vars['sortby']; ?>
&sortDirection=<?php echo $this->_tpl_vars['sortDirection']; ?>
&page=<?php echo $this->_tpl_vars['page']; ?>
&pagegroup=<?php echo $this->_tpl_vars['pagegroup']; ?>
"><img src="assets/images/view.gif"  alt="view" title="view" /></a><?php endif; ?>
				
				<?php if ($this->_tpl_vars['gridItemDiabled']['delete']): ?><a href="javascript:delete_member('<?php echo $this->_tpl_vars['dataList']['id']; ?>
','4','<?php echo $this->_tpl_vars['k']; ?>
')"><img src="assets/images/bin.gif" width="16" height="16" alt="delete" title="delete" /></a><?php endif; ?> </td>
                
                
                
                
                
                
                
                
                
                
              </tr>
        <?php endforeach; endif; unset($_from); ?>     
            </tbody>
			<?php else: ?>
		<tbody>
		 <?php ob_start();  echo count($this->_tpl_vars['tabHeading']);  $this->_smarty_vars['capture']['rowCount'] = ob_get_contents(); ob_end_clean(); ?> 	
		<td colspan="<?php echo $this->_smarty_vars['capture']['rowCount']+2; ?>
"> <div style="padding:50px" align="center">No Record Found</div></td>
		
		</tbody>
		  
          <?php endif; ?>
          </table>
		 <?php if ($this->_tpl_vars['gridItemDiabled']['status'] || $this->_tpl_vars['gridItemDiabled']['delete']): ?>
          <div class="pager" id="pager">
            <div> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <img src="assets/images/arrow-curve-000-left.gif"> <a href="javascript:check_all();"><font>check all</font> </a> / <a href="javascript:uncheck_all();"><font >uncheck all </font> </a>&nbsp;</a> </div>
          </div>
          <div class="table-apply">
            <div> <span>Apply action to selected:</span>
              <select id='with_selected' name='with_selected'  class="input-medium" onChange="javascript:with_selected_function();">
                <option value="">--with selected--</option>
             <?php if ($this->_tpl_vars['gridItemDiabled']['status']): ?>    <option value="1">Active</option>
                <option value="0">Inactive</option>
			<?php endif; ?>
                <?php if ($this->_tpl_vars['gridItemDiabled']['delete']): ?><option value="4">Delete</option><?php endif; ?>
              </select>
            </div>
          </div>
		  <?php endif; ?>
          
          <div style="clear: both"></div>
        </div>
        <!-- End .module-table-body -->
      </div>
     <div class="pagination">
       
    
         
   
          
         
         
          
           <?php echo $this->_tpl_vars['displayPaging']; ?>

         
          
         
        
      </div>
    </form>