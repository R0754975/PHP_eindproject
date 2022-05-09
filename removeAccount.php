<?php
    //add alert in javascript
    use imdmedia\Auth\User;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
        boot();
        checkAuthorisation();

    $user = $_SESSION['user'];
    var_dump($user);
    if(!empty($_POST)){
        var_dump("post");
        $givenpassword = $_POST['password'];
        $username = $_SESSION['user']['username'];
        $delete = User::validateUser($username, $givenpassword);
        if($delete){
            User::deleteUser($user['email'], $user['id']);
            //otherwise you can go back and still be loggedin
            session_destroy();
            //redirect to signup.php
            header("Location: signup.php");
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>Remove your account</title>
</head>
<body>
    <form action="" method="post">
        <h1>Are you sure you want to delete your account?</h1>
        <div class="form__field">
            <label for="Password">Password</label>
            <input type="password" name="password">
        </div>
        <div class="form__field">
            <input type="submit" value="Remove account" class="formbtn primarybtn">
        </div>
    </form>
    <script type="module" src="main.js"></script>
</body>
</html>