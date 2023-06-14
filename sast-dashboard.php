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


//Tests by category
$tests_url = $_SESSION['site-url'] . '/api/reports/tests-by-category';
$tests = json_decode($cta->httpGetWithAuth($tests_url,$_SESSION['auth-phrase']), true);
$count=1; $uiCount=0; $restCount=0; $hybridCount=0;
foreach($tests as $test){
    if($test['test_category'] == 'UI'){
        $uiCount = $test['count'];
        $count+= $test['count'];
    }
    if($test['test_category'] == 'REST'){
        $restCount = $test['count'];
        $count+= $test['count'];
    }
    if($test['test_category'] == 'HYBRID'){
        $hybridCount = $test['count'];
        $count+= $test['count'];
    }
}


//Test runs by type
$runs_url = $_SESSION['site-url'] . '/api/reports/test-runs-by-type';
$runs = json_decode($cta->httpGetWithAuth($runs_url,$_SESSION['auth-phrase']), true);
$adhocCount=0; $featureCount=0; $releaseCount=0;
foreach($runs as $run){
    if(strtolower($run['parent_node']) == 'adhoc runs'){
        //echo '<br>Adhoc Runs: '. $adhocCount;
        $adhocCount = $run['count'];
    }
    if(strtolower($run['parent_node']) == 'feature runs'){
        //echo '<br>Feature Runs: '. $featureCount;
        $featureCount = $run['count'];
    }
    if(strtolower($run['parent_node']) == 'release runs'){
        //echo '<br>Release Runs: '. $releaseCount;
        $releaseCount = $run['count'];
    }
}
//echo '<br>Adhoc: '. $adhocCount .', Feature: '. $featureCount .', Release: '. $releaseCount;


//Test runs by type
$latest_runs_url = $_SESSION['site-url'] . '/api/reports/lastest-runs';
$latestRuns = json_decode($cta->httpGetWithAuth($latest_runs_url,$_SESSION['auth-phrase']), true);
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

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-account-invoice-three">
                                            <div class="widget-heading">
                                                <div class="wallet-usr-info">
                                                    <div class="usr-name">
                                                        <span><img src="assets/img/90x90.jpg" alt="admin-profile"
                                                                class="img-fluid"> Alan Green</span>
                                                    </div>
                                                    <div class="add">
                                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-plus">
                                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                            </svg></span>
                                                    </div>
                                                </div>
                                                <div class="wallet-balance">
                                                    <p>Wallet Balance</p>
                                                    <h5 class=""><span class="w-currency">$</span>2953</h5>
                                                </div>
                                            </div>

                                            <div class="widget-amount">

                                                <div class="w-a-info funds-received">
                                                    <span>Received <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-up">
                                                            <polyline points="18 15 12 9 6 15"></polyline>
                                                        </svg></span>
                                                    <p>$97.99</p>
                                                </div>

                                                <div class="w-a-info funds-spent">
                                                    <span>Spent <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg></span>
                                                    <p>$53.00</p>
                                                </div>
                                            </div>

                                            <div class="widget-content">

                                                <div class="bills-stats">
                                                    <span>Pending</span>
                                                </div>

                                                <div class="invoice-list">

                                                    <div class="inv-detail">
                                                        <div class="info-detail-1">
                                                            <p>Netflix</p>
                                                            <p><span class="w-currency">$</span> <span
                                                                    class="bill-amount">13.85</span></p>
                                                        </div>
                                                        <div class="info-detail-2">
                                                            <p>BlueHost VPN</p>
                                                            <p><span class="w-currency">$</span> <span
                                                                    class="bill-amount">15.66</span></p>
                                                        </div>
                                                    </div>

                                                    <div class="inv-action">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-outline-primary view-details">View
                                                            Details</a>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-outline-primary pay-now">Pay Now $29.51</a>
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
                    <!-- <div class="col-right">
                        <?php //require_once './partials/notifications.php'; ?>
                    </div> -->

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

    <script>
    /*
      ==================================
          Test runs By Type | Options
      ==================================
  */
    var options = {
        chart: {
            type: 'donut',
            width: 380
        },
        colors: ['#2196f3', '#e2a03f', '#8738a7'],
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
            },
            itemMargin: {
                horizontal: 0,
                vertical: 8
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '29px',
                            fontFamily: 'Nunito, sans-serif',
                            color: undefined,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '26px',
                            fontFamily: 'Nunito, sans-serif',
                            color: '20',
                            offsetY: 16,
                            formatter: function(val) {
                                return val
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            color: '#888ea8',
                            formatter: function(w) {
                                return w.globals.seriesTotals.reduce(function(a, b) {
                                    return a + b
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
        stroke: {
            show: true,
            width: 25,
        },
        series: [<?php echo $adhocCount.','.$releaseCount.','.$featureCount ?>],
        labels: ['Adhoc', 'Release', 'Feature'],
        responsive: [{
            breakpoint: 1599,
            options: {
                chart: {
                    width: '350px',
                    height: '400px'
                },
                legend: {
                    position: 'bottom'
                }
            },

            breakpoint: 1439,
            options: {
                chart: {
                    width: '250px',
                    height: '390px'
                },
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                        }
                    }
                }
            },
        }]
    }
    var chart = new ApexCharts(
        document.querySelector("#test-runs"),
        options
    );

    chart.render();
    </script>
</body>

</html>