<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');
// header ('Access-Control-Allow-Methods: PUT');
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
    $file -> id = $data -> id;
    $file -> name = $data -> name;

    if($file -> update_file()){
        http_response_code(200);
    }else{
        http_response_code(204);
    }
}else{
    http_response_code(401);
}

?>