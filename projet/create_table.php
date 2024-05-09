<?php
include 'config.php';


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "
CREATE TABLE Departments (
    DepartmentID INT PRIMARY KEY AUTO_INCREMENT,
    DepartmentName VARCHAR(255)
);

CREATE TABLE Employees (
    EmployeeID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Role VARCHAR(50),
    DepartmentID INT,
    FOREIGN KEY (DepartmentID) REFERENCES Departments(DepartmentID)
);

CREATE TABLE WorkSchedules (
    ScheduleID INT PRIMARY KEY AUTO_INCREMENT,
    EmployeeID INT,
    Date DATE,
    StartTime TIME,
    EndTime TIME,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);

CREATE TABLE LeaveRequests (
    RequestID INT PRIMARY KEY AUTO_INCREMENT,
    EmployeeID INT,
    RequestDate DATE,
    StartDate DATE,
    EndDate DATE,
    Status VARCHAR(50),
    ManagerID INT,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID),
    FOREIGN KEY (ManagerID) REFERENCES Employees(EmployeeID)
);

CREATE TABLE PerformanceEvaluations (
    EvaluationID INT PRIMARY KEY AUTO_INCREMENT,
    EmployeeID INT,
    EvaluationDate DATE,
    EvaluationForm VARCHAR(255),
    Result VARCHAR(255),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);



CREATE TABLE TASKS (
    TaskID INT PRIMARY KEY AUTO_INCREMENT,
    TaskName VARCHAR(255),
    TaskDescription VARCHAR(255),
    TaskStatus VARCHAR(50),
    TaskPriority VARCHAR(50),
    TaskDueDate DATE,
    EmployeeID INT,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);
";


if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>
