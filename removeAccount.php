<?php
    //add alert in javascript
    include_once("bootstrap.php");
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();

    User::deleteUser($_SESSION['user']);

    header("Location: login.php");

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("header.inc.php"); ?>
    <title>Remove account</title>
</head>
<body>
    <h1>Your account gets deleted</h1>
</body>
</html>