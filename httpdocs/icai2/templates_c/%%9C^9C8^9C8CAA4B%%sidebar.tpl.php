<?php /* Smarty version 2.6.14, created on 2014-09-11 12:26:16
         compiled from sidebar.tpl */ ?>
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
                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2' || $this->_tpl_vars['sessData']['User']['type'] == '3'): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'home'): ?> class="active"<?php endif; ?>>
                        <a href="index.php?module=home">
                            <i class="icon-dashboard"></i>
                            <span>  Dashboard</span>
                        </a>
                    </li>
				<?php endif; ?>
                    <!--<li>
                        <a href="typography.html">
                            <i class="icon-text-width"></i>
                            <span>Typography</span>
                        </a>
                    </li>-->
					<?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2' || $this->_tpl_vars['sessData']['User']['type'] == '3'): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'caindex' || $this->_tpl_vars['currentClass'] == 'casecurities' || $this->_tpl_vars['currentClass'] == 'caupcomingindex' || $this->_tpl_vars['currentClass'] == 'uniquesecurities' || $this->_tpl_vars['currentClass'] == 'uniquecurrencies' || $this->_tpl_vars['currentClass'] == 'updatecusip' || $this->_tpl_vars['currentClass'] == 'benchmarkindex' || $this->_tpl_vars['currentClass'] == 'updatesedol'): ?> class="active"<?php endif; ?>>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span>Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       
                        <ul class="submenu">
                        <li><a href="index.php?module=caindex">Running Index</a></li>
                           <?php if ($this->_tpl_vars['sessData']['User']['type'] != 3): ?><li><a href="index.php?module=caindex&event=addNewRunning">Add new Running Index</a></li><?php endif; ?>
                        <li><a href="index.php?module=caupcomingindex">Upcoming Index</a></li>
                         <li><a href="index.php?module=benchmarkindex">USD Benchmark Index</a></li> 
			<li><a href="index.php?module=adjbenchmarkindex">Local Benchmark Index</a></li>
                            <li><a href="index.php?module=casecurities">Securities</a></li>
                            <li><a href="index.php?module=updatecusip">Update Cusip</a></li>
                            <li><a href="index.php?module=updatesedol">Update Sedol</a></li>
                            <?php if ($this->_tpl_vars['sessData']['User']['type'] == 3): ?><li><a href="index.php?module=uniquesecurities">Active Unique Securities</a></li>
                            <li><a href="index.php?module=uniquecurrencies">Active Unique Currencies</a></li>
                            <?php endif; ?>
                                      </ul>
                        <!-- END Submenu -->
                    </li>
<?php endif; ?>
                     <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?>
                     
                           <li <?php if ($this->_tpl_vars['currentClass'] == 'csi'): ?> class="active"<?php endif; ?>>
                        <a href="index.php?module=csi" title="Complex Strategy Index" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Complex Strategy Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
					</li>
                       <li <?php if ($this->_tpl_vars['currentClass'] == 'csi'): ?> class="active"<?php endif; ?>>
                        <a href="index.php?module=sl" title="short and leveraged Index" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Short and Leveraged Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
					</li>
                     
                     <?php endif; ?>
                     
                        <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1 || $this->_tpl_vars['sessData']['User']['type'] == 2 || $this->_tpl_vars['sessData']['User']['type'] == 3): ?>
                       <li <?php if ($this->_tpl_vars['currentClass'] == 'cashindex' || $this->_tpl_vars['currentClass'] == 'cashindextemp' || $this->_tpl_vars['currentClass'] == 'lsc'): ?> class="active"<?php endif; ?>>
                        <a href="#"  class="dropdown-toggle">
                            <i class="icon-th"></i>
                            <span>Long Short Index</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        
                        
                         <ul class="submenu">
                       <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1 || $this->_tpl_vars['sessData']['User']['type'] == 2): ?>   <li><a href="index.php?module=cashindex&event=addNew">Add New Cash Index</a></li><?php endif; ?>
                        <li><a href="index.php?module=cashIndex">Live Cash Index</a></li>
                          <li><a href="index.php?module=cashIndextemp">Upcomming Cash Index</a></li>
                         <li><a href="index.php?module=cashindex&event=exportExcel">Download Cash Tickers</a></li>
                        <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?><li><a href="index.php?module=lsc">Long Short Index</a></li>
                        <?php endif; ?>
                           
                                      </ul>
                        
                        
                        
                        
                    </li>
                     
                      <li <?php if ($this->_tpl_vars['currentClass'] == 'commodityticker' || $this->_tpl_vars['currentClass'] == 'commodityindxxtemp' || $this->_tpl_vars['currentClass'] == 'commodityindxx'): ?> class="active"<?php endif; ?>>
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
                     
                     <?php endif; ?>
