<?php
session_start();

require_once 'config.php';
include 'classes/_employe.php';



if (isset($_SESSION['email'])) {

    
    $email = $_SESSION['email'];
$sql = "SELECT * FROM Employees WHERE Email = '$email'";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $employee_name = $row['FirstName'] . ' ' . $row['LastName'] ;
    $departmentId = $row['DepartmentID'];
    // Connect to the database
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $departmentId = $_POST['department'];

        // Set password
        $password = $first_name . $last_name . "123";

        // Create a new Employee object
        $newEmployee = new Employe($first_name, $last_name, $email, $password , $role, $departmentId);

        // Insert the new employee
        $newEmployee->insert($conn);

        echo "Employee added successfully.";
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
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Ajouter Employé </title>

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
                <div class="account2">                        <h4 class="name">
                    <?php
                    echo $employee_name;
                    ?>
                    </h4>
                        <form method="post" action="logout">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    </div>
                <nav class="navbar-sidebar2">
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
                    <div class="account2">                        <h4 class="name">
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

            <form method="POST"
                style="max-width: 400px; margin: auto; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h2 style="text-align: center; margin-bottom: 20px;">Add New Employee</h2>

                <label for="first_name" style="display: block; margin-bottom: 5px;">First Name:</label>
                <input type="text" id="first_name" name="first_name" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; margin-bottom: 15px;">

                <label for="last_name" style="display: block; margin-bottom: 5px;">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; margin-bottom: 15px;">

                <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
                <input type="email" id="email" name="email" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; margin-bottom: 15px;">

                <label for="role" style="display: block; margin-bottom: 5px;">Role:</label>
                <select id="role" name="role" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; margin-bottom: 15px;">
                    <option value="Employee">Employee</option>
                    <option value="Manager">Manager</option>
                </select>

                <label for="department" style="display: block; margin-bottom: 5px;">Department:</label>
                <select id="department" name="department" required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; margin-bottom: 15px;">
                    <?php
// Include the database configuration file
include 'config.php';

// Fetch department data from the database
$sql = "SELECT * FROM Departments";
$stmt = sqlsrv_query($conn, $sql);

// Check if there are departments in the database
if ($stmt !== false) {
    // Output each department as an option
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<option value='" . $row['DepartmentID'] . "'>" . $row['DepartmentName'] . "</option>";
    }
    sqlsrv_free_stmt($stmt);
} else {
    echo "<option value=''>No departments found</option>";
}
?>
                </select>

                <input type="submit" value="Add Employee"
                    style="width: 100%; padding: 10px; border: none; border-radius: 5px; background-color: #007bff; color: #fff; cursor: pointer; transition: background-color 0.3s ease;">
            </form>


            <!-- END PAGE CONTAINER-->
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