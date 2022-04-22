<?php
    include_once("bootstrap.php");
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button class="changePass">Change password</button>
    <a href="removeAccount.php">Delete account</a>
</body>
</html>