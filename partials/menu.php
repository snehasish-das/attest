<?php
    @$currUrl = end(explode('/',$_SERVER['REQUEST_URI']));
?>
<nav id="compactSidebar">
    <ul class="menu-categories">
        <li class="menu menu-single <?php  if($currUrl == 'index' || $currUrl =='') { echo 'active'; }?>">
            <a href="index" data-active="<?php echo ($currUrl == 'index' || $currUrl =='') ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-terminal">
                            <polyline points="4 17 10 11 4 5"></polyline>
                            <line x1="12" y1="19" x2="20" y2="19"></line>
                        </svg>
                    </div>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        <li class="menu <?php  if($currUrl == 'test-plan') { echo 'active'; }?>">
            <a href="#testplan" data-active="<?php echo ($currUrl == 'test-plan') ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-cpu">
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                            <rect x="9" y="9" width="6" height="6"></rect>
                            <line x1="9" y1="1" x2="9" y2="4"></line>
                            <line x1="15" y1="1" x2="15" y2="4"></line>
                            <line x1="9" y1="20" x2="9" y2="23"></line>
                            <line x1="15" y1="20" x2="15" y2="23"></line>
                            <line x1="20" y1="9" x2="23" y2="9"></line>
                            <line x1="20" y1="14" x2="23" y2="14"></line>
                            <line x1="1" y1="9" x2="4" y2="9"></line>
                            <line x1="1" y1="14" x2="4" y2="14"></line>
                        </svg>
                    </div>
                    <span>Test Plan</span>
                </div>
            </a>
        </li>

        <li class="menu" <?php  if($currUrl == 'test-lab') { echo 'active'; }?>>
            <a href="#testlab" data-active="<?php echo ($currUrl == 'test-lab') ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-zap">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                    <span>Test Lab</span>
                </div>
            </a>
        </li>

        <li class="menu menu-single" <?php  if($currUrl == 'requirements') { echo 'active'; }?>>
            <a href="requirements" data-active="<?php echo ($currUrl == 'requirements') ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-box">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <span>Requirements</span>
                </div>
            </a>
        </li>

        <li class="menu menu-single" <?php  if($currUrl == 'releases') { echo 'active'; }?>>
            <a href="releases" data-active="<?php echo ($currUrl == 'releases') ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-file">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                    <span>Releases</span>
                </div>
            </a>
        </li>

        <li class="menu menu-single" <?php  if($currUrl == 'reports') { echo 'active'; }?>>
            <a href="reports" data-active="<?php echo ($currUrl == 'reports') ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-clipboard">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                    </div>
                    <span>Reports</span>
                </div>
            </a>
        </li>

    </ul>
</nav>

<div id="compact_submenuSidebar" class="submenu-sidebar">
    <div class="nav-link dropdown-toggle d-icon label-group">
        <a href="#"> 
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
        </a>
        <a href="#"> 
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
        </a>
    </div>
    <div class="submenu" id="testplan">
        <ul class="submenu-list" data-parent-element="#testplan">
            <li>
                <span class="caret">Test Plan Parent</span>
                <ul class="nested active">
                    <li>
                        <span class="caret caret-down">Empty Child</span>
                        <ul class="nested">
                        </ul>
                    </li>
                    <li>
                        <span class="caret caret-down">Child 1</span>
                        <ul class="nested">
                            <li>Test 1</li>
                        </ul>
                    </li>
                    <li>
                        <span class="caret caret-down">Child 2</span>
                        <ul class="nested">
                            <li>Test 2</li>
                        </ul>
                    </li>
                    <li>
                    <li>Test 3</li>
            </li>
        </ul>
        </li>
        </ul>
    </div>

    <div class="submenu" id="testlab">
        <ul class="submenu-list" data-parent-element="#testlab">
            <li>
                <span class="caret">Test Lab Parent</span>
                <ul class="nested active">
                    <li>
                        <span class="caret caret-down">Empty Child</span>
                        <ul class="nested">
                        </ul>
                    </li>
                    <li>
                        <span class="caret caret-down">Child 1</span>
                        <ul class="nested">
                            <li>Test 1</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                        </ul>
                    </li>
                    <li>
                        <span class="caret caret-down">Child 2</span>
                        <ul class="nested">
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                            <li>Test 2</li>
                        </ul>
                    </li>
                    <li>
                    <li>Test 3</li>
            </li>
        </ul>
        </li>
        </ul>
    </div>

    <!-- <div class="submenu" id="menuSecond">
        <ul class="submenu-list" data-parent-element="#menuSecond">
            <li>
                <a href="javascript:void(0);"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit">
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="1.05" y1="12" x2="7" y2="12"></line>
                            <line x1="17.01" y1="12" x2="22.96" y2="12"></line>
                        </svg></span> Submenu 1 </a>
            </li>
            <li>
                <a href="javascript:void(0);"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit">
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="1.05" y1="12" x2="7" y2="12"></line>
                            <line x1="17.01" y1="12" x2="22.96" y2="12"></line>
                        </svg></span> Submenu 2 </a>
            </li>
            <li>
                <a href="javascript:void(0);"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit">
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="1.05" y1="12" x2="7" y2="12"></line>
                            <line x1="17.01" y1="12" x2="22.96" y2="12"></line>
                        </svg></span> Submenu 3 </a>
            </li>
        </ul>
    </div>

    <div class="submenu" id="menuThird">
        <ul class="submenu-list" data-parent-element="#menuThird">
            <li>
                <a href="dragndrop_dragula.html"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit">
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="1.05" y1="12" x2="7" y2="12"></line>
                            <line x1="17.01" y1="12" x2="22.96" y2="12"></line>
                        </svg></span> Submenu 1 </a>
            </li>
            <li>
                <a href="charts_apex.html"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit">
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="1.05" y1="12" x2="7" y2="12"></line>
                            <line x1="17.01" y1="12" x2="22.96" y2="12"></line>
                        </svg></span> Submenu 2 </a>
            </li>

            <li class="sub-submenu">
                <a role="menu" class="collapsed" data-toggle="collapse" data-target="#auth" aria-expanded="false">
                    <div> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z">
                                </path>
                            </svg></span> Submenu 3 </div> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
                <ul id="auth" class="collapse" data-parent="#compact_submenuSidebar">
                    <li>
                        <a href="javascript:void(0)"> Sub-Submenu 1 </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"> Sub-Submenu 2 </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div> -->

</div>