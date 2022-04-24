<?php
 include_once("bootstrap.php");
 include_once("inc/functions.inc.php");
// password reset system
if(isset($_POST['reset-request-submit'])) {
	Security::resetRequest();
}


?><!DOCTYPE html>
<html>
<head>
	<title>Forgot your password</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div id="header">
		<div class="logo"></div>
	</div>
	<div id="main">
		<h1>Reset your password</h1>
        <p>An e-mail will be send to you with the instructions on how to reset your password.</p>
        <form action="" method="post">
            <input type="text" name="email" placeholder="Enter your e-mail adress...">
            <button type="submit" name="reset-request-submit">Reset Passsword</button>
        </form>
        <?php if (isset ($_GET["reset"])):?>
        <?php if ($_GET["reset"] == "success"):?>
        <p class="signupsuccess">Check your e-mail!</p>
        <?php endif ?>    
        <?php endif ?>    

	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>