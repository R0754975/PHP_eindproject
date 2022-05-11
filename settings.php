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
        session_start();
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
    <script type="module" src="main.js"></script>
</body>
</html>