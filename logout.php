<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/15/2019
 * Time: 1:51 PM
 */
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to unloged page
header("Location: home_guest.php");
exit;
?>