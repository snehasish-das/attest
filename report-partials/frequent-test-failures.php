<?php
//session_start();
$failures_url = $_SESSION['site-url'] . '/api/reports/frequent-test-failures';
$failures = json_decode($cta->httpGetWithAuth($failures_url,$_SESSION['auth-phrase']), true);

?>

<table id="html5-extension" class="table table-hover non-hover" style="width:100%" >
    <thead>
        <tr>
            <th>Test Name</th>
            <th>Product</th>
            <th>Author</th>
            <th>Priority</th>
            <th>Node Name</th>
            <th>Test run link</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach((array)$failures as $failure){
        ?>
        <tr>
            <td><?php echo $failure['name']; ?></td>
            <td><?php echo $failure['product']; ?></td>
            <td><?php echo $failure['author']; ?></td>
            <td><?php echo $failure['priority']; ?></td>
            <td><?php echo $failure['parent_node']; ?></td>
            <td><a class="link" target="_blank" href="<?php echo $failure['test_run_link']; ?>">link</a></td>
            <td><?php echo $failure['count']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>