<?php
    ob_start();
    session_start();
    //unset($_SESSION['user-details']);
    
    session_destroy();
    header('Location:index');
    exit;
?>