<?php

$connection = mysqli_connect('localhost','root','','studentski_portal_db');
$tables = array();

include_once '../../config/authentication.php';
$auth = new authentication();
$is_valid =  $auth -> validate_token();

if($is_valid){
	$result = mysqli_query($connection,"SHOW TABLES");
	while($row = mysqli_fetch_row($result)){
		$tables[] = $row[0];
	}

	$return = '';

	foreach($tables as $table){
		$result = mysqli_query($connection,"SELECT * FROM ".$table);
		$num_fields = mysqli_num_fields($result);
  
		$row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
		$return .= "\n\n".$row2[1].";\n\n";
  
		for($i=0;$i<$num_fields;$i++){
			while($row = mysqli_fetch_row($result)){
				$return .= "INSERT INTO ".$table." VALUES(";
				for($j=0;$j<$num_fields;$j++){
					$row[$j] = addslashes($row[$j]);
					if(isset($row[$j])){
						$return .= '"'.$row[$j].'"';}
					else{ $return .= '""';}
					if($j<$num_fields-1){ 
						$return .= ',';}
				}
				$return .= ");\n";
			}
		}
	$return .= "\n\n\n";
	}
	$handle = fopen("backup.sql","w+");
	fwrite($handle,$return);
	$data=file_get_contents("backup.sql");
	echo($data);
	fclose($handle);
	http_response_code(200);
}else{
	http_response_code(403);
}
