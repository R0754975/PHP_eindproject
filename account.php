<?php
    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");

    boot();
    $auth = checkLoggedIn();

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>IMD Media Account</title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>

    <h1 class="username">Hallo</h1>
    <div class="pic">
        <div class="userPic"></div>
        <button class="changePic userSession"></button>
    </div>
    <div class="bio">
        <p class="bioInput">Bla bla bla bla bla bla </p>
        <button class="changeButton userSession"></button>
    </div>
    <div class="socials">
        <div class="socialPic"></div>
        <button class="changeSocialPic userSession"></button>
    </div>

    <script type="module" src="main.js"></script>
</body>
</html>