<!--
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/control-esp32-esp8266-gpios-from-anywhere/

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
-->
<?php
include_once('esp-database.php');

session_start(); // Add session_start() to the beginning of the code to initialize the session

// Check if the user is logged in
// if (!isset($_SESSION['email']) || empty($_SESSION['email']) || !isset($_SESSION['password']) || empty($_SESSION['password'])) {
//     header('Location: login.php'); // Redirect to the login page if the user is not logged in
//     exit();
// }

$result = getAllOutputs();
$html_buttons = null;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        
        if ($row['state'] == "0") {
            $button_checked = "checked";
        } else {
            $button_checked = "unchecked";
        }
        $html_buttons .= '<h3>' . $row["name"] . ' - Board ' . $row["board"] . ' - GPIO ' . $row["gpio"] . 
        ' </h3><label class="switch"><input type="checkbox" onchange="updateOutput(this)" id="' . $row["id"] . '" ' . 
        $button_checked . '><span class="slider"></span></label> <br><br><br><br><br><br>';
    }
}

$result2 = getAllBoards();
$html_boards = null;
if ($result2) {
    $html_boards .= '<h3>Boards</h3>';
    while ($row = $result2->fetch_assoc()) {
        $row_reading_time = $row["last_request"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));

        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 7 hours"));
        $html_boards .= '<p><strong>Board ' . $row["board"] . '</strong> - Last Request Time: ' . $row_reading_time . '</p>';
    }
}
?>

<!DOCTYPE HTML>
<html>


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="esp-style.css">
    <title>ESP Output Control</title>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Title -->
        <title>rUrban Control System</title>

        <!-- Styles -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
        <link href="../plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/bootstrap/js/bootstrap.min.js" rel="stylesheet">
        <link href="../plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="../plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" rel="stylesheet"> -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->


        <!-- Theme Styles -->
        <!-- <link href="../css/main.min.css" rel="stylesheet">
        <link href="../css/custom.css" rel="stylesheet">  -->
        <link href="esp-style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
</head>

<body>
<!-- 
    <div class="page-container">

        <div class="page-header">
            <nav class="navbar navbar-expand-lg d-flex justify-content-between">
                <div class="" id="navbarNav">
                    <ul class="navbar-nav" id="leftNav">
                        <li class="nav-item">
                            <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                    </ul>
                </div>
                <div class="logo">
                 <a class="navbar-brand" href="index.html"></a> -->
                    <!--<a href="index.php">AKUAFO</a>-->
                <!-- </div>
                <div class="" id="headerNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"><img src="../images/avatars/avatar.jpg"
                                    alt=""></a>
                            <div class="dropdown-menu dropdown-menu-end profile-drop-menu"
                                aria-labelledby="profileDropDown">
                                <a class="dropdown-item" href="#"><i data-feather="edit"></i>Farm Recordings<span
                                        class="badge rounded-pill bg-success">12</span></a>
                                <a class="dropdown-item" href="#"><i data-feather="check-circle"></i>Tasks</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i>Change Password</a>
                                <a class="dropdown-item" href="../actions/logout.php"><i
                                        data-feather="log-out"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="page-sidebar">
            <ul class="list-unstyled accordion-menu">
                <li class="sidebar-title">
                <li>
                    <a href="../view/dashboard.php"><i data-feather="home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="../view/farmrecordings.php"><i data-feather="inbox"></i>Farm Recordings</a>
                </li>
                <li>
                <li class="active-page">
                    <a href="controlsystem.php"><i data-feather="calendar"></i>Control System</a>
                </li>
                <li>
                    <a href="../view/history.php"><i data-feather="clock"></i>Archives</a>
                </li>
            </ul>
        </div>

        <br>

        <br>
        <br>
        <br>

        <br>
        <br>
        <br>
        <br>
        <br>  -->
        <center><h2>rUrban Control System</h2></center>
        <center>
            ENABLE AUTOMATIC CONTROL
            <?php echo $html_buttons; ?>
            <!-- <?php echo $html_boards; ?> -->
            <center>
                <br><br>
    

                <script>
                    function updateOutput(element) {
                        var xhr = new XMLHttpRequest();
                        if (element.checked) {
                            xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=0", true);
                        }
                        else {
                            xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=1", true);
                        }
                        xhr.send();
                    }



                    </script>
                <!-- <script src="../plugins/jquery/jquery-3.4.1.min.js"></script>
                <script src="https://unpkg.com/@popperjs/core@2"></script>
                <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
                <script src="https://unpkg.com/feather-icons"></script>
                <script src="../plugins/perfectscroll/perfect-scrollbar.min.js"></script>
                <script src="../plugins/blockui/jquery.blockUI.js"></script>
                <script src="../js/main.min.js"></script>
                <script src="../js/pages/blockui.js"></script> -->
          
</body>

</html>