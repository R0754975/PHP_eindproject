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

if(isset($_POST['submit'])){
    
    $file = $_FILES['file'];
    $user = new User();
    $user->setEmail($_SESSION['user']["email"]);
    $user->uploadProfile_Pic($file);


}
if(isset($_POST['update'])){
            
            $bio = $_POST['bio'];
            $education = $_POST['education'];
            $ig = $_POST['ig'];
            $tw = $_POST['tw'];
            $user = new User();
            $user->setUsername($_SESSION["user"]["username"]);
            $user->setEmail($_SESSION["user"]["email"]);
        
            $user->setBio($bio);
            $user->setEducation($education);
            $user->setIg($ig);
            $user->setTw($tw);
            
    }


            ?><!DOCTYPE html>
            <html lang="en">
            <head>
                <?php include_once("inc/header.inc.php"); ?>
                <title>Account settings</title>
            </head>
            <body>
            <?php include_once("inc/nav.inc.php"); ?>
                
            <form class="postForm" action="" method="POST" enctype="multipart/form-data">

        <div id="divUploadProfilePic">
        <label for="file">Change Profile Picture</label>    
        <input class="fileInput" type="file" name="file">   
        <button type="submit" name="submit">Update</button>
        </div>
        </form>
            
            <form class="postForm" method="POST" action="" enctype="multipart/form-data"> 
            <h2>Change password</h2>
            <div class="error">
                <?php echo $error ?>
            </div>
            <label for="pass">Old password</label>
            <input type="password" id="oldPassword" name="oldPassword">
       
            <label for="pass">New password</label>
            <input type="password" id="newPassword" name="newPassword">
            
            <label for="pass">Repeat password</label>
            <input type="password" id="repeatPassword" name="repeatPassword">

            <button type="submit" name="changePassword">Change password</button>
        </form>

            
            <form class="postForm" action="" method="POST">
                <label for="bio">Biography</label>
                <input type="text" id="bio" value="<?php echo $_SESSION['user']['bio']?>" name="bio">
            
            
            
            
                <label for="education">Education</label>
                <input type="text" id="education" value="<?php echo $_SESSION['user']['education']?>" name="education">
            
            
            
                <label for="ig">Instagram username</label>
                <input type="text" id="ig" value="<?php echo $_SESSION['user']['ig']?>" name="ig">
            
                <label for="tw">Twitter username</label>
                <input type="text" id="tw" value="<?php echo $_SESSION['user']['tw']?>" name="tw">
            
                <input type="submit" value="Update" name="update">
            </form>
                
            <a href="removeAccount.php">Delete account</a>

            <script type="module" src="main.js"></script>
            </body>
            </html>