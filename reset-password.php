<?php
use imdmedia\Auth\Security;

require __DIR__ . '/vendor/autoload.php';

if (isset($_POST['reset-request-submit'])) {
    try {
        Security::resetRequest();
    }
        catch (Throwable $e) {
            $error = $e->getMessage();
        }
}
?><!DOCTYPE html>
<html>
<head>
    <?php include_once("inc/header.inc.php"); ?>
	<title>Forgot your password</title>
</head>
<body class="splitForm">
	<div class="IMDMediaSignIn">
		<div class="form form--login">
			<form action="" method="post">
				<h1 form__title>Reset your password</h1>
                <p>An e-mail will be send to you with the instructions on how to reset your password.</p>
                <?php if (isset($error)) : ?>
				<div class="formError">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>		
				<div class="form__field">
					<input type="text" name="email" placeholder="Enter your e-mail adress...">
				</div>
				<button type="submit" name="reset-request-submit"class="formbtn primarybtn">Reset Passsword</button> 
                <?php if (isset($_GET["reset"])):?>
                <?php if ($_GET["reset"] == "success"):?>
                <p class="signupsuccess">Check your e-mail!</p>
                <?php endif ?>    
                <?php endif ?>  	
			</form>

		</div>
	</div>
	<div class="formFilling">
		<img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1651321304/IMDMedia_Pictures/Home_eye.png" alt="IMD eye" class="fillingImage">
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="module" src="./js/sass.js"></script>
</body>
</html>