<?php
require_once 'config.php';
// Start the session
session_start();
if (empty($_SESSION["username"]))
    header("Location: home_guest.php");


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
                <a class="nav-link" href="home_admin.php" style="padding: 0;">
                    <img src="logo.png" alt = "Logo" style="height: 40px; width: 130px;"></a>
            </li>
        </ul>
        <ul class = "navbar-nav ml-auto">
            <li class = "nav-item">
                <a class="nav-link" href="home_admin.php">Home</a>
            </li>
            <li class = "dropdown" style ="float:right;">
                <a class="dropdown-toggle nav-link"  data-toggle ="dropdown" href="#"><span class = "caret"><?php echo $_SESSION["username"]; ?></span></a>
                <div class ="dropdown-menu">
                    <a class="dropdown-item" href ="logout.php">Sign Out</a>

                </div>


            </li>
            <li class = "dropdown">
                <a class="dropdown-toggle nav-link"  data-toggle ="dropdown" href="products_admin.php"><span class = "caret">Products</span></a>
                <div class ="dropdown-menu">
                    <?php
                    foreach ($category as $ap)
                    {
                        $name = $ap['name'];
                        ?>
                        <a class="dropdown-item" href ="products_admin.php?id=<?php echo $name?>"><?php echo $name?></a>
                    <?php }?>
                </div>
            </li>
            <li class = "nav-item">
                <a class="nav-link" href="add_items.php">Add items</a>
            </li>
            <li class = "nav-item">
                <a class="nav-link" href="delete_item.php">Delete items</a>
            </li>
            <li class = "nav-item">
                <a class="nav-link" href="update.php">Update Inventory</a>
            </li>
            <li class = "nav-item">
                <a class="nav-link" href="add_category.php">Update Category</a>
            </li>
        </ul>
    </header>