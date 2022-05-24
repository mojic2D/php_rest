<?php

// header('Access-Control-Allow-Origin: *');
// header ('Content-Type: application/json');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
// // header('Access-Control-Allow-Headers: *');
// header ('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
// header('Access-Control-Max-Age: 86400');

// if (isset($_SERVER['HTTP_ORIGIN'])) {
//     // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
//     // you want to allow, and if so:
//     header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//     header('Access-Control-Allow-Credentials: true');
//     header('Access-Control-Max-Age: 86400');    // cache for 1 day
// }

// // Access-Control headers are received during OPTIONS requests
// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
//     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
//         // may also be using PUT, PATCH, HEAD etc
//         header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    
//     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
//         header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

//     exit(0);
// }


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