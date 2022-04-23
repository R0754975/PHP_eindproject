<?php
    include_once("bootstrap.php");
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();
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
    <a href="logout.php" class="navbar__logout">Hi, logout?</a>	
    <a href="settings.php" class="navbar__logout">Settings</a>	
</body>
</html>