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


$platform = array("platform:createbot","platform:dal","platform:dialogmanager","platform:dialog-manager-runtimeclient","platform:messenger-handler-webview","platform:integrated-tool-suite","platform:locations","platform:mca-slack","platform:messenger-client-onboarding","platform:messenger-commons","platform:messenger-distributor","platform:messenger-handler-abc","platform:messenger-handler-abc","platform:messenger-handler-abc","platform:messenger-handler-abc","platform:messenger-standard-scxml","platform:msg-deliverer","platform:node-analytics-client","platform:node-apigee-client","platform:node-cassandra-client","platform:node-messenger-card-maker","platform:node-messenger-card-maker","platform:node-messenger-card-maker","platform:node-nl","platform:node-service-template","platform:omnichannel-content-schema","platform:registrations","platform:messenger-omnichannel-scxml","speech-binlog-sessionizer-etl","platform:tfs-ui","platform:ude-console-service","platform:ude-console-schema","platform:ude-console-service","platform:ude-console-ui","platform:ude-frontends-service","platform:ude-native-sdk","platform:vagent-orchestrator","platform:voicebiometrics","platform:web2nl","platform:web2spell","platform:whatsappmca","speech-callsearch-webservice","tmmain-binlog2idm","platform:omnichannel-orchestrator-mechanisms","platform:omnichannel-uia","247inc-speakerverificationdemo-vxml","247inc-speakerverificationdemo-vxml","msft_stt_audio_stream_demo","speech-ana-webservice","speech-binlog-sessionizer-etl","custom-jobs","ATTLocality-jobs","kafka-producer","ATT-CDR","InvoiceDetailsReport","tfs-commons","pdsp-wrapper");
$mwb = array("advancedprototype:conversation-discovery","advancedprototype:conversation-discovery","advancedprototype:conversation-discovery","advancedprototype:conversation-discovery","advancedprototypes:modelbuilder-web-service","advancedprototypes-ui");
$ci = array("ingress-pipeline","client-uploader","kafka-integration-service-java");
$central = array("Central-cobp-be","Central-cobp-fe","Central-org-hierarchy-service","dcc","dcrs","Central-config-versioning","config-listener","Central-org-hierarchy-cache","Central-ajuba-admin-console","Central-reload-framework");
$speech = array("cosmos_indexer","speech_elastic_search","wcr_ap","speech-clientprov-webservice","filebeat_config","tpc-writer","raw-events-writer","speech-cassandra-etl","tm_tree","sisyphus_reports","247Genericpackages","utt_process","speech-modernization-studio-web-app","pcentral","TPM","binlog-sender","speech-modernization-studio-web-app","speech-modernization-studio-web-app","telaudio","cms_packages","speech-api-webservice","smpp_gateway","switchboard","Tellme-Mommy-sls","mod_tmwcr","call-recording-api-webservice","reports-api-webservice","admin_log_relay","Tellme-OutboundProcess develo","Tellme-OutboundProcess develo","Tellme-OutboundProcess develo","speech_elastic-search-7.1.0","sisyphus_db","lgspack","commons-webreco","gmspack","jobctl_package","siteadmin_reco","outbound_process","outbound_portal","notifypackages","mmep-sma-2","web2mm","Hindsightpackages","platform:function-executor-scxml","speech_kibana","sisyphuspackages","redis_centos6_sentinel","ana_webserver","CCXML","vault_database","content_static","web_calltools","content_static_private","247Genericpackages","extranet-devlog","speech-modernization-studio-web-app","speech-modernization-studio-web-app","speech-modernization-studio-web-app","cpm-webapp","outbound_vxml","speech-modernization-studio-web-app","cdr-ani-removal","speech-modernization-studio-web-app","speech-modernization-studio-web-app","tgs_configuration","ExpManager","tgs_jobctl_statusweb","tgs_jobctl_data","lgs","speech-monitoring-jobs","calldisplay","speech-callsearch-webservice","TTS-Containers","cms","CosmosTMScope","www-resources","extranet-devlog","sipproxy","statusd-checks-devlogs","statusd-checks-devlogs","statusd-checks-devlogs","statusd-checks-devlogs","outbound_qm_db");
$assist = array("visitor-service-ef","breeze null","Assist-PE_nemo-core","Assist-PE_nemo-miscellaneous","com.tfs.answers:ir-user-core","platform:node-messenger-auth-token","Assist-PE_chronos-core","bridge","logarchiver assist-3.26","CRM-Integration","Assist-PE_chronos-base","mailer-service","speech-callsearch-webservice","http-utils");

$repos = array("platform:dialogmanager");
@$sast_type = @$_REQUEST['type'];

