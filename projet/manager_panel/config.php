<?php
// Database configuration
$serverName = "OMAR-LAPTOP\\SQLEXPRESS"; // Server name
$databaseName = "projet_final"; // Database name
$username = "starlord"; // Your SQL Server username
$password = "123456789"; // Your SQL Server password

// Connection options
$connectionOptions = array(
    "Database" => $databaseName,
    "Uid" => $username,
    "PWD" => $password
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);



// Check if the connection is successful
if ($conn === false) {
    die("Connection failed. Error: " . print_r(sqlsrv_errors(), true));
}
?>