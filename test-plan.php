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

$parent_node = $_REQUEST['node'];
$tests_url = $_SESSION['site-url'] . '/api/tests?parent_node='.$parent_node;
$tests = json_decode($cta->httpGetWithAuth($tests_url,$_SESSION['auth-phrase']), true);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $site_name; ?> - Test Plan</title>
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

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="assets/css/elements/custom-tree_view.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/editors/quill/quill.snow.css">
    <link href="assets/css/apps/todolist.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <!-- END PAGE LEVEL CUSTOM STYLES -->

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

                                <div class="row layout-top-spacing" id="cancel-row">

                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="widget-content widget-content-area br-6">
                                            <table id="html5-extension" class="table table-hover non-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Product</th>
                                                        <th>Author</th>
                                                        <th>Test Type</th>
                                                        <th>Priority</th>
                                                        <th>Automation Status</th>
                                                        <th>Tags</th>
                                                        <!-- <th class="dt-no-sorting"></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    if(isset($tests)){
                                                    foreach((array) $tests as $test){ ?>
                                                    <tr>
                                                        <td><?php echo '<a class="link" href="test-plan-details?name='.$test['name'].'"><span class="taskBoard-number">'.$test['name'].'</span></a>'; ?></td>
                                                        <td><?php echo $test['product']; ?></td>
                                                        <td><?php echo $test['user_name']; ?></td>
                                                        <td><?php echo $test['test_type']; ?></td>
                                                        <td><?php echo $test['priority']; ?></td>
                                                        <td><?php if(str_contains($test['automation_status'],'Not')){ echo '<span class="badge badge-danger">'; } else if(str_contains($test['automation_status'],'In Progress')){ echo '<span class="badge badge-warning">'; } else { echo '<span class="badge badge-primary">'; } echo $test['automation_status'].'</span>'; ?></td>
                                                        <td><?php echo $test['tag']; ?></td>
                                                        <!-- <td>
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-dark btn-sm">Open</button>
                                                                <button type="button"
                                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                                    id="dropdownMenuReference1" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    data-reference="parent">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-chevron-down">
                                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                                    </svg>
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuReference1">
                                                                    <a class="dropdown-item" href="#">Action</a>
                                                                    <a class="dropdown-item" href="#">Another action</a>
                                                                    <a class="dropdown-item" href="#">Something else
                                                                        here</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="#">Separated link</a>
                                                                </div>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    <?php } 
                                                    } else{
                                                        echo '<tr><td colspan="8">No tests added</td></tr>';   
                                                    }?>
                                                </tbody>
                                            </table>
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

    <!-- Add Test plan node Modal -->
    <form id="addTestplanNode" action="./actions/addNode.php" method="POST" novalidate>
        <div class="modal fade" id="addTestplanFolderModal" tabindex="-1" role="dialog" aria-hidden="true"
            data-focus="false">
            <div class="modal-dialog modal-dialog-centered" role="dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x close" data-dismiss="modal">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <div class="compose-box">
                            <div class="compose-content">
                                <h5 class="task-heading">Add Node</h5>
                                <div class="form-group mb-4">
                                    <input type="hidden" value="testplan" name="node_type" />
                                    <input type="text" class="form-control" id="node_name" name="node_name"
                                        aria-describedby="nodeNameHelp" placeholder="Node name" required>
                                    <small id="nodeNameHelp" class="form-text text-muted">You wont be able to update
                                        this later.</small>
                                </div>
                                <div class="form-group mb-4">
                                    <select class="form-control basic" id="parent_node" name="parent_node">
                                        <?php 
                                        $distinctValues = array();
                                        foreach((array) $_SESSION['testplanNodes'] as $testplanNode){ 
                                            if(array_search($testplanNode['node_name'], $distinctValues) == ''){
                                                array_push($distinctValues,$testplanNode['node_name']);
                                                echo '<option>'.$testplanNode['node_name'].'</option>';
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button class="btn" data-dismiss="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                            </svg> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Add Test plan node Modal -->
    <form id="addTestplanNode" action="./actions/addNode.php" method="POST" novalidate>
        <div class="modal fade" id="addTestplanFolderModal" tabindex="-1" role="dialog" aria-hidden="true"
            data-focus="false">
            <div class="modal-dialog modal-dialog-centered" role="dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x close" data-dismiss="modal">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <div class="compose-box">
                            <div class="compose-content">
                                <h5 class="task-heading">Add Node</h5>
                                <div class="form-group mb-4">
                                    <input type="hidden" value="testplan" name="node_type" />
                                    <input type="text" class="form-control" id="node_name" name="node_name"
                                        aria-describedby="nodeNameHelp" placeholder="Node name" required>
                                    <small id="nodeNameHelp" class="form-text text-muted">You wont be able to update
                                        this later.</small>
                                </div>
                                <div class="form-group mb-4">
                                    <select class="form-control basic" id="parent_node" name="parent_node">
                                        <?php 
                                        $distinctValues = array();
                                        foreach((array) $_SESSION['testplanNodes'] as $testplanNode){ 
                                            if(array_search($testplanNode['node_name'], $distinctValues) == ''){
                                                array_push($distinctValues,$testplanNode['node_name']);
                                                echo '<option>'.$testplanNode['node_name'].'</option>';
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button class="btn" data-dismiss="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                            </svg> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN MODAL FORM -->
    <script src="plugins/select2/select2.min.js"></script>
    <script src="plugins/select2/custom-select2.js"></script>
    <script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <!-- BEGIN MODAL FORM -->

    

    <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>    
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
        $('#html5-extension').DataTable( {
            "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn btn-sm' },
                    { extend: 'csv', className: 'btn btn-sm' },
                    { extend: 'excel', className: 'btn btn-sm' },
                    { extend: 'print', className: 'btn btn-sm' }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7 
        } );
    </script>
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->

</body>

</html>