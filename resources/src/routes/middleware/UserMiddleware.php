<?php
session_start();
class UserMiddleware
{
    /**
     * User middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        @$user = $request->getHeader('PHP_AUTH_USER')[0];
        @$pass = md5($request->getHeader('PHP_AUTH_PW')[0]);
        //echo "\n\nUser : " . $user . ", Pass: " . $pass."\n";
        if(!isset($user) || !isset($pass)){
            return $response->withStatus(401)->write('You are not authorized for this action');
        }
        $getEmployees="SELECT * FROM `tcm_users` WHERE `email`='$user' and `password`='$pass' and `is_deleted`=0";

        try{
            $db= new db();
            $db= $db->connect();

            $stmt= $db->query($getEmployees);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if(empty($result)){
                return $response->withStatus(401)->write('Incorrect username or password');
            }
            foreach((array)$result as $key => $value){
                //echo "\nKey=".$key.", Value=".$value;
                if($key=='id'){
                    $_SESSION['emp_id']=$value;
                }
                if($key == 'role'){
                    $_SESSION['role']=$value;
                }
            }
            if (isset($_SESSION['emp_id'])) {
                $response = $next($request, $response);
            }
            else
                return $response->withStatus(401)->write('Incorrect username or password');
        }
        catch (PDOException $e){
            return $response->withStatus(401)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
        }
        $db=null;
        return $response;
    }
}
