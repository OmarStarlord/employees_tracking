<?php
session_start();

include 'config.php';

if (isset($_FILES["evaluation_form"])) {
    $employeeID = 1; // Assuming employeeID is stored in session

    // Define the target directory
    $target_dir = "uploads/";

    // Create the uploads directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory recursively
    }

    // Get the file name
    $file_name = basename($_FILES["evaluation_form"]["name"]);

    // Generate a unique file name using old name + done / the done should be added before type 
    $unique_file_name = $file_name;

    // Set the target file path
    $target_file = $target_dir . $unique_file_name;

    if (move_uploaded_file($_FILES["evaluation_form"]["tmp_name"], $target_file)) {

        $sql = "UPDATE performanceevaluations SET EvaluationForm = ? WHERE EmployeeID = ?";
        $params = array($target_file, $employeeID);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt !== false) {
            echo "Evaluation form updated successfully.";
        } else {
            echo "Error: " . print_r(sqlsrv_errors(), true);
        }
        sqlsrv_free_stmt($stmt);
    } else {
        // Error moving uploaded file
        echo "Error uploading file. Please try again.";
    }



    if (isset($_GET['logout'])) {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: ../login.php");
        exit();
    }


    

} else {
    // No file uploaded
    echo "No file uploaded.";
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
    <title>Passer Evaluation</title>

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
                    <div class="image img-cir img-120">
                        <img src="images/icon/avatar-big-01.jpg" alt="John Doe" />
                    </div>
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
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            
            
            <!-- END HEADER DESKTOP-->

            <!-- BREADCRUMB-->
             
            <!-- END BREADCRUMB-->

            <!-- submit evaluatiion -->
            <form method="post" enctype="multipart/form-data">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong>Passer Evaluation</strong>
                        </div>
                        <div class="card-body card-block">
                            <div class="form-group
                                <label for=" company" class=" form-control-label">Evaluation Form</label>
                                <input type="file" id="evaluation_form" name="evaluation_form"
                                    class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
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