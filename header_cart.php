<?php

if (empty($_SESSION["username"]))
    header("Location: home_guest.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile store</title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
    <link href="main.css" rel="stylesheet" type="text/css">


    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<main class="page-container">
    <header class="navbar navbar-expand-sm justify-content-between navbar-dark fixed-top " style="background-color: #689EB8">
        <ul class = "navbar-nav">
            <li class = "nav-item ">
                <a class="nav-link" href="Feedback.php">Feedback</a>
            </li>
        </ul>
        <ul class = "navbar-nav ml-auto">
            <li class = "nav-item">
                <a class="nav-link" href="home_member.php">Home</a>
            </li>
            <li class = "dropdown" style ="float:right;">
                <a class="dropdown-toggle nav-link"  data-toggle ="dropdown" href="#"><span class = "caret"><?php echo $_SESSION["username"]; ?></span></a>
                <div class ="dropdown-menu">
                    <a class="dropdown-item" href ="logout.php">Sign Out</a>

                </div>


            </li>
            <li class = "nav-item">
                <a class="nav-link" href="products_member.php">Products</a>
            </li>
            <li class="nav-item"><a class="nav-link" href=".?action=show_cart">View Cart</a></li>

        </ul>
    </header>