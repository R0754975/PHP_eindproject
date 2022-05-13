<?php
    
    use imdmedia\Feed\Post;
    use imdmedia\Auth\User;
    use imdmedia\data\DB;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");

    boot();
    $auth = checkLoggedIn();

    if(isset($_POST['update'])) {
        session_start();
        $user = new User();

        $user->setUsername($_SESSION['user']['username']);
        $user->setEmail($_SESSION['user']['email']);
        $user->setBio($bio);
        
    }
    
    

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>Account settings</title>
</head>

<body bgcolor="black">

<form action="" method="POST">

    <input type="text" name="bio" value="" placeholder="<?php echo $_SESSION['user']['bio']; ?>"> 
    <input type="submit" name="update" value="Update">

</form>


</body>         
         
</html>