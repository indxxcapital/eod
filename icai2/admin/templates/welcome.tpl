<div style="min-height:400px; text-align:center;">
<h2>Welcome to Admin Panel</h2>
<div class="container_12">
<div class="grid_7">
 
 {if $transportPetComment gt '0'}
 
 <a href="{makeUrl link="index.php?module=pettranscomment"}" class="dashboard-module"> <img src="{$BASE_URL}assets/images/1322477591_Hourglass.png" width="64" height="64" alt="edit" /> <span>{$transportPetComment} New comment{if $transportPetComment gt '1'}(s){/if} on <br /><b>Pet Transport</b>.</span></a>
{/if} 
 
{if $urgentPetComment gt '0'}
<a href="{makeUrl link="index.php?module=urgentpetscomment"}" class="dashboard-module"> <img src="{$BASE_URL}assets/images/1322477591_Hourglass.png" width="64" height="64" alt="edit" /> <span>{$urgentPetComment} New Comment
{if $urgentPetComment gt '1'}(s){/if} on <br /><b>Urgent Pet</b>.</span> </a> 
{/if}

    
</div>
</div>
</div>