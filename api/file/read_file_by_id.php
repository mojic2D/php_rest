<?php

// header('Access-Control-Allow-Origin: *');
header ('Content-Type: application/json; charset=utf-8');

include_once '../../config/database.php';
include_once '../../models/file.php';
include_once '../../config/authentication.php';

require $_SERVER['DOCUMENT_ROOT'].'/php_rest/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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
			$file = ($row['fileData']);
			$name = ($row['name']);
			$name.='.xlsx';
    	}
		$f = fopen($name, 'wb');
		file_put_contents($name,$file);

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load($name); 
		$data = $spreadsheet->getActiveSheet()->toArray();
		
		fclose($f);
		unlink($name);
	
		$output=[];
		$columns = [];

		foreach ($data[0] as $key => $value) {
			array_push($columns, $value);
		}

		unset($data[0]);
		foreach($data as $row){
			$temp;
			foreach ($columns as $key => $value) {
				$temp[$value] = $row[$key];
			}
			array_push($output,(object) $temp);
		}

		echo json_encode(
			array(	
				'columns'=> $columns,
				'data'=> $output,
			)
		);
		http_response_code(200);
	} else {
    	http_response_code(204);
	}
}else{
	http_response_code(404);
}
?>