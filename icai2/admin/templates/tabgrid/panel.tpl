{literal}
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
	
	
	go('sort_col');
}

function go(string) {
	
	var records=document.frm.DisplayRecords.value;
//	var olderdisplayvalue=document.frm.olderdisplayvalue.value;
	
	if(IsNumeric(records)){
		if(records>0) {
			//form is valid, so take actions if any befor submitting it
			//the following if conditions are reserved for future use
			if(string=='Move_To_Previous_Page')document.frm.submit();
			if(string=='Move_To_Next_Page')document.frm.submit();
			if(string=='with_selected_function')document.frm.submit();
			if(string=='ShowThisPage')document.frm.submit();
			if(string=='sort_col')document.frm.submit();
			if(string=='submit')document.frm.submit();
			if((string=='sponsor')||(string=='rockman')) {
				if(check_date()) return true;
				else return false;
			}
			
			if(string=='DisplayRecordsGo') {
				//document.frm.ShowThisPage.value=0;
				//document.frm.checkval.value=1;
				document.frm.submit();
			}
		} 
		//else {alert('Please enter a valid number of records per page'); document.frm.DisplayRecords.value=olderdisplayvalue; return false;}
	} else  { alert('Please enter a valid number of records per page'); document.frm.DisplayRecords.value=olderdisplayvalue; return false;}
}
function IsNumeric(sText)
{
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
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
		var checkbox='check_'+i;
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
		var checkbox='check_'+i;
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
		var checkbox='check_'+i;
		try {
			if(document.getElementById(checkbox).checked) checked=true;
		}catch(e){}
	}
	if(checked) {
		var selected_value=document.getElementById('with_selected').value;
		if(selected_value==4) {
			var temp=confirm("Are you sure you want to delete");
			if(temp) {
				document.frm.change_selection.value=1;
				go('with_selected_function');
			}else {document.getElementById('with_selected').value='';uncheck_all();}
		} else {
				document.frm.change_selection.value=1;
				go('with_selected_function');
		}
	} else { alert("Please Select at least 1 item."); }
}

