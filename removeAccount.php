<?php
    //add alert in javascript
    require __DIR__ . '/vendor/autoload.php';
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();

    User::deleteUser($_SESSION['user']);

    header("Location: login.php");

?>