<?php
     if (!isset($name)) { $name = ''; };
     if (!isset($email)) { $email = ''; };
     if (!isset($comment)) { $comment = ''; };
if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}
if (empty($_SESSION["username"])) {
    include('header_guest.php');
}   else {include ('header_member.php');
}
?>

<!DOCTYPE html>

<div class="wrapper">
    <form action = "submit_feedback.php" method ="post">
        <h1><b>Feedback</b></h1>
        <div>Your name:</div><br>
            <input class="input-group" type = "text" name = "name">
        <br>
        <div>Email:</div>
        <br>
            <input class="input-group" type = "email" name = "email">
        <br>
        <div>Your suggestion to make our website better:</div>
        <br>
            <textarea class="input-group" name ="comment" rows="4" cols="50"></textarea>
        <br>
        <input type = "submit" value = "Submit">


    </form>
</div>
<?php include('footer.php');?>