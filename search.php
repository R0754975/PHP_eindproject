<?php
    session_start();

    $collectionId = $_GET['search'];

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title><?php echo $collectionId; ?></title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>
    
</body>
</html>