<?php
    //check if form is filled in when submitted
    if(!empty($_POST)){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $initialPassword = $_POST['password'];
        $repeatPassword = $_POST['passwordRepeat'];

        //checks if password has at least 6 characters
        if(strlen($initialPassword) >= 6){
            $passwordLength = true;
        }else{
            $error = true;
            $errorPasswordLength = true;
        }

    }
    //error when one of the input fields aren't fild in
    


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
                    <?php if(isset($errorPasswordLength)):?>
                        <p>Your password should at least containt 6 characters.</p>
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