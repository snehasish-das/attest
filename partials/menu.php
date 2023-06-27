<?php
    $currUrl = $_SERVER['REQUEST_URI'];
    $urlWithoutParams = explode('?',$_SERVER['REQUEST_URI']);
    $endpointArray = explode('/',$urlWithoutParams[0]);
    $endpoint = end($endpointArray);
    //echo "Endpoint: ". $endpoint;
    //@$currUrl = end(explode('/',$endpoint[0]));
    
    function getTreeView($nodes,$node_type){
        foreach($nodes as $node){
            if($node_type=='testplan'){
                echo '<li><span class="caret caret-down"></span><a class="menu-block-submenu" href="test-plan?node='.$node['node_name'].'&parent_node='.$node['parent_node'].'">'.$node['node_name'].'</a><ul class="nested">';
            }else{
                echo '<li><span class="caret caret-down"></span><a class="menu-block-submenu" href="test-lab?node='.$node['node_name'].'&parent_node='.$node['parent_node'].'">'.$node['node_name'].'</a><ul class="nested">';
            }
            if(sizeof($node['nodes'])>0){
                getTreeView($node['nodes'],$node_type);
            }
            if(sizeof($node['tests'])>0){
                for($i=0; $i<sizeof($node['tests']); $i++)
                echo '<li><a href="test-plan-details?test_id='.$node['tests'][$i]['id'].'">'.$node['tests'][$i]['name'].'</a></li>';
            }
            echo '</ul></li>';
        }
    }
?>
<nav id="compactSidebar">
    <ul class="menu-categories">
        <li class="menu menu-single <?php  if(str_contains($endpoint,'index') || $endpoint =='') { echo 'active'; }?>">
            <a href="index"
                data-active="<?php echo (str_contains($endpoint,'index') || $endpoint =='') ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-terminal">
                            <polyline points="4 17 10 11 4 5"></polyline>
                            <line x1="12" y1="19" x2="20" y2="19"></line>
                        </svg>
                    </div>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        <li class="menu <?php  if(str_contains($endpoint,'test-plan')) { echo 'active'; }?>">
            <a href="#testplan" data-active="<?php echo (str_contains($endpoint,'test-plan')) ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-cpu">
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                            <rect x="9" y="9" width="6" height="6"></rect>
                            <line x1="9" y1="1" x2="9" y2="4"></line>
                            <line x1="15" y1="1" x2="15" y2="4"></line>
                            <line x1="9" y1="20" x2="9" y2="23"></line>
                            <line x1="15" y1="20" x2="15" y2="23"></line>
                            <line x1="20" y1="9" x2="23" y2="9"></line>
                            <line x1="20" y1="14" x2="23" y2="14"></line>
                            <line x1="1" y1="9" x2="4" y2="9"></line>
                            <line x1="1" y1="14" x2="4" y2="14"></line>
                        </svg>
                    </div>
                    <span>Test Plan</span>
                </div>
            </a>
        </li>

        <li class="menu <?php  if(str_contains($endpoint,'test-lab')) { echo 'active'; }?>">
            <a href="#testlab" data-active="<?php echo (str_contains($endpoint,'test-lab')) ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-zap">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                    <span>Test Lab</span>
                </div>
            </a>
        </li>

        <li class="menu menu-single <?php  if(str_contains($endpoint,'features')) { echo 'active'; }?>">
            <a href="features" data-active="<?php echo (str_contains($endpoint,'features')) ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-box">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <span>Features</span>
                </div>
            </a>
        </li>

        <!-- <li class="menu menu-single <?php  if(str_contains($endpoint,'releases')) { echo 'active'; }?>">
            <a href="releases" data-active="<?php echo (str_contains($endpoint,'releases')) ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-file">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                    <span>Releases</span>
                </div>
            </a>
        </li> -->

        <li class="menu <?php  if(str_contains($endpoint,'reports')) { echo 'active'; }?>">
            <a href="#reports" data-active="<?php echo (str_contains($endpoint,'reports')) ? 'true' : 'false'  ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-clipboard">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                    </div>
                    <span>Reports</span>
                </div>
            </a>
        </li>

        <li class="menu <?php if(str_contains($endpoint,'sast')) { echo 'active'; }?> ">
            <a href="#sast" data-active="<?php echo str_contains($endpoint,'sast')? 'true': 'false'; ?>"
                class="menu-toggle">
                <div class="base-menu">
                    <div class="base-icons">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                    </div>
                    <span>SAST Reports</span>
                </div>
            </a>
        </li>
    </ul>
