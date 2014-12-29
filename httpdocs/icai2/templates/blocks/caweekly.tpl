 <li class="hidden-phone">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-bell-alt"></i>
                                <span class="badge badge-important">{$totalweeklycarows}</span>
                            </a>

                            <!-- BEGIN Notifications Dropdown -->
                            <ul class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-ok"></i>
                                    Corporate Actions for week
                                </li>
                                
                                {foreach from=$totalweeklyca item=point key=k}
                                {if $k<4}
                               <li>
                                    <a href="index.php?module=viewca&event=view&id={$point.corpactionid}">
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

                                <!--<li class="notify">
                                    <a href="#">
                                        <i class="icon-comment orange"></i>
                                        <p>New Comments</p>
                                        <span class="badge badge-warning">4</span>
                                    </a>
                                </li>

                                <li class="notify">
                                    <a href="#">
                                        <i class="icon-twitter blue"></i>
                                        <p>New Twitter followers</p>
                                        <span class="badge badge-info">7</span>
                                    </a>
                                </li>

                                <li class="notify">
                                    <a href="#">
                                        <img src="img/demo/avatar/avatar2.jpg" alt="Alex" />
                                        <p>David would like to become moderator.</p>
                                    </a>
                                </li>

                                <li class="notify">
                                    <a href="#">
                                        <i class="icon-bug pink"></i>
                                        <p>New bug in program!</p>
                                    </a>
                                </li>

                                <li class="notify">
                                    <a href="#">
                                        <i class="icon-shopping-cart green"></i>
                                        <p>You have some new orders</p>
                                        <span class="badge badge-success">+10</span>
                                    </a>
                                </li>-->

                                <li class="more">
                                    <a href="index.php?module=viewca&event=viewweeklycorporateactions">View All</a>
                                </li>
                            </ul>
                            <!-- END Notifications Dropdown -->
                        </li>