<?php
require 'classes/DB.php';
	function canLogin($email, $password) {
		/*if($email === "dummy" && $password === "12345" ) {
			return true;
		}
		else {
			return false;
		}
		*/

		// 1 - connectie databank
		// 2 - query schrijven
		try{
			$conn = DB::getConnection();
			/*$password = md5($password);
			$sql = "select * from users where email = '$email' and password = '$password'";
			//hack query
			//"selecht * from users where email = 'x' OR 1=1 LIMIT 1; --' //-- rest query in comentaar zetten
			echo $sql;
			exit();
			$result = $conn->query($sql);
			var_dump($result->rowCount());

			$count = $result->rowCount();
			if($count === 1){
				return true;
			}else{
				return false;
				
			}*/

			$statement = $conn->prepare("select * from users where email = :email");
			$statement->bindValue("email", $email);
			$statement->execute();
			$user = $statement->fetch(PDO::FETCH_ASSOC);

			
			$hash = $user['password'];
			if( password_verify($password, $hash)){
				echo "juist password";
				return true;
			}else{
				echo "fout password";
				return false;
			}
		}
		catch(Throwable $e){
			echo $e->getMessage();
			return false;
		}
	
	} 


	if( !empty($_POST) ) {
		// er is iéts gepost!
		$email = $_POST['email']; //name in form
		$password = $_POST['password'];
		
		// checken of user mag aanloggen
		if( canLogin($email, $password) ) {
			session_start();
			// $_SESSION['username'] = $email; // Op de server !!!

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
				<?php if (isset ($_GET["newpassword"])):?>
					<p>
					please make sure your password is at least 6 characters in length, includes at least one upper case letter, one number, and one special character.
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