</nav>

<div id="compact_submenuSidebar"
    class="submenu-sidebar <?php if(!(str_contains($endpoint,'index')  || $endpoint =='' )) { echo 'ps show submenu-enable'; }?> ">
    <div class="submenu" id="testplan">
        <div class="actions">
            <a data-toggle="modal" data-target="#addTestplanFolderModal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24">
                    <path
                        d="M464 96h-192l-64-64h-160C21.5 32 0 53.5 0 80v352C0 458.5 21.5 480 48 480h416c26.5 0 48-21.5 48-48v-288C512 117.5 490.5 96 464 96zM336 311.1h-56v56C279.1 381.3 269.3 392 256 392c-13.27 0-23.1-10.74-23.1-23.1V311.1H175.1C162.7 311.1 152 301.3 152 288c0-13.26 10.74-23.1 23.1-23.1h56V207.1C232 194.7 242.7 184 256 184s23.1 10.74 23.1 23.1V264h56C349.3 264 360 274.7 360 288S349.3 311.1 336 311.1z" />
                </svg>
                <span></span>
            </a>
            <!--a data-toggle="modal" data-target="#addTestplanModal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24">
                    <path
                        d="M0 64C0 28.65 28.65 0 64 0H224V128C224 145.7 238.3 160 256 160H384V198.6C310.1 219.5 256 287.4 256 368C256 427.1 285.1 479.3 329.7 511.3C326.6 511.7 323.3 512 320 512H64C28.65 512 0 483.3 0 448V64zM256 128V0L384 128H256zM288 368C288 288.5 352.5 224 432 224C511.5 224 576 288.5 576 368C576 447.5 511.5 512 432 512C352.5 512 288 447.5 288 368zM448 303.1C448 295.2 440.8 287.1 432 287.1C423.2 287.1 416 295.2 416 303.1V351.1H368C359.2 351.1 352 359.2 352 367.1C352 376.8 359.2 383.1 368 383.1H416V431.1C416 440.8 423.2 447.1 432 447.1C440.8 447.1 448 440.8 448 431.1V383.1H496C504.8 383.1 512 376.8 512 367.1C512 359.2 504.8 351.1 496 351.1H448V303.1z" />
                </svg>
                <span></span>
            </a-->
        </div>
        <hr />
        <ul class="submenu-list" data-parent-element="#testplan">
            <?php 
                $getNodes = $_SESSION['site-url'] . '/api/nodes?node_type=testplan';
                $testplanNodes = json_decode($cta->httpGetWithAuth($getNodes,$_SESSION['auth-phrase']), true); //Sorted by Distance=> Parent node=> Node
                $_SESSION['testplanNodes'] = $testplanNodes;
                getTreeView($testplanNodes,'testplan');
            ?>
        </ul>
    </div>

    <div class="submenu" id="testlab">
        <div class="actions">
            <a data-toggle="modal" data-target="#addTestlabFolderModal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24">
                    <path
                        d="M464 96h-192l-64-64h-160C21.5 32 0 53.5 0 80v352C0 458.5 21.5 480 48 480h416c26.5 0 48-21.5 48-48v-288C512 117.5 490.5 96 464 96zM336 311.1h-56v56C279.1 381.3 269.3 392 256 392c-13.27 0-23.1-10.74-23.1-23.1V311.1H175.1C162.7 311.1 152 301.3 152 288c0-13.26 10.74-23.1 23.1-23.1h56V207.1C232 194.7 242.7 184 256 184s23.1 10.74 23.1 23.1V264h56C349.3 264 360 274.7 360 288S349.3 311.1 336 311.1z" />
                </svg>
                <span></span>
            </a>
        </div>
        <hr />
        <ul class="submenu-list" data-parent-element="#testlab">
            <?php 
                $getNodes = $_SESSION['site-url'] . '/api/nodes?node_type=testlab';
                $testlabNodes = json_decode($cta->httpGetWithAuth($getNodes,$_SESSION['auth-phrase']), true); //Sorted by Distance=> Parent node=> Node
                $_SESSION['testlabNodes'] = $testlabNodes;
                getTreeView($testlabNodes,'testlab');
            ?>
        </ul>
    </div>


    <div class="submenu" id="reports">
        <ul class="submenu-list" data-parent-element="#reports">
            <li <?php  if(str_contains($endpoint,'top-bugs')) { echo 'class="active"'; }?>>
                <a href="reports?node=top-bugs-in-recent-runs"> <span class="icon"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-git-commit">
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="1.05" y1="12" x2="7" y2="12"></line>
                            <line x1="17.01" y1="12" x2="22.96" y2="12"></line>
                        </svg></span> Top bugs in recent runs </a>
            </li>
            <li <?php  if(str_contains($endpoint,'frequent-test-failures')) { echo 'class="active"'; }?>>
                <a href="reports?node=frequent-test-failures"> <span class="icon"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-git-commit">
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="1.05" y1="12" x2="7" y2="12"></line>
                            <line x1="17.01" y1="12" x2="22.96" y2="12"></line>
                        </svg></span> Frequent Test Failures </a>
            </li>
        </ul>
    </div>

    <div class="submenu <?php if(str_contains($endpoint,'sast')) {echo 'show'; } ?>" id="sast">
        <ul class="submenu-list menu-block-submenu" data-parent-element="#sast">
            <li
                class="<?php if(str_contains($endpoint,'sast') && str_contains($currUrl,'platform')) { echo 'active'; }?> menu-block">
                <a href="sast-dashboard?type=platform"><svg viewBox="0 0 24 24" width="24" height="24"
                        stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" class="css-i6dzq1">
                        <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                        <polygon points="12 15 17 21 7 21 12 15"></polygon>
                    </svg> Platform </a>
            </li>
            <li
                class="<?php if(str_contains($endpoint,'sast') && str_contains($currUrl,'mwb')) { echo 'active'; }?> menu-block">
                <a href="sast-dashboard?type=mwb"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <path
                            d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z">
                        </path>
                    </svg> MWB </a>
            </li>
            <li
                class="<?php if(str_contains($endpoint,'sast') && str_contains($currUrl,'ci')) { echo 'active'; }?> menu-block">
                <a href="sast-dashboard?type=ci"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg> CI </a>
            </li>
            <li
                class="<?php if(str_contains($endpoint,'sast') && str_contains($currUrl,'central')) { echo 'active'; }?> menu-block">
                <a href="sast-dashboard?type=central"><svg viewBox="0 0 24 24" width="24" height="24"
                        stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" class="css-i6dzq1">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="7.5 4.21 12 6.81 16.5 4.21"></polyline>
                        <polyline points="7.5 19.79 7.5 14.6 3 12"></polyline>
                        <polyline points="21 12 16.5 14.6 16.5 19.79"></polyline>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg> Central </a>
            </li>
            <li
                class="<?php if(str_contains($endpoint,'sast') && str_contains($currUrl,'assist')) { echo 'active'; }?> menu-block">
                <a href="sast-dashboard?type=assist"><svg viewBox="0 0 24 24" width="24" height="24"
                        stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" class="css-i6dzq1">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                        </path>
                    </svg> Assist PE </a>
            </li>
            <li
                class="<?php if(str_contains($endpoint,'sast') && str_contains($currUrl,'speech')) { echo 'active'; }?> menu-block">
                <a href="sast-dashboard?type=speech"><svg viewBox="0 0 24 24" width="24" height="24"
                        stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" class="css-i6dzq1">
                        <circle cx="5.5" cy="11.5" r="4.5"></circle>
                        <circle cx="18.5" cy="11.5" r="4.5"></circle>
                        <line x1="5.5" y1="16" x2="18.5" y2="16"></line>
                    </svg> Speech CE </a>
            </li>
        </ul>
    </div>

</div>