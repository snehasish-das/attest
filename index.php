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
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />

    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" class="dashboard-analytics" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="assets/css/elements/custom-tree_view.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/editors/quill/quill.snow.css">
    <link href="assets/css/apps/todolist.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/widgets/modules-widgets.css">
    <!--  END CUSTOM STYLE FILE  -->

</head>

<body class="dashboard-analytics admin-header">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <div class="theme-logo">
                <a href="index">
                    <img src="assets/img/247-logo.svg" class="navbar-logo" alt="logo">
                    <span class="admin-logo"><?php echo $site_name; ?><span></span></span>
                </a>
            </div>

            <div class="sidebarCollapseFixed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
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
                                <?php require_once './partials/header.php'; ?>
                            </div>

                            <div class="admin-data-content layout-top-spacing">

                                <div class="row">
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                                        <div class="widget-four">
                                            <div class="widget-heading">
                                                <h5 class="">Tests by category</h5>
                                            </div>
                                            <div class="widget-content">
                                                <div class="vistorsBrowser">
                                                    <div class="browser-list">
                                                        <div class="w-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-globe">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                                                <path
                                                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <div class="w-browser-details">
                                                            <div class="w-browser-info">
                                                                <h6>UI</h6>
                                                                <p class="browser-count">65%</p>
                                                            </div>
                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-primary"
                                                                        role="progressbar" style="width: 65%"
                                                                        aria-valuenow="90" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="browser-list">
                                                        <div class="w-icon">
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                                <path
                                                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <div class="w-browser-details">

                                                            <div class="w-browser-info">
                                                                <h6>API</h6>
                                                                <p class="browser-count">25%</p>
                                                            </div>

                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-danger"
                                                                        role="progressbar" style="width: 35%"
                                                                        aria-valuenow="65" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="browser-list">
                                                        <div class="w-icon">
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
                                                                <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
                                                                <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
                                                                <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
                                                                <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
                                                                <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
                                                            </svg>
                                                        </div>
                                                        <div class="w-browser-details">

                                                            <div class="w-browser-info">
                                                                <h6>Hybrid</h6>
                                                                <p class="browser-count">15%</p>
                                                            </div>

                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-warning"
                                                                        role="progressbar" style="width: 15%"
                                                                        aria-valuenow="15" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-five">
                                            <div class="widget-content">

                                                <div class="header">
                                                    <div class="header-body">
                                                        <h6>Bugs Status</h6>
                                                        <p class="meta-date">Mar 2023</p>
                                                    </div>
                                                </div>

                                                <div class="w-content">
                                                    <div class="">
                                                        <p class="task-left">8</p>
                                                        <p class="task-completed"><span>12 Done</span></p>
                                                        <p class="task-hight-priority"><span>3 Task</span> with High
                                                            priotity</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-chart-two">
                                            <div class="widget-heading">
                                                <h5 class="">Test runs</h5>
                                            </div>
                                            <div class="widget-content">
                                                <div id="chart-2" class=""></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-table-three">

                                            <div class="widget-heading">
                                                <h5 class="">Latest Automation runs</h5>
                                            </div>
   
                                            <div class="widget-content">
                                                <div class="table-responsive">
                                                    <table class="table table-scroll">
                                                        <thead>
                                                            <tr>
                                                                <th><div class="th-content">Node</div></th>
                                                                <th><div class="th-content th-heading">Total Tests</div></th>
                                                                <th><div class="th-content th-heading">Passed</div></th>
                                                                <th><div class="th-content">Failed</div></th>
                                                                <th><div class="th-content">URL</div></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><div class="td-content product-name"><div class="align-self-center"><p class="prd-name">Assist Admin tests</p><p class="prd-category text-primary">Adhoc Runs</p></div></div></td>
                                                                <td><div class="td-content"><span class="pricing">10</span></div></td>
                                                                <td><div class="td-content"><span class="discount-pricing">8</span></div></td>
                                                                <td><div class="td-content">2</div></td>
                                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> link</a></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="td-content product-name"><div class="align-self-center"><p class="prd-name">Assist Admin tests</p><p class="prd-category text-primary">Adhoc Runs</p></div></div></td>
                                                                <td><div class="td-content"><span class="pricing">10</span></div></td>
                                                                <td><div class="td-content"><span class="discount-pricing">8</span></div></td>
                                                                <td><div class="td-content">2</div></td>
                                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> link</a></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="td-content product-name"><div class="align-self-center"><p class="prd-name">Assist Admin tests</p><p class="prd-category text-primary">Adhoc Runs</p></div></div></td>
                                                                <td><div class="td-content"><span class="pricing">10</span></div></td>
                                                                <td><div class="td-content"><span class="discount-pricing">8</span></div></td>
                                                                <td><div class="td-content">2</div></td>
                                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> link</a></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="td-content product-name"><div class="align-self-center"><p class="prd-name">Assist Admin tests</p><p class="prd-category text-primary">Adhoc Runs</p></div></div></td>
                                                                <td><div class="td-content"><span class="pricing">10</span></div></td>
                                                                <td><div class="td-content"><span class="discount-pricing">8</span></div></td>
                                                                <td><div class="td-content">2</div></td>
                                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> link</a></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="td-content product-name"><div class="align-self-center"><p class="prd-name">Assist Admin tests</p><p class="prd-category text-primary">Adhoc Runs</p></div></div></td>
                                                                <td><div class="td-content"><span class="pricing">10</span></div></td>
                                                                <td><div class="td-content"><span class="discount-pricing">8</span></div></td>
                                                                <td><div class="td-content">2</div></td>
                                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> link</a></div></td>
                                                            </tr>
   
   
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-chart-one">
                                            <div class="widget-heading">
                                                <h5 class="">Tests Added this year</h5>
                                            </div>

                                            <div class="widget-content">
                                                <div class="tabs tab-content">
                                                    <div id="content_1" class="tabcontent">
                                                        <div id="revenueMonthly"></div>
                                                    </div>
                                                </div>
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
                                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <rect x="9" y="9" width="13" height="13" rx="2"
                                                                        ry="2"></rect>
                                                                    <path
                                                                        d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <div class="">
                                                                <p class="w-value">1.6K</p>
                                                                <h5 class="">Test Scenarios</h5>
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
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-link">
                                                                    <path
                                                                        d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71">
                                                                    </path>
                                                                    <path
                                                                        d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <div class="">
                                                                <p class="w-value">100</p>
                                                                <h5 class="">Executions</h5>
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
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-message-circle">
                                                                    <path
                                                                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <div class="">
                                                                <p class="w-value">18.2%</p>
                                                                <h5 class="">Automation</h5>
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
                                </div>
                            </div>
                            <div class="footer-wrapper col-xl-12">
                                <?php require './partials/footer.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-right">
                        <?php require_once './partials/notifications.php'; ?>
                    </div>

                </div>
            </div>

        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->
    <?php require_once './partials/modals.php'; ?>

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
    <script src="plugins/treeview/custom-jstree.js"></script>
    <script src="plugins/select2/select2.min.js"></script>
    <script src="plugins/select2/custom-select2.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="plugins/apex/apexcharts.min.js"></script>
    <script src="assets/js/widgets/modules-widgets.js"></script>
    <script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>