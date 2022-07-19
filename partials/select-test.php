<?php
    $endpoint = explode('?',$_SERVER['REQUEST_URI']);
    @$currUrl = end(explode('/',$endpoint[0]));
    
    function getTestTreeView($nodes){
        foreach($nodes as $node){
            echo '<li><span class="caret caret-down">'.$node['node_name'].'</span><ul class="nested">';
            if(sizeof($node['nodes'])>0){
                getTestTreeView($node['nodes']);
            }
            if(sizeof($node['tests'])>0){
                for($i=0; $i<sizeof($node['tests']); $i++)
                {
                    $test_name = $node['tests'][$i]['name'];
                    $test_id = $node['tests'][$i]['id'];
                    echo '<li>
                    <div class="n-chk">
                        <label class="new-control new-checkbox checkbox-primary">
                          <input type="checkbox" class="new-control-input" name="test_id[]" value="'.$test_id.'">
                          <span class="new-control-indicator"></span>
                            <span class="ml-2">'.$test_name.'</span>
                        </label>
                    </div>
                </li>';
                }
                //echo '<li><a href="test-plan?name='.$node['tests'][$i]['name'].'">'.$node['tests'][$i]['name'].'</a></li>';
            }
            echo '</ul></li>';
        }
    }
?>
<div class="col-right-content">
    <div class="col-right-content-container">
        <div class="activity-section">
            <form method="POST" action="./actions/selectTests.php">
                <input type="hidden" name="parent_node" value="<?php echo $_REQUEST['node']; ?>">
                <input type="hidden" name="redirect_uri" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <div class="widget-taskBoard">
                    <div class="widget-title">
                        <h5>Select Tests</h5>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-arrow-left">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            <span>Move</span>
                        </button>
                    </div>
                    <div class="widget-taskBoard-lists">
                        <ul id="myUL" class="list-group task-list-group">
                            <?php 
                            getTestTreeView($_SESSION['testplanNodes']);
                        ?>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>