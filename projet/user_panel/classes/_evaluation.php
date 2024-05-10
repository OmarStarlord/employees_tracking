<?php
class Evaluation {
    private $evaluationID;
    private $employeeID;
    private $evaluationDate;
    private $evaluationForm;
    private $result;

    public function __construct( $employeeID, $evaluationDate, $evaluationForm, $result = null ) {
        
        $this->employeeID = $employeeID;
        $this->evaluationDate = $evaluationDate;
        $this->evaluationForm = $evaluationForm;
        $this->result = $result;
    }

    public function insert($conn) {
    $sql = "INSERT INTO PerformanceEvaluations (EmployeeID, EvaluationDate, EvaluationForm, Result) VALUES (?, ?, ?, ?)";
    $params = array($this->employeeID, $this->evaluationDate, $this->evaluationForm, $this->result);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "New record created successfully";
    }
}

public function update($conn) {
    $sql = "UPDATE PerformanceEvaluations SET EvaluationDate = ?, EvaluationForm = ?, Result = ? WHERE EvaluationID = ?";
    $params = array($this->evaluationDate, $this->evaluationForm, $this->result, $this->evaluationID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record updated successfully";
    }
}

public function delete($conn) {
    $sql = "DELETE FROM PerformanceEvaluations WHERE EvaluationID = ?";
    $params = array($this->evaluationID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record deleted successfully";
    }
}

    
    
    


}

?>