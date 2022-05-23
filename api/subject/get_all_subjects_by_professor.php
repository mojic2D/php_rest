<?php

header('Access-Control-Allow-Origin: *');
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
    $subject -> professor_id = isset($_GET['professor_id']) ? $_GET['professor_id'] : die();
    $result = $subject -> get_all_subjects_by_professor();
    $num = $result -> rowCount();

    if($num > 0){
        $subjects_arr = array();
        $subjects_arr = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $subject_item = array(
                'id' => $id,
                'name' => $name,
                'faculty_id' => $faculty,
                'year' => $year,
                'professor' => $professor,
                'estc' => $ects,
                'active' => $active,
			    'faculty'=>$facultyName,
			    'parentShortName'=>$parentShortName
            );
            array_push($subjects_arr, $subject_item);
        }

        echo json_encode($subjects_arr);
        http_response_code(200);
    } else {
        http_response_code(204);
    };
}else{
    http_response_code(401);
}

?>