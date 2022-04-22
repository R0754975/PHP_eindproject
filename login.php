<?php
require 'classes/DB.php';
include_once("bootstrap.php");

if(!empty($_POST)) {
	try {
	$user = new User();
	$user->setEmail($_POST['email']);
	$user->setPassword($_POST['password']);
	if($user->canLogin()){
	session_start();
	$_SESSION['user'] = $user;
	header("Location: index.php");
	
	}
	}
	catch ( Throwable $e) {
	$error = $e->getMessage();
	}
	}

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign in IMDMedia</title>
  <link rel="stylesheet" href="css/app.css">
</head>
<body>
	<div class="IMDMediaSignIn">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Sign In</h2>


				<?php if( isset($error) ) : ?>
				<div class="formError">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>
				<?php if (isset ($_GET["newpassword"])):?>
					<p>
					please make sure your password is at least 6 characters in length, includes at least one upper case letter, one number, and one special character.
					</p>
				<?php endif ?>
				<?php if (isset ($_GET["succes"])):?>
					<p>
					Your password has been succesfully updated.
					</p>
				<?php endif ?>
				<div class="form__field">
					<label for="Email">Thomas More Email</label>
					<input autocomplete="on" type="text" name="email">
				</div>
				<div class="form__field">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>
				<div><a href="signup.php">Register now</a></div>
				<div><a href="reset-password.php">Forgot your password?</a></div>

				
					<input type="submit" value="Sign in" class="primarybtn">	
				
			
			</form>
		</div>
	</div>
</body>
</html>