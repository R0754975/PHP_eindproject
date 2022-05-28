<?php
use imdmedia\Auth\Security;

require __DIR__ . '/vendor/autoload.php';
// password reset system

$validator = $_GET["validator"];

if (empty($validator)) {
    echo "Could not validate your request!";
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
	<?php include_once("inc/header.inc.php"); ?>
	<title>Reset your password</title>
</head>
<body class="splitForm">
	<div class="IMDMediaSignIn">
		<div class="form form--login">
			<form action="" method="post">
				<h1 form__title>Reset your password</h1>


				<?php if (isset($error)) : ?>
				<div class="formError">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>
				<input type="hidden" name="validator" value="<?php echo htmlspecialchars($validator);?>">
				<div class="form__field">
					<input type="password" name="password" placeholder="Enter a new password...">
				</div>
				<div class="form__field">
					<input type="password" name="passwordrepeat" placeholder="Repeat new password...">
				</div>
				
				<button type="submit" name="reset-password-submit" class="formbtn primarybtn">Reset password</button>	
				
			
			</form>

		</div>
	</div>
	<div class="formFilling">
		<img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1651321304/IMDMedia_Pictures/Home_eye.png" alt="IMD eye" class="fillingImage">
    </div>
    <script type="module" src="./js/sass.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
