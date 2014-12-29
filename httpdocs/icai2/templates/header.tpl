<div id="navbar" class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <!-- BEGIN Brand -->
                    <a href="{$BASE_URL}" class="brand">
                        <small>
                            <i class="icon-desktop"></i>
                            ICAI Admin
                        </small>
                    </a>
                    <!-- END Brand -->

                    <!-- BEGIN Responsive Sidebar Collapse -->
                    <a href="#" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                        <i class="icon-reorder"></i>
                    </a>
                    <!-- END Responsive Sidebar Collapse -->

                    <!-- BEGIN Navbar Buttons -->
                    
                    <ul class="nav flaty-nav pull-right">
                        <!-- BEGIN Button Tasks -->
                        {block file="catoday" class="block_catoday"}{/block}
                        
                        <!-- END Button Tasks -->

                        <!-- BEGIN Button Notifications -->
                        
                        {block file="caweekly" class="block_caweekly"}{/block}
                       
                        <!-- END Button Notifications -->

                        <!-- BEGIN Button Messages -->
                        
                        {block file="messages" class="block_messages"}{/block}
                        <!-- BEGIN Button User -->
                        
                        {block file="logintab" class="block_logintab"}{/block}
                        
                        
                        <!-- END Button User -->
                    </ul>
                    <!-- END Navbar Buttons -->
                </div><!--/.container-fluid-->
            </div><!--/.navbar-inner-->
        </div>