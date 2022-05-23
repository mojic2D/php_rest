<?php

class faculty {

    private $conn;
    private $table = 'faculties';
    public $id;
    public $name;
    public $shortName;
    public $ects;

    public function __construct($db) {
        $this -> conn = $db;
    }

    public function get_all_faculties() {

        $query = 'SELECT 
                f.id,
                f.name,
                f.parentShortName,
                f.ects
            FROM
                ' . $this -> table . ' f
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> execute();

    return $stmt;
    }
}

?>