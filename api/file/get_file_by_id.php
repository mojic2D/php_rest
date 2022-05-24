<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/file.php';
include_once '../../config/authentication.php';

$database = new database();
$auth = new authentication();

$db = $database -> connect();
$is_valid =  $auth -> validate_token();

if($is_valid){
    $file = new file($db);
    $file -> id = isset($_GET['id']) ? $_GET['id'] : die();
    $result = $file -> get_file_by_id();
    $num = $result -> rowCount();

    if($num > 0){
	
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
		    $file =  ($row['fileData']);
        }
        header("Content-type:" . $type);
        echo(($file));
        http_response_code(200);
    } else {
    http_response_code(204);
    };
}else{
    http_response_code(401);
}

?>