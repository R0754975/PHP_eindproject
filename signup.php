<?php
    require __DIR__ . '/vendor/autoload.php';

    //check if form is filled in when submitted
    use imdmedia\Auth\User;

    if (!empty($_POST)) {
        try {
            $user = new User();
            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->setRepeatPassword($_POST['passwordRepeat']);
            $savedUser = $user->save();

            session_start();
            $_SESSION['user'] = $savedUser;
            
            header("Location: index.php");
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>Signup IMDMedia</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/signupcheck.js"></script>
</head>
<body class="splitForm">
    <div class="IMDMediaSignIn">
        <div class="form">
            <form action="" method="post">
                <h1>Signup to IMDMedia</h1>

                <?php if (isset($error)): ?>
                    <div class="formError">
                            <p><?php echo $error; ?></p>
                    </div>
                <?php else: ?>    
                    <p>Get inspired by your fellow students!</p>
                <?php endif; ?>
                
        
                <div class="form__field">
                    <label for="Username">Username</label>
                    <input autocomplete="off" type="text" id="username"  name="username" onBlur="userAvailability()"><span id="user-availability-status"></span> 
                </div>

                <div class="form__field">
                    <label for="Email">Email</label>
                    <input type="text" id="email" name="email" onBlur="emailAvailability()"><span id="email-availability-status"></span> 
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
                    <input type="submit" value="Sign up" class="formbtn primarybtn">
                </div>

            </form>
            <p class="extraP">Already have an account? <a href="login.php">Sign in here.</a></p>   
        </div>
    </div>
    <div class="formFilling">
        <img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1651321304/IMDMedia_Pictures/Home_eye.png" alt="IMD eye" class="fillingImage">
    </div>
    <script type="module" src="main.js"></script>
</body>
</html>