<?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'cacalendar'): ?> class="active"<?php endif; ?>>
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
<?php endif; ?>
                    
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
<?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'upcomingca' || $this->_tpl_vars['currentClass'] == 'myca' || $this->_tpl_vars['currentClass'] == 'myindex' || $this->_tpl_vars['currentClass'] == 'myindextemp' || $this->_tpl_vars['currentClass'] == 'approveadjfactor'): ?> class="active"<?php endif; ?>>
                        <a href="#"  class="dropdown-toggle">
                            <i class="icon-th"></i>
                            <span>Corporate Action</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        
                        
                         <ul class="submenu">
                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1'): ?>    <li><a href="index.php?module=upcomingca">All Upcoming Corporate Actions</a></li><?php endif; ?>
                        <li><a href="index.php?module=myca">My Corporate Actions For Live</a></li>
                       <li><a href="index.php?module=myca&event=upcomming">My Corporate Actions For Upcoming</a></li>
                        <li><a href="index.php?module=myindex">Indexwise Corporate Actions for Live</a></li> 
                        <li><a href="index.php?module=myindextemp">Indexwise Corporate Actions for upcomming</a></li>  <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1'): ?>
                        <li><a href="index.php?module=approveadjfactor">Approve Adjustment Factor for today</a></li> 
                        <?php endif; ?>
                           
                                      </ul>
                        
                        
                        
                        
                    </li>
                    
                    
     <?php endif; ?>               
                    
                    
                    
                    
                    
                    
                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'users' || $this->_tpl_vars['currentClass'] == 'itusers' || $this->_tpl_vars['currentClass'] == 'assignindex' || $this->_tpl_vars['currentClass'] == 'databaseusers'): ?> class="active"<?php endif; ?>>
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
					<?php endif; ?>
                    
                    
  <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'clients' || $this->_tpl_vars['currentClass'] == 'assignclientindex'): ?> class="active"<?php endif; ?>>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-edit"></i>
                            <span>Clients</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       <ul class="submenu">
                            <li><a href="index.php?module=clients">Clients</a></li>
                           <!-- <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?><li><a href="index.php?module=assignclientindex">Assign Index</a></li><?php endif; ?>-->
                        </ul>
                        <!-- END Submenu -->
                    </li>
                    <?php endif; ?>
                    
                    
                        <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'holidays' || $this->_tpl_vars['currentClass'] == 'calendarzone'): ?> class="active"<?php endif; ?>>
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
					<?php endif; ?>
                    
                    
                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1 || $this->_tpl_vars['sessData']['User']['type'] == 2 || $this->_tpl_vars['sessData']['User']['type'] == 3): ?>
                    
                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'replacerunningsecurities' || $this->_tpl_vars['currentClass'] == 'replacetempupcoming'): ?> class="active"<?php endif; ?>>
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
                    
                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'delistrunningsecurities' || $this->_tpl_vars['currentClass'] == 'delisttempupcoming'): ?> class="active"<?php endif; ?>>
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
                    
                     <?php endif; ?>  
                     
                      <li <?php if ($this->_tpl_vars['currentClass'] == 'spinstockadd'): ?> class="active"<?php endif; ?>>
                        <a href="index.php?module=spinstockadd" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Spin-off Stock Addition</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>
                        </li>
                         <li <?php if ($this->_tpl_vars['currentClass'] == 'updaterequest' || $this->_tpl_vars['currentClass'] == 'issuetrack'): ?> class="active"<?php endif; ?>>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            <span>Support</span>
                            <b class="arrow icon-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                       
                        <ul class="submenu">
                         <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1 || $this->_tpl_vars['sessData']['User']['type'] == 4): ?>
                   <li><a href="index.php?module=updaterequest">Update Request</a></li>
                      <?php endif; ?>  <li><a href="index.php?module=issuetrack">Issue Track</a></li>
                                      </ul>
                        <!-- END Submenu -->
                    </li>
                    
  <!--Rebalance -->
                    <!--  <li <?php if ($this->_tpl_vars['currentClass'] == 'rebalance'): ?> class="active"<?php endif; ?>>
                        <a href="index.php?module=rebalance">
                            <i class="icon-th"></i>
                            <span>Rebalance</span>
                           
                        </a>

                      
                       
                       
                     
                    </li>-->
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