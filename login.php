<?php

include_once(__DIR__ . "/classes/DB.php");
include_once(__DIR__ . "/classes/User.php");

	function canLogin($email, $password) {
        $statement = $conn->prepare("select * from users where email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $email = $statement->fetch();
        echo $email["password"];
        die();

	}


	if( !empty($_POST) ) {
		// er is iéts gepost!
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		// check if email and password are correct
		if( canLogin($email, $password) ) {
			session_start();
			$_SESSION['email'] = $email; // Op de server !!!

			// doorsturen naar index.php
			header("Location: index.php");

		}
		else 
		{
			// error tonen
			$error = true;
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
						Sorry, we can't log you in with that email address and password. Can you try again?
					</p>
				</div>
				<?php endif; ?>

				<div class="form__field">
					<label for="Email">Thomas More Email</label>
					<input autocomplete="off" type="text" name="email">
				</div>
				<div class="form__field">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>

				
					<input type="submit" value="Sign in" class="primarybtn">	
				
			
			</form>
		</div>
	</div>
</body>
</html>