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
    $subject -> id = isset($_GET['id']) ? $_GET['id'] : die();

    if($subject -> get_subject_by_id()){
        $subject_arr = array(
            'id' => $subject -> id,
            'name' => $subject -> name,
            'faculty' => $subject -> faculty,
            'year' => $subject -> year,
            'professor' => $subject -> professor,
	        'professor_id'=>$subject ->professor_id,
            'ects' => $subject -> ects,
            'active' => $subject -> active,
	        'faculty'=>$subject -> facultyName,
	        'parentShortName'=>$subject -> parentShortName
        );
        echo(json_encode($subject_arr));
        http_response_code(200);}
    else{
        http_response_code(400);
    }
}else{
    http_response_code(401);
}
?>