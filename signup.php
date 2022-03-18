<?php
    //check if form is filled in when submitted
    if(!empty($_POST)){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $initialPassword = $_POST['password'];
        $repeatPassword = $_POST['passwordRepeat'];


        //checks if email contains @student.thomasmore.be or @thomasmore.be
        if(str_contains($email, '@student.thomasmore.be') || str_contains($email, '@thomasmore.be')) {
            $emailVerified = true ;
        }else{
            $error = true;
            $errorEmail = true;
        }

        //checks if password has at least 6 characters
        if(strlen($initialPassword) >= 6){
            $passwordLength = true;
        }else{
            $error = true;
            $errorPasswordLength = true;
        }

        //checks if InitialPassword en RepeatPassword are the same
        if($initialPassword === $repeatPassword){
            $passwordVerified = true;
        }else{
            $error = true;
            $errorPassword = true;
        }

    }

    


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <title>Signup IMDMedia</title>
</head>
<body>
    <div class="IMDMediaSignIn">
        <form action="" method="post">
            <h2>Signup to IMDMedia</h2>
            <p>Get inspired by your fellow students!</p>

            <?php if(isset($error)): ?>
                <div class="formError">
                <?php if(isset($errorEmail)):?>
                        <p>Sign up with your Thomas More mailadres. </p>
                    <?php endif; ?>
                    <?php if(isset($errorPasswordLength)):?>
                        <p>Your password should at least contain 6 characters.</p>
                    <?php endif; ?>
                    <?php if(isset($errorPassword)):?>
                        <p>The two given passwords are not the same.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>     

            <div class="form__field">
                <label for="Username">Username</label>
                <input autocomplete="off" type="text" name="username">
            </div>

            <div class="form__field">
                <label for="Email">Email</label>
                <input type="text" name="email">
            </div>

            <div class="form__field">
                <label for="Password">Password</label>
                <input type="password" name="password">
            </div>

            <div class="form__field">
                <label for="Password">Repeat password</label>
                <input type="password" name="passwordRepeat">
            </div>

            <div class="form__field">
                <input type="submit" value="Sign up" class="primarybtn">
            </div>
        </form>
    </div>
</body>
</html>