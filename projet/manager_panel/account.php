<?php
session_start();

include 'config.php';

if (isset($_SESSION['email'])) {

    // Get employee email from session variable
    $email = $_SESSION['email'];
$sql = "SELECT * FROM Employees WHERE Email = '$email'";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $employee_name = $row['FirstName'] . ' ' . $row['LastName'] ;
    $departmentId = $row['DepartmentID'];
    $message = '';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data
        $employee_id = $_POST['employee_id'];
        $new_email = $_POST['new_email'];
        $new_name = $_POST['new_name'];
        $new_password = $_POST['new_password']; // Make sure to hash the password before storing it in the database

        // Prepare and execute the update query
        $sql = "UPDATE Employees SET Email=?, FirstName=?, Password=? WHERE EmployeeID=?";
        $params = array($new_email, $new_name, $new_password, $employee_id);
        $stmt = sqlsrv_query($conn, $sql, $params);

        // Check if the query executed successfully
        if ($stmt === false) {
            echo "Error: " . print_r(sqlsrv_errors(), true);
            exit();
        }

        // Check if the update was successful
        if (sqlsrv_rows_affected($stmt) > 0) {
            $message = "Employee information updated successfully.";
        } else {
            $message = "Failed to update employee information.";
        }

        // Close the statement
        sqlsrv_free_stmt($stmt);
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Account</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

    <style>
        /* Adjustments to prevent overlap */
        .menu-sidebar2 {
            width: 250px;
            z-index: 1000; /* Ensure sidebar is above other content */
        }

        .page-container2 {
            margin-left: 250px;
            padding-top: 100px; /* Add padding to avoid overlap with header */
        }

        .header-desktop2 {
            z-index: 1001; /* Ensure header is above sidebar */
        }
    </style>
</head>

<body class="animsition">
    <!-- Header Desktop -->
    <header class="header-desktop2">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap2">
                    <div class="logo d-block d-lg-none">
                        <a href="#">
                            <img src="images/icon/logo-white.png" alt="CoolAdmin" />
                        </a>
                    </div>
                    <div class="header-button2">
                        <div class="header-button-item mr-0 js-sidebar-btn">
                            <i class="zmdi zmdi-menu"></i>
                        </div>
                        <div class="setting-menu js-right-sidebar d-none d-lg-block">
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a href="account.php">
                                        <i class="zmdi zmdi-account"></i>Account</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header Desktop -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Sidebar -->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <img src="images/icon/logo-white.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <h4 class="name">
                    <?php
                    echo $employee_name;
                    ?>
                    </h4>
                    <form method="post" action="">
                        <button type="submit" name="logout">Logout</button>
                    </form>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="index.php">
                                <i class="fas fa-tachometer-alt"></i>Dashboard

                            </a>
                        </li>
                        <li>
                            <a href="get_evaluation.php">
                                <i class="fas fa-chart-bar"></i>Telecharger Evaluation</a>
                        </li>
                        <li>
                            <a href="submit_evaluation.php">
                                <i class="fas fa-shopping-basket"></i>Soumettre Evaluation</a>
                        </li>
                        <li>
                            <a href="demande_conge.php">
                                <i class="fas fa-shopping-basket"></i>Demande Congé</a>
                        </li>
                        <li>
                            <a href="valider_taches.php">
                                <i class="fas fa-shopping-basket"></i>Valider Taches</a>
                        </li>


                    </ul>
                </nav>
            </div>
        </aside>
        <!-- End Sidebar -->

        <!-- Page Container -->
        <div class="page-container2">
            <!-- Breadcrumb and Form -->
            <h2>Update Employee Information</h2>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <!-- Form Inputs -->
                <div>
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" id="employee_id" name="employee_id" required>
                </div>
                <div>
                    <label for="new_email">New Email:</label>
                    <input type="email" id="new_email" name="new_email" required>
                </div>
                <div>
                    <label for="new_name">New Name:</label>
                    <input type="text" id="new_name" name="new_name" required>
                </div>
                <div>
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <button type="submit">Update</button>
            </form>
            <!-- End Form -->
        </div>
        <!-- End Page Container -->
    </div>
    <!-- End Page Wrapper -->

    <!-- Jquery and other scripts -->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <script src="vendor/slick/slick.min.js"></script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.js"></script>
    <script src="vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="vendor/vector-map/jquery.vmap.world.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
