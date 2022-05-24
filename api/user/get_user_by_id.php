<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/user.php';
include_once '../../config/authentication.php';

$database = new database();
$auth = new authentication();

$db = $database -> connect();
$is_valid =  $auth -> validate_token();

if($is_valid){
    $user = new user($db);
    $user -> id = isset($_GET['id']) ? $_GET['id'] : die();
    if($user -> get_user_by_id()){
        $user_arr = array(
        'id' => $user->id,
        'username' => $user -> username,
        'password' => $user -> password,
        'role' => $user -> role,
        'active' => $user -> active
        );
        print_r(json_encode($user_arr));
        http_response_code(200);
    }else{
        http_response_code(400);
    }
}else{
    http_response_code(401);
}

?>