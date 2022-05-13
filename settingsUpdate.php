<?php
 use imdmedia\Feed\Post;
 use imdmedia\Auth\User;
 use imdmedia\data\DB;

 require __DIR__ . '/vendor/autoload.php';
 include_once("inc/functions.inc.php");

 boot();
 $auth = checkLoggedIn();


    if(isset($_POST['update'])) {
    $userNewBio = $_POST['bio'];

    $u = new User();
        $email = $_SESSION['email'];
        $username = $_POST['username'];
        $bio = $userNewBio;
        $initialPassword = $_POST['initialPassword'];
        $repeatPassword = $_POST['repeatPassword'];
    
            

        $result = $u->changeSettings($username, $email, $password, $profile_pic, $newpassword, $bio);

   $results = mysqli_query($connection,$statement);

    header('Location: account.php');

   }

   if(!empty($userNewBio)) {

   } else {
   header('Location: settings.php');
   exit;

    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    test
</body>
</html>