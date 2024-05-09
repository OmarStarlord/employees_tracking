<?php

class LeaveRequest {
    public $requestID;
    public $employeeID;
    public $requestDate;
    public $startDate;
    public $endDate;
    public $status;
    public $managerID;


    public function __construct($requestID, $employeeID, $requestDate, $startDate, $endDate, $status, $managerID) {
        $this->requestID = $requestID;
        $this->employeeID = $employeeID;
        $this->requestDate = $requestDate;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->managerID = $managerID;
    }


    public function insert($conn) {
        $sql = "INSERT INTO leave_request (employee_id, request_date, start_date, end_date, status, manager_id) VALUES ('$this->employeeID', '$this->requestDate', '$this->startDate', '$this->endDate', '$this->status', '$this->managerID')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function update($conn) {
        $sql = "UPDATE leave_request SET employee_id = '$this->employeeID', request_date = '$this->requestDate', start_date = '$this->startDate', end_date = '$this->endDate', status = '$this->status', manager_id = '$this->managerID' WHERE request_id = $this->requestID";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function delete($conn) {
        $sql = "DELETE FROM leave_request WHERE request_id = $this->requestID";
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    


}


?>