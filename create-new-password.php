<?php
use imdmedia\Auth\Security;

require __DIR__ . '/vendor/autoload.php';
include_once("inc/functions.inc.php");
// password reset system

$validator = $_GET["validator"];

if (empty($validator)) {
    echo "Could not validate your request!";
}

//add search function
if(isset($_GET['search'])){
    header("Location: index.php?search=" . $_GET['search']);
}

if (isset($_POST['reset-password-submit'])) {
    try {
        Security::resetPassword();
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

?><!DOCTYPE html>
<html>
<head>
	<title>Reset your password</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div id="header">
		<div class="logo"></div>
	</div>
	<div id="main">
		<h1>Reset your password</h1>
        <?php if (isset($e)) : ?>
				<div class="formError">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
		<?php endif; ?>
                 <form action="" method="post">
                        <input type="hidden" name="validator" value="<?php echo $validator;?>">
                        <input type="password" name="password" placeholder="Enter a new password...">
                        <input type="password" name="passwordrepeat" placeholder="Repeat new password...">
                        <button type="submit" name="reset-password-submit">Reset password</button>
                    </form>    


	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>