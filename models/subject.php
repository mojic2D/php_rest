<?php

class subject {

    private $conn;
    private $table = 'subjects';
    public $id;
    public $name;
    public $shortName;
    public $ects;

    public function __construct($db) {
        $this -> conn = $db;
    }

    public function get_all_subjects() {

        $query = 'SELECT 
                subjects.id,
                subjects.name,
                subjects.faculty,
                subjects.year,
                users.name as professor,
                subjects.professor_id,
                subjects.ects,
                subjects.active
            FROM
            ' . $this -> table . ' LEFT OUTER JOIN users ON users.id=subjects.professor_id;
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> execute();

    return $stmt;
    }

    public function get_subject_by_id() {

        $query = 'SELECT 
        subjects.id,
        subjects.name,
        subjects.faculty,
        subjects.year,
        users.name as professor,
        subjects.professor_id,
        subjects.ects,
        subjects.active,
		faculties.name as facultyName,
		faculties.parentShortName as parentShortName
    FROM
    ' . $this -> table . ' LEFT OUTER JOIN users ON users.id=subjects.professor_id LEFT OUTER JOIN faculties ON faculties.id = subjects.faculty
    
            WHERE
                subjects.id = ?
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> bindParam(1, $this -> id);
    $stmt -> execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    $this -> name = $row['name'];
    $this -> faculty = $row['faculty'];
    $this -> year = $row['year'];
    $this -> professor = $row['professor'];
	$this -> professor_id=$row['professor_id'];
    $this -> ects = $row['ects'];
    $this -> active = $row['active'];
	$this -> facultyName = $row['facultyName'];
	$this -> parentShortName = $row['parentShortName'];

    return $stmt;
    }
    

    public function get_all_subjects_by_faculty() {

        $query = 'SELECT 
        subjects.id,
        subjects.name,
        subjects.faculty,
        subjects.year,
        users.name as professor,
        subjects.professor_id,
        subjects.ects,
        subjects.active,
		faculties.name as facultyName,
		faculties.parentShortName as parentShortName
		
    FROM
    ' . $this -> table . ' LEFT OUTER JOIN users ON users.id=subjects.professor_id LEFT OUTER JOIN faculties ON faculties.id = subjects.faculty
            WHERE
                subjects.faculty = ?
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> bindParam(1, $this -> faculty);
    $stmt -> execute();

    return $stmt;
    }

    public function get_all_subjects_by_professor() {

        $query = 'SELECT 
        subjects.id,
        subjects.name,
        subjects.faculty,
        subjects.year,
        users.name as professor,
        subjects.professor_id,
        subjects.ects,
        subjects.active,
		faculties.name as facultyName,
		faculties.parentShortName as parentShortName
    FROM
    ' . $this -> table . ' LEFT OUTER JOIN users ON users.id=subjects.professor_id LEFT OUTER JOIN faculties ON faculties.id = subjects.faculty
            WHERE
                subjects.professor_id = ?
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> bindParam(1, $this -> professor_id);
    $stmt -> execute();

    return $stmt;
    }

    public function create_subject() {

        $query = 'INSERT INTO ' . $this -> table . '
            SET
                name = :name,
                faculty = :faculty,
                year = :year,
                professor_id = :professor_id,
                ects = :ects,
                active = :active
            ';
        
        $stmt = $this -> conn -> prepare($query);

        $stmt -> bindParam(':name', $this -> name);
        $stmt -> bindParam(':faculty', $this -> faculty);
        $stmt -> bindParam(':year', $this -> year);
        $stmt -> bindParam(':professor_id', $this -> professor_id);
        $stmt -> bindParam(':ects', $this -> ects);
        $stmt -> bindParam(':active', $this -> active);

        if($stmt -> execute()){
            return true;
        }

        print_f("Error: %s. \n", $stmt -> error);
        return false;
    }

    public function update_subject() {

        $query = 'UPDATE ' . $this -> table . '
            SET
                name = :name,
                faculty = :faculty,
                year = :year,
                professor_id = :professor_id,
                ects = :ects,
                active = :active
            WHERE 
                id = :id    
            ';
        
        $stmt = $this -> conn -> prepare($query);

        $stmt -> bindParam(':name', $this -> name);
        $stmt -> bindParam(':faculty', $this -> faculty);
        $stmt -> bindParam(':year', $this -> year);
        $stmt -> bindParam(':professor_id', $this -> professor_id);
        $stmt -> bindParam(':ects', $this -> ects);
        $stmt -> bindParam ('active', $this -> active);
        $stmt -> bindParam(':id', $this -> id);

        if($stmt -> execute()){
            return true;
        }

        print_f("Error: %s. \n", $stmt -> error);
        return false;
    }
}

?>