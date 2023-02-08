<?php
    session_start();
    require_once '../api/src/config/init.php';
    $_SESSION['jenkins-url']=JENKINS_URL;
    $jenkins_user=JENKINS_USER;
    $jenkins_pwd=JENKINS_PWD;


    $payload = new stdClass();
    $parent_node = $_REQUEST['parent_node'];
    $ancestor_node = $_REQUEST['ancestor_node'];
    $home_url = $_REQUEST['home_url'];

    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/releases/'. $parent_node;
    $tests = json_decode($cta->httpGetWithAuth($url,$_SESSION['auth-phrase']), true);

    $scriptPaths = array();
    foreach($tests as $test){
        echo '<br>Test type:'. $test['test_type'] . ', Automation status:' .$test['test_type'] . ', Automation status:' .$test['automation_status'] . ', Automation Script path:' .$test['automation_script_path'];
        if($test['test_type']=='Automation' && $test['automation_status']=='Ready' && $test['automation_script_path']!=''){
            echo '<br> Adding :' . $test['automation_script_path'] . '...';
            array_push($scriptPaths,$test['automation_script_path']);
        }
    }
    $uniquePaths = array_unique($scriptPaths);
    $specs = ''; $index = 0;
    foreach($uniquePaths as $uniquePath){
        $specs.='--spec '. $uniquePath .' ';
        $index++;
    }
    echo '<br> Final Spec :' . $specs . ', count:'. $index;

    $triggerJobUrl = $_SESSION['jenkins-url'].'/job/certify-test-framework/job/TCM_Adhoc_Test_Run/buildWithParameters?HOME='.$home_url.'&TESTS='.$specs.'&NODE_NAME='.$parent_node;
    $jenkins_auth = base64_encode($jenkins_user.':'.$jenkins_pwd);
    $result = json_decode($cta->httpPostWithAuthAndProxy($triggerJobUrl,null,$jenkins_auth), true);

    if($result != '201'){
        $_SESSION['executeTestsError'] = $result;
    }

    header("Location:".$_SESSION['site-url'].'/test-lab?node='.$_REQUEST['parent_node'].'&parent_node='.$ancestor_node);
    exit();

?>