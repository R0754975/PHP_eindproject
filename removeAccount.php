<?php
    //add alert in javascript
    include_once("bootstrap.php");
    include_once("functions.inc.php");
        boot();
        checkAuthorisation();

    User::deleteUser($_SESSION['user']);

    header("Location: login.php");

?>