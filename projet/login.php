<?php
session_start(); // Start session at the beginning

include 'config.php';
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a SQL statement to retrieve user information based on email
    $sql = "SELECT * FROM employees WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the provided email exists
    if ($result->num_rows == 1) {
        // User exists, verify password
        $row = $result->fetch_assoc();
        $password_user= $row['Password'];
        if ($password === $password_user) {
            // Password is correct, retrieve their role
            $role = $row['Role'];

            // Save role to session
            $_SESSION['role'] = $role;

            // Redirect the user based on their role
            if ($role === "Manager") {
                $_SESSION['email'] = $email;
                header("Location: manager_panel/index.php");
                exit();
            } else {
                header("Location: user_panel/index.php");
                exit();
            }
        } else {
            // Invalid password
            header("Location: login.php?error=InvalidCredentials");
            exit();
        }
    } else {
        // User with the provided email does not exist
        header("Location: login.php?error=InvalidCredentials");
        exit();
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php
    // Display error message if provided
    if (isset($_GET['error']) && $_GET['error'] === 'InvalidCredentials') {
        echo '<p style="color: red;">Invalid email or password. Please try again.</p>';
    }
    ?>
    <form method="POST" action="login.php">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>

</html>
