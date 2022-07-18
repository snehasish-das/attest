<?php
    $endpoint = explode('?',$_SERVER['REQUEST_URI']);
    @$currUrl = end(explode('/',$endpoint[0]));
    
    function getTreeView($nodes,$node_type){
        foreach($nodes as $node){
            if($node_type=='testplan'){
                echo '<li><span class="caret caret-down"></span><a class="menu-block-submenu" href="test-plan?node='.$node['node_name'].'">'.$node['node_name'].'</a><ul class="nested">';
            }else{
                echo '<li><span class="caret caret-down"></span><a class="menu-block-submenu" href="test-lab?node='.$node['node_name'].'">'.$node['node_name'].'</a><ul class="nested">';
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
        <li class="menu menu-single <?php  if(str_contains($currUrl,'index') || $currUrl =='') { echo 'active'; }?>">
            <a href="index" data-active="<?php echo (str_contains($currUrl,'index') || $currUrl =='') ? 'true' : 'false'  ?>"
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

        <li class="menu <?php  if(str_contains($currUrl,'test-plan')) { echo 'active'; }?>">
            <a href="#testplan" data-active="<?php echo (str_contains($currUrl,'test-plan')) ? 'true' : 'false'  ?>"
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

        <li class="menu" <?php  if(str_contains($currUrl,'test-lab')) { echo 'active'; }?>>
            <a href="#testlab" data-active="<?php echo (str_contains($currUrl,'test-lab')) ? 'true' : 'false'  ?>"
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

        <li class="menu menu-single" <?php  if(str_contains($currUrl,'requirements')) { echo 'active'; }?>>
            <a href="requirements" data-active="<?php echo (str_contains($currUrl,'requirements')) ? 'true' : 'false'  ?>"
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
                    <span>Requirements</span>
                </div>
            </a>
        </li>

        <li class="menu menu-single" <?php  if(str_contains($currUrl,'releases')) { echo 'active'; }?>>
            <a href="releases" data-active="<?php echo (str_contains($currUrl,'releases')) ? 'true' : 'false'  ?>"
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
        </li>

        <li class="menu menu-single" <?php  if(str_contains($currUrl,'reports')) { echo 'active'; }?>>
            <a href="reports" data-active="<?php echo (str_contains($currUrl,'reports')) ? 'true' : 'false'  ?>"
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

    </ul>
</nav>

<div id="compact_submenuSidebar" class="submenu-sidebar ps ps--active-x">
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
</div>