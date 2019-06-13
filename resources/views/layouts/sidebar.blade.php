            <!--ASIDE-->
            <!--===================================================-->
            <aside id="aside-container">
                <div id="aside">
                    <div class="nano">
                        <div class="nano-content">
                            waiting for development
                        </div>
                    </div>
                </div>
            </aside>
            <!--===================================================-->
            <!--END ASIDE-->

            
            <!--MAIN NAVIGATION-->
            <!--===================================================-->
            <nav id="mainnav-container">
                <div id="mainnav">
                    <!--Menu-->
                    <!--================================-->
                    <div id="mainnav-menu-wrap">
                        <div class="nano">
                            <div class="nano-content">

                                <!--Profile Widget-->
                                <!--================================-->
                                <div id="mainnav-profile" class="mainnav-profile">
                                    <div class="text-center">
                                        <a href="#" class="list-group-item">
                                            <div class="media-left pos-rel">
                                                <img class="img-circle img-sm" src="/robot.jpg" alt="Profile Picture">
                                                <i class="badge badge-success badge-stat badge-icon pull-left"></i>
                                            </div>
                                            <div class="media-body">
                                                <small class="text-muteds">{{ isset(Auth::user()->name) ? Auth::user()->name : '' }}</small>
                                                <p class="mar-no text-main"> 职位</p>
                                                
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <!--Shortcut buttons-->
                                <!--================================-->
                                <div id="mainnav-shortcut" class="hidden">
                                    <ul class="list-unstyled shortcut-wrap">
                                        <li class="col-xs-3" data-content="My Profile">
                                            <a class="shortcut-grid" href="#">
                                                <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                                                <i class="demo-pli-male"></i>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="col-xs-3" data-content="Messages">
                                            <a class="shortcut-grid" href="#">
                                                <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                                <i class="demo-pli-speech-bubble-3"></i>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="col-xs-3" data-content="Activity">
                                            <a class="shortcut-grid" href="#">
                                                <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                                <i class="demo-pli-thunder"></i>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="col-xs-3" data-content="Lock Screen">
                                            <a class="shortcut-grid" href="#">
                                                <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                                                <i class="demo-pli-lock-2"></i>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!--================================-->
                                <!--End shortcut buttons-->


                                <ul id="mainnav-menu" class="list-group">
                        
                                    <!--Category name-->
                                    <li class="list-header">Navigation</li>
                        
                                    <!--Menu list item-->
                                    <li class="{{active_class(Active::checkUriPattern('dashboard'),'active-sub active' )}}">
                                        <a href="/">
                                            <i class="demo-pli-home"></i>
                                            <span class="menu-title">Dashboard</span>
                                        </a>
                                    </li>
                        
                                    <!--Menu list item-->
                                    <li class="{{ active_class(Active::checkUriPattern('chat/*'),'active-sub active' ) }}">
                                        <a href="#">
                                            <i class="demo-pli-split-vertical-2"></i>
                                            <span class="menu-title">Chat</span>
                                            <i class="arrow"></i>
                                        </a>
                        
                                        <!--Submenu-->
                                        <ul class="collapse">
                                            <li class="{{ active_class(Active::checkUriPattern('chat/user/*') ,'active-link active') }}"><a href="{{ route('chat.user.index') }}">用户管理 </a></li>
                                            <li class="{{ active_class(Active::checkUriPattern('chat/room/*') ,'active-link active') }}"><a href="{{ route('chat.room.index') }}">聊天室管理 </a></li>
                                            
                                        </ul>
                                    </li>
                        
                                    <!--Menu list item-->
                                    <li>
                                        <a href="#">
                                            <i class="demo-pli-gear"></i>
                                            <span class="menu-title">
                                                Widgets
                                                <span class="pull-right badge badge-warning">24</span>
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="list-divider"></li>
                        
                                    <!--Category name-->
                                    <li class="list-header">Components</li>
                        
                                    <!--Menu list item-->
                                    <li class="{{ active_class(Active::checkUriPattern('access/*'),'active-sub active' ) }}">
                                        <a href="#">
                                            <i class="demo-pli-gear"></i>
                                            <span class="menu-title">Access Management</span>
                                            <i class="arrow"></i>
                                        </a>
                        
                                        <!--Submenu-->
                                        <ul class="collapse">
                                            <li class="{{ active_class(Active::checkUriPattern('access/user/*') ,'active-link active') }}"><a href="{{ route('access.user.index') }}">User </a></li>
                                            <li class="{{ active_class(Active::checkUriPattern('access/role/*'),'active-link active') }}"><a href="{{ route('access.role.index') }}">Role </a></li>
                                            <li class="{{ active_class(Active::checkUriPattern('access/permission/*'),'active-link active') }}"><a href="{{ route('access.permission.index') }}">Permission </a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--================================-->
                    <!--End menu-->

                </div>
            </nav>
            <!--===================================================-->
            <!--END MAIN NAVIGATION-->