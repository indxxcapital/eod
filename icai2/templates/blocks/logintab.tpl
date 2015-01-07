<li class="user-profile">
                            <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                                <!--<img class="nav-user-photo" src="img/demo/avatar/avatar1.jpg" alt="Penny's Photo" />-->
                                <span class="hidden-phone" id="user_info">
                                    {$sessData.User.name}
                                </span>
                                <i class="icon-caret-down"></i>
                            </a>

                            <!-- BEGIN User Dropdown -->
                            <ul class="dropdown-menu dropdown-navbar" id="user_menu">
                                <li class="nav-header">
                                    <i class="icon-time"></i>
                                    Logined From {$sessData.User.time}
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="icon-cog"></i>
                                        Account Settings
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="icon-user"></i>
                                        Edit Profile
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="icon-question"></i>
                                        Help
                                    </a>
                                </li>

                                <li class="divider visible-phone"></li>

                                <li class="visible-phone">
                                    <a href="#">
                                        <i class="icon-tasks"></i>
                                        Tasks
                                        <span class="badge badge-warning">4</span>
                                    </a>
                                </li>
                                <li class="visible-phone">
                                    <a href="#">
                                        <i class="icon-bell-alt"></i>
                                        Notifications
                                        <span class="badge badge-important">8</span>
                                    </a>
                                </li>
                                <li class="visible-phone">
                                    <a href="#">
                                        <i class="icon-envelope"></i>
                                        Messages
                                        <span class="badge badge-success">5</span>
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="index.php?module=login&event=logout">
                                        <i class="icon-off"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                            <!-- BEGIN User Dropdown -->
                        </li>