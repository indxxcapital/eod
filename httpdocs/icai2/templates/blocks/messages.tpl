
<li class="hidden-phone">
                       
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-exclamation-sign"></i>
                                <span class="badge badge-success">{$admin_message|@count}</span>
                            </a>

                            <!-- BEGIN Messages Dropdown -->
                            <ul class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-comments"></i>
                                    Messages from System
                                </li>
						
                                <li class="msg">
                                    <a href="index.php?module=caindex">
                                        <div>
                                            <span class="msg-title">Unsubbmitted Index</span>
                                            <span class="msg-time">
                                                <span>{$admin_message.0.uindex}</span>
                                            </span>
                                        </div>
                                    </a>
                                </li>

                            <!--    <li class="msg">
                                    <a href="#">
                                        <img src="img/demo/avatar/avatar4.jpg" alt="Emma's Avatar" />
                                        <div>
                                            <span class="msg-title">Emma</span>
                                            <span class="msg-time">
                                                <i class="icon-time"></i>
                                                <span>2 Days ago</span>
                                            </span>
                                        </div>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris ...</p>
                                    </a>
                                </li>

                                <li class="msg">
                                    <a href="#">
                                        <img src="img/demo/avatar/avatar5.jpg" alt="John's Avatar" />
                                        <div>
                                            <span class="msg-title">John</span>
                                            <span class="msg-time">
                                                <i class="icon-time"></i>
                                                <span>8:24 PM</span>
                                            </span>
                                        </div>
                                        <p>Duis aute irure dolor in reprehenderit in ...</p>
                                    </a>
                                </li>

                                <li class="more">
                                    <a href="#">See all messages</a>
                                </li>-->
                            </ul>
                            <!-- END Notifications Dropdown -->
                        </li>
                         
                        <!-- END Button Messages -->
