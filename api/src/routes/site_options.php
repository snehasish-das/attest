<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    
    //Get site_options
    $app->get('/site_options/{key}', function (Request $request, Response $response, array $args) {
        $option_key = $args['key'];
        $getSingleQuery="SELECT `option_value` FROM `tcm_options` WHERE `option_key`='$option_key'";

        try{
            $db= new db();
            $db= $db->connect();

            $stmt= $db->query($getSingleQuery);
            $type=$stmt->fetchAll(PDO::FETCH_OBJ);
            $db=null;
            echo json_encode($type);
        }
        catch (PDOException $e){
            echo '{"error" : {"text": '.$e->getMessage().'}';
            $db=null;
        }
    });
?>