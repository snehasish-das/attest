<?php
session_start();
require_once 'api/src/config/init.php';
$_SESSION['site-url']=BASE_URL;

@$currUrl = end(explode('/',$_SERVER['REQUEST_URI']));
$redirect = $currUrl == '' ? 'index' : $currUrl; 
if (!isset($_SESSION['user-details'])) {
	header("Location: login?redirect=".$redirect);
	exit();
}
require_once 'api/src/functions.php';

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
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" class="dashboard-analytics" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
<body class="dashboard-analytics admin-header">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <div class="theme-logo">
                <a href="index.html">
                    <img src="assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                    <span class="admin-logo"><?php echo $site_name; ?><span></span></span>
                </a>
            </div>

            <div class="sidebarCollapseFixed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </div>
            
            <?php require_once './partials/menu.php'; ?>

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
                                                <h3>Analytics</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="header-actions">
                                        <div class="nav-item dropdown language-dropdown more-dropdown">
                                            <div class="dropdown custom-dropdown-icon">
                                                <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/img/flag-ca2.svg" class="flag-width" alt="flag"><span>English</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                        
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                                                    <a class="dropdown-item" data-img-value="flag-de3" data-value="German" href="javascript:void(0);"><img src="assets/img/flag-de3.svg" class="flag-width" alt="flag"> German</a>
                                                    <a class="dropdown-item" data-img-value="flag-sp" data-value="Spanish" href="javascript:void(0);"><img src="assets/img/flag-sp.svg" class="flag-width" alt="flag"> Spanish</a>
                                                    <a class="dropdown-item" data-img-value="flag-fr3" data-value="French" href="javascript:void(0);"><img src="assets/img/flag-fr3.svg" class="flag-width" alt="flag"> French</a>
                                                    <a class="dropdown-item" data-img-value="flag-ca2" data-value="English" href="javascript:void(0);"><img src="assets/img/flag-ca2.svg" class="flag-width" alt="flag"> English</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="toggle-notification-bar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                        </div>
                                    </div>
                                </header>
                            </div>

                            <div class="admin-data-content layout-top-spacing">

                                <div class="row">
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-one">
                                            <div class="widget-heading">
                                                <h6 class="">Statistics</h6>
                                            </div>
                                            <div class="w-chart">

                                                <div class="w-chart-section total-visits-content">
                                                    <div class="w-detail">
                                                        <p class="w-title">Total Visits</p>
                                                        <p class="w-stats">423,964</p>
                                                    </div>
                                                    <div class="w-chart-render-one">
                                                        <div id="total-users"></div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="w-chart-section paid-visits-content">
                                                    <div class="w-detail">
                                                        <p class="w-title">Paid Visits</p>
                                                        <p class="w-stats">7,929</p>
                                                    </div>
                                                    <div class="w-chart-render-one">
                                                        <div id="paid-visits"></div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-card-four">
                                            <div class="widget-content">
                                                <div class="w-header">
                                                    <div class="w-info">
                                                        <h6 class="value">Expenses</h6>
                                                    </div>
                                                    <div class="task-action">
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                            </a>
                
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                                <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="w-content">

                                                    <div class="w-info">
                                                        <p class="value">$ 45,141 <span>this week</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></p>
                                                        <!-- <p class="">Expenses</p> -->
                                                    </div>
                                                    
                                                </div>

                                                <div class="w-progress-stats">                                            
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>

                                                    <div class="">
                                                        <div class="w-icon">
                                                            <p>57%</p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-account-invoice-two">
                                            <div class="widget-content">
                                                <div class="account-box">
                                                    <div class="info">
                                                        <div class="inv-title">
                                                            <h5 class="">Total Balance</h5>
                                                        </div>
                                                        <div class="inv-balance-info">

                                                            <p class="inv-balance">$ 41,741.42</p>
                                                            
                                                            <span class="inv-stats balance-credited">+ 2453</span>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="acc-action">
                                                        <div class="">
                                                            <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></a>
                                                            <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></a>
                                                        </div>
                                                        <a href="javascript:void(0);">Upgrade</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-card-one">
                                            <div class="widget-content">
                
                                                <div class="media">
                                                    <div class="w-img">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6>Jimmy Turner</h6>
                                                        <p class="meta-date-time">Monday, Nov 18</p>
                                                    </div>
                                                </div>
                
                                                <p>"Duis aute irure dolor" in reprehenderit in voluptate velit esse cillum "dolore eu fugiat" nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
                
                                                <div class="w-action">
                                                    <div class="card-like">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                                        <span>551 Likes</span>
                                                    </div>

                                                    <div class="read-more">
                                                        <a href="javascript:void(0);">Read More <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-chart-three">
                                            <div class="widget-heading">
                                                <div class="">
                                                    <h5 class="">Unique Visitors</h5>
                                                </div>
                
                                                <div class="dropdown ">
                                                    <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                    </a>
                
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="uniqueVisitors">
                                                        <a class="dropdown-item" href="javascript:void(0);">View</a>
                                                        <a class="dropdown-item" href="javascript:void(0);">Update</a>
                                                        <a class="dropdown-item" href="javascript:void(0);">Download</a>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="widget-content">
                                                <div id="uniqueVisits"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                                        <div class="widget-four">
                                            <div class="widget-heading">
                                                <h5 class="">Visitors by Browser</h5>
                                            </div>
                                            <div class="widget-content">
                                                <div class="vistorsBrowser">
                                                    <div class="browser-list">
                                                        <div class="w-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chrome"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>
                                                        </div>
                                                        <div class="w-browser-details">
                                                            <div class="w-browser-info">
                                                                <h6>Chrome</h6>
                                                                <p class="browser-count">65%</p>
                                                            </div>
                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 65%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="browser-list">
                                                        <div class="w-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-compass"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                                                        </div>
                                                        <div class="w-browser-details">
                                                            
                                                            <div class="w-browser-info">
                                                                <h6>Safari</h6>
                                                                <p class="browser-count">25%</p>
                                                            </div>

                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="browser-list">
                                                        <div class="w-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                                        </div>
                                                        <div class="w-browser-details">
                                                            
                                                            <div class="w-browser-info">
                                                                <h6>Others</h6>
                                                                <p class="browser-count">15%</p>
                                                            </div>

                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-activity-five">

                                            <div class="widget-heading">
                                                <h5 class="">Activity Log</h5>

                                                <div class="task-action">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                        </a>
            
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                                            <a class="dropdown-item" href="javascript:void(0);">View All</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Mark as Read</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="widget-content">

                                                <div class="w-shadow-top"></div>

                                                <div class="mt-container mx-auto">
                                                    <div class="timeline-line">
                                                        
                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>New project created : <a href="javscript:void(0);"><span>[<?php echo $site_name; ?> Admin Template]</span></a></h5>
                                                                </div>
                                                                <p>27 Feb, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Mail sent to <a href="javascript:void(0);">HR</a> and <a href="javascript:void(0);">Admin</a></h5>
                                                                </div>
                                                                <p>28 Feb, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Server Logs Updated</h5>
                                                                </div>
                                                                <p>27 Feb, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Task Completed : <a href="javscript:void(0);"><span>[Backup Files EOD]</span></a></h5>
                                                                </div>
                                                                <p>01 Mar, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Documents Submitted from <a href="javascript:void(0);">Sara</a></h5>
                                                                    <span class=""></span>
                                                                </div>
                                                                <p>10 Mar, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Server rebooted successfully</h5>
                                                                    <span class=""></span>
                                                                </div>
                                                                <p>06 Apr, 2020</p>
                                                            </div>
                                                        </div>                                      
                                                    </div>                                    
                                                </div>

                                                <div class="w-shadow-bottom"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row widget-statistic">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                                                <div class="widget widget-one_hybrid widget-followers">
                                                    <div class="widget-heading">
                                                        <div class="w-title">
                                                            <div class="w-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                            </div>
                                                            <div class="">
                                                                <p class="w-value">31.6K</p>
                                                                <h5 class="">Followers</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content">    
                                                        <div class="w-chart">
                                                            <div id="hybrid_followers"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                                                <div class="widget widget-one_hybrid widget-referral">
                                                    <div class="widget-heading">
                                                        <div class="w-title">
                                                            <div class="w-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                                            </div>
                                                            <div class="">
                                                                <p class="w-value">1,900</p>
                                                                <h5 class="">Referral</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content">    
                                                        <div class="w-chart">
                                                            <div id="hybrid_followers1"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                                                <div class="widget widget-one_hybrid widget-engagement">
                                                    <div class="widget-heading">
                                                        <div class="w-title">
                                                            <div class="w-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                                            </div>
                                                            <div class="">
                                                                <p class="w-value">18.2%</p>
                                                                <h5 class="">Engagement</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-content">    
                                                        <div class="w-chart">
                                                            <div id="hybrid_followers3"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-card-two">
                                            <div class="widget-content">

                                                <div class="media">
                                                    <div class="w-img">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6>Dev Summit - New York</h6>
                                                        <p class="meta-date-time">Bronx, NY</p>
                                                    </div>
                                                </div>

                                                <div class="card-bottom-section">
                                                    <h5>4 Members Going</h5>
                                                    <div class="img-group">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                    </div>
                                                    <a href="javascript:void(0);" class="btn">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-five">

                                            <div class="widget-heading">

                                                <a href="javascript:void(0)" class="task-info">

                                                    <div class="usr-avatar">
                                                        <span>FD</span>
                                                    </div>

                                                    <div class="w-title">

                                                        <h5>Figma Design</h5>
                                                        <span>Design Reset</span>
                                                        
                                                    </div>

                                                </a>

                                                <div class="task-action">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                        </a>
            
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                                            <a class="dropdown-item" href="javascript:void(0);">View Project</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Edit Project</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            
                                            <div class="widget-content">

                                                <p>Doloribus nisi vel suscipit modi, optio ex repudiandae voluptatibus officiis commodi. Nesciunt quas aut neque incidunt!</p>

                                                <div class="progress-data">

                                                    <div class="progress-info">
                                                        <div class="task-count"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg><p>5 Tasks</p></div>
                                                        <div class="progress-stats"><p>86.2%</p></div>
                                                    </div>
                                                    
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="meta-info">

                                                    <div class="due-time">
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 3 Days Left</p>
                                                    </div>
                                                    

                                                    <div class="avatar--group">

                                                        <div class="avatar translateY-axis more-group">
                                                            <span class="avatar-title">+6</span>
                                                        </div>
                                                        <div class="avatar translateY-axis">
                                                            <img alt="avatar" src="assets/img/90x90.jpg"/>
                                                        </div>
                                                        <div class="avatar translateY-axis">
                                                            <img alt="avatar" src="assets/img/90x90.jpg"/>
                                                        </div>
                                                        <div class="avatar translateY-axis">
                                                            <img alt="avatar" src="assets/img/90x90.jpg"/>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                                
                                                
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
                    <div class="col-right">
                        <div class="col-right-content">
                            <div class="navbar-item flex-row search-ul navbar-dropdown">
                                <div class="nav-item align-self-center search-animated">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                    <form class="form-inline search-full form-inline search" role="search">
                                        <div class="search-bar">
                                            <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-right-content-container">

                                <div class="activity-section">

                                    <div class="widget-profile">

                                        <div class="w-profile-view">
                                            <img src="assets/img/90x90.jpg" alt="admin-profile" class="img-fluid">
                                            <div class="w-profile-content">
                                                <h6>Alan Green</h6>
                                                <p>Lead Developer</p>
                                            </div>
                                        </div>

                                        <div class="w-profile-links">
                                            <a href="user_profile.html" class="w-p-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                <p>My Profile</p>
                                            </a>

                                            <a href="apps_mailbox.html" class="w-p-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                                                <p>Inbox</p>
                                            </a>
                                        </div>
                                        
                                    </div>

                                    <div class="widget-todo">
                                        <div class="todo-content">
                                            <div class="todo-title">
                                                <h6><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span> <span class="align-self-center">Todo</span></h6>
                                            </div>
                                            <div class="todo-text">
                                                <a href="apps_todoList.html"><p>11 New Task</p></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="widget-message">
                                        <div class="widget-title">
                                            <h5>Messages</h5>
                                            <a href="apps_chat.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                            </a>
                                        </div>

                                        <div class="widget-messages">
                                            <a href="apps_chat.html" class="w-message">
                                                <img src="assets/img/90x90.jpg" alt="" class="img-fluid">
                                                <div class="msg-content">
                                                    <h5 class="w-msg-username">Andy King</h5>
                                                    <p class="w-msg-text">Work is delayed</p>
                                                </div>
                                            </a>

                                            <a href="apps_chat.html" class="w-message">
                                                <img src="assets/img/90x90.jpg" alt="" class="img-fluid">
                                                <div class="msg-content">
                                                    <h5 class="w-msg-username">Alma Clark</h5>
                                                    <p class="w-msg-text">It was a bit dramatic.</p>
                                                </div>
                                            </a>

                                            <a href="apps_chat.html" class="w-message">
                                                <img src="assets/img/90x90.jpg" alt="" class="img-fluid">
                                                <div class="msg-content">
                                                    <h5 class="w-msg-username">Vincent</h5>
                                                    <p class="w-msg-text">Coffee?</p>
                                                </div>
                                            </a>

                                            <a href="apps_chat.html" class="w-message">
                                                <img src="assets/img/90x90.jpg" alt="" class="img-fluid">
                                                <div class="msg-content">
                                                    <h5 class="w-msg-username">Iris Hofman</h5>
                                                    <p class="w-msg-text">Not comming to office today.</p>
                                                </div>
                                            </a>

                                            <a href="apps_chat.html" class="w-message">
                                                <img src="assets/img/90x90.jpg" alt="" class="img-fluid">
                                                <div class="msg-content">
                                                    <h5 class="w-msg-username">Linda Nelson</h5>
                                                    <p class="w-msg-text">Uploaded files to server.</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="widget-invoice">
                                        <div class="widget-title">
                                            <h5>New Invoice</h5>
                                            <a href="apps_invoice.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                            </a>
                                        </div>

                                        <div class="widget-invoice-lists">
                                            <div class="w-invoice">
                                                <p class="w-inv-text"><a href="apps_invoice.html"><span class="inv-number">#002658</span></a> is generated for <span class="usr-name">Laurie Fox</span></p>
                                            </div>

                                            <div class="w-invoice">
                                                <p class="w-inv-text"><a href="apps_invoice.html"><span class="inv-number">#0036489</span></a> is generated for <span class="usr-name">Ernest Reeves</span></p>
                                            </div>

                                            <div class="w-invoice">
                                                <p class="w-inv-text"><a href="apps_invoice.html"><span class="inv-number">#014778</span></a> is generated for <span class="usr-name">Sean Freeman</span></p>
                                            </div>

                                            <div class="w-invoice">
                                                <p class="w-inv-text"><a href="apps_invoice.html"><span class="inv-number">#0165987</span></a> is generated for <span class="usr-name">Nia Hillyer</span></p>
                                            </div>

                                            <div class="w-invoice">
                                                <p class="w-inv-text"><a href="apps_invoice.html"><span class="inv-number">#0265998</span></a> is generated for <span class="usr-name">Dale Butler</span></p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="widget-taskBoard">
                                        <div class="widget-title">
                                            <h5>Task Board</h5>
                                            <a href="apps_scrumboard.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </a>
                                        </div>

                                        <div class="widget-taskBoard-lists">
                                            <div class="w-taskBoard">
                                                <p class="w-taskBoard-text"><a href="apps_scrumboard.html"><span class="taskBoard-number">Launch New Seo Wordpress Theme</span></a> has been moved to <span class="taskBoard-name">Completed</span> Board by <span class="usr-name">Alma Clark</span></p>
                                            </div>

                                            <div class="w-taskBoard">
                                                <p class="w-taskBoard-text"><a href="apps_scrumboard.html"><span class="taskBoard-number">New Task</span></a> is added by <span class="usr-name">Ernest Reeves</span></p>
                                            </div>

                                            <div class="w-taskBoard">
                                                <p class="w-taskBoard-text"><a href="apps_scrumboard.html"><span class="taskBoard-number">Dinner with Kelly Young</span></a> has been moved to <span class="taskBoard-name">Completed</span> Board by <span class="usr-name">Dale Butler</span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="widget-calendar">
                                        <div class="widget-title">
                                            <h5>Event Notifications</h5>

                                            <div class="task-action">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                    </a>
        
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                                        <a class="dropdown-item" href="javascript:void(0);">View All</a>
                                                        <a class="dropdown-item" href="javascript:void(0);">Mark as Read</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="widget-calendar-lists">
                                            <div class="widget-calendar-lists-scroll">
                                                <a href="apps_calendar.html" class="w-calendar w-calendar-c6">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                    </div>
                                                    <p class="w-calendar-text"><span class="calendar-number">New Event</span> has been added on <span class="calendar-name">15 Dec 2020</span></p>
                                                </a>

                                                <a href="apps_calendar.html" class="w-calendar w-calendar-c3">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                    <p class="w-calendar-text">Collect <span class="calendar-number">documents</span> from <span class="calendar-number">Kelly</span> at the restaurant tommorrow.</p>
                                                </a>

                                                <a href="apps_calendar.html" class="w-calendar w-calendar-c1">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                    <p class="w-calendar-text"><span class="calendar-number">Meeting Event</span> on 12 Nov has been updated to 8 PM</p>
                                                </a>

                                                <a href="apps_calendar.html" class="w-calendar w-calendar-c5">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                    </div>
                                                    <p class="w-calendar-text"><span class="calendar-number">New Event</span> Seminar organised by Design Reset will be held on 25 January</p>
                                                </a>

                                                <a href="apps_calendar.html" class="w-calendar w-calendar-c2">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                    </div>
                                                    <p class="w-calendar-text">Today's <span class="calendar-number">Conference</span> is Cancelled.</p>
                                                </a>

                                                <a href="apps_calendar.html" class="w-calendar w-calendar-c4">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                    <p class="w-calendar-text">Meeting with <span class="calendar-number">Project Lead</span> on 01 Jan has been updated to 15 Jan</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
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
    <script src="plugins/apex/apexcharts.min.js"></script>
    <script src="assets/js/dashboard/dash_1.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>
</html>