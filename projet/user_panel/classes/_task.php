<?php
class Task {
    public $taskName;
    public $taskDescription;
    public $taskStatus;
    public $taskPriority;
    public $taskDueDate;
    public $employeeID;

    public function __construct($taskName, $taskDescription, $taskStatus, $taskPriority, $taskDueDate, $employeeID) {
        $this->taskName = $taskName;
        $this->taskDescription = $taskDescription;
        $this->taskStatus = $taskStatus;
        $this->taskPriority = $taskPriority;
        $this->taskDueDate = $taskDueDate;
        $this->employeeID = $employeeID;
    }

    public function insert($conn){
    $sql = "INSERT INTO TASKS (TaskName, TaskDescription, TaskStatus, TaskPriority, TaskDueDate, EmployeeID) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($this->taskName, $this->taskDescription, $this->taskStatus, $this->taskPriority, $this->taskDueDate, $this->employeeID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "New record created successfully";
    }
}

public function update($conn){
    $sql = "UPDATE TASKS SET TaskName = ?, TaskDescription = ?, TaskStatus = ?, TaskPriority = ?, TaskDueDate = ?, EmployeeID = ? WHERE TaskID = ?";
    $params = array($this->taskName, $this->taskDescription, $this->taskStatus, $this->taskPriority, $this->taskDueDate, $this->employeeID, $this->taskID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record updated successfully";
    }
}

public function delete($conn){
    $sql = "DELETE FROM TASKS WHERE TaskID = ?";
    $params = array($this->taskID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record deleted successfully";
    }
}




}

?>

