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
/**
 * Delete the test from Release
 */
if(isset($_REQUEST['test-id'])){
    $delete_url=$_SESSION['site-url'] . '/api/releases/'.$parent_node.'/'.$_REQUEST['test-id'];
    $delete = json_decode($cta->httpDeleteWithAuth($delete_url,$_SESSION['auth-phrase']), true);
    //echo 'URL: '.$delete_url.'<br>Result : '.$delete;
    $url = explode('&',$_SERVER['REQUEST_URI'])[0];
    header("Location:".$url);
    exit();
}

/**
 * Display release tests
 */
$releases_url = $_SESSION['site-url'] . '/api/releases/'.$parent_node;
$releases = json_decode($cta->httpGetWithAuth($releases_url,$_SESSION['auth-phrase']), true);
//echo 'URL : '.$releases_url.'Data : '.$releases[0]['test_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $site_name; ?> - Test Lab</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
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
    <link href="assets/css/components/custom-list-group.css" rel="stylesheet" type="text/css">
    <!-- END PAGE LEVEL CUSTOM STYLES -->
    <!-- Icons Css -->
    <!-- <link href="https://themesbrand.com/skote/layouts/assets/css/icons.min.css" rel="stylesheet" type="text/css" /> -->

    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

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
                                            <table id="html5-extension"
                                                class="table table-hover non-hover table-editable table-edits"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="dt-no-sorting">Actions</th>
                                                        <th>Test ID</th>
                                                        <th>Test Name</th>
                                                        <th>Product</th>
                                                        <th>Priority</th>
                                                        <th>Execution Date</th>
                                                        <th>Test Status</th>
                                                        <th>Bug No</th>
                                                        <th>Link</th>
                                                        <th>Tags</th>
                                                        <th>Scrum</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    if(isset($releases)){
                                                    foreach((array) $releases as $release){ ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <a onclick="if (! confirm('Are you sure you want to delete <?php echo $release['test_name']; ?> ?')) return false;"
                                                                href="<?php echo $_SERVER['REQUEST_URI'].'&test-id='.$release['test_id']; ?>"
                                                                class="bs-tooltip" data-toggle="tooltip"
                                                                data-placement="top" title=""
                                                                data-original-title="Remove"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-x-circle table-cancel">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                                                </svg></a>

                                                            <a href="#runTestModal" class="bs-tooltip"
                                                                data-original-title="Run Test" data-toggle="modal"
                                                                data-test_id="<?php echo $release['test_id']; ?>"
                                                                data-test_status="<?php echo $release['test_status']; ?>"
                                                                data-bug_no="<?php echo $release['bug_no']; ?>"
                                                                data-test_run_link="<?php echo $release['test_run_link']; ?>"><svg
                                                                    viewBox="0 0 24 24" width="24" height="24"
                                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <polygon points="10 8 16 12 10 16 10 8"></polygon>
                                                                </svg></a>
                                                        </td>
                                                        <td><?php echo '<a class="link" href="test-plan-details?test_id='.$release['test_id'].'"><span class="taskBoard-number">'.$release['test_id'].'</span></a>'; ?>
                                                        </td>
                                                        <td><?php echo $release['test_name']; ?></td>
                                                        <td><?php echo $release['product']; ?></td>
                                                        <td><?php echo $release['priority']; ?></td>
                                                        <td><?php echo $release['execution_date']; ?></td>
                                                        <td><?php if(str_contains($release['test_status'],'Failed')){ echo '<span class="badge badge-danger">'; } else if(str_contains($release['test_status'],'Not')){ echo '<span class="badge badge-warning">'; } else { echo '<span class="badge badge-success">'; } echo $release['test_status'].'</span>'; ?>
                                                        </td>
                                                        <td><?php if($release['bug_no']!='') {echo '<a href="#" target="_blank">'.$release['bug_no'].'</a>';} ?>
                                                        </td>
                                                        <td><?php if($release['test_run_link']!='') {echo '<a class="link" href="'.$release['test_run_link'].'" target="_blank"><span class="w-profile-content">click here</span></a>';} ?>
                                                        </td>
                                                        <td><?php echo $release['tag']; ?></td>
                                                        <td><?php echo $release['scrum_name']; ?></td>
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
                        <?php require_once './partials/select-test.php'; ?>
                    </div>

                </div>
            </div>

        </div>
        <!--  END CONTENT AREA  -->
    </div>

    <!-- Run Test from Testlab Modal -->
    <form id="runTestForm" action="./actions/runTest.php" method="POST" novalidate>
        <div class="modal fade" id="runTestModal" tabindex="-1" role="dialog" aria-hidden="true" data-focus="false">
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
                                <h5 class="task-heading">Run Test</h5>
                                <div class="form-group mb-4">
                                    <input type="hidden" id="testid" name="test_id" />
                                    <input type="hidden" id="parent_node" name="parent_node"
                                        value="<?php echo $parent_node; ?>" />
                                    <input type="hidden" id="redirect_uri" name="redirect_uri"
                                        value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                                    <select class="form-control selectpicker" name="test_status" id="test_status">
                                        <option value="Not started">Not started</option>
                                        <option value="Passed">Passed</option>
                                        <option value="Failed">Failed</option>
                                    </select>
                                    <small id="testStatusHelp" class="form-text text-muted">Update Test Status</small>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control" id="bug_no" name="bug_no"
                                        placeholder="Jira ID" />
                                    <small id="bugNoHelp" class="form-text text-muted">Mandatory when the test is
                                        failed.</small>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control" id="test_run_link" name="test_run_link" placeholder="http://" />
                                    <small id="testRunLinkHelp" class="form-text text-muted">Please provide the
                                        automation
                                        test run link, if applicable</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button class="btn" data-dismiss="modal"> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
    $('#html5-extension').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        buttons: {
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-sm'
                },
                {
                    extend: 'csv',
                    className: 'btn btn-sm'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-sm'
                },
                {
                    extend: 'print',
                    className: 'btn btn-sm'
                }
            ]
        },
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });

    // Execute something when the modal window is shown.
    $('#runTestModal').on('show.bs.modal', function (event) {
        // Button that triggered the modal
        var a = $(event.relatedTarget); 

        // Extract info from data-* attributes
        var testid = a.data('test_id'); 
        var test_status = a.data('test_status'); 
        var bug_no = a.data('bug_no'); 
        var test_run_link = a.data('test_run_link'); 
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body input#testid').val(testid);
        modal.find('.modal-body select#test_status').val(test_status);
        modal.find('.modal-body input#bug_no').val(bug_no);
        modal.find('.modal-body input#test_run_link').val(test_run_link);
    });
    </script>
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->

</body>

</html>