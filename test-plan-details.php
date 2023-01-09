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

$id = $_REQUEST['test_id'];
if(isset($_REQUEST['name']) || isset($_REQUEST['steps']) || isset($_REQUEST['existing_features'])){
    $url = $_SESSION['site-url'] . '/api/tests/'.$id;
    $payload = new stdClass();
    if(isset($_REQUEST['name'])){
        $payload->name = $_REQUEST['name'];
        $payload->product = $_REQUEST['product'];
        $payload->priority = $_REQUEST['priority'];
        $payload->automation_status = $_REQUEST['automation_status'];
        $payload->scrum_name = $_REQUEST['scrum_name'];
        $payload->description = $_REQUEST['description'];
        $payload->tag = $_REQUEST['tags'];
    }
    if(isset($_REQUEST['steps'])){
        $payload->steps = implode('>>',$_REQUEST['steps']);
        $payload->expected_output = implode('>>',$_REQUEST['expected_output']);
    }
    if(isset($_REQUEST['existing_features'])){
        $payload->feature_id = $_REQUEST['existing_features'].','.$_REQUEST['feature_id'];
    }
    $result = $cta->httpPatchWithAuth($url,json_encode($payload),$_SESSION['auth-phrase']);
    //echo 'URL : '.$url.'<br>Payload : '.json_encode($payload).'<br>Result : '.$result;
}

$tests_url = $_SESSION['site-url'] . '/api/tests?test_id='.$id;
$tests = json_decode($cta->httpGetWithAuth($tests_url,$_SESSION['auth-phrase']), true);
$test = $tests[0];

$tags = explode(',', $test['tag']);


