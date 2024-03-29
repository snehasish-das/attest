<?php
@session_start();
require_once 'api/src/functions.php';

$cta = new CallToAction();
$rootnodes_url = $_SESSION['site-url'] . '/api/nodes/root';
$rootnodes = json_decode($cta->httpGetWithAuth($rootnodes_url,$_SESSION['auth-phrase']), true);

?>
<!-- Add Test plan node Modal -->
<form id="addTestplanNode" action="./actions/addNode.php" method="POST">
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
                    <button class="btn" data-dismiss="modal"> Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Add Test plan node Modal -->
<form id="addTestlabNode" action="./actions/addNode.php" method="POST">
    <div class="modal fade" id="addTestlabFolderModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                                <input type="hidden" value="testlab" name="node_type" />
                                <input type="text" class="form-control" id="node_name" name="node_name"
                                    aria-describedby="nodeNameHelp" placeholder="Node name" required>
                                <small id="nodeNameHelp" class="form-text text-muted">You wont be able to update
                                    this later.</small>
                            </div>
                            <div class="form-group mb-4">
                                <select class="form-control basic" id="parent_node" name="parent_node">
                                    <?php 
                                        $distinctValues = array();
                                        foreach((array) $_SESSION['testlabNodes'] as $testlabNode){ 
                                            if(array_search($testlabNode['node_name'], $distinctValues) == ''){
                                                array_push($distinctValues,$testlabNode['node_name']);
                                                echo '<option>'.$testlabNode['node_name'].'</option>';
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
                    <button class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Add Test Modal -->
<form id="addNewTest" action="./actions/addNewTest.php" method="POST">
    <input type="hidden" class="form-control" name="parent_node" value="<?php echo @$_REQUEST['node']; ?>" />
    <input type="hidden" class="form-control" name="ancestor_node" value="<?php echo @$_REQUEST['parent_node']; ?>" />
    <div class="modal fade" id="addNewTestModal" tabindex="-1" role="dialog" aria-hidden="true" data-focus="false">
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
                            <h5 class="task-heading">Add new test</h5>
                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Verify if login is successful" required />
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label>Test Type</label>
                                    <select class="form-control selectpicker" name="test_type">
                                        <option value="Automation">Automation</option>
                                        <option value="Manual">Manual</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Test Category</label>
                                    <select class="form-control selectpicker" name="test_category">
                                        <option value="UI">UI</option>
                                        <option value="REST">REST</option>
                                        <option value="HYBRID">HYBRID</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label>Product</label>
                                    <select class="form-control selectpicker" name="product">
                                        <?php foreach ($rootnodes as $rootnode){
                                            echo '<option value="'.$rootnode['node_name'].'">'.$rootnode['node_name'].'</option>';
                                        } ?>
                                    </select>
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Priority</label>
                                    <select class="form-control selectpicker" name="priority">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label>Scrum Name</label>
                                    <input type="text" class="form-control" name="scrum_name"
                                        placeholder="Scrum Name" />
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="form-row">
                                <div class="col-md-12 mb-12">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Execute Automation Tests Modal -->
<form id="executeAutomationTests" action="./actions/executeAutomationTests.php" method="POST">
    <input type="hidden" class="form-control" name="parent_node" value="<?php echo @$_REQUEST['node']; ?>" />
    <input type="hidden" class="form-control" name="ancestor_node" value="<?php echo @$_REQUEST['parent_node']; ?>" />
    <div class="modal fade" id="executeAutomationTestsModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                            <h5 class="task-heading">Execute Automation Tests via Jenkins</h5>
                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label>Home url</label>
                                    <input type="text" class="form-control" name="home_url"
                                        placeholder="https://staging.247-inc.net/home" required />
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label>Jenkins Job url</label>
                                    <input type="text" class="form-control" name="job_url"
                                        placeholder="https://cicd.cloud.247-inc.net/job/certify-test-framework/job/TCM_Adhoc_Test_Run" />
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Add Feature Modal -->
<form id="addNewFeature" action="./actions/addNewFeature.php" method="POST">
    <div class="modal fade" id="addNewFeatureModal" tabindex="-1" role="dialog" aria-hidden="true" data-focus="false">
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
                            <h5 class="task-heading">Add new feature</h5>
                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Introducing cards to assist" required />
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label>Feature Type</label>
                                    <select class="form-control selectpicker" name="feature_type">
                                        <option value="New Feature">New Feature</option>
                                        <option value="Enhancement">Enhancement</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Status</label>
                                    <select class="form-control selectpicker" name="status">
                                        <option value="Not Planned">Not Planned</option>
                                        <option value="Not Started">Not Started</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Partially Delivered">Partially Delivered</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label>Is Multi-Sprint</label>
                                    <select class="form-control selectpicker" name="is_multi_sprint">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="form-row">
                                <div class="col-md-12 mb-12">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Upload Tests Modal -->
<form id="uploadTests" action="./actions/uploadTests.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" class="form-control" name="parent_node" value="<?php echo @$_REQUEST['node']; ?>" />
    <input type="hidden" class="form-control" name="ancestor_node" value="<?php echo @$_REQUEST['parent_node']; ?>" />
    <div class="modal fade" id="uploadTestsModal" tabindex="-1" role="dialog" aria-hidden="true" data-focus="false">
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
                            <h5 class="task-heading">Upload tests</h5>
                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label>File (in csv)</label>
                                    <input type="file" class="form-control" name="uploadFile" required />
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Display SAST History modal -->
<div class="modal fade" id="sastHistoryModal" tabindex="-1" role="dialog" aria-hidden="true" data-focus="false">
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
                        <h5 class="task-heading">SAST History</h5>
                        <div id="sastHistory"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>

