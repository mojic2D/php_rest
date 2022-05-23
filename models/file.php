<?php

class file {

    private $conn;
    private $table = 'files';
    public $id;
    public $name;
    public $fileData;
    public $createdAt;
    public $createdBy;
    public $subject;

    public function __construct($db) {
        $this -> conn = $db;
    }

    public function create_file() {

        $query = 'INSERT INTO ' . $this -> table . '
            SET
                name = :name,
                type = :type,
                fileData = :fileData,
                createdBy = :createdBy,
                subject = :subject,
				isResults=:isResults
            ';
        
        $stmt = $this -> conn -> prepare($query);
        $stmt -> bindParam(':name', $this -> name);
        $stmt -> bindParam(':type', $this -> type);
        $stmt -> bindParam(':fileData', $this -> fileData);
        $stmt -> bindParam(':createdBy', $this -> createdBy);
        $stmt -> bindParam(':subject', $this -> subject);
		$stmt -> bindParam(':isResults', $this -> isResults);

        if($stmt -> execute()){
            return true;
        }

        print_f("Error: %s. \n", $stmt -> error);
        return false;
    }
	
	    public function get_all_files() {

        $query = 'SELECT 
                files.id,
                files.name,
                users.name as createdBy,
                files.createdAt,
                subjects.name as subject,
				files.isResults

				FROM
				' . $this -> table . ' LEFT OUTER JOIN users ON users.id=files.createdBy LEFT OUTER JOIN subjects ON subjects.id=files.subject
                ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> execute();

    return $stmt;
    }

    public function get_all_files_by_subject() {

        $query = 'SELECT 
                f.id,
                f.name,
                f.createdBy,
                f.createdAt,
                f.subject,
				f.isResults

            FROM
                ' . $this -> table . ' f
            WHERE
                f.subject = ?
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> bindParam(1, $this -> subject);
    $stmt -> execute();

    return $stmt;
    }

    public function get_file_by_id() {

        $query = 'SELECT 
        f.id,
        f.name,
		f.type,
        f.fileData,
        f.createdBy,
        f.createdAt,
        f.subject

    FROM
        ' . $this -> table . ' f
    WHERE
        f.id = ?
    ';

$stmt = $this -> conn -> prepare($query);
$stmt -> bindParam(1, $this -> id);
$stmt -> execute();

return $stmt;
}

    public function delete_file() {

        $query = 'DELETE FROM ' . $this -> table . '
            WHERE 
                id = ?
            ';

        $stmt = $this -> conn -> prepare($query);
        $stmt -> bindParam(1, $this -> id);

        if($stmt -> execute()){
            return true;
        }

        print_f("Error: %s. \n", $stmt -> error);
        return false;
    }
	
	    public function update_file() {


	$query = 'UPDATE ' . $this -> table . '
            SET
                name = :name
            WHERE 
                id = :id    
            ';
	

        $stmt = $this -> conn -> prepare($query);
        $stmt -> bindParam(':name', $this -> name);
		$stmt -> bindParam(':id', $this -> id);

        if($stmt -> execute()){
            return true;
        }

        print_f("Error: %s. \n", $stmt -> error);
        return false;
    }
}
    ?>