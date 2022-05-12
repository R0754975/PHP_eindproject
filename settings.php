<?php
use imdmedia\Auth\Security;
use imdmedia\Auth\User;
use imdmedia\Feed\Post;
require __DIR__ . '/vendor/autoload.php';
include_once("inc/functions.inc.php");
    boot();
    Security::onlyLoggedInUsers();

if(isset($_POST['uploadProfilePicture'])){
    session_start();
    $user = new User();
    $user->setUsername($_SESSION["user"]["username"]);
    $user->setEmail($_SESSION["user"]["email"]);
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folderPath = "images/uploads/users/" .$user->getUsername();
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $imagePath =  $folderPath . "/". $filename;
    
    if(move_uploaded_file($tempname, $imagePath)){
        $user->setProfile_pic($filename);
    }

}
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>Account settings</title>
</head>
<body>
<?php include_once("inc/nav.inc.php"); ?>

<button class="changePass">Change password</button>
<a href="removeAccount.php">Delete account</a>

<button>Change profile picture</button>

<div id="divUploadProfilePic">

    <form method="POST"
            action=""
            enctype="multipart/form-data">
        <input type="file"
                name="uploadfile"
                value="" />

        <div>
            <button type="submit"
                    name="uploadProfilePicture">
                Update
            </button>
        </div>
    </form>
</div>

<script type="module" src="main.js"></script>
</body>
</html>