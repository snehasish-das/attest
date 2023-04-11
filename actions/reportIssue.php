<?php
    session_start();
    require_once '../api/src/config/init.php';
    $_SESSION['jira-url']=JIRA_URL;
    $jira_user=JIRA_USER;
    $jira_pwd=JIRA_PWD;
    $jira_cookie=JIRA_COOKIE;
    $jira_auth = base64_encode($jira_user.':'.$jira_pwd);
    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['jira-url'] . '/api/3/issue';

    $redirect_url = $_REQUEST['redirect_uri'];
    $summary = $_REQUEST['summary'];
    $description = 'Issue Details : '.$_REQUEST['description'].'\n\nTest Run Link : '.$_REQUEST['test_run_link'];
    $product_details = explode('|',$_REQUEST['product_details']);
    $product_id = $product_details[0];
    $product_name = $product_details[1];
    $assignee = $product_details[2];
    $priority = $_REQUEST['priority'];
    $usecase = $_REQUEST['test_id'].' - '.$_REQUEST['test_name'];

    echo '<hr>Summary: '. $summary .'<hr>Description: '. $description .'<hr>Product Name: '. $product_name .'<hr>Product ID: '. $product_id .'<hr>Assignee: '. $assignee .'<hr> Usecase: '. $usecase.'<hr>';

    $payload = '{
        "fields": {
            "project": {
                "id": "23511"
            },
            "issuetype": {
                "id": "1"
            },
            "summary": "'.$summary.'",
            "description": {
                "version": 1,
                "type": "doc",
                "content": [
                    {
                        "type": "paragraph",
                        "content": [
                            {
                                "type": "text",
                                "text": "'.$description.'"
                            }
                        ]
                    }
                ]
            },
            "customfield_20971": {
                "type": "doc",
                "version": 1,
                "content": [
                    {
                        "type": "paragraph",
                        "content": [
                            {
                                "type": "text",
                                "text": "'.$usecase.'"
                            }
                        ]
                    }
                ]
            },
            "priority": {
                "id": "'.$priority.'"
            },
            "assignee": {
                "id": "'.$assignee.'"
            },
            "fixVersions": [
                {
                    "id": "35438"
                }
            ],
            "labels": [],
            "customfield_20030": [
                {
                    "id": "'.$product_id.'",
                    "value": "'.$product_name.'"
                }
            ],
            "customfield_21074": [
                {
                    "id": "35438"
                }
            ],
            "customfield_21238": [
                {
                    "id": "29061",
                    "value": "E2E"
                }
            ],
            "customfield_21237": [
                {
                    "id": "29051",
                    "value": "N/A"
                }
            ],
            "customfield_20632": [
                {
                    "id": "29062",
                    "value": "N/A"
                }
            ],
            "customfield_20384": [],
            "customfield_21080": [],
            "customfield_21235": {
                "id": "29048",
                "value": "No"
            },
            "customfield_21236": {
                "id": "29050",
                "value": "No"
            },
            "components": []
        },
        "update": {}
    }';
    $result = json_decode($cta->jiraPost($url,$payload,$jira_cookie,$jira_auth), true);
    echo '<hr>URL : '.$url.'<br> Payload: '.$payload.'<br> Jira_ID : '.$result['key'].'<hr> Auth: '. $jira_auth;

    $url = $_SESSION['site-url'] . '/api/releases/'.$_REQUEST['parent_node'].'/'.$_REQUEST['test_id'];
    $payload = new stdClass();
    $payload->bug_no = $result['key'];
    $result = json_decode($cta->httpPatchWithAuth($url,json_encode($payload),$_SESSION['auth-phrase']), true);
    echo '<hr>URL : '.$url.'<br> Payload: '.json_encode($payload).'<br> Result : '.$result;

    header("Location:".$redirect_url);
    exit();
?>