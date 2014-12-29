
<div id="panel"><div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner" id="advanced" style="margin-top: 0px;"><span class="trigger"><strong></strong><em></em></span><div class="container"><nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation"><ul class="nav navbar-nav"><li class="home"><a href="index.php?module=home"  {if $currentClass=="home2"} style="color: #FFFFFF !important;" {/if}  class="glyphicon glyphicon-home"></a></li><li class="divider-vertical"></li>
 {block file="catoday2" class="block_catoday2"}{/block}

{block file="caweekly2" class="block_caweekly2"}{/block}

{block file="messages2" class="block_messages2"}{/block}


<li class="divider-vertical"></li>

 {block file="logintab2" class="block_logintab2"}{/block}

</ul></nav></div></div></div>

<!--header-->
<header style="padding-top:50px !important;">
    <div class="menuBox">  
        <div class="container" style="width:1270px !important; margin-left:10px !important; margin-right:10px !important;"> 
            <nav class="navbar navbar-default navbar-static-top tm_navbar clearfix" role="navigation">
                <ul class="nav sf-menu clearfix">
                   <!-- <li {if $currentClass=="home2"} class="active"{/if}><a href="index.php?module=home">Home</a></li>-->
                    <li  {if $currentClass=="caindex" || $currentClass=="casecurities" || $currentClass=="caupcomingindex" || $currentClass=="uniquesecurities"  || $currentClass=="uniquecurrencies" || $currentClass=="updatecusip"  || $currentClass=="benchmarkindex" || $currentClass=="updatesedol" } class="active" {else} class="sub-menu" {/if}><a href="#">Index</a><span></span>
                        <ul class="submenu">
            				<li><a href="index.php?module=caindex2">Running Index</a></li>
                           {if $sessData.User.type!=3}<li><a href="index.php?module=caindex2&event=addNewRunning">Add new Running Index</a></li>{/if}
                        <li><a href="index.php?module=caupcomingindex2">Upcoming Index</a></li>
                         <li><a href="index.php?module=benchmarkindex2">USD Benchmark Index</a></li> 
			<li><a href="index.php?module=adjbenchmarkindex2">Local Benchmark Index</a></li>
                            <li><a href="index.php?module=casecurities2">Securities</a></li>
                            <li><a href="index.php?module=updatecusip2">Update Cusip</a></li>
                            <li><a href="index.php?module=updatesedol2">Update Sedol</a></li>
                            {if $sessData.User.type==3}<li><a href="index.php?module=uniquesecurities2">Active Unique Securities</a></li>
                            <li><a href="index.php?module=uniquecurrencies2">Active Unique Currencies</a></li>
                            {/if}
            			</ul>
                    </li>
                    {if $sessData.User.type=='1' || $sessData.User.type=='2'}
                     
                           <li {if $currentClass=="csi"} class="active"{/if}><a href="index.php?module=csi2">Complex Strategy Index</a></li>
                    <li {if $currentClass=="sl"} class="active"{/if}><a href="index.php?module=sl2">S & L Index</a></li>
                    {/if}
                    
                    <li {if $currentClass=="cashindex" || $currentClass=="lsc" } class="active" {else} class="sub-menu" {/if}><a href="#">Long Short Index</a><span></span>
                    
                    <ul class="submenu">
                        <li><a href="index.php?module=cashIndex2">Cash Index</a></li>
                        {if $sessData.User.type=='1' ||  $sessData.User.type=='2'}<li><a href="index.php?module=lsc2">Long Short Index</a></li>
                        {/if}
                           
                                      </ul>                    
                    </li>
                    
                    <li {if $currentClass=="commodityticker" || $currentClass=="commodityindxxtemp"  || $currentClass=="commodityindxx"} class="active" {else} class="sub-menu" {/if}><a href="#">Commodity</a><span></span>
                    
                        <ul class="submenu">
                        <li><a href="index.php?module=commodityticker2">Commodity ticker</a></li>
                        <li><a href="index.php?module=commodityindxx2">Running Index</a></li>
                      <li><a href="index.php?module=commodityindxxtemp2">Upcomming Index</a></li>
                                      </ul>
                    
                    
                    </li>
                    
                    {if $sessData.User.type=='1' || $sessData.User.type=='2'}
                    <li {if $currentClass=="cacalendar"} class="active"{/if}>
                    <a href="index.php?module=cacalendar2">CA Calendar</a>
                    </li>
                    {/if}
                    
                    
                    {if $sessData.User.type=='1' || $sessData.User.type=='2'}
                    <li {if $currentClass=="upcomingca" || $currentClass=="myca" ||$currentClass=="indexwiseca"} class="active" {else} class="sub-menu" {/if}>
                    <a href="#">Corporate Action</a><span></span>
                    
                      <ul class="submenu">
                        <li><a href="index.php?module=upcomingca2">All Upcoming Corporate Actions</a></li>
                        <li><a href="index.php?module=myca2">My Corporate Actions</a></li>
                        <li><a href="index.php?module=myindex2">Indexwise Corporate Actions</a></li> 
                        {if $sessData.User.type=='1'}
                        <li><a href="index.php?module=approveadjfactor2">Approve Adjustment Factor for today</a></li> 
                        {/if}
                           
                                      </ul>                    
                    </li>
                    
                    {/if}
                    
                    
                     {if $sessData.User.type==1}
                    <li {if $currentClass=="users" || $currentClass=="assignindex" ||$currentClass=="databaseusers"} class="active" {else} class="sub-menu" {/if}><a href="#">Users</a><span></span>
                    
                     <ul class="submenu">
                        <li><a href="index.php?module=users2">Users</a></li>
                        <li><a href="index.php?module=assignindex2">Assign Index</a></li>
                        <li><a href="index.php?module=databaseusers2">Database Users</a></li>    
                        
                                      </ul>
                    
                    </li>
                    {/if}
                    
                    
                    <li {if $currentClass=="clients" || $currentClass=="assignclientindex"} class="active" {else} class="sub-menu" {/if}>
                    <a href="#">Clients</a><span></span>
                     <ul class="submenu">
                            <li><a href="index.php?module=clients2">Clients</a></li>
                           <!-- {if $sessData.User.type==1}<li><a href="index.php?module=assignclientindex">Assign Index</a></li>{/if}-->
                        </ul>
                    
                    </li>
                    
                   	{if $sessData.User.type==1}
                    <li {if $currentClass=="holidays" || $currentClass=="calendarzone"} class="active" {else} class="sub-menu" {/if}><a href="#">Holidays</a><span></span>
                     <ul class="submenu">
                        <li><a href="index.php?module=calendarzone2">Calendar Zone</a></li>
                        <li><a href="index.php?module=holidays2">Holidays</a></li>   
                                      </ul>
                        
                    
                    </li>
                    {/if}
                    
                    <li {if $currentClass=="replacerunningsecurities" || $currentClass=="replacetempupcoming"} class="active" {else} class="sub-menu" {/if}><a href="#">Replacement</a><span></span>
                    
                    
                        <ul class="submenu">
                        <li><a href="index.php?module=replacerunningsecurities2">Running Index</a></li>
                        <li><a href="index.php?module=replacetempupcoming2">Upcoming Index</a></li>
                                      </ul>
                    
                    </li>
                    
                    <li {if $currentClass=="delistrunningsecurities" || $currentClass=="delisttempupcoming"} class="active" {else} class="sub-menu" {/if}>
                    <a href="#">Delist</a><span></span>
                    
                      <ul class="submenu">
                        <li><a href="index.php?module=delistrunningsecurities2">Running Index</a></li>
                        <li><a href="index.php?module=delisttempupcoming2">Upcoming Index</a></li>
                                      </ul>
                    
                    </li>
                    
                </ul>
            </nav>
        </div>
    </div>
</header>
