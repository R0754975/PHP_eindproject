<?php
    //add alert in javascript
    use imdmedia\Auth\User;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
        boot();
        //checkAuthorisation();

    //add search function
    if(isset($_GET['search'])){
        header("Location: index.php?search=" . $_GET['search']);
    }

    $user = $_SESSION['user'];
    if(!empty($_POST)){
        try{
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
        }catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>Remove your account</title>
</head>
<body>
<?php include_once("inc/nav.inc.php"); ?>

    <div class="centerDiv centerRemoveAccount">
        <form action="" method="post">
            <h1 class="upload__title">Are you sure you want to delete your account?</h1>
            <?php if(isset($error)): ?>
                <p class="passwordError"><?php echo $error ?></p>
            <?php endif; ?>
            <div class="form__field">
                <label class="upload__text__subtitle" for="Password">Password</label>
                <input class="upload__text__input" type="password" name="password">
            </div>
            <div class="form__field">
                <input type="submit" value="Remove account" class="upload__text__btn">
            </div>
        </form>
    </div>
    <script type="module" src="./js/sass.js"></script>
</body>
</html>