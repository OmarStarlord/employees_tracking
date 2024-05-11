<?php
session_start();
include 'config.php';

$tasksAmount = 0;
$evaluationsAmount = 0;

if (isset($_SESSION['email'])) {
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
    $sql = "SELECT EmployeeID FROM Employees WHERE Email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error retrieving user data: " . print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $employeeID = $row['EmployeeID'];

    // Retrieve tasks count for the user
    $sql = "SELECT COUNT(*) AS TaskCount FROM Tasks WHERE EmployeeID = ?";
    $params = array($employeeID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error retrieving tasks count: " . print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $tasksAmount = $row['TaskCount'];

    // Retrieve evaluations count for the user
    $sql = "SELECT COUNT(*) AS EvaluationCount FROM PerformanceEvaluations WHERE EmployeeID = ?";
    $params = array($employeeID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error retrieving evaluations count: " . print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $evaluationsAmount = $row['EvaluationCount'];

    // Handle logout
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../login.php");
        exit();
    }
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="get_evaluation.php">
                                    <i class="fas fa-chart-bar"></i>Telecharger Evaluation</a>
                                <span class="inbox-num">3</span>
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
            <!-- END HEADER DESKTOP-->

            <!-- BREADCRUMB-->
            <section class="au-breadcrumb m-t-75">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left">
                                        <span class="au-breadcrumb-span">You are here:</span>
                                        <ul class="list-unstyled list-inline au-breadcrumb__list">
                                            <li class="list-inline-item active">
                                                <a href="#">Home</a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">Dashboard</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- END BREADCRUMB-->

            <!-- STATISTIC-->
            <section class="statistic">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item">
                                    <h2 class="number"><?php echo $tasksAmount; ?></h2>
                                    <span class="desc">Taches</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-account-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item">
                                    <h2 class="number"><?php echo $evaluationsAmount; ?></h2>
                                    <span class="desc">Evaluations</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- END STATISTIC-->



            <section class="task-status-section">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item">
                            <canvas id="task-status-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php
    

    // Initialize variables
    $completedTasks = 0;
    $incompleteTasks = 0;

    if (isset($_SESSION['email'])) {
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
        $sql = "SELECT EmployeeID FROM Employees WHERE Email = ?";
        $params = array($email);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Error retrieving user data: " . print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $employeeID = $row['EmployeeID'];

        // Retrieve user's tasks
        $sql = "SELECT * FROM Tasks WHERE EmployeeID = ?";
        $params = array($employeeID);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Error retrieving tasks: " . print_r(sqlsrv_errors(), true));
        }

        // Count completed and incomplete tasks
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['TaskStatus'] === 'completed') {
                $completedTasks++;
            } else {
                $incompleteTasks++;
            }
        }
    }
    ?>

    <script>
        $(document).ready(function () {
            // Retrieve the data for the chart
            var completedTasks = <?php echo json_encode($completedTasks); ?>;
            var incompleteTasks = <?php echo json_encode($incompleteTasks); ?>;

            // Get context with jQuery
            var ctx = $("#task-status-chart");

            // Pie chart data
            var data = {
                labels: ["Completed", "Incomplete"],
                datasets: [{
                    data: [completedTasks, incompleteTasks],
                    backgroundColor: [
                        '#36A2EB',
                        '#FFCE56'
                    ],
                    hoverBackgroundColor: [
                        '#36A2EB',
                        '#FFCE56'
                    ]
                }]
            };

            // Pie chart options
            var options = {
                responsive: true
            };

            // Create pie chart
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options
            });
        });
    </script>

            <!-- END PAGE CONTAINER-->
        </div>

    </div>
    >
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
    <script>
    </script>

</body>

</html>
<!-- end document-->