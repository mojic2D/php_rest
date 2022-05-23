<?php

header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');
header ('Access-Control-Allow-Methods: POST');
header ('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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
    $fileData = file_get_contents($_FILES['file']['tmp_name']);

    $file -> name = $_POST['name'];
    $file -> type = $_FILES['file']['type'];
    $file -> fileData = $fileData;
    $file -> createdBy = $_POST['createdBy']; 
    $file -> subject = $_POST['subject']; 
    $file->isResults = $_POST['isResults'];

    if($file -> create_file()){
	    http_response_code(201);
    }else{
        http_response_code(400);
    }
}
else{
    http_response_code(401);
}

?>