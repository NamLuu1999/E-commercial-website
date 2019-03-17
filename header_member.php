<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile store</title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
    <link href="style.css" rel="stylesheet" type="text/css">

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<main class="page-container">
    <header class="navbar navbar-expand-sm bg-dark justify-content-between navbar-dark fixed-top">
        <ul class = "navbar-nav">
            <li class = "nav-item ">
                <a class="nav-link" href="#"><img src ="" alt = "Logo" style=""></a>
            </li>
        </ul>
        <ul class = "navbar-nav ml-auto">
            <li class = "nav-item">
                <a class="nav-link" href="home_guest.php">Home</a>
            </li>
            <li class = "dropdown">
                <a class="dropdown-toggle nav-link"  data-toggle ="dropdown" href="#"><span class = "caret"><?php echo $_SESSION["username"]; ?></span></a>
                <div class ="dropdown-menu">
                    <a class="dropdown-item" href ="logout.php">Sign Out</a>

                </div>


            </li>
            <li class = "nav-item">
                <a class="nav-link" href="Products.php">Products</a>
            </li>

        </ul>
    </header>