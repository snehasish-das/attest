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
    <title><?php echo $site_name; ?> - Test Plan</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
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
                <a href="index">
                    <img src="assets/img/247-logo.svg" class="navbar-logo" alt="logo">
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
                                <?php require_once './partials/header.php'; ?>
                            </div>

                            <div class="admin-data-content layout-top-spacing">

                                <div class="row">
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
                                    <p class="">© <?php echo date('Y'); ?> <a target="_blank" href="https://www.247.ai/">247.ai</a></p>
                                </div>
                                <div class="footer-section f-section-2">
                                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                                </div>
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