<?php /* Smarty version 2.6.14, created on 2014-04-24 11:49:55
         compiled from blocks/catoday.tpl */ ?>
<li class="hidden-phone">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-tasks"></i>
                                <span class="badge badge-warning"><?php echo $this->_tpl_vars['totalcarows']; ?>
</span>
                            </a>

                            <!-- BEGIN Tasks Dropdown -->
                            <ul class="pull-right dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-ok"></i>
                                    Corporate Actions for today
                                </li>
								<?php $_from = $this->_tpl_vars['caquery']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['point']):
?>
                                <?php if ($this->_tpl_vars['k'] < 4): ?>
                               <li>
                                    <a href="index.php?module=viewca&event=view&id=<?php echo $this->_tpl_vars['point']['corpid']; ?>
">
                                        <div class="clearfix">
                                            <span class="pull-left"><?php echo $this->_tpl_vars['point']['company_name']; ?>
</span>
                                            <span class="pull-right"><?php echo $this->_tpl_vars['point']['mnemonic']; ?>
</span>
                                        </div>

                                        <!--<div class="progress progress-mini progress-warning">
                                            <div style="width:75%" class="bar"></div>
                                        </div>-->
                                    </a>
                                </li>
                                <?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
                                <!--<li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">Transfer To New Server</span>
                                            <span class="pull-right">45%</span>
                                        </div>

                                        <div class="progress progress-mini progress-danger">
                                            <div style="width:45%" class="bar"></div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">Bug Fixes</span>
                                            <span class="pull-right">20%</span>
                                        </div>

                                        <div class="progress progress-mini">
                                            <div style="width:20%" class="bar"></div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <div class="clearfix">
                                            <span class="pull-left">Writing Documentation</span>
                                            <span class="pull-right">85%</span>
                                        </div>

                                        <div class="progress progress-mini progress-success progress-striped active">
                                            <div style="width:85%" class="bar"></div>
                                        </div>
                                    </a>
                                </li>-->

                                <li class="more">
                                    <a href="index.php?module=viewca&event=viewcorporateactions">View All</a>
                                </li>
                            </ul>
                            <!-- END Tasks Dropdown -->
                        </li>