<?php

class user {

    private $conn;
    private $table = 'users';
    public $id;
    public $username;
    public $password;
    public $role;
    public $active;
    public $createdAt;

    public function __construct($db) {
        $this -> conn = $db;
    }

    public function get_all_users() {

        $query = 'SELECT 
                u.id,
                u.username,
                u.password,
                u.role,
                u.active,
                u.createdAt,
				u.name
            FROM
                ' . $this -> table . ' u
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> execute();
if($stmt -> execute())

    return $stmt;

else 
return false;
    }

    public function get_user_by_id() {

        $query = 'SELECT 
                u.id,
                u.username,
                u.password,
                u.role,
                u.active,
                u.createdAt
            FROM
                ' . $this -> table . ' u
            WHERE
                u.id = ?
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> bindParam(1, $this -> id);
    $stmt -> execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    $this -> username = $row['username'];
    $this -> password = $row['password'];
    $this -> role = $row['role'];
    $this -> active = $row['active'];

    return $stmt;
    }

    public function login() {

        $query = 'SELECT 
                u.id,
                u.role,
				u.username,
				u.password,
                u.active,
				u.name
            FROM
                ' . $this -> table . ' u
           WHERE 
           (username = :username AND password = :password)
            ';

    $stmt = $this -> conn -> prepare($query);
    $stmt -> bindParam(':username', $this -> username);
    $stmt -> bindParam(':password', $this -> password);
    $stmt -> execute();

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){ 
	    $this -> id = $row['id'];
        $this -> role = $row['role'];
        $this -> active = $row['active'];
	    $this -> name = $row['name'];
	}
	
    if($stmt -> execute()){
        return $stmt;
    }

    print_f("Error: %s. \n", $stmt -> error);
    return false;
    }

    public function create_user() {

        $query = 'INSERT INTO ' . $this -> table . '
            SET
			name = :name,
                username = :username,
                password = :password,
                role = :role,
                active = :active
            ';
        
        $stmt = $this -> conn -> prepare($query);
		$stmt -> bindParam(':name', $this -> name);
        $stmt -> bindParam(':username', $this -> username);
        $stmt -> bindParam(':password', $this -> password);
        $stmt -> bindParam(':role', $this -> role);
        $stmt -> bindParam(':active', $this -> active);

        if($stmt -> execute()){
            return true;
        }

        print_f("Error: %s. \n", $stmt -> error);
        return false;
    }

    public function update_user() {

if(isset($this->password)){
        $query = 'UPDATE ' . $this -> table . '
            SET
				name=:name,
                username = :username,
                password = :password,
                role = :role,
                active = :active
            WHERE 
                id = :id    
            ';
}else{
	$query = 'UPDATE ' . $this -> table . '
            SET
				name=:name,
                username = :username,
                role = :role,
                active = :active
            WHERE 
                id = :id    
            ';
};
        $stmt = $this -> conn -> prepare($query);
        $stmt -> bindParam(':username', $this -> username);
		$stmt -> bindParam(':name', $this -> name);
		if(isset($this->password)){
            $stmt -> bindParam(':password', $this -> password);
		}
        $stmt -> bindParam(':role', $this -> role);
        $stmt -> bindParam(':active', $this -> active);
        $stmt -> bindParam(':id', $this -> id);
        if($stmt -> execute()){
            return true;
        }

        print_f("Error: %s. \n", $stmt -> error);
        return false;
    }

    public function delete_user() {

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
}

?>