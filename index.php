<?php
    include_once("bootstrap.php");
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("header.inc.php"); ?>
    <title>IMDMedia</title>
</head>
<body>
    <a href="logout.php" class="navbar__logout">Hi, logout?</a>	
    <a href="settings.php" class="navbar__logout">Settings</a>	
</body>
</html>