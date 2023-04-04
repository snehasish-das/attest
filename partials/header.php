<?php
    $endpoint = explode('?',$_SERVER['REQUEST_URI']);
    @$currUrl = end(explode('/',$endpoint[0]));
    $currUrl = ($currUrl == 'index' || $currUrl =='') ? 'Dashboard' : $currUrl;
    $header = str_replace('-',' ',strtoupper($currUrl));

    if(isset($_REQUEST['parent_node'])){
        $parent_node = $_REQUEST['parent_node'];
    }
    if(isset($_REQUEST['node'])){
        $node = $_REQUEST['node'];
    }

    if(isset($test)){
        @$parent_node = $test['product'];
        @$node = $test['parent_node'];
    }
?>

<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />

<header class="header navbar navbar-expand-sm">
    <div class="d-flex">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <div class="bt-menu-trigger">
                <span></span>
            </div>
        </a>
        <div class="page-header">
            <div class="page-title">
                <h3><?php echo $header; ?></h3>
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php $_SESSION['site-url'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                        <li class="breadcrumb-item <?php if($header == 'DASHBOARD'){echo 'active';}?>"><a href="<?php $_SESSION['site-url'] ?>"><?php if($header =='TEST PLAN DETAILS'){ echo 'Test plan'; } else{ echo ucfirst(strtolower($header)); } ?></a></li>
                        <?php if($header != 'DASHBOARD'){ if(@$parent_node != ''){?>
                        <li class="breadcrumb-item"><a href="<?php if (strpos($currUrl, 'plan') !== false) {echo $_SESSION['site-url'].'/test-plan?node='.$parent_node. '&parent_node=';} else {echo $_SESSION['site-url'].'/test-lab?node='.$parent_node. '&parent_node=';} ?>"><?php echo ucfirst(@$parent_node); ?></a></li>
                        <?php } ?>
                        <li class="breadcrumb-item active" aria-current="page"><a href="<?php if (strpos($currUrl, 'plan') !== false) {echo $_SESSION['site-url'].'/test-plan?node='.$node. '&parent_node='.$parent_node;} else {echo $_SESSION['site-url'].'/test-lab?node='.$parent_node. '&parent_node='.$parent_node;} ?>"><?php echo ucfirst(@$node); ?></a></li>
                        <?php } ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="header-actions">
        <div class="nav-item dropdown language-dropdown more-dropdown">
            <div class="dropdown custom-dropdown-icon">
                <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><img src="assets/img/user.svg" class="flag-width"
                        alt="flag"><span><?php echo $_SESSION['user-details']['name'] ?></span> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevron-down">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg></a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                    <a class="dropdown-item" data-img-value="user-x" data-value="Logout" href="logout"><img
                            src="assets/img/user-x.svg" class="flag-width" alt="flag">
                        Logout</a>
                </div>
            </div>
        </div>

        <div class="toggle-notification-bar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bell">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
        </div>
    </div>
</header>