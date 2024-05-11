<?php
// Include the database connection configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user's SQL query from the form
    $userQuery = $_POST['user_query'];

    // Execute the user's query
    $stmt = sqlsrv_query($conn, $userQuery);

    // Check if the query execution was successful
    if ($stmt === false) {
        echo "Error executing query: " . print_r(sqlsrv_errors(), true);
    } else {
        // Fetch and display the results
        echo "<h2>Query Results:</h2>";
        echo "<table border='1'>";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($row as $column) {
                echo "<td>" . $column . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // Free statement and close connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>

<!-- HTML form to input the user's SQL query -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="user_query">Enter your SQL query:</label><br>
    <textarea id="user_query" name="user_query" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Execute">
</form>
