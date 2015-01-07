<div id="header">
  <div id="header-status">
    <div class="container_12"> {if $Admin|@count>0 }
      <div class="grid_8"> <span id="text-invitation"> </span>
        <!-- Messages displayed through the thickbox -->
      </div>
      <div class="grid_4" id="chatpanel"> <a href="index.php?module=home&event=logout" id="logout"> Logout </a> </div>
      {/if} </div>
    <div style="clear:both;"></div>
  </div>
  <div id="header-main">
    <div class="container_12">
      <div class="grid_12">
        <div id="logo"> {if $Admin|@count>0 }
          <ul id="nav">
          
            <!--<li {if $currentClass == 'employee'} id="current" {/if} >
            <a href="index.php?module=employee">Employee</a></li>-->
            <li {if $currentClass == 'category' || $currentClass == 'subcategory'} id="current" {/if} >     <a href="index.php?module=category">Category</a></li>
             <li {if $currentClass == 'actioneventtype' || $currentClass == 'actionevent' || $currentClass == 'actionfields'} id="current" {/if} >     <a href="index.php?module=actioneventtype">Action</a></li>
             </ul>
          {/if} </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <div id="subnav">
    <div class="container_12">
      <div class="grid_12"> </div>
    
     
      
        {if  $currentClass == 'category' || $currentClass == 'subcategory'}
      <ul>
       <li {if $currentClass == 'category'} id="current" {/if} > <a href="index.php?module=category">Category</a></li>
      <li {if $currentClass == 'subcategory'} id="current" {/if} > <a href="index.php?module=subcategory">SubCategory</a></li>

      </ul>
      {/if}
      {if $currentClass == 'actioneventtype' || $currentClass == 'actionevent' || $currentClass == 'actionfields' || $currentClass == 
      'cconstituents'}
        <ul><li {if $currentClass == 'actioneventtype'} id="current" {/if} > <a href="index.php?module=actioneventtype">Event Type </a></li>
        	<li {if $currentClass == 'actionevent'} id="current" {/if} > <a href="index.php?module=actionevent">Event </a></li>
            <li {if $currentClass == 'actionfields'} id="current" {/if} > <a href="index.php?module=actionfields">Fields </a></li>
           
		</ul>

      {/if}
	
    </div>
    <!-- End. .container_12 -->
  </div>
</div>
