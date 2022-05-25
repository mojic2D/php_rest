<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json; charset=utf-8');
// header ('Access-Control-Allow-Methods: POST');
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

    $user -> name = $data -> name;
    $user -> username = $data -> username;
    $user -> password = $data -> password;
    $user -> role = $data -> role;
    $user -> active = $data -> active;

    if($user -> create_user()){
        http_response_code(201);
    }else{
        http_response_code(400);
    }
}else{
    http_response_code(401);
}

?>