<?php
include 'config.php';

# check if conn is established
if ($conn === false) {
    echo "Connection failed. Error: " . print_r(sqlsrv_errors(), true);
}


$sql = "
CREATE TABLE Departments (
    DepartmentID INT PRIMARY KEY IDENTITY(1,1),
    DepartmentName VARCHAR(255)
);

CREATE TABLE Employees (
    EmployeeID INT PRIMARY KEY IDENTITY(1,1),
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Role VARCHAR(50),
    DepartmentID INT,
    FOREIGN KEY (DepartmentID) REFERENCES Departments(DepartmentID)
);

CREATE TABLE WorkSchedules (
    ScheduleID INT PRIMARY KEY IDENTITY(1,1),
    EmployeeID INT,
    Date DATE,
    StartTime TIME,
    EndTime TIME,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);

CREATE TABLE LeaveRequests (
    RequestID INT PRIMARY KEY IDENTITY(1,1),
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
    EvaluationID INT PRIMARY KEY IDENTITY(1,1),
    EmployeeID INT,
    EvaluationDate DATE,
    EvaluationForm VARCHAR(255),
    Result VARCHAR(255),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);

CREATE TABLE Tasks (
    TaskID INT PRIMARY KEY IDENTITY(1,1),
    TaskName VARCHAR(255),
    TaskDescription VARCHAR(255),
    TaskStatus VARCHAR(50),
    TaskPriority VARCHAR(50),
    TaskDueDate DATE,
    EmployeeID INT,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);
";

$queries = explode(';', $sql);

// Execute each SQL statement individually
foreach ($queries as $query) {
    if (!empty(trim($query))) {
        $stmt = sqlsrv_query($conn, $query);
        if ($stmt === false) {
            echo "Error creating tables: " . print_r(sqlsrv_errors(), true);
            break; // Stop execution if an error occurs
        }
    }
}

echo "Tables created successfully";

// Close the connection
sqlsrv_close($conn);
?>
