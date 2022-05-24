<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/subject.php';
include_once '../../config/authentication.php';

$database = new database();
$auth = new authentication();

$db = $database -> connect();
$is_valid =  $auth -> validate_token();

if($is_valid){
    $subject = new subject($db);
    $subject -> faculty = isset($_GET['faculty']) ? $_GET['faculty'] : die();
    $result = $subject -> get_all_subjects_by_faculty();
    $num = $result -> rowCount();

    if($num > 0){
        $subjects_arr = array();
        $subjects_arr = array();

        $sss='0';
        while($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $subject_item = array(
                'id' => $id,
                'name' => $name,
                'faculty' => $faculty,
                'year' => $year,
                'professor' => $professor,
                'professor_id' => $professor_id,
                'estc' => $ects,
                'active' => $active,
			    'faculty' => $facultyName,
			    'parentShortName' => $parentShortName
                  );
            array_push($subjects_arr, $subject_item);
            
            $sss= $subject_item;
        }
        echo json_encode($sss);
        echo json_encode($subjects_arr);
        http_response_code(200);
    } else {
        http_response_code(204);
    };
           
}else{
    http_response_code(401);
}

?>