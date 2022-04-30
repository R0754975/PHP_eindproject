<?php
require 'classes/ErrorGenerator.php';
if(isset($_GET['error'])) {
$msg = $_GET['error'];

    try {
        
        $errorGen = ErrorGenerator::getError($msg);
    }
    catch(Throwable $e){
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
    <?php include_once("inc/nav.inc.php"); ?>

	<div id="header">
		<div class="logo"></div>
	</div>
	<div id="main">
		<h1>Reset your password</h1>
        <?php if( isset($e) ) : ?>
				<div class="formError">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
		<?php endif; ?>
        <?php
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            if (empty($selector) || empty($validator)) {
                echo "Could not validate your request!";
            }
            else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {

                    ?>
                    
                    <form action="inc/reset-password.inc.php" method="post">
                        <input type="hidden" name="selector" value="<?php echo $selector;?>">
                        <input type="hidden" name="validator" value="<?php echo $validator;?>">
                        <input type="password" name="password" placeholder="Enter a new password...">
                        <input type="password" name="password-repeat" placeholder="Repeat new password...">
                        <button type="submit" name="reset-password-submit">Reset password</button>
                    </form>    
                    <?php


                }
            }
        ?>


	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>