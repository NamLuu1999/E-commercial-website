<?php
//Connect to database
require_once "config.php";

// get the data from the form
$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['comment'];

//Validate data

if ($name == "")
    $error_message = 'Please enter your name';
elseif ($email == "")
    $error_message = 'Please enter your email address';
elseif ($comment == "")
    $error_message = 'Please write your suggestion';
else {
    $error_message = '';
}


// if an error message exists, go to the index page
    if ($error_message != '') {
        include('Feedback.php');
        exit(); }

//Insert the feedback to database
$sql = "INSERT INTO feedback (name, email, feedback) VALUES ('$name','$email','$comment');";


if (mysqli_query($link, $sql))
    {echo 'Thank you for you feedback';}
else
    {echo 'There is an error, please try again';};

header("refresh:5; url=Feedback.php");
mysqli_close($link);
?>