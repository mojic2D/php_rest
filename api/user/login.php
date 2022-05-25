<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json');
// header ('Access-Control-Allow-Methods: POST');

include_once '../../config/database.php';
include_once '../../models/user.php';

$database = new database();
$db = $database -> connect();

$user = new user($db);

$user -> username = $_POST['username'];
$user -> password = $_POST['password'];

$user -> login();

if(property_exists($user, 'name')){
	$user_arr = array(
		'id' 		=> intval($user -> id),
		'role' 		=> $user -> role,
		'active' 	=> intval($user -> active),
		'name' 		=> $user -> name
	);
};

if($user->id===null){
	print_r(json_encode(array('error'=>'user not found')));
}else{
	http_response_code(200);
	print_r(json_encode($user_arr));
}

?>