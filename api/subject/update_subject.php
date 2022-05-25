<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json; charset=utf-8');
// header ('Access-Control-Allow-Methods: PUT');
// header ('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/subject.php';
include_once '../../config/authentication.php';

$database = new database();
$auth = new authentication();

$db = $database -> connect();
$is_valid =  $auth -> validate_token();

if($is_valid){
    $subject = new subject($db);
    $data = json_decode(file_get_contents("php://input"));

    $subject -> id = $data -> id;
    $subject -> name = $data -> name;
    $subject -> faculty = $data -> faculty;
    $subject -> year = $data -> year;
    $subject -> professor_id = $data -> professor_id;
    $subject -> ects = $data -> ects;
    $subject -> active = $data -> active;

    if($subject -> update_subject()){
        http_response_code(200);
    }else{
        http_response_code(200);
    }
}else{
    http_response_code(401);
}
?>