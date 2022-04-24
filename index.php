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
    <div class="nav">
        <div>
            <a href="./index.php"><img src="./images/computer.png" alt="IMDMedia logo" class="logo"></a>
        </div>
        <div>
            <form action="" method="post" class="searchBar">
                <div class="form__field">
                    <input type="text" name="search">
                </div>
                <button type="submit">
                    <img src="./images/computer.png" alt="IMDMedia logo" class="searchIcon"/>
                </button>
            </form>
        </div>
        <div>
            <a href="#" class="primarybtn">Upload project</a>
            <div>
                <button class="dropbtn"></button>
                <div class="dropdownContent"> 
                    <a href="#">Profile</a>
                    <a href="./settings.php">Settings</a>
                    <a href="./logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>


	<script type="module" src="main.js"></script>

</body>
</html>