<?php
session_start();
if (!isset($_SESSION['user-details'])) {
	header("Location: index.php");
	exit();
}
require_once '../api/src/functions.php';

$cta = new CallToAction();
$site_name_url = $_SESSION['site-url'] . '/api/site_options/site_name';
$data = json_decode($cta->httpGet($site_name_url), true);
$site_name = $data[0]['option_value'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $site_name; ?> - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <style>

        /* 
            Note: If you are using this demo without activity sidebar then you have to make some changes by applying the .admin-data-content css inside structure.css
        */

        .admin-data-content {
            height: calc(100vh - 132px);
            max-width: 100%;
            margin: 0;
        }
        .admin-header .header-container {
            margin: 0;
            max-width: 100%;
        }
        .footer-wrapper {
            max-width: 100%;
            margin: 0;
        }


        /* User Profile Dropdown*/
        .admin-header .header-container .nav-item.user-profile-dropdown {
            align-self: center;
            padding: 0;
            border-radius: 8px;
            margin-left: 22px;
            margin-right: 0;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-toggle {
            display: flex;
            justify-content: flex-end;
            padding: 0 20px 0 16px;
            transition: .5s;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-toggle:after {
            display: none;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-toggle svg {
            color: #515365;
            width: 15px;
            height: 15px;
            align-self: center;
            margin-left: 6px;
            stroke-width: 1.7px;
            -webkit-transition: -webkit-transform .2s ease-in-out;
            transition: -webkit-transform .2s ease-in-out;
            transition: transform .2s ease-in-out;
            transition: transform .2s ease-in-out, -webkit-transform .2s ease-in-out;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown.show .dropdown-toggle svg {
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        .admin-header .header-container .nav-item.user-profile-dropdown a.user .media {
            margin: 0;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown a.user .media img {
            width: 33px;
            height: 33px;
            border-radius: 6px;
            box-shadow: 0 0px 0.9px rgba(0, 0, 0, 0.07), 0 0px 7px rgba(0, 0, 0, 0.14); 
            margin-right: 13px;
            border: none;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown a.user .media .media-body {
            flex: auto;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown a.user .media .media-body h6 {
            color: #4361ee;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 0;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown a.user .media .media-body h6 span {
            color: #515365;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown a.user .media .media-body p {
            color: #bfc9d4;
            font-size: 10px;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .nav-link.user {
            padding: 0 0;
            font-size: 25px;
        }
        .admin-header .header-container .nav-item.dropdown.user-profile-dropdown .nav-link:after { display: none; }

        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu {
            z-index: 9999;
            max-width: 13rem;
            padding: 0 11px;
            top: 166%!important;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu.show {
            top: 42px!important;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .user-profile-section {
            padding: 16px 14px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            margin-right: -12px;
            margin-left: -12px;
            background: rgb(96 152 149);
            margin-top: -1px;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .user-profile-section .media {
            margin: 0;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .user-profile-section .media img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 3px solid rgb(224 230 237 / 58%);
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .user-profile-section .media .media-body {
            align-self: center;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .user-profile-section .media .media-body h5 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 0;
            color: #fafafa;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .user-profile-section .media .media-body p {
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 0;
            color: #e0e6ed;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item {
            padding: 0;
            background: transparent;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item a {
            display: block;
            color: #3b3f5c;
            font-size: 13px;
            font-weight: 600;
            padding: 9px 14px;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item a:hover {
            color: #000
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item.active,
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item:active {
            background-color: transparent;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item:not(:last-child) {
            border-bottom: 1px solid #ebedf2;
        }
        .admin-header .header-container .nav-item.user-profile-dropdown .dropdown-menu .dropdown-item svg {
            width: 17px;
            margin-right: 7px;
            height: 17px;
            color: #009688;
            fill: rgb(0 150 136 / 13%);
        }

        #content .col-left {
            margin-right: 0;
        }
        
        /*
            The below code is for DEMO purpose --- Use it if you are using this demo otherwise, Remove it
        */
        .navbar .navbar-item.navbar-dropdown {
            margin-left: auto;
        }
        .layout-px-spacing {
            min-height: calc(100vh - 145px)!important;
        }

    </style>

    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    
</head>
<body class="collapsable-menu starterkit admin-header">
    
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sidebar-closed sbar-open" id="container">

        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <div class="theme-logo">
                <a href="index.html">
                    <img src="assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                    <span class="admin-logo">CORK<span></span></span>
                </a>
            </div>

            <div class="sidebarCollapseFixed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </div>
            
            <nav id="compactSidebar">
                <ul class="menu-categories">
                    <li class="menu active submenu-closed">
                        <a href="#starterKit" data-active="true" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-terminal"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                                </div>
                                <span>Starter Kit</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="#menuFirst" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                </div>
                                <span>Menu 1</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="#menuSecond" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                </div>
                                <span>Menu 2</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="#menuThird" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                </div>
                                <span>Menu 3</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu menu-single">
                        <a href="widgets.html" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                </div>
                                <span>Menu 4</span>
                            </div>
                        </a>
                    </li>
                    
                </ul>
            </nav>

            <div id="compact_submenuSidebar" class="submenu-sidebar">

                <div class="submenu" id="starterKit">
                    <ul class="submenu-list" data-parent-element="#starterKit"> 
                        <li class="active">
                            <a href="starter_kit_blank_page.html"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Blank Page </a>
                        </li>
                        <li>
                            <a href="starter_kit_breadcrumb.html"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Breadcrumb </a>
                        </li>
                        <li>
                            <a href="starter_kit_alt_menu.html"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Alternate Menu </a>
                        </li>
                    </ul>
                </div>

                <div class="submenu" id="menuFirst">
                    <ul class="submenu-list menu-block-submenu" data-parent-element="#menuFirst"> 
                        <li class="menu-block">
                            <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg> Submenu 1 </a>
                        </li>
                        <li class="menu-block">
                            <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> Submenu 2 </a>
                        </li>
                    </ul>
                </div>

                <div class="submenu" id="menuSecond">
                    <ul class="submenu-list" data-parent-element="#menuSecond"> 
                        <li>
                            <a href="javascript:void(0);"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Submenu 1 </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Submenu 2 </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Submenu 3 </a>
                        </li>
                    </ul>
                </div>

                <div class="submenu" id="menuThird">
                    <ul class="submenu-list" data-parent-element="#menuThird">
                        <li>
                            <a href="dragndrop_dragula.html"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Submenu 1 </a>
                        </li>
                        <li>
                            <a href="charts_apex.html"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-commit"><circle cx="12" cy="12" r="4"></circle><line x1="1.05" y1="12" x2="7" y2="12"></line><line x1="17.01" y1="12" x2="22.96" y2="12"></line></svg></span> Submenu 2 </a>
                        </li>

                        <li class="sub-submenu">
                            <a role="menu" class="collapsed" data-toggle="collapse" data-target="#auth" aria-expanded="false"><div> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg></span> Submenu 3 </div> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a>
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
                </div>

            </div>

        </div>
        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                
                <div class="content-container">

                    <div class="col-left layout-top-spacing">
                        <div class="col-left-content">

                            <div class="header-container">
                                <header class="header navbar navbar-expand-sm">                                    
                                    <div class="d-flex">
                                        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                                            <div class="bt-menu-trigger">
                                                <span></span>
                                            </div>
                                        </a>
                                        <div class="page-header">
                                            <div class="page-title">
                                                <h3>Blank Page</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="header-actions">

                                        <div class="nav-item dropdown user-profile-dropdown">
                                            <a href="#" class="nav-link dropdown-toggle user" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                                <div class="media">
                                                    <img src="assets/img/90x90.jpg" class="img-fluid" alt="admin-profile">
                                                    <div class="media-body align-self-center">
                                                        <h6>Alan</h6>
                                                    </div>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </a>
                                            <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                                                <div class="user-profile-section">
                                                    <div class="media mx-auto">
                                                        <img src="assets/img/90x90.jpg" class="img-fluid mr-2" alt="avatar">
                                                        <div class="media-body">
                                                            <h5>Alan Green</h5>
                                                            <p>Project Leader</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-item">
                                                    <a href="user_profile.html">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>My Profile</span>
                                                    </a>
                                                </div>
                                                <div class="dropdown-item">
                                                    <a href="apps_mailbox.html">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span>My Inbox</span>
                                                    </a>
                                                </div>
                                                <div class="dropdown-item">
                                                    <a href="auth_lockscreen.html">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Lock Screen</span>
                                                    </a>
                                                </div>
                                                <div class="dropdown-item">
                                                    <a href="auth_login.html">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                                                    </a>
                                                </div>
                                            </div>
                        
                                        </div>
                                        
                                    </div>
                                </header>
                            </div>

                            <div class="admin-data-content layout-top-spacing">

                                <div class="row layout-top-spacing">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                                        <div class="widget-content-area br-4">
                                            <div class="widget-one">
                
                                                <h6>Kick Start you new project with ease!</h6>
                
                                                <p class="">With CORK starter kit, you can begin your work without any hassle. The starter page is highly optimized which gives you freedom to start with minimal code and add only the desired components and plugins required for your project.</p>
                
                                            </div>
                                        </div>
                                    </div>
                
                                </div>
                                
                            </div>
                            <div class="footer-wrapper col-xl-12">
                                <div class="footer-section f-section-1">
                                    <p class="">© 2021 <a target="_blank" href="https://designreset.com">DesignReset</a></p>
                                </div>
                                <div class="footer-section f-section-2">
                                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>
</html>