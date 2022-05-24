<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');
// header ('Access-Control-Allow-Methods: DELETE');
// header ('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/user.php';
include_once '../../config/authentication.php';

$database = new database();
$auth = new authentication();

$db = $database -> connect();
$is_valid =  $auth -> validate_token();

if($is_valid){
    $user = new user($db);
    $data = json_decode(file_get_contents("php://input"));
    $user -> id = isset($_GET['id']) ? $_GET['id'] : die();

    if($user -> delete_user()){
        http_response_code(200);
    }else{
        http_response_code(400);
    }
}else{
    http_response_code(401);
}

?>