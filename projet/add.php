<?php
// Include the configuration file
require 'config.php';

// Add Manager
$managerFirstName = "John";
$managerLastName = "Doe";
$managerEmail = "manager@example.com";
$managerPassword = "123456"; // Password set to "123456" for testing
$managerRole = "Manager";
$managerDepartmentID = null; // Assuming the manager belongs to department 1

// Add Employee
$employeeFirstName = "Jane";
$employeeLastName = "Smith";
$employeeEmail = "employee@example.com";
$employeePassword = "123456"; // Password set to "123456" for testing
$employeeRole = "Employee";
$employeeDepartmentID = null; // Assuming the employee belongs to department 2

// Prepare and execute statements to insert users
try {
    // Prepare statement for manager
    $sqlManager = "INSERT INTO employees (FirstName, LastName, Email, Password, Role, DepartmentID) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $paramsManager = array($managerFirstName, $managerLastName, $managerEmail, $managerPassword, $managerRole, $managerDepartmentID);
    $stmtManager = sqlsrv_query($conn, $sqlManager, $paramsManager);

    // Execute the statement for manager
    if ($stmtManager === false) {
        throw new Exception("Error inserting manager: " . print_r(sqlsrv_errors(), true));
    }

    // Prepare statement for employee
    $sqlEmployee = "INSERT INTO employees (FirstName, LastName, Email, Password, Role, DepartmentID) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $paramsEmployee = array($employeeFirstName, $employeeLastName, $employeeEmail, $employeePassword, $employeeRole, $employeeDepartmentID);
    $stmtEmployee = sqlsrv_query($conn, $sqlEmployee, $paramsEmployee);

    // Execute the statement for employee
    if ($stmtEmployee === false) {
        throw new Exception("Error inserting employee: " . print_r(sqlsrv_errors(), true));
    }

    echo "Users added successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
