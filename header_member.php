<?php
require_once 'config.php';

//if(!isset($_SESSION))
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}
if (empty($_SESSION["username"]))
    header("Location: home_guest.php");
if ($_SESSION["username"] == 'admin')
    header("Location: home_admin.php");

function get_category ()
{
    global $link;
    $cat_names = array();
    $sql_category = "SELECT `name` FROM `categories`";
    $result = mysqli_query($link, $sql_category);

    while ($ar = mysqli_fetch_assoc($result)){
        $cat_names[] = $ar;
    }
    return $cat_names;
}

$category = get_category();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile store</title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
    <link href="style.css" rel="stylesheet" type="text/css">
    <style>
        .dropdown:hover>.dropdown-menu {
            display: block;
        }
    </style>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
<main class="page-container">
    <header class="navbar navbar-expand-sm justify-content-between navbar-dark fixed-top " style="background-color: #000000; font-size: 18px; color: #FFFFFF;">
        <ul class = "navbar-nav">
            <li class = "nav-item ">
                <a class="nav-link" href="home_member.php" style="padding: 0;">
                    <img src="logo.png" alt = "Logo" style="height: 40px; width: 130px;"></a>
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
            <li class = "dropdown">
                <a class="dropdown-toggle nav-link"  data-toggle ="dropdown" href="products_member.php"><span class = "caret">Products</span></a>
                <div class ="dropdown-menu">
                    <?php
                    foreach ($category as $ap)
                    {
                        $cat_name = $ap['name'];
                        ?>
                        <a class="dropdown-item" href ="products_member.php?id=<?php echo $cat_name?>"><?php echo $cat_name?></a>
                    <?php }?>
                </div>
            </li>
            <li class = "nav-item ">
                <a class="nav-link" href="Feedback.php">Feedback</a>
            </li>
            <li class="nav-item"><a class="nav-link" href=".?action=show_cart">View Cart</a></li>

        </ul>
    </header>