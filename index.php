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
                                    <!-- Tests by Category -->
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
                                                                <p class="browser-count"><?php echo round(($uiCount/$count)*100)?>%</p>
                                                            </div>
                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-primary"
                                                                        role="progressbar" style="width: <?php echo round(($uiCount/$count)*100)?>%"
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
                                                                <p class="browser-count"><?php echo round(($restCount/$count)*100)?>%</p>
                                                            </div>

                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-danger"
                                                                        role="progressbar" style="width: <?php echo round(($restCount/$count)*100)?>%"
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
                                                                <p class="browser-count"><?php echo round(($hybridCount/$count)*100)?>%</p>
                                                            </div>

                                                            <div class="w-browser-stats">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-gradient-warning"
                                                                        role="progressbar" style="width: <?php echo round(($hybridCount/$count)*100)?>%"
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

                                    <!-- Jira connector -->
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-five">
                                            <div class="widget-content">

                                                <div class="header">
                                                    <div class="header-body">
                                                        <h6>Open Bugs</h6>
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

                                    <!-- Test runs donut chart -->
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-chart-two">
                                            <div class="widget-heading">
                                                <h5 class="">Test runs</h5>
                                            </div>
                                            <div class="widget-content">
                                                <div id="test-runs" class=""></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Latest Automation runs -->
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
                                                                <th><div class="th-content th-heading">Total</div></th>
                                                                <th><div class="th-content th-heading">Passed</div></th>
                                                                <th><div class="th-content">Failed</div></th>
                                                                <th><div class="th-content">URL</div></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($latestRuns as $latestRun) {?>
                                                            <tr>
                                                                <td><div class="td-content product-name"><div class="align-self-center"><p class="prd-name"><?php echo $latestRun['node_name']; ?></p><p class="prd-category text-primary"><?php echo $latestRun['parent_node']; ?></p></div></div></td>
                                                                <td><div class="td-content"><span class="pricing"><?php echo $latestRun['total']; ?></span></div></td>
                                                                <td><div class="td-content"><span class="discount-pricing"><?php echo $latestRun['passed']; ?></span></div></td>
                                                                <td><div class="td-content"><?php echo $latestRun['failed']; ?></div></td>
                                                                <td><div class="td-content"><a href="<?php echo $latestRun['test_run_link']; ?>" class="text-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> link</a></div></td>
                                                            </tr>
                                                            <?php } ?>
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
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: 'Total',
              color: '#888ea8',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce(function (a, b) {
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