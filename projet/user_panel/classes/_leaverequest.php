<?php

class LeaveRequest {
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
    $sql = "INSERT INTO LeaveRequests (EmployeeID, RequestDate, StartDate, EndDate, Status, ManagerID) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($this->employeeID, $this->requestDate, $this->startDate, $this->endDate, $this->status, $this->managerID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "New record created successfully";
    }
}

// Update function
public function update($conn) {
    $sql = "UPDATE LeaveRequests SET EmployeeID = ?, RequestDate = ?, StartDate = ?, EndDate = ?, Status = ?, ManagerID = ? 
            WHERE RequestID = ?";
    $params = array($this->employeeID, $this->requestDate, $this->startDate, $this->endDate, $this->status, $this->managerID, $this->requestID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record updated successfully";
    }
}

// Delete function
public function delete($conn) {
    $sql = "DELETE FROM LeaveRequests WHERE RequestID = ?";
    $params = array($this->requestID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    } else {
        echo "Record deleted successfully";
    }
}


}




?>