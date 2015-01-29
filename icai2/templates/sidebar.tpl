<div id="sidebar" class="nav-collapse">
                <!-- BEGIN Navlist -->
                <ul class="nav nav-list">
                    <!-- BEGIN Search Form -->
                    <li>
                        <form target="#" method="GET" class="search-form">
                            <span class="search-pan">
                                <button type="submit">
                                    <i class="icon-search"></i>
                                </button>
                                <input type="text" name="search" placeholder="Search Security..." autocomplete="off" />
                            </span>
                        </form>
                    </li>
                    <!-- END Search Form -->
                    {if $sessData.User.type=='1' || $sessData.User.type=='2' || $sessData.User.type=='3'}
                    <li {if $currentClass=="home"} class="active"{/if}>
                        <a href="index.php?module=home">
                            <i class="icon-dashboard"></i>
                            <span>  Dashboard</span>
                        </a>
                    </li>
				{/if}
                    <!--<li>
                        <a href="typography.html">
                            <i class="icon-text-width"></i>
                            <span>Typography</span>
                        </a>
                    </li>-->
					{if $sessData.User.type=='1' || $sessData.User.type=='2' || $sessData.User.type=='3'}
                    <li {if $currentClass=="caindex" || $currentClass=="casecurities" || $currentClass=="caupcomingindex" || $currentClass=="uniquesecurities"  || $currentClass=="uniquecurrencies" || $currentClass=="updatecusip"  || $currentClass=="benchmarkindex" || $currentClass=="updatesedol" } class="active"{/if}>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span>Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       
                        <ul class="submenu">
                        <li><a href="index.php?module=caindex">Running Index</a></li>
                           {if $sessData.User.type!=3}<li><a href="index.php?module=caindex&event=addNewRunning">Add new Running Index</a></li>{/if}
                        <li><a href="index.php?module=caupcomingindex">Upcoming Index</a></li>
                         <li><a href="index.php?module=benchmarkindex">USD Benchmark Index</a></li> 
			<li><a href="index.php?module=adjbenchmarkindex">Local Benchmark Index</a></li>
                            <li><a href="index.php?module=casecurities">Securities</a></li>
                            <li><a href="index.php?module=updatecusip">Update Cusip</a></li>
                            <li><a href="index.php?module=updatesedol">Update Sedol</a></li>
                            {if $sessData.User.type==3}<li><a href="index.php?module=uniquesecurities">Active Unique Securities</a></li>
                            <li><a href="index.php?module=uniquecurrencies">Active Unique Currencies</a></li>
                            {/if}
                                      </ul>
                        <!-- END Submenu -->
                    </li>
{/if}
                     {if $sessData.User.type=='1' || $sessData.User.type=='2'}
                     
                           <li {if $currentClass=="csi"} class="active"{/if}>
                        <a href="index.php?module=csi" title="Complex Strategy Index" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Complex Strategy Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
					</li>
                       <li {if $currentClass=="csi"} class="active"{/if}>
                        <a href="index.php?module=sl" title="short and leveraged Index" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Short and Leveraged Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
					</li>
                     
                     {/if}
                     
                        {if $sessData.User.type==1 ||  $sessData.User.type==2 ||  $sessData.User.type==3}
                       <li {if $currentClass=="cashindex" || $currentClass=="cashindextemp" || $currentClass=="lsc" } class="active"{/if}>
                        <a href="#"  class="dropdown-toggle">
                            <i class="icon-th"></i>
                            <span>Long Short Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        
                        
                         <ul class="submenu">
                       {if $sessData.User.type==1 ||  $sessData.User.type==2 }   <li><a href="index.php?module=cashindex&event=addNew">Add New Cash Index</a></li>{/if}
                        <li><a href="index.php?module=cashIndex">Live Cash Index</a></li>
                          <li><a href="index.php?module=cashIndextemp">Upcomming Cash Index</a></li>
                         <li><a href="index.php?module=cashindex&event=exportExcel">Download Cash Tickers</a></li>
                        {if $sessData.User.type=='1' ||  $sessData.User.type=='2'}<li><a href="index.php?module=lsc">Long Short Index</a></li>
                        {/if}
                           
                                      </ul>
                        
                        
                        
                        
                    </li>
                     
                      <li {if $currentClass=="commodityticker" || $currentClass=="commodityindxxtemp"  || $currentClass=="commodityindxx"} class="active"{/if}>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Commodity</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       
                        <ul class="submenu">
                        <li><a href="index.php?module=commodityticker">Commodity ticker</a></li>
                        <li><a href="index.php?module=commodityindxx">Running Index</a></li>
                      <li><a href="index.php?module=commodityindxxtemp">Upcomming Index</a></li>
                                      </ul>
                        <!-- END Submenu -->
                    </li>
                     
                     {/if}
{if $sessData.User.type=='1' || $sessData.User.type=='2'}
                    <li {if $currentClass=="cacalendar"} class="active"{/if}>
                        <a href="index.php?module=cacalendar" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>CA Calendar</span>
                            
                        </a>

                        <!-- BEGIN Submenu -->
                        <!--<ul class="submenu">
                            <li><a href="table_basic.html">Basic</a></li>
                            <li><a href="table_advance.html">Advance</a></li>
                            <li><a href="table_dynamic.html">Dynamic</a></li>
                        </ul>-->
                        <!-- END Submenu -->
                    </li>
{/if}
                    
                    <!--<li>
                        <a href="calendar.html">
                            <i class="icon-calendar"></i>
                            <span>Calendar</span>
                        </a>
                    </li>

                    <li>
                        <a href="gallery.html">
                            <i class="icon-picture"></i>
                            <span>Gallery</span>
                        </a>
                    </li>-->
{if $sessData.User.type=='1' || $sessData.User.type=='2'}
                    <li {if $currentClass=="upcomingca" || $currentClass=="myca" ||$currentClass=="myindex" ||$currentClass=="myindextemp"||$currentClass=="approveadjfactor"} class="active"{/if}>
                        <a href="#"  class="dropdown-toggle">
                            <i class="icon-th"></i>
                            <span>Corporate Action</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        
                        
                         <ul class="submenu">
                    {if $sessData.User.type=='1'}    <li><a href="index.php?module=upcomingca">All Upcoming Corporate Actions</a></li>{/if}
                        <li><a href="index.php?module=myca">My Corporate Actions For Live</a></li>
                       <li><a href="index.php?module=myca&event=upcomming">My Corporate Actions For Upcoming</a></li>
                        <li><a href="index.php?module=myindex">Indexwise Corporate Actions for Live</a></li> 
                        <li><a href="index.php?module=myindextemp">Indexwise Corporate Actions for upcomming</a></li>  {if $sessData.User.type=='1'}
                        <li><a href="index.php?module=approveadjfactor">Approve Adjustment Factor for today</a></li> 
                        {/if}
                           
                                      </ul>
                        
                        
                        
                        
                    </li>
                    
                    
     {/if}               
                    
                    
                    
                    
                    
                    
                    {if $sessData.User.type==1}
                    <li {if $currentClass=="users" || $currentClass=="itusers"  || $currentClass=="assignindex" ||$currentClass=="databaseusers"} class="active"{/if}>
                        <a href="#"  class="dropdown-toggle">
                            <i class="icon-list-alt"></i>
                            <span>Users</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        
                        <ul class="submenu">
                        <li><a href="index.php?module=users">Users</a></li>
                        <li><a href="index.php?module=assignindex">Assign Index</a></li>
                        <li><a href="index.php?module=databaseusers">Database Users</a></li>    
                         <li><a href="index.php?module=itusers">IT Users</a></li>    
                        </ul>
                        
                    </li>
					{/if}
                    
                    
  {if $sessData.User.type==1}                    
                    <li {if $currentClass=="clients" || $currentClass=="assignclientindex"} class="active"{/if}>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-edit"></i>
                            <span>Clients</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       <ul class="submenu">
                            <li><a href="index.php?module=clients">Clients</a></li>
                           <!-- {if $sessData.User.type==1}<li><a href="index.php?module=assignclientindex">Assign Index</a></li>{/if}-->
                        </ul>
                        <!-- END Submenu -->
                    </li>
                    {/if}
                    
                    
                        {if $sessData.User.type==1}
                    <li {if $currentClass=="holidays" || $currentClass=="calendarzone"} class="active"{/if}>
                        <a href="#"  class="dropdown-toggle">
                            <i class="icon-file"></i>
                            <span>Holidays</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        
                        <ul class="submenu">
                        <li><a href="index.php?module=calendarzone">Calendar Zone</a></li>
                        <li><a href="index.php?module=holidays">Holidays</a></li>   
                                      </ul>
                        
                    </li>
					{/if}
                    
                    
                    {if $sessData.User.type==1 ||  $sessData.User.type==2 ||  $sessData.User.type==3}
                    
                    
                    <li {if $currentClass=="replacerunningsecurities" || $currentClass=="replacetempupcoming"} class="active"{/if}>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span>Replacement</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       
                        <ul class="submenu">
                        <li><a href="index.php?module=replacerunningsecurities">Running Index</a></li>
                        <li><a href="index.php?module=replacetempupcoming">Upcoming Index</a></li>
                                      </ul>
                        <!-- END Submenu -->
                    </li>
                    
                    
                    <li {if $currentClass=="delistrunningsecurities" || $currentClass=="delisttempupcoming"} class="active"{/if}>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Delist</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       
                        <ul class="submenu">
                        <li><a href="index.php?module=delistrunningsecurities">Running Index</a></li>
                        <li><a href="index.php?module=delisttempupcoming">Upcoming Index</a></li>
                                      </ul>
                        <!-- END Submenu -->
                    </li>
                    
                     {/if}  
                     
                      <li {if $currentClass=="spinstockadd"} class="active"{/if}>
                        <a href="index.php?module=spinstockadd" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Spin-off Stock Addition</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        </li>
                         <li {if $currentClass=="updaterequest" || $currentClass=="issuetrack"} class="active"{/if}>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Support</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       
                        <ul class="submenu">
                         {if $sessData.User.type==1 || $sessData.User.type==4  }
                   <li><a href="index.php?module=updaterequest">Update Request</a></li>
                      {/if}  <li><a href="index.php?module=issuetrack">Issue Track</a></li>
                                      </ul>
                        <!-- END Submenu -->
                    </li>
                    
  <!--Rebalance -->
                    <!--  <li {if $currentClass=="rebalance"} class="active"{/if}>
                        <a href="index.php?module=rebalance">
                            <i class="icon-th"></i>
                            <span>Rebalance</span>
                           
                        </a>

                      
                       
                       
                     
                    </li>-->
					<li {if $currentClass=="useraction"} class="active"{/if}>
                        <a href="index.php?module=useraction">
                            <i class="icon-th"></i>
                            <span>User Actions</span>
                           
                        </a>
					<li {if $currentClass=="restoredb"} class="active"{/if}>
                        <a href="index.php?module=restoredb">
                            <i class="icon-th"></i>
                            <span>Restore DB</span>
                           
                        </a>
					
                     <!-- Rebalance -->
                    
                    
					
                    <!--<li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-file"></i>
                            <span>Other Pages</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                        <!--<ul class="submenu">
                            <li><a href="more_login.html">Login &amp; Register</a></li>
                            <li><a href="more_error-404.html">Error 404</a></li>
                            <li><a href="more_error-500.html">Error 500</a></li>
                            <li><a href="more_blank.html">Blank Page</a></li>
                            <li><a href="more_set-skin.html">Skin</a></li>
                            <li><a href="more_set-sidebar-navbar-color.html">Sidebar &amp; Navbar</a></li>
                            <li><a href="more_sidebar-collapsed.html">Collapsed Sidebar</a></li>
                        </ul>
                        <!-- END Submenu -->
                    </li>
                </ul>
                <!-- END Navlist -->

                <!-- BEGIN Sidebar Collapse Button -->
                <div id="sidebar-collapse" class="visible-desktop">
                    <i class="icon-double-angle-left"></i>
                </div>
                <!-- END Sidebar Collapse Button -->
            </div>