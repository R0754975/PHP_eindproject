<?php
    include_once("bootstrap.php");
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("header.inc.php"); ?>
    <title>Document</title>
</head>
<body>
    <button class="changePass">Change password</button>
    <a href="removeAccount.php">Delete account</a>
</body>
</html>