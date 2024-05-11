<?php
session_start();

// Include database configuration
include 'config.php';

// Redirect if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Retrieve user's ID from the database
$email = $_SESSION['email'];
$sql = "SELECT * FROM Employees WHERE Email = '$email'";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $employee_name = $row['FirstName'] . ' ' . $row['LastName'] ;
    $departmentId = $row['DepartmentID'];
$sql = "SELECT * FROM Employees WHERE Email = ?";
$params = array($email);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die("Error retrieving user data: " . print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
$employeeID = $row['EmployeeID'];

// Retrieve tasks for the user
$sql = "SELECT * FROM Tasks WHERE EmployeeID = ?";
$params = array($employeeID);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die("Error retrieving tasks: " . print_r(sqlsrv_errors(), true));
}

$tasks = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $tasks[] = $row;
}

// Handle task submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id']) && isset($_POST['completed'])) {
    $taskID = $_POST['task_id'];
    $completed = $_POST['completed'];

    // Update task status in the database
    $sql = "UPDATE Tasks SET TaskStatus = ? WHERE TaskID = ?";
    $params = array($completed, $taskID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error updating task: " . print_r(sqlsrv_errors(), true));
    } else {
        echo "Task updated successfully!";
        // Redirect to prevent form resubmission
        header("Location: index.php");
        exit();
    }
}

// Handle logout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_destroy();
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
    <title>Index</title>

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

</head>

<style>
.menu-sidebar2 {
    width: 250px; /* Adjust width as needed */
}

/* Add margin to main content area */
.page-container2 {
    margin-left: 250px; /* Same as sidebar width */
}
</style>

<body class="animsition">
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2" aria-label="Menu Sidebar">
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
                            <a href="index.php">
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


                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
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
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <img src="images/icon/logo-white.png" alt="Cool Admin" />
                    </a>
                </div>
                <div class="menu-sidebar2__content js-scrollbar2">
                    <div class="account2">

                        <h4 class="name">john doe</h4>
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
            <!-- END HEADER DESKTOP-->

            <!-- BREADCRUMB-->
            <div class="page-wrapper">
                <h1>User Tasks</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?php echo $task['TaskName']; ?></td>
                                <td class="<?php echo $task['TaskStatus'] === 'completed' ? 'completed' : ''; ?>">
                                    <?php echo $task['TaskStatus'] === 'completed' ? 'Completed' : 'Pending'; ?>
                                </td>
                                <td>
                                    <?php if ($task['TaskStatus'] !== 'completed'): ?>
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                            <input type="hidden" name="task_id" value="<?php echo $task['TaskID']; ?>">
                                            <input type="hidden" name="completed" value="completed">
                                            <button type="submit" class="btn-submit">Mark as Completed</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="completed">Completed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>

        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            .page-wrapper {
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                text-align: center;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .completed {
                color: green;
            }

            .btn-submit {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-submit:hover {
                background-color: #45a049;
            }
        </style>






        <!-- END PAGE CONTAINER-->




    </div>



    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>
    <script src="vendor/vector-map/jquery.vmap.js"></script>
    <script src="vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="vendor/vector-map/jquery.vmap.world.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->