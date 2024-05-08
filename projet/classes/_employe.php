<?php 

class Employe {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $role;
    public $departmentId;


    public function __construct($id, $nom, $prenom, $email, $password, $role, $departmentId) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->departmentId = $departmentId;
    }

    public function insert() {
        $db = new Database();
        $sql = "INSERT INTO employe (nom, prenom, email, password, role, department_id) VALUES ('$this->nom', '$this->prenom', '$this->email', '$this->password', '$this->role', '$this->departmentId')";
        $db->executeSql($sql);
    }

    public function update() {
        $db = new Database();
        $sql = "UPDATE employe SET nom = '$this->nom', prenom = '$this->prenom', email = '$this->email', password = '$this->password', role = '$this->role', department_id = '$this->departmentId' WHERE id = $this->id";
        $db->executeSql($sql);
    }

    public function delete() {
        $db = new Database();
        $sql = "DELETE FROM employe WHERE id = $this->id";
        $db->executeSql($sql);
    }


    public static function getEmployeByName($nom, $conn) {
        $db = new Database($conn);
        $sql = "SELECT * FROM employe WHERE nom = '$nom'";
        $data = $db->queryOne($sql);
        return new Employe($data['id'], $data['nom'], $data['prenom'], $data['email'], $data['password'], $data['role'], $data['department_id']);
        
    }

}