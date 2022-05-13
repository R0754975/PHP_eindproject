<?php
use imdmedia\Auth\Security;
use imdmedia\Auth\User;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
        boot();
        Security::onlyLoggedInUsers();

    $error = "";

    if(isset($_POST['changePassword'])){
        $newPassword = $_POST["newPassword"];
        
        if($_POST["repeatPassword"] == $newPassword){
             $user = new User();
             $user->setEmail($_SESSION['user']["email"]);
             try{
                if($user->changePassword($_POST["oldPassword"], $newPassword)) $error = "password has changed";
             }catch (Throwable $e) {
                $error = $e->getMessage();
            }
        }else{
             $error = "passwords dont match";
        }
    }

if(isset($_POST['uploadProfilePicture'])){
    
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
if(isset($_POST['updateBio'])){

    $bio = $_POST['bio'];
    $user = new User();
    $user->setUsername($_SESSION["user"]["username"]);
    $user->setEmail($_SESSION["user"]["email"]);


    $user->setBio($bio);
    
    }


    if(isset($_POST['updateEducation'])){

        $education = $_POST['education'];
        $user = new User();
        $user->setUsername($_SESSION["user"]["username"]);
        $user->setEmail($_SESSION["user"]["email"]);
    
    
        $user->setEducation($education);
        
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

<form method="POST"
        action=""
        enctype="multipart/form-data">

<div id="divUploadProfilePic">
	<input type="file"
                name="uploadfile"
                value="" />

        <div>
            <button type="submit"
                    name="uploadProfilePicture">
                Update
            </button>
        </div>
</div>
</form>

    <form method="POST"
            action=""
            enctype="multipart/form-data">
            <div>
        <h2>Change password</h2>
        <div>
            <div class="error">
                <?php echo $error ?>
            </div>
            <label for="pass">Old password</label>
                <input type="password" id="oldPassword" name="oldPassword">
            </div>

            <label for="pass">New password</label>
                <input type="password" id="newPassword" name="newPassword">
            </div>

            <label for="pass">Repeat password</label>
                <input type="password" id="repeatPassword" name="repeatPassword">
            </div>
        </div>

        <button type="submit"
                    name="changePassword">
                Change password
            </button>
    </form>

    <form action="" method="post">
    <label for="bio">Biography</label>
    <input type="text" id="bio" value="" name="bio">

    <input type="submit" value="Update bio" name="updateBio">

    </form>

    <form action="" method="post">
    <label for="education">Education</label>
    <input type="text" id="education" value="" name="education">

    <input type="submit" value="Update education" name="updateEducation">

    </form>

<script type="module" src="main.js"></script>
</body>
</html>

