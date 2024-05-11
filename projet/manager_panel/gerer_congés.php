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
    $employee_name = $row['FirstName'] . ' ' . $row['LastName'];
    $departmentId = $row['DepartmentID'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form
        $requestID = $_POST['request_id'];
        $status = $_POST['status']; // Retrieve status from form
        $action = $_POST['action']; // Retrieve action from form

        // Prepare the SQL statement
        $sql = "UPDATE LeaveRequests SET Status = ? WHERE RequestID = ? AND EmployeeID = (SELECT EmployeeID FROM Employees WHERE Email = ?)";
        $params = array($status, $requestID, $email);
        $stmt = sqlsrv_query($conn, $sql, $params);

        // Check if the update was successful
        if ($stmt) {
            $rowsAffected = sqlsrv_rows_affected($stmt);
            if ($rowsAffected > 0) {
                echo "Status updated successfully.";
            } else {
                echo "No rows were updated.";
            }
        } else {
            echo "Error updating status: " . sqlsrv_errors()[0]['message'];
        }

        // Free statement and close connection
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
    }

    // Logout
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../login.php");
        exit();
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Gerer Congés</title>

    <!-- CSS Stylesheets -->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="vendor/wow/animate.css" rel="stylesheet">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet">
    <link href="vendor/slick/slick.css" rel="stylesheet">
    <link href="vendor/select2/select2.min.css" rel="stylesheet">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
    <link href="vendor/vector-map/jqvmap.min.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* Adjust sidebar and page container */
        .menu-sidebar2 {
            width: 250px;
        }

        .page-container2 {
            margin-left: 250px;
            padding-top: 70px; /* Ensure space for the header */
            position: relative;
        }

        /* Adjust header position */
        .header-desktop2 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            z-index: 1000;
        }

        /* Adjust table styles */
        #leave_requests_div {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
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
                    <form method="post" action="logout">
                        <button type="submit" name="logout">Logout</button>
                    </form>
                </div>
                <nav class="navbar-sidebar2" aria-label="Sidebar Navigation">
                    <ul class="list-unstyled navbar__list">

                        <li>
                            <a href="index.php">
                                <i class="fas fa-shopping-basket"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="ajouter_employé.php">
                                <i class="fas fa-shopping-basket"></i>Ajouter Employé</a>
                        </li>
                        <li>
                            <a href="creer_evaluation.php">
                                <i class="fas fa-chart-bar"></i>Assigner Evaluation</a>
                        <li>
                            <a href="assigner_tache.php">
                                <i class="fas fa-chart-bar"></i>Assigner Tache </a>
                        </li>
                        <li>
                            <a href="gerer_congés.php">
                                <i class="fas fa-shopping-basket"></i>Gerer Demande Congé</a>
                        </li>
                        <li>
                            <a href="gerer_evaluations.php">
                                <i class="fas fa-shopping-basket"></i>Gerer Evaluation</a>
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
                        <h4 class="name">
                            <?php
                            echo $employee_name;
                            ?>
                        </h4>
                        <form method="post" action="logout">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    </div>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>

                        </li>
                        <li>
                            <a href="inbox.html">
                                <i class="fas fa-chart-bar"></i>Gerer Evaluation</a>
                            <span class="inbox-num">3</span>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-shopping-basket"></i>Gérer Demande Congé</a>
                        </li>

                    </ul>
                </nav>
        </div>
        </aside>
        <!-- END HEADER DESKTOP-->

        <!-- BREADCRUMB-->

        <!-- END BREADCRUMB-->
        <section>
            <div id="leave_requests_div">
                <?php
                // check conn
                if ($conn === false) {
                    echo "Could not connect.\n";
                    die(print_r(sqlsrv_errors(), true));
                }

                $sql = "SELECT lr.RequestID, lr.EmployeeID, lr.RequestDate, lr.StartDate, lr.EndDate, lr.Status, lr.ManagerID, e.FirstName, e.LastName
        FROM LeaveRequests lr
        INNER JOIN Employees e ON lr.EmployeeID = e.EmployeeID";
                $stmt = sqlsrv_query($conn, $sql);

                if ($stmt !== false) {
                    // Output data of each row
                    echo '<table border="1">';
                    echo '<thead><tr><th>Request ID</th><th>Employee Name</th><th>Request Date</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Manager ID</th><th>Action</th></tr></thead>';
                    echo '<tbody>';
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $employeeName = $row["FirstName"] . ' ' . $row["LastName"];
                        echo '<tr>';
                        echo '<td>' . $row["RequestID"] . '</td>';
                        echo '<td>' . $employeeName . '</td>';
                        echo '<td>' . $row["RequestDate"]->format('Y-m-d') . '</td>';
                        echo '<td>' . $row["StartDate"]->format('Y-m-d') . '</td>';
                        echo '<td>' . $row["EndDate"]->format('Y-m-d') . '</td>';
                        echo '<td>' . $row["Status"] . '</td>';
                        echo '<td>' . $row["ManagerID"] . '</td>';
                        echo '<td>';
                        // Approve form
                        echo '<form method="post">';
                        echo '<input type="hidden" name="request_id" value="' . $row["RequestID"] . '">';
                        echo '<input type="hidden" name="status" value="Approved">';
                        echo '<button type="submit" name="action" value="approve">Approve</button>';
                        echo '</form>';
                        // Reject form
                        echo '<form  method="post">';
                        echo '<input type="hidden" name="request_id" value="' . $row["RequestID"] . '">';
                        echo '<input type="hidden" name="status" value="Rejected">';
                        echo '<button type="submit" name="action" value="reject">Reject</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "No leave requests found.";
                }

                sqlsrv_free_stmt($stmt);
                sqlsrv_close($conn);
                ?>

            </div>

            </section>

            <style>
                #leave_requests_div {
                    margin-top: 20px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    border: 1px solid #dddddd;
                    padding: 8px;
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2;
                }

                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
            </style>
            
    </div>

    </div>

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