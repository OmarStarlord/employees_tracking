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
    $sql = "INSERT INTO Employees (FirstName, LastName, Email, Password, Role, DepartmentID) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($this->nom, $this->prenom, $this->email, $this->password, $this->role, $this->departmentId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "New record created successfully";
    }
}

public function update($conn) {
    $sql = "UPDATE Employees SET FirstName = ?, LastName = ?, Email = ?, Password = ?, Role = ?, DepartmentID = ? WHERE EmployeeID = ?";
    $params = array($this->nom, $this->prenom, $this->email, $this->password, $this->role, $this->departmentId, $this->id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record updated successfully";
    }
}

public function delete($conn) {
    $sql = "DELETE FROM Employees WHERE EmployeeID = ?";
    $params = array($this->id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record deleted successfully";
    }
}



    


}