<?php
//session_start();
$runs_url = $_SESSION['site-url'] . '/api/reports/recent-run-dates';
$runs = json_decode($cta->httpGetWithAuth($runs_url,$_SESSION['auth-phrase']), true);

?>

<table id="html5-extension" class="table table-hover non-hover" style="width:100%" >
    <thead>
        <tr>
            <th>Execution Date</th>
            <th>Node</th>
            <th>Bug ID</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(isset($runs)){
        foreach((array) $runs as $run){ 
            $bugs_url = $_SESSION['site-url'] . '/api/reports/most-failures?execution_date='.$run['execution_date'];
            //echo '<br>'.$bugs_url;
            $bugs = json_decode($cta->httpGetWithAuth($bugs_url,$_SESSION['auth-phrase']), true);
            //if(sizeof($bugs)>0){
            foreach((array)$bugs as $bug){
        ?>
        <tr>
            <td><?php echo $run['execution_date']; ?></td>
            <td><a class="link" target="_blank" href="<?php echo $bug['test_run_link']; ?>"><?php echo $bug['parent_node']; ?></a></td>
            <td><?php echo $bug['bug_no']; ?></td>
            <td><?php echo $bug['count']; ?></td>
        </tr>
        <?php } } 
        } else{
            echo '<tr><td colspan="4">No records to be displayed</td></tr>';   
        }?>
    </tbody>
</table>