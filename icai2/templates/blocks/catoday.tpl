<li class="hidden-phone">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-tasks"></i>
                                <span class="badge badge-warning">{$totalcarows}</span>
                            </a>

                            <!-- BEGIN Tasks Dropdown -->
                            <ul class="pull-right dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-ok"></i>
                                    Corporate Actions for today
                                </li>
								{foreach from=$caquery item=point key=k}
                                {if $k<4}
                               <li>
                                    <a href="index.php?module=viewca&event=view&id={$point.corpid}">
                                        <div class="clearfix">
                                            <span class="pull-left">{$point.company_name}</span>
                                            <span class="pull-right">{$point.mnemonic}</span>
                                        </div>

                                        <!--<div class="progress progress-mini progress-warning">
                                            <div style="width:75%" class="bar"></div>
                                        </div>-->
                                    </a>
                                </li>
                                {/if}
								{/foreach}
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