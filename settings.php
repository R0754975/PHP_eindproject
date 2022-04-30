<?php
    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
        boot();
        checkAuthorisation();
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>Account settings</title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>

    <button class="changePass">Change password</button>
    <a href="removeAccount.php">Delete account</a>
    
    <script type="module" src="main.js"></script>
</body>
</html>