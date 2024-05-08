<?php
class Evaluation {
    private $evaluationID;
    private $employeeID;
    private $evaluationDate;
    private $evaluationForm;
    private $result;

    public function __construct($evaluationID, $employeeID, $evaluationDate, $evaluationForm, $result) {
        $this->evaluationID = $evaluationID;
        $this->employeeID = $employeeID;
        $this->evaluationDate = $evaluationDate;
        $this->evaluationForm = $evaluationForm;
        $this->result = $result;
    }

    public function insert() {
        $db = new Database();
        $sql = "INSERT INTO evaluation (employee_id, evaluation_date, evaluation_form, result) VALUES ('$this->employeeID', '$this->evaluationDate', '$this->evaluationForm', '$this->result')";
        $db->executeSql($sql);
    }

    public function update() {
        $db = new Database();
        $sql = "UPDATE evaluation SET employee_id = '$this->employeeID', evaluation_date = '$this->evaluationDate', evaluation_form = '$this->evaluationForm', result = '$this->result' WHERE evaluation_id = $this->evaluationID";
        $db->executeSql($sql);
    }

    public function delete() {
        $db = new Database();
        $sql = "DELETE FROM evaluation WHERE evaluation_id = $this->evaluationID";
        $db->executeSql($sql);
    }

    


}

?>