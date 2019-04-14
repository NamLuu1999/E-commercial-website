<?php
require_once 'config.php';

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
</head>
<body>

<main class="page-container">
    <header class="navbar navbar-expand-sm justify-content-between navbar-dark fixed-top" style="background-color: #689EB8">
        <ul class = "navbar-nav">
            <li class = "nav-item ">
                <a class="nav-link" href="Feedback.php">Feedback</a>
            </li>
        </ul>
        <ul class = "navbar-nav ml-auto">
            <li class = "nav-item">
                <a class="nav-link" href="home_guest.php">Home</a>
            </li>
            <li class = "dropdown">
                <a class="dropdown-toggle nav-link"  data-toggle ="dropdown" href="products_guest.php"><span class = "caret">Products</span></a>
                <div class ="dropdown-menu">
                    <?php
                    foreach ($category as $ap)
                    {
                        $name = $ap['name'];
                        ?>
                    <a class="dropdown-item" href ="products_guest.php?id=<?php echo $name?>"><?php echo $name?></a>
                    <?php }?>
                </div>
            </li>
            <li class = "nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
    </header>

