<?php
class Database {

    private $db_host = 'studentska-baza.cm4gaef6uauk.us-east-1.rds.amazonaws.com';
    private $db_name = 'studentski_portal_db';
    private $username = 'root';
    private $password = 'alfa123!';
    private $con;

    public function connect() {
        $this -> conn = null;

        try {
            $this -> conn = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo 'Connection  Error: ' . $e -> getMessage();
        } 

        return $this -> conn;
    }
}
?>