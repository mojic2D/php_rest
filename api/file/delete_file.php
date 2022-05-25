<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json; charset=utf-8');
// header ('Access-Control-Allow-Methods: DELETE');
// header ('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/file.php';
include_once '../../config/authentication.php';

$database = new database();
$auth = new authentication();

$db = $database -> connect();
$is_valid =  $auth -> validate_token();

if($is_valid){
    $file = new file($db);
    $data = json_decode(file_get_contents("php://input"));
    $file -> id = isset($_GET['id']) ? $_GET['id'] : die();

    if($file -> delete_file()){
        http_response_code(200);
    }else{
        http_response_code(400);
    }
}else{
    http_response_code(401);
}

?>