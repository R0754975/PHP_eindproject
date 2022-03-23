<?php
    // destroy a cookie?
    // setcookie("loggedin", "", time()-60*60);
    session_start();
    session_destroy();
    
    header("Location: login.php");
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IMDMedia</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <input type="submit" value="Log out" class="primarybtn">	
</body>
</html>