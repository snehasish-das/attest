
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