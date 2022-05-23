<?php

header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/faculty.php';
include_once '../../config/authentication.php';

$database = new database();
$auth = new authentication();

$db = $database -> connect();
$is_valid =  $auth -> validate_token();

if($is_valid){
    $faculty = new faculty($db);
    $result = $faculty -> get_all_faculties();
    $num = $result -> rowCount();

    if($num > 0){
        http_response_code(200);
        $faculty_arr = array();
        $faculty_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
  
            $faculty_item = array(
                'id' => $id,
                'name' => $name,
                'parentShortName' => $parentShortName,
                'ects' => $ects
            );
        
            array_push($faculty_arr, $faculty_item);
        }
        echo json_encode($faculty_arr);
    } else {
        http_response_code(204);
    }
}else{
	http_response_code(401);
}

?>