function updateRecord(id,status,chkid)
{

	document.getElementById('check_'+chkid).checked=true

	document.frm.change_selection.value=1;
	
	
	document.getElementById('with_selected').value = status;
	
	go('with_selected_function');


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
{/literal}
<form action="index.php?module={$currentClass}" method="get" name="frm" onSubmit="go('DisplayRecordsGo')">
   		  <input type="hidden" id="sortby" name='sortby' value="{$sortby}">
		  <input type="hidden" id="sortDirection" name='sortDirection' value="{$sortDirection}">
          <input type="hidden" id='submit_frm' name='submit_frm' value="">
          <input type="hidden" id="limit" name='limit' value="{$DisplayRecords}">

          <input type="hidden" id="change_selection" name="change_selection" value="">
		  <input type="hidden" id="module" name="module" value="{$currentClass}">
		  <input type="hidden" id="event" name="event" value="{$currentFunction}">
		  <input type="hidden" id="page" name="page" value="{$page}">
		  <input type="hidden" id="pagegroup" name="pagegroup" value="{$pagegroup}">
		  {if $panelHiddenVar}

			{foreach from=$panelHiddenVar item=HiddenVars}
				 <input type="hidden" name="{$HiddenVars.name}" value="{$HiddenVars.value}">
			{/foreach}
		  
		  {/if}
      <div class="bottom-spacing">
        <!-- Button -->
     {if $gridItemDiabled.add}
	 	{if $addNewLink}
		<div class="float-right"> <a href="{$addNewLink}" class="button"> <span>Add New <img src="assets/images/plus-small.gif" width="12" height="9" alt="New article" /></span> </a> </div>
		{else}
	    <div class="float-right"> <a href="index.php?module={$currentClass}&event=addNew" class="button"> <span>Add New <img src="assets/images/plus-small.gif" width="12" height="9" alt="New article" /></span> </a> </div>
		{/if}
	 {/if}
	{if $gridData|@count>0} 
        <div  style='float:left;'>
           {$gridDisplayRecords} | Show
          <input type="text" id="DisplayRecords" name='DisplayRecords' value="{$DisplayRecords}" size=2 style="height:13px;font-size:12px;">
          records per page  &nbsp;
          <div class="float-right"> <a href="javascript:void(0)" onClick="javascript:go('DisplayRecordsGo');" class="button"> <span>Go&nbsp;</span> </a></div>
          
       
		  
        </div>
	{/if}
        <br />
      </div>
      <div class="module">
        <h2><span>{$gridHeading}</span></h2>
        <div class="module-table-body">
          
		 
		  <table id="myTable" class="tablesorter">
<thead>
<tr>
{if $gridItemDiabled.status || $gridItemDiabled.delete}
<td></td>
{/if}

{foreach from=$tabHeading item=heading key=p}

<td>{if $heading.search|is_array}
	 {capture name="searcEnabled"}1{/capture} 
{if $heading.search.type=="text"}
<input type="text" name="searchFeilds[{$heading.search.name}]" class="input-long" style="width:98%" value="{$searchVars[$heading.search.name]}" />
{/if}

{if $heading.search.type=="select"}
<select  name="searchFeilds[{$heading.search.name}]" class="input-long" style="width:98%">
<option></option>
{foreach from=$heading.search.values item=searchVal key=z}
<option value="{$z}" {if $searchVars[$heading.search.name] == $z && $searchVars[$heading.search.name]!=""}selected="selected"{/if}>{$searchVal}</option>
{/foreach}
</select>

{/if}

{/if}</td>
{/foreach}
<td align="center">{if $smarty.capture.searcEnabled==1}<input type="submit" name="search" value="Search" class="submit-gray"/>{/if}</td>
</tr>

<tr>
{if $gridItemDiabled.status || $gridItemDiabled.delete}
<th>#</th>
{/if}

{foreach from=$tabHeading item=heading key=p}
<th  {if $heading.sortby}class="header{if $heading.sortby==$sortby}{if $sortDirection=="up"} headerSortUp{else} headerSortDown{/if}{/if}" onclick="javascript:sort_col('{$heading.sortby}');"{/if}>{$heading.title}</th>
{/foreach}
<th>Action</th>
</tr>
</thead>
 {if $gridData|@count>0} 
<tbody>
         <input type='hidden' id='counter_start' name='counter_start' value='0'>
	{foreach from=$gridData item=dataList key=k}	
		     
			 {capture name="classornot"}{if $k % 2 == 0}even{else}odd{/if}{/capture} 
              <tr class="{$smarty.capture.classornot}">
               {if $gridItemDiabled.status || $gridItemDiabled.delete} <td class="align-center"><input name='check_{$k}' id='check_{$k}' type='checkbox' style='size:10px;border:0px;' value='{$dataList.id}'>
				</td>{/if}
				
				{foreach from=$tabHeading item=heading key=p}
           
                	<td>{$dataList[$heading.coloum]}</td>
				
				{/foreach}
				
                <td align="center" >
			 {capture name="statusImage"}{if $dataList.status == '0'}minus-circle.gif{else}tick-circle.gif{/if}{/capture} 	
			 {capture name="statusCurrent"}{if $dataList.status == '0'}1{else}0{/if}{/capture} 	
			
			{if $gridItemDiabled.status} 	
				<a href="javascript:updateRecord('{$dataList.id}','{$smarty.capture.statusCurrent}','{$k}')" class='a2'><img src="assets/images/{$smarty.capture.statusImage}" width="16" height="16"  /></a> 
				 
			{/if}	
				
				{if $gridItemDiabled.edit}
					{if $editLink}
					<a href="{$editLink}{$dataList.id}{$backVars}"><img src="assets/images/pencil.gif" width="16" height="16" alt="edit" title="edit" /></a>
					{else}
					<a href="index.php?module={$currentClass}&event=edit&edit=1&id={$dataList.id}{$backVars}"><img src="assets/images/pencil.gif" width="16" height="16" alt="edit" title="edit" /></a>
					{/if}
				{/if}
				
				{if $gridItemDiabled.view}<a href="index.php?module={$currentClass}&event=view&id={$dataList.id}&filter={$filter}&DisplayRecords={$DisplayRecords}&ShowThisPage={$ShowThisPage}&sortby={$sortby}&sortDirection={$sortDirection}&page={$page}&pagegroup={$pagegroup}"><img src="assets/images/view.gif"  alt="view" title="view" /></a>{/if}
				
				{if $gridItemDiabled.delete}<a href="javascript:delete_member('{$dataList.id}','4','{$k}')"><img src="assets/images/bin.gif" width="16" height="16" alt="delete" title="delete" /></a>{/if} </td>
              </tr>
        {/foreach}     
            </tbody>
			{else}
		<tbody>
		 {capture name="rowCount"}{$tabHeading|@count}{/capture} 	
		<td colspan="{$smarty.capture.rowCount+2}"> <div style="padding:50px" align="center">No Record Found</div></td>
		
		</tbody>
		  
          {/if}
          </table>
		 {if $gridItemDiabled.status || $gridItemDiabled.delete}
          <div class="pager" id="pager">
            <div> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <img src="assets/images/arrow-curve-000-left.gif"> <a href="javascript:check_all();"><font>check all</font> </a> / <a href="javascript:uncheck_all();"><font >uncheck all </font> </a>&nbsp;</a> </div>
          </div>
          <div class="table-apply">
            <div> <span>Apply action to selected:</span>
              <select id='with_selected' name='with_selected'  class="input-medium" onChange="javascript:with_selected_function();">
                <option value="">--with selected--</option>
             {if $gridItemDiabled.status}    <option value="1">Active</option>
                <option value="0">Inactive</option>
			{/if}
                {if $gridItemDiabled.delete}<option value="4">Delete</option>{/if}
              </select>
            </div>
          </div>
		  {/if}
          
          <div style="clear: both"></div>
        </div>
        <!-- End .module-table-body -->
      </div>
     <div class="pagination">
       
    
         
   
          
         
         
          
           {$displayPaging}
         
          
         
        
      </div>
    </form>