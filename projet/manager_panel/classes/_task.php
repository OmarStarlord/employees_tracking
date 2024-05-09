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
    $sql = "INSERT INTO tasks (TaskName, TaskDescription, TaskStatus, TaskPriority, TaskDueDate, EmployeeID) VALUES ('$this->taskName', '$this->taskDescription', '$this->taskStatus', '$this->taskPriority', '$this->taskDueDate', '$this->employeeID')";
    if ($conn->query($sql) === true) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

public function update($conn){
    $sql = "UPDATE tasks SET TaskName = '$this->taskName', TaskDescription = '$this->taskDescription', TaskStatus = '$this->taskStatus', TaskPriority = '$this->taskPriority', TaskDueDate = '$this->taskDueDate', EmployeeID = '$this->employeeID' WHERE TaskID = $this->taskID";
    if ($conn->query($sql) === true) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

public function delete($conn){
    $sql = "DELETE FROM tasks WHERE TaskID = $this->taskID";
    if ($conn->query($sql) === true) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


    





}

?>

