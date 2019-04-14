<?php
/**
 * Created by PhpStorm.
 * User: James Mai
 * Date: 3/14/2019
 * Time: 10:24 PM
 */
/* Database credentials.*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Rfbmy6ccco');
define('DB_NAME', 'demo');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else{
    $_SESSION['message'] = "Successful";
}
