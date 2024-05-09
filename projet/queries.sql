
CREATE TABLE Departments (
    DepartmentID INT PRIMARY KEY,
    DepartmentName VARCHAR(255)
);


CREATE TABLE Employees (
    EmployeeID INT PRIMARY KEY,
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Role VARCHAR(50),
    DepartmentID INT,
    FOREIGN KEY (DepartmentID) REFERENCES Departments(DepartmentID)
);


CREATE TABLE WorkSchedules (
    ScheduleID INT PRIMARY KEY,
    EmployeeID INT,
    Date DATE,
    StartTime TIME,
    EndTime TIME,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);


CREATE TABLE LeaveRequests (
    RequestID INT PRIMARY KEY,
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
    EvaluationID INT PRIMARY KEY,
    EmployeeID INT,
    EvaluationDate DATE,
    EvaluationForm VARCHAR(255),
    Result VARCHAR(255),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);

-- Create the Authentication table
CREATE TABLE Authentication (
    UserID INT PRIMARY KEY,
    Username VARCHAR(255),
    Password VARCHAR(255), 
    EmployeeID INT,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);
