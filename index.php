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
                                                <h5 class="">Tests by Browser</h5>
                                            </div>
                                            <div class="widget-content">
                                                <div class="vistorsBrowser">
                                                    <div class="browser-list">
                                                        <div class="w-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-chrome">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <circle cx="12" cy="12" r="4"></circle>
                                                                <line x1="21.17" y1="8" x2="12" y2="8"></line>
                                                                <line x1="3.95" y1="6.06" x2="8.54" y2="14"></line>
                                                                <line x1="10.88" y1="21.94" x2="15.46" y2="14"></line>
                                                            </svg>
                                                        </div>
                                                        <div class="w-browser-details">
                                                            <div class="w-browser-info">
                                                                <h6>Chrome</h6>
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
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-compass">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <polygon
                                                                    points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76">
                                                                </polygon>
                                                            </svg>
                                                        </div>
                                                        <div class="w-browser-details">

                                                            <div class="w-browser-info">
                                                                <h6>Safari</h6>
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
                                                                <h6>Others</h6>
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
                                        <div class="widget widget-activity-five">

                                            <div class="widget-heading">
                                                <h5 class="">Activity Log</h5>

                                                <div class="task-action">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button"
                                                            id="pendingTask" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-more-horizontal">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="19" cy="12" r="1"></circle>
                                                                <circle cx="5" cy="12" r="1"></circle>
                                                            </svg>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="pendingTask"
                                                            style="will-change: transform;">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                All</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Mark as
                                                                Read</a>
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
                                                                <div class="t-secondary"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-plus">
                                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                                    </svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>New Feature created : <a
                                                                            href="javscript:void(0);"><span>[Kiran
                                                                                S]</span></a></h5>
                                                                </div>
                                                                <p>27 Feb, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-success"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-mail">
                                                                        <path
                                                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                                        </path>
                                                                        <polyline points="22,6 12,13 2,6"></polyline>
                                                                    </svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Mail sent to <a href="javascript:void(0);">E2E
                                                                            Squad</a> for automation test failure
                                                                        analysis</h5>
                                                                </div>
                                                                <p>28 Feb, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-primary"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-check">
                                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                                    </svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Thor release testing completed</h5>
                                                                </div>
                                                                <p>27 Feb, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-danger"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-check">
                                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                                    </svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Task Completed : <a
                                                                            href="javscript:void(0);"><span>[Backup
                                                                                Files EOD]</span></a></h5>
                                                                </div>
                                                                <p>01 Mar, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-warning"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-file">
                                                                        <path
                                                                            d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                                                        </path>
                                                                        <polyline points="13 2 13 9 20 9"></polyline>
                                                                    </svg></div>
                                                            </div>
                                                            <div class="t-content">
                                                                <div class="t-uppercontent">
                                                                    <h5>Documents Submitted from <a
                                                                            href="javascript:void(0);">Sara</a></h5>
                                                                    <span class=""></span>
                                                                </div>
                                                                <p>10 Mar, 2020</p>
                                                            </div>
                                                        </div>

                                                        <div class="item-timeline timeline-new">
                                                            <div class="t-dot">
                                                                <div class="t-dark"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-server">
                                                                        <rect x="2" y="2" width="20" height="8" rx="2"
                                                                            ry="2"></rect>
                                                                        <rect x="2" y="14" width="20" height="8" rx="2"
                                                                            ry="2"></rect>
                                                                        <line x1="6" y1="6" x2="6" y2="6"></line>
                                                                        <line x1="6" y1="18" x2="6" y2="18"></line>
                                                                    </svg></div>
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
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-users">
                                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2">
                                                                    </path>
                                                                    <circle cx="9" cy="7" r="4"></circle>
                                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
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
    <script src="assets/js/dashboard/dash_1.js"></script>
    <script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>