<?php
// Include the database configuration file
include 'config.php';

// Sample SQL queries to insert tasks
$tasksQueries = [
    // Completed tasks for EmployeeID = 1
    "INSERT INTO Tasks (TaskName, TaskDescription, TaskStatus, TaskPriority, TaskDueDate, EmployeeID)
    VALUES
    ('Complete project report', 'Finalize and submit the project report', 'completed', 'high', '2024-05-15', 2),
    ('Prepare presentation slides', 'Create slides for the upcoming presentation', 'completed', 'medium', '2024-05-17', 2);",

    // Incomplete tasks for EmployeeID = 1
    "INSERT INTO Tasks (TaskName, TaskDescription, TaskStatus, TaskPriority, TaskDueDate, EmployeeID)
    VALUES
    ('Update project timeline', 'Revise project timeline based on recent changes', 'incomplete', 'high', '2024-05-20', 2),
    ('Review project proposal', 'Provide feedback on the project proposal document', 'incomplete', 'medium', '2024-05-18', 2);",

    // Completed tasks for EmployeeID = 2
    "INSERT INTO Tasks (TaskName, TaskDescription, TaskStatus, TaskPriority, TaskDueDate, EmployeeID)
    VALUES
    ('Submit expense report', 'Submit expense report for approval', 'completed', 'medium', '2024-05-16', 2);",

    // Incomplete tasks for EmployeeID = 2
    "INSERT INTO Tasks (TaskName, TaskDescription, TaskStatus, TaskPriority, TaskDueDate, EmployeeID)
    VALUES
    ('Review customer feedback', 'Analyze customer feedback data and generate insights', 'incomplete', 'high', '2024-05-22', 2),
    ('Schedule team meeting', 'Coordinate and schedule the next team meeting', 'incomplete', 'low', '2024-05-19', 2);"
];

// Loop through each query and execute it
foreach ($tasksQueries as $query) {
    $result = sqlsrv_query($conn, $query);
    if ($result === false) {
        // If an error occurred, display the error message
        echo "Error inserting tasks: " . print_r(sqlsrv_errors(), true);
        // Rollback any changes
        sqlsrv_rollback($conn);
        exit(); // Exit the script
    }
}

// If all queries executed successfully, commit the transaction
sqlsrv_commit($conn);

// Close the database connection
sqlsrv_close($conn);

echo "Sample tasks inserted successfully!";
?>
