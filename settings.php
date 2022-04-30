<?php
    include_once("bootstrap.php");
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("header.inc.php"); ?>
    <title>Account settings</title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>

    <button class="changePass">Change password</button>
    <a href="removeAccount.php">Delete account</a>
    
    <script type="module" src="main.js"></script>
</body>
</html>