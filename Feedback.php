<?php
     if (!isset($name)) { $name = ''; };
     if (!isset($email)) { $email = ''; };
     if (!isset($comment)) { $comment = ''; };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
</head>
<body>

<form action = "submit_feedback.php" method ="post">

    <div>Your name:</div><br>
    <input type = "text" name = "name">
    <br>
    <div>Email:</div>
    <br>
    <input type = "email" name = "email">
    <br>
    <div>Your suggestion to make our website better:</div>
    <br>
    <textarea name ="comments" rows="4" cols="50"></textarea>
    <br>
    <input type = "submit" value = "Submit">


</form>

</body>
</html>