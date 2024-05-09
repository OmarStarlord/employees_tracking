<?php 

class Employe {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $role;
    public $departmentId;


    public function __construct( $nom, $prenom, $email, $password, $role, $departmentId) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->departmentId = $departmentId;
    }

    public function insert($conn) {
    $sql = "INSERT INTO employees (FirstName, LastName, Email, Password, Role, DepartmentID) VALUES ('$this->nom', '$this->prenom', '$this->email', '$this->password', '$this->role', '$this->departmentId')";
    if ($conn->query($sql) === true) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

public function update($conn) {
    $sql = "UPDATE employees SET FirstName = '$this->nom', LastName = '$this->prenom', Email = '$this->email', Password = '$this->password', Role = '$this->role', DepartmentID = '$this->departmentId' WHERE EmployeeID = $this->id";
    if ($conn->query($sql) === true) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

public function delete($conn) {
    $sql = "DELETE FROM employees WHERE EmployeeID = $this->id";
    if ($conn->query($sql) === true) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


    


}