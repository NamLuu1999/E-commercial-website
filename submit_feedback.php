<?php
//Connect to database
$user = 'root';
$password = 'Rfbmy6ccco';
$db = '';
$db = new mysqli('localhost',$user, $password, $db) or die("Not Connected");
echo "Connected\r\n";

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



// if an error message exists, go to the index page
    if ($error_message != '') {
        include('index.php');
        exit(); }

//Insert the feedback to database
$sql = "INSERT INTO std_table (Name, Email, Feedback) VALUES ('$name', '$email', '$comment')";


if (!mysqli_query($db, $sql))
{echo 'Thank you for you feedback';}
else
{echo 'There is an error, please try again';};

header("refresh:2; url=Feedback.html");

?>