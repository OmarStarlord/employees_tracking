<?php
session_start(); // Start session at the beginning

include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a SQL statement to retrieve user information based on email
    $sql = "SELECT * FROM Employees WHERE Email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Check if the query executed successfully
    if ($stmt === false) {
        echo "Error: " . print_r(sqlsrv_errors(), true);
        exit();
    }

    // Check if a user with the provided email exists
    if (sqlsrv_has_rows($stmt)) {
        // User exists, verify password
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $password_user = $row['Password'];
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
                $_SESSION['email'] = $email;
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
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <?php
        // Display error message if provided
        if (isset($_GET['error']) && $_GET['error'] === 'InvalidCredentials') {
            echo '<p class="error-message">Invalid email or password. Please try again.</p>';
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
    </div>
</body>

</html>