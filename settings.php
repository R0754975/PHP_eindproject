<?php
use imdmedia\Auth\Security;
use imdmedia\Auth\User;
use imdmedia\Feed\Post;


    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
        boot();
        Security::onlyLoggedInUsers();

    $error = "";

    //add search function
    if(isset($_GET['search'])){
        header("Location: index.php?search=" . $_GET['search']);
    }

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

if (isset($_POST['submit'])) {
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
<body >
<?php include_once("inc/nav.inc.php"); ?>

<div class="updateSettings">
<form class="postForm" method="POST"
            action=""
            enctype="multipart/form-data">

        <div id="divUploadProfilePic">
            <h2 class="upload__title" >Change profile picture</h2>
            <div class="form__field--upload--updateimage ">
                <input class="upload__text__input" type="file"
                        name="uploadfile"
                        value="" />

            </div>
                <div>
                    <button class="upload__text__btn" type="submit"
                            name="uploadProfilePicture">
                        Update
                    </button>
                </div>
        </div>
    </form>


    <form class="postForm" action="" method="post"
                enctype="multipart/form-data">
                <div>
            <h2 class="upload__title" >Change password</h2>
            <div>
                <div class="error">
                    <?php echo $error ?>
                </div>
                <div class="form__field form__field--upload">
                    <label class="upload__text__subtitle" for="pass">Old password</label>
                    <input class="upload__text__input" type="password" id="oldPassword" name="oldPassword">
                </div>

                <div class="form__field form__field--upload">
                <label class="upload__text__subtitle" for="pass">New password</label>
                    <input class="upload__text__input" type="password" id="newPassword" name="newPassword">
                </div>

                <div class="form__field form__field--upload">
                <label class="upload__text__subtitle" for="pass">Repeat password</label>
                    <input class="upload__text__input" type="password" id="repeatPassword" name="repeatPassword">
                </div>
            </div>

            <button class="upload__text__btn" type="submit"
                        name="changePassword">
                    Change password
                </button>
        </form>

        <form class="postForm" action="" method="post">
            <div class="form__field form__field--upload">
                <label class="upload__text__subtitle" for="bio">Biography</label>
                <input class="upload__text__input" type="text" id="bio" value="" name="bio">
            </div>
            <input class="upload__text__btn" type="submit" value="Update bio" name="updateBio">
        </form>

        <form class="postForm" action="" method="post">
            <div class="form__field form__field--upload">
                <label class="upload__text__subtitle" for="education">Education</label>
                <input class="upload__text__input" type="text" id="education" value="" name="education">
            </div>
            <input class="upload__text__btn" type="submit" value="Update education" name="updateEducation">
        </form>

        <form class="postForm" action="" method="post">
            <div class="form__field form__field--upload">
                <label class="upload__text__subtitle" for="ig">Instagram</label>
                <input class="upload__text__input" type="text" id="ig" value="" name="ig">
            </div>
            <input class="upload__text__btn" type="submit" value="Update instagram" name="updateIg">
        </form>

</div>

<a class="deleteBtn" href="removeAccount.php">Delete account</a>

    <script type="module" src="./js/sass.js"></script>
</body>
</html>


            
            <form class="postForm" action="" method="POST">
                <label for="bio">Biography</label>
                <input type="text" id="bio" value="<?php echo $_SESSION['user']['bio']?>" name="bio">
            
            
            
            
                <label for="education">Education</label>
                <input type="text" id="education" value="<?php echo $_SESSION['user']['education']?>" name="education">
            
            
            
                <label for="ig">Instagram username</label>
                <input type="text" id="ig" value="<?php echo $_SESSION['user']['ig']?>" name="ig">
            
                <label for="tw">Twitter username</label>
                <input type="text" id="tw" value="<?php echo $_SESSION['user']['tw'];?>" name="tw">
            
                <input type="submit" value="Update" name="update">
            </form>
                
            <a href="removeAccount.php">Delete account</a>

            <script type="module" src="main.js"></script>
            </body>
            </html>
