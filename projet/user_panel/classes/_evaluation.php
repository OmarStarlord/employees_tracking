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
    $sql = "INSERT INTO performanceevaluations (EmployeeID, EvaluationDate, EvaluationForm, Result) VALUES ('$this->employeeID', '$this->evaluationDate', '$this->evaluationForm', '$this->result')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

public function update($conn) {
    $sql = "UPDATE performanceevaluations SET EvaluationDate = '$this->evaluationDate', EvaluationForm = '$this->evaluationForm', Result = '$this->result' WHERE EvaluationID = $this->evaluationID";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

public function delete($conn) {
    $sql = "DELETE FROM performanceevaluations WHERE EvaluationID = $this->evaluationID";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


    
    
    


}

?>