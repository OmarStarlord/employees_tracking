<?php
// Database configuration
$serverName = "OMAR-LAPTOP\\SQLEXPRESS"; 
$databaseName = "projet_final";
$username = "starlord";
$password = "123456789";

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