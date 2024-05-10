<?php

class Request {
    private $employeeID;
    private $requestDate;
    private $startDate;
    private $endDate;
    private $status;
    private $managerID;

    // Constructor
    public function __construct($employeeID, $requestDate, $startDate, $endDate, $status, $managerID) {
        $this->employeeID = $employeeID;
        $this->requestDate = $requestDate;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->managerID = $managerID;
    }

    // Insert function
    public function insert($conn) {
        $sql = "INSERT INTO leaverequests (EmployeeID, RequestDate, StartDate, EndDate, Status, ManagerID) 
                VALUES ('$this->employeeID', '$this->requestDate', '$this->startDate', '$this->endDate', '$this->status', '$this->managerID')";
        if ($conn->query($sql) === true) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Update function
    public function update($conn) {
        $sql = "UPDATE leaverequests SET EmployeeID = '$this->employeeID', RequestDate = '$this->requestDate', 
                StartDate = '$this->startDate', EndDate = '$this->endDate', Status = '$this->status', ManagerID = '$this->managerID' 
                WHERE RequestID = requestID";
        if ($conn->query($sql) === true) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Delete function
    public function delete($conn) {
        $sql = "DELETE FROM leaverequests WHERE RequestID = requestID";
        if ($conn->query($sql) === true) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

}




?>