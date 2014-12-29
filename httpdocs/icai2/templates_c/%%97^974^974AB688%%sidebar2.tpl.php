<?php /* Smarty version 2.6.14, created on 2014-08-01 12:47:01
         compiled from sidebar2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'block', 'sidebar2.tpl', 3, false),)), $this); ?>

<div id="panel"><div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner" id="advanced" style="margin-top: 0px;"><span class="trigger"><strong></strong><em></em></span><div class="container"><nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation"><ul class="nav navbar-nav"><li class="home"><a href="index.php?module=home"  <?php if ($this->_tpl_vars['currentClass'] == 'home2'): ?> style="color: #FFFFFF !important;" <?php endif; ?>  class="glyphicon glyphicon-home"></a></li><li class="divider-vertical"></li>
 <?php $this->_tag_stack[] = array('block', array('file' => 'catoday2','class' => 'block_catoday2')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('block', array('file' => 'caweekly2','class' => 'block_caweekly2')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('block', array('file' => 'messages2','class' => 'block_messages2')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>


<li class="divider-vertical"></li>

 <?php $this->_tag_stack[] = array('block', array('file' => 'logintab2','class' => 'block_logintab2')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

</ul></nav></div></div></div>

<!--header-->
<header style="padding-top:50px !important;">
    <div class="menuBox">  
        <div class="container" style="width:1270px !important; margin-left:10px !important; margin-right:10px !important;"> 
            <nav class="navbar navbar-default navbar-static-top tm_navbar clearfix" role="navigation">
                <ul class="nav sf-menu clearfix">
                   <!-- <li <?php if ($this->_tpl_vars['currentClass'] == 'home2'): ?> class="active"<?php endif; ?>><a href="index.php?module=home">Home</a></li>-->
                    <li  <?php if ($this->_tpl_vars['currentClass'] == 'caindex' || $this->_tpl_vars['currentClass'] == 'casecurities' || $this->_tpl_vars['currentClass'] == 'caupcomingindex' || $this->_tpl_vars['currentClass'] == 'uniquesecurities' || $this->_tpl_vars['currentClass'] == 'uniquecurrencies' || $this->_tpl_vars['currentClass'] == 'updatecusip' || $this->_tpl_vars['currentClass'] == 'benchmarkindex' || $this->_tpl_vars['currentClass'] == 'updatesedol'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>><a href="#">Index</a><span></span>
                        <ul class="submenu">
            				<li><a href="index.php?module=caindex2">Running Index</a></li>
                           <?php if ($this->_tpl_vars['sessData']['User']['type'] != 3): ?><li><a href="index.php?module=caindex2&event=addNewRunning">Add new Running Index</a></li><?php endif; ?>
                        <li><a href="index.php?module=caupcomingindex2">Upcoming Index</a></li>
                         <li><a href="index.php?module=benchmarkindex2">USD Benchmark Index</a></li> 
			<li><a href="index.php?module=adjbenchmarkindex2">Local Benchmark Index</a></li>
                            <li><a href="index.php?module=casecurities2">Securities</a></li>
                            <li><a href="index.php?module=updatecusip2">Update Cusip</a></li>
                            <li><a href="index.php?module=updatesedol2">Update Sedol</a></li>
                            <?php if ($this->_tpl_vars['sessData']['User']['type'] == 3): ?><li><a href="index.php?module=uniquesecurities2">Active Unique Securities</a></li>
                            <li><a href="index.php?module=uniquecurrencies2">Active Unique Currencies</a></li>
                            <?php endif; ?>
            			</ul>
                    </li>
                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?>
                     
                           <li <?php if ($this->_tpl_vars['currentClass'] == 'csi'): ?> class="active"<?php endif; ?>><a href="index.php?module=csi2">Complex Strategy Index</a></li>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'sl'): ?> class="active"<?php endif; ?>><a href="index.php?module=sl2">S & L Index</a></li>
                    <?php endif; ?>
                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'cashindex' || $this->_tpl_vars['currentClass'] == 'lsc'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>><a href="#">Long Short Index</a><span></span>
                    
                    <ul class="submenu">
                        <li><a href="index.php?module=cashIndex2">Cash Index</a></li>
                        <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?><li><a href="index.php?module=lsc2">Long Short Index</a></li>
                        <?php endif; ?>
                           
                                      </ul>                    
                    </li>
                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'commodityticker' || $this->_tpl_vars['currentClass'] == 'commodityindxxtemp' || $this->_tpl_vars['currentClass'] == 'commodityindxx'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>><a href="#">Commodity</a><span></span>
                    
                        <ul class="submenu">
                        <li><a href="index.php?module=commodityticker2">Commodity ticker</a></li>
                        <li><a href="index.php?module=commodityindxx2">Running Index</a></li>
                      <li><a href="index.php?module=commodityindxxtemp2">Upcomming Index</a></li>
                                      </ul>
                    
                    
                    </li>
                    
                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'cacalendar'): ?> class="active"<?php endif; ?>>
                    <a href="index.php?module=cacalendar2">CA Calendar</a>
                    </li>
                    <?php endif; ?>
                    
                    
                    <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1' || $this->_tpl_vars['sessData']['User']['type'] == '2'): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'upcomingca' || $this->_tpl_vars['currentClass'] == 'myca' || $this->_tpl_vars['currentClass'] == 'indexwiseca'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>>
                    <a href="#">Corporate Action</a><span></span>
                    
                      <ul class="submenu">
                        <li><a href="index.php?module=upcomingca2">All Upcoming Corporate Actions</a></li>
                        <li><a href="index.php?module=myca2">My Corporate Actions</a></li>
                        <li><a href="index.php?module=myindex2">Indexwise Corporate Actions</a></li> 
                        <?php if ($this->_tpl_vars['sessData']['User']['type'] == '1'): ?>
                        <li><a href="index.php?module=approveadjfactor2">Approve Adjustment Factor for today</a></li> 
                        <?php endif; ?>
                           
                                      </ul>                    
                    </li>
                    
                    <?php endif; ?>
                    
                    
                     <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'users' || $this->_tpl_vars['currentClass'] == 'assignindex' || $this->_tpl_vars['currentClass'] == 'databaseusers'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>><a href="#">Users</a><span></span>
                    
                     <ul class="submenu">
                        <li><a href="index.php?module=users2">Users</a></li>
                        <li><a href="index.php?module=assignindex2">Assign Index</a></li>
                        <li><a href="index.php?module=databaseusers2">Database Users</a></li>    
                                      </ul>
                    
                    </li>
                    <?php endif; ?>
                    
                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'clients' || $this->_tpl_vars['currentClass'] == 'assignclientindex'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>>
                    <a href="#">Clients</a><span></span>
                     <ul class="submenu">
                            <li><a href="index.php?module=clients2">Clients</a></li>
                           <!-- <?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?><li><a href="index.php?module=assignclientindex">Assign Index</a></li><?php endif; ?>-->
                        </ul>
                    
                    </li>
                    
                   	<?php if ($this->_tpl_vars['sessData']['User']['type'] == 1): ?>
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'holidays' || $this->_tpl_vars['currentClass'] == 'calendarzone'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>><a href="#">Holidays</a><span></span>
                     <ul class="submenu">
                        <li><a href="index.php?module=calendarzone2">Calendar Zone</a></li>
                        <li><a href="index.php?module=holidays2">Holidays</a></li>   
                                      </ul>
                        
                    
                    </li>
                    <?php endif; ?>
                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'replacerunningsecurities' || $this->_tpl_vars['currentClass'] == 'replacetempupcoming'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>><a href="#">Replacement</a><span></span>
                    
                    
                        <ul class="submenu">
                        <li><a href="index.php?module=replacerunningsecurities2">Running Index</a></li>
                        <li><a href="index.php?module=replacetempupcoming2">Upcoming Index</a></li>
                                      </ul>
                    
                    </li>
                    
                    <li <?php if ($this->_tpl_vars['currentClass'] == 'delistrunningsecurities' || $this->_tpl_vars['currentClass'] == 'delisttempupcoming'): ?> class="active" <?php else: ?> class="sub-menu" <?php endif; ?>>
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