if($sast_type=='platform'){
    $repos = $platform;
}
if($sast_type=='mwb'){
    $repos = $mwb;
}
if($sast_type=='ci'){
    $repos = $ci;
}
if($sast_type=='central'){
    $repos = $central;
}
if($sast_type=='speech'){
    $repos = $speech;
}
if($sast_type=='assist'){
    $repos = $assist;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SAST Dashboard - <?php echo $site_name; ?></title>
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
                                    <?php foreach($repos as $repo) {
                                    //Retrieve status data
                                    $statusUrl = SONAR_URL . '/project_branches/list?project='. $repo;
                                    $statusData = json_decode($cta->httpGet($statusUrl), true);
                                    $analysisDate = date_format(date_create($statusData['branches'][0]['analysisDate']),"d-M-Y");
                                    $currStatus =  $statusData['branches'][0]['status']['qualityGateStatus'];

                                    //retrieve component data
                                    $componentUrl = SONAR_URL . '/measures/component?additionalFields=metrics,periods&component='.$repo.'&metricKeys=bugs,vulnerabilities,code_smells,coverage,duplicated_lines_density';
                                    $componentData = json_decode($cta->httpGet($componentUrl), true);
                                    $measures = $componentData['component']['measures'];
                                    //$measuresArray
                                    //echo '<br>Bugs:'. $componentData['component']['measures'][2]['value'];

                                    //retrieve history data
                                    $fromDate = date('Y-m-d', strtotime("-30 days")); // Y-m-d
                                    //$fromDate->add(new DateInterval('P30D'));
                                    $toDate = date('Y-m-d');
                                    $historyUrl = SONAR_URL . '/measures/search_history?component='.$repo.'&metrics=bugs,vulnerabilities,code_smells,coverage,duplicated_lines_density&from='.$fromDate.'&to='.$toDate;
                                    //echo '<hr> History URL:'. $historyUrl;
                                    $historyData = json_decode($cta->httpGet($historyUrl), true);
                                    //echo '<hr> History Data:'. json_encode($historyData);
                                    //$measuresArray
                                    //echo '<br>Coverage:'. $historyData['measures'][0]['history'][0]['value'];

                                    $finalArray = array(); $historyDates = array();
                                    $ms= $historyData['measures'];
                                    foreach($ms as $measure){
                                        $dataArray = array();
                                        $dataArray['name'] = $measure['metric'];
                                        $value = array();
                                        $hCount = 0;
                                        $metrics = $measure['history'];
                                        $limit=1;
                                        foreach($metrics as $metric){
                                            array_push($value,$metric['value']);
                                            array_push($historyDates,date_format(date_create($metric['date']),"d-M-Y"));
                                            $hCount++;
                                            $limit++;
                                            if($limit > 10){
                                                break;
                                            }
                                        }
                                        //echo '<br><hr>No. of Values: '. sizeof($value);
                                        $dataArray['data']=$value;
                                        array_push($finalArray,$dataArray);
                                    }

                                    $historyDates = array_slice($historyDates,0,$hCount);
                                    // echo '<br><hr>'. json_encode($finalArray);
                                    // echo '<br><hr>'. json_encode($historyDates);
                                    // echo '<br><hr>No. of dates: '. sizeof($historyDates);

                                    
                                ?>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="widget widget-account-invoice-three">
                                            <div class="widget-heading">
                                                <div class="wallet-usr-info">
                                                    <div class="usr-name">
                                                        <span><?php echo ucfirst($repo).'('.$analysisDate.')'; ?></span>
                                                        <span
                                                            class="<?php echo ($currStatus == 'OK')? 'success': 'failure' ?>"><?php echo ($currStatus == 'OK')? 'SUCCESS': $currStatus; ?></span>
                                                    </div>
                                                </div>
                                                <!-- <div class="wallet-balance">
                                                        <p><?php echo ucfirst($repo); ?></p>
                                                        <p><?php echo $analysisDate; ?></p>
                                                    </div> -->
                                            </div>

                                            <div class="widget-amount">
                                                <?php foreach($measures as $measure){ ?>
                                                <div
                                                    class="w-a-info <?php if($measure['bestValue'] == 'true') echo 'funds-received'; else echo 'funds-spent'; ?>">
                                                    <span><?php echo $measure['metric'].' '; if($measure['bestValue'] == 'true') echo '<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-chevron-up">
                                                                <polyline points="18 15 12 9 6 15"></polyline>
                                                            </svg>'; else echo '<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-chevron-down">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>'; ?></span>
                                                    <p><?php echo $measure['value']; ?></p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php 
                                                $sastOptions = "{
                                                    chart: {
                                                        fontFamily: 'Quicksand, sans-serif',
                                                        height: 365,
                                                        type: 'area',
                                                        zoom: {
                                                            enabled: false
                                                        },
                                                        dropShadow: {
                                                            enabled: true,
                                                            opacity: 0.2,
                                                            blur: 10,
                                                            left: -7,
                                                            top: 22
                                                        },
                                                        toolbar: {
                                                            show: false
                                                        },
                                                        events: {
                                                            mounted: function(ctx, config) {
                                                                const highest1 = ctx.getHighestValueInSeries(0);
                                                                const highest2 = ctx.getHighestValueInSeries(1);
                                                            },
                                                        }
                                                    },
                                                    colors: ['#2196f3', '#6d17cb', '#e7515a', '#4361ee', '#009688', '#fc9842'],
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    markers: {
                                                        discrete: [{
                                                            seriesIndex: 0,
                                                            dataPointIndex: 7,
                                                            fillColor: '#000',
                                                            strokeColor: '#000',
                                                            size: 5
                                                        }, {
                                                            seriesIndex: 2,
                                                            dataPointIndex: 11,
                                                            fillColor: '#000',
                                                            strokeColor: '#000',
                                                            size: 4
                                                        }]
                                                    },
                                                    subtitle: {
                                                        text: 'last 10 runs',
                                                        align: 'left',
                                                        margin: 0,
                                                        offsetX: 95,
                                                        offsetY: 0,
                                                        floating: false,
                                                        style: {
                                                            fontSize: '18px',
                                                            color: '#4361ee'
                                                        }
                                                    },
                                                    title: {
                                                        text: 'History of :',
                                                        align: 'left',
                                                        margin: 0,
                                                        offsetX: -10,
                                                        offsetY: 0,
                                                        floating: false,
                                                        style: {
                                                            fontSize: '18px',
                                                            color: '#0e1726'
                                                        },
                                                    },
                                                    stroke: {
                                                        show: true,
                                                        curve: 'smooth',
                                                        width: 2,
                                                        lineCap: 'square'
                                                    },
                                                    series: ".json_encode($finalArray).",
                                                    labels: ".json_encode($historyDates).",
                                                    xaxis: {
                                                        axisBorder: {
                                                            show: false
                                                        },
                                                        axisTicks: {
                                                            show: false
                                                        },
                                                        crosshairs: {
                                                            show: true
                                                        },
                                                        labels: {
                                                            offsetX: 0,
                                                            offsetY: 5,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Quicksand, sans-serif',
                                                                cssClass: 'apexcharts-xaxis-title',
                                                            },
                                                        }
                                                    },
                                                    yaxis: {
                                                        labels: {
                                                            formatter: function(value, index) {
                                                                //return (value / 1000) + 'K'
                                                                return value
                                                            },
                                                            offsetX: -22,
                                                            offsetY: 0,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Quicksand, sans-serif',
                                                                cssClass: 'apexcharts-yaxis-title',
                                                            },
                                                        }
                                                    },
                                                    grid: {
                                                        borderColor: '#e0e6ed',
                                                        strokeDashArray: 5,
                                                        xaxis: {
                                                            lines: {
                                                                show: true
                                                            }
                                                        },
                                                        yaxis: {
                                                            lines: {
                                                                show: false,
                                                            }
                                                        },
                                                        padding: {
                                                            top: 0,
                                                            right: 0,
                                                            bottom: 0,
                                                            left: -10
                                                        },
                                                    },
                                                    legend: {
                                                        position: 'top',
                                                        horizontalAlign: 'right',
                                                        offsetY: -50,
                                                        fontSize: '16px',
                                                        fontFamily: 'Quicksand, sans-serif',
                                                        markers: {
                                                            width: 10,
                                                            height: 10,
                                                            strokeWidth: 0,
                                                            strokeColor: '#fff',
                                                            fillColors: undefined,
                                                            radius: 12,
                                                            onClick: undefined,
                                                            offsetX: 0,
                                                            offsetY: 0
                                                        },
                                                        itemMargin: {
                                                            horizontal: 0,
                                                            vertical: 20
                                                        }
                                                    },
                                                    tooltip: {
                                                        theme: 'dark',
                                                        marker: {
                                                            show: true,
                                                        },
                                                        x: {
                                                            show: false,
                                                        }
                                                    },
                                                    fill: {
                                                        type: 'gradient',
                                                        gradient: {
                                                            type: 'vertical',
                                                            shadeIntensity: 1,
                                                            inverseColors: !1,
                                                            opacityFrom: .28,
                                                            opacityTo: .05,
                                                            stops: [45, 100]
                                                        }
                                                    },
                                                    responsive: [{
                                                        breakpoint: 575,
                                                        options: {
                                                            legend: {
                                                                offsetY: -30,
                                                            },
                                                        },
                                                    }]
                                                }";
                                            ?>
                                            <div class="widget-content">
                                                <div class="invoice-list">
                                                    <!-- <div class="inv-detail" id="revenueMonthly"></div> -->
                                                    <div class="inv-action">
                                                        <a href="#sastHistoryModal"
                                                            data-original-title="View SAST History" data-toggle="modal"
                                                            data-repo="<?php echo $repo; ?>"
                                                            class="btn btn-outline-primary view-details">View
                                                            history</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
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
    var sastChart = new ApexCharts(
        document.querySelector("#sastHistory"),
        <?php echo $sastOptions; ?>
    );

    sastChart.render();
    </script>
</body>

</html>