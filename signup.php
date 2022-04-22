<?php
    include_once(__DIR__ . "/classes/DB.php");
    include_once(__DIR__ . "/classes/User.php");

    //check if form is filled in when submitted
    if(!empty($_POST)){
        try{
            $user = new User();
            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->setRepeatPassword($_POST['passwordRepeat']);
            $user->save();

            session_start();
            $_SESSION['user'] = $user;
            header("Location: index.php");
        }catch (Throwable $e){
            $error = $e->getMessage();
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
                        <p><?php echo $error; ?></p>
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