$features_url = $_SESSION['site-url'] . '/api/features';
$features = json_decode($cta->httpGetWithAuth($features_url,$_SESSION['auth-phrase']), true);

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
    <link href="assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css" />
    <link href="plugins/tagInput/tags-input.css" rel="stylesheet" type="text/css" />
    <style>
    .tags-input-wrapper input {
        margin: 0 auto;
    }
    </style>
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/apps/contacts.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/apps/invoice-edit.css" rel="stylesheet" type="text/css" />
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
                                    <div class="col-lg-12 col-12 layout-spacing">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-header">
                                                <div class="row">
                                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                        <h4><?php echo $test['name'] ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content widget-content-area animated-underline-content">

                                                <ul class="nav nav-tabs  mb-3" id="animateLine" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="basic-details-tab"
                                                            data-toggle="tab" href="#basic-details" role="tab"
                                                            aria-controls="basic-details" aria-selected="true"><svg
                                                                viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                                            </svg> Basic Details</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="step-definition-tab" data-toggle="tab"
                                                            href="#step-definition" role="tab"
                                                            aria-controls="step-definition" aria-selected="false"><svg
                                                                viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                                            </svg> Step Definitions</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="requirement-tab" data-toggle="tab"
                                                            href="#requirement" role="tab" aria-controls="requirement"
                                                            aria-selected="false"><svg viewBox="0 0 24 24" width="24"
                                                                height="24" stroke="currentColor" stroke-width="2"
                                                                fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round" class="css-i6dzq1">
                                                                <path
                                                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                </path>
                                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                                <polyline points="10 9 9 9 8 9"></polyline>
                                                            </svg> Requirements</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content" id="tab-content">
                                                    <div class="tab-pane fade show active" id="basic-details"
                                                        role="tabpanel" aria-labelledby="basic-details-tab">
                                                        <div class="row">
                                                            <div id="custom_styles"
                                                                class="col-lg-12 layout-spacing col-md-12">
                                                                <div class="statbox widget box box-shadow">
                                                                    <!-- <div class="widget-header">
                                                                        <div class="row">
                                                                            <div
                                                                                class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                                                <h4>Custom styles</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="widget-content widget-content-area">
                                                                        <form
                                                                            action="test-plan-details?test_id=<?php echo $test['id'] ?>"
                                                                            method="POST">
                                                                            <div class="form-row">
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Test ID</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="Test ID"
                                                                                        value="<?php echo $test['id']; ?>"
                                                                                        readonly>
                                                                                </div>
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Name</label>
                                                                                    <input type="text"
                                                                                        class="form-control" name="name"
                                                                                        placeholder="Name"
                                                                                        value="<?php echo $test['name'] ?>"
                                                                                        required>
                                                                                    <div class="valid-feedback">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Product</label>

                                                                                    <select
                                                                                        class="form-control selectpicker"
                                                                                        name="product">
                                                                                        <option value="Answers"
                                                                                            <?php if($test['product']=='Answers'){echo 'selected="selected"'; } ?>>
                                                                                            Answers</option>
                                                                                        <option value="Assist"
                                                                                            <?php if($test['product']=='Assist'){echo 'selected="selected"'; } ?>>
                                                                                            Assist</option>
                                                                                        <option value="Butterfly"
                                                                                            <?php if($test['product']=='Butterfly'){echo 'selected="selected"'; } ?>>
                                                                                            Butterfly</option>
                                                                                        <option value="Conversation"
                                                                                            <?php if($test['product']=='Conversation'){echo 'selected="selected"'; } ?>>
                                                                                            Conversation</option>
                                                                                        <option value="Messaging"
                                                                                            <?php if($test['product']=='Messaging'){echo 'selected="selected"'; } ?>>
                                                                                            Messaging</option>
                                                                                        <option value="Voice"
                                                                                            <?php if($test['product']=='Voice'){echo 'selected="selected"'; } ?>>
                                                                                            Voice</option>
                                                                                    </select>
                                                                                    <div class="valid-feedback">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Author</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="author"
                                                                                        placeholder="Author"
                                                                                        value="<?php echo $test['user_name']; ?>"
                                                                                        readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Test Type</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="test_type"
                                                                                        placeholder="Test Type"
                                                                                        value="<?php echo $test['test_type']; ?>"
                                                                                        readonly>
                                                                                </div>
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Priority</label>
                                                                                    <select
                                                                                        class="form-control selectpicker"
                                                                                        name="priority">
                                                                                        <option
                                                                                            <?php if($test['priority']==1){echo 'selected="selected"'; } ?>>
                                                                                            1</option>
                                                                                        <option
                                                                                            <?php if($test['priority']==2){echo 'selected="selected"'; } ?>>
                                                                                            2</option>
                                                                                        <option
                                                                                            <?php if($test['priority']==3){echo 'selected="selected"'; } ?>>
                                                                                            3</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Automation status</label>
                                                                                    <select
                                                                                        class="form-control selectpicker"
                                                                                        name="automation_status">
                                                                                        <option
                                                                                            <?php if($test['automation_status']=='Not Planned'){echo 'selected="selected"'; } ?>>
                                                                                            Not Planned</option>
                                                                                        <option
                                                                                            <?php if($test['automation_status']=='In Progress'){echo 'selected="selected"'; } ?>>
                                                                                            In Progress</option>
                                                                                        <option
                                                                                            <?php if($test['automation_status']=='Ready'){echo 'selected="selected"'; } ?>>
                                                                                            Ready</option>
                                                                                        <option
                                                                                            <?php if($test['automation_status']=='Not Applicable'){echo 'selected="selected"'; } ?>>
                                                                                            Not Applicable</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-3 mb-4">
                                                                                    <label>Scrum Name</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="scrum_name"
                                                                                        placeholder="Scrum Name"
                                                                                        value="<?php echo $test['scrum_name'] ?>" />
                                                                                    <div class="valid-feedback">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr />
                                                                            <div class="form-row">
                                                                                <div class="col-md-12 mb-12">
                                                                                    <label>Description</label>
                                                                                    <textarea class="form-control"
                                                                                        rows="3"
                                                                                        name="description"><?php echo $test['description']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <hr />
                                                                            <div class="form-row">
                                                                                <div class="col-md-12 mb-12">
                                                                                    <label>Tags</label>
                                                                                    <div
                                                                                        class="widget-content widget-content-area text-center tags-content">
                                                                                        <div>
                                                                                            <input type="text" id="tags"
                                                                                                name="tags"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button class="btn btn-primary btn-sm"
                                                                                type="submit">Update</button>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="step-definition" role="tabpanel"
                                                        aria-labelledby="step-definition-tab">

                                                        <div class="invoice-detail-items">
                                                            <div class="table-responsive">
                                                                <form
                                                                    action="test-plan-details?test_id=<?php echo $test['id'] ?>"
                                                                    method="POST" id="steps-form">
                                                                    <table class="table table-bordered item-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class=""></th>
                                                                                <th>Step Definition</th>
                                                                                <th>Expected Output</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                            $steps = explode('>>',$test['steps']);
                                                                            $expected_output = explode('>>',$test['expected_output']);
                                                                            for($i=0;$i<sizeof($steps);$i++){?>
                                                                            <tr>
                                                                                <td class="delete-item-row">
                                                                                    <ul class="table-controls">
                                                                                        <li><a href="javascript:void(0);"
                                                                                                class="delete-item"
                                                                                                data-toggle="tooltip"
                                                                                                data-placement="top"
                                                                                                title=""
                                                                                                data-original-title="Delete"><svg
                                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                                    width="24"
                                                                                                    height="24"
                                                                                                    viewBox="0 0 24 24"
                                                                                                    fill="none"
                                                                                                    stroke="currentColor"
                                                                                                    stroke-width="2"
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    class="feather feather-x-circle">
                                                                                                    <circle cx="12"
                                                                                                        cy="12" r="10">
                                                                                                    </circle>
                                                                                                    <line x1="15" y1="9"
                                                                                                        x2="9" y2="15">
                                                                                                    </line>
                                                                                                    <line x1="9" y1="9"
                                                                                                        x2="15" y2="15">
                                                                                                    </line>
                                                                                                </svg></a></li>
                                                                                    </ul>
                                                                                </td>
                                                                                <td class="description"><textarea
                                                                                        class="form-control"
                                                                                        placeholder="Step Definition"
                                                                                        name="steps[]"><?php echo $steps[$i]; ?></textarea>
                                                                                </td>
                                                                                <td class="description"><textarea
                                                                                        class="form-control"
                                                                                        placeholder="Expected Output"
                                                                                        name="expected_output[]"><?php echo $expected_output[$i]; ?></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </form>
                                                            </div>
                                                            <button class="btn btn-primary btn-sm" type="submit"
                                                                onclick="document.getElementById('steps-form').submit();">Update</button>
                                                            <button class="btn btn-secondary additem btn-sm">Add
                                                                Step</button>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="requirement" role="tabpanel"
                                                        aria-labelledby="requirement-tab">
                                                        <div class="widget-content searchable-container list">

                                                            <div class="row">
                                                                <div
                                                                    class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                                                                    <form class="form-inline my-2 my-lg-0">
                                                                        <div class="">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-search">
                                                                                <circle cx="11" cy="11" r="8"></circle>
                                                                                <line x1="21" y1="21" x2="16.65"
                                                                                    y2="16.65"></line>
                                                                            </svg>
                                                                            <input type="text"
                                                                                class="form-control product-search"
                                                                                id="input-search" placeholder="Search">
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                <div
                                                                    class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                                                                    <div
                                                                        class="d-flex justify-content-sm-end justify-content-center">
                                                                        <svg id="btn-add-contact"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather file-plus">
                                                                            <title>Add Requirement</title>
                                                                            <path
                                                                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                            </path>
                                                                            <polyline points="14 2 14 8 20 8">
                                                                            </polyline>
                                                                            <line x1="12" y1="18" x2="12" y2="12">
                                                                            </line>
                                                                            <line x1="9" y1="15" x2="15" y2="15"></line>
                                                                        </svg>

                                                                        <div class="switch align-self-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-list view-list active-view">
                                                                                <line x1="8" y1="6" x2="21" y2="6">
                                                                                </line>
                                                                                <line x1="8" y1="12" x2="21" y2="12">
                                                                                </line>
                                                                                <line x1="8" y1="18" x2="21" y2="18">
                                                                                </line>
                                                                                <line x1="3" y1="6" x2="3" y2="6">
                                                                                </line>
                                                                                <line x1="3" y1="12" x2="3" y2="12">
                                                                                </line>
                                                                                <line x1="3" y1="18" x2="3" y2="18">
                                                                                </line>
                                                                            </svg>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-grid view-grid">
                                                                                <rect x="3" y="3" width="7" height="7">
                                                                                </rect>
                                                                                <rect x="14" y="3" width="7" height="7">
                                                                                </rect>
                                                                                <rect x="14" y="14" width="7"
                                                                                    height="7"></rect>
                                                                                <rect x="3" y="14" width="7" height="7">
                                                                                </rect>
                                                                            </svg>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Modal -->

                                                                    <form
                                                                        action="test-plan-details?test_id=<?php echo $test['id']; ?>"
                                                                        method="POST">
                                                                        <div class="modal fade" id="addContactModal"
                                                                            tabindex="-1" role="dialog"
                                                                            aria-labelledby="addContactModalTitle"
                                                                            aria-hidden="true" data-focus="false">
                                                                            <div class="modal-dialog modal-dialog-centered"
                                                                                role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-body">
                                                                                        <i class="flaticon-cancel-12 close"
                                                                                            data-dismiss="modal"></i>
                                                                                        <div class="add-contact-box">
                                                                                            <div
                                                                                                class="add-contact-content">
                                                                                                <input type="hidden"
                                                                                                    name="existing_features"
                                                                                                    value="<?php echo $test['feature_id']; ?>" />
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="autocomplete-dynamic">Features:</label>

                                                                                                    <select
                                                                                                        class="form-control basic"
                                                                                                        id="features"
                                                                                                        name="feature_id">
                                                                                                        <?php 
                                                                                                            $distinctValues = array();
                                                                                                            foreach((array) $features as $feature){ 
                                                                                                                if(array_search($feature['feature_id'], $distinctValues) == ''){
                                                                                                                    array_push($distinctValues,$feature['feature_id']);
                                                                                                                    echo '<option value="'.$feature['feature_id'].'">'.$feature['name'].'</option>';
                                                                                                                }
                                                                                                            } 
                                                                                                            ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button class="btn"
                                                                                            data-dismiss="modal"> <i
                                                                                                class="flaticon-delete-1"></i>
                                                                                            Discard</button>

                                                                                        <button id="btn-add" class="btn"
                                                                                            type="submit">Add</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="searchable-items list">
                                                                <div class="items items-header-section">
                                                                    <div class="item-content">
                                                                        <div class="">
                                                                            <div
                                                                                class="n-chk align-self-center text-center">
                                                                                <label
                                                                                    class="new-control new-checkbox checkbox-primary">
                                                                                    <input type="checkbox"
                                                                                        class="new-control-input"
                                                                                        id="contact-check-all">
                                                                                    <span
                                                                                        class="new-control-indicator"></span>
                                                                                </label>
                                                                            </div>
                                                                            <h4>Feature</h4>
                                                                        </div>
                                                                        <div class="">
                                                                            <h4 style="margin-left: 0;">Type</h4>
                                                                        </div>
                                                                        <div class="">
                                                                            <h4 style="margin-left: 3px;">Status</h4>
                                                                        </div>
                                                                        <div class="action-btn">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-trash-2  delete-multiple">
                                                                                <polyline points="3 6 5 6 21 6">
                                                                                </polyline>
                                                                                <path
                                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                </path>
                                                                                <line x1="10" y1="11" x2="10" y2="17">
                                                                                </line>
                                                                                <line x1="14" y1="11" x2="14" y2="17">
                                                                                </line>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php if($test['feature_id']!=''){ 
                                                                    $features_url = $_SESSION['site-url'] . '/api/features?feature_id='.$test['feature_id'];
                                                                    $features = json_decode($cta->httpGetWithAuth($features_url,$_SESSION['auth-phrase']), true);
                                                                    
                                                                    foreach($features as $feature){?>
                                                                <div class="items">
                                                                    <div class="item-content">
                                                                        <div class="user-profile">
                                                                            <div
                                                                                class="n-chk align-self-center text-center">
                                                                                <label
                                                                                    class="new-control new-checkbox checkbox-primary">
                                                                                    <input type="checkbox"
                                                                                        class="new-control-input contact-chkbox">
                                                                                    <span
                                                                                        class="new-control-indicator"></span>
                                                                                </label>
                                                                            </div>
                                                                            <?php if(str_contains($feature['feature_type'],'New')){?>
                                                                            <svg viewBox="0 0 24 24" width="40"
                                                                                height="40" stroke="currentColor"
                                                                                stroke-width="2" fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="css-i6dzq1">
                                                                                <circle cx="18" cy="18" r="3"></circle>
                                                                                <circle cx="6" cy="6" r="3"></circle>
                                                                                <path d="M13 6h3a2 2 0 0 1 2 2v7">
                                                                                </path>
                                                                                <line x1="6" y1="9" x2="6" y2="21">
                                                                                </line>
                                                                            </svg>
                                                                            <?php } else{ ?>
                                                                            <svg viewBox="0 0 24 24" width="40"
                                                                                height="40" stroke="currentColor"
                                                                                stroke-width="2" fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="css-i6dzq1">
                                                                                <line x1="6" y1="3" x2="6" y2="15">
                                                                                </line>
                                                                                <circle cx="18" cy="6" r="3"></circle>
                                                                                <circle cx="6" cy="18" r="3"></circle>
                                                                                <path d="M18 9a9 9 0 0 1-9 9"></path>
                                                                            </svg>
                                                                            <?php } ?>
                                                                            <div class="user-meta-info">
                                                                                <p class="user-name"
                                                                                    data-name="<?php echo $feature['feature_id']; ?>">
                                                                                    <?php echo $feature['feature_id']; ?>
                                                                                </p>
                                                                                <p class="user-work"
                                                                                    data-occupation="<?php echo $test['name']; ?>">
                                                                                    <?php echo $feature['name']; ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="user-location">
                                                                            <p class="info-title">Type: </p>
                                                                            <p class="usr-email-addr"
                                                                                data-email="<?php echo $feature['feature_type']; ?>">
                                                                                <?php echo $feature['feature_type']; ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="user-phone">
                                                                            <p class="info-title">Status: </p>
                                                                            <p class="usr-location"
                                                                                data-location="<?php echo $feature['status']; ?>">
                                                                                <?php echo $feature['status']; ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="action-btn">
                                                                            <!-- <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-edit-2 edit">
                                                                                <path
                                                                                    d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                                </path>
                                                                            </svg> -->

                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather file-minus delete">
                                                                                <path
                                                                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                                </path>
                                                                                <polyline points="14 2 14 8 20 8">
                                                                                </polyline>
                                                                                <line x1="9" y1="15" x2="15" y2="15">
                                                                                </line>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php } } else {echo '<div class="items">No requirements associated</div>';}?>
                                                            </div>

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
    <script src="plugins/treeview/custom-jstree.js"></script>
    <script src="plugins/select2/select2.min.js"></script>
    <script src="plugins/select2/custom-select2.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <script src="plugins/tagInput/tags-input.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
    var instance = new TagsInput({
        selector: 'tags'
    });
    //instance.addData(['PHP', 'Wordpress', 'Javascript', 'jQuery'])

    instance.addData([<?php echo '"'.implode('","', $tags).'"' ?>]);
    </script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/js/apps/contact.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>