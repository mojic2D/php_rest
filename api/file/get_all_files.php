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
    $result = $file -> get_all_files();
    $num = $result -> rowCount();

    if($num > 0){
        $files_arr = array();
        $files_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
  
            $files_item = array(
                'id' => $id,
                'name' => $name,
                'createdBy' => $createdBy,
                'createdAt' => $createdAt,
                'subject' => $subject,
			    'isResults' => $isResults
            );
        
        array_push($files_arr, $files_item);
        }
        echo json_encode($files_arr);
        http_response_code(200);
    }else{
        http_response_code(204);
    }
}else{
    http_response_code(403);
}

?>