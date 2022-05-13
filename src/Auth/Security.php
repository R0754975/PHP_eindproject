<?php

    namespace imdmedia\Auth;

    use imdmedia\Data\DB;
    use imdmedia\Data\Mail;
    use imdmedia\Data\Config;
    use Exception;

    class Security
    {
        public static function onlyLoggedInUsers()
        {
            
            if (!isset($_SESSION['user'])) {
                header("Location: login.php");
            }
        }

        public static function checkLoggedIn()
        {
            //check if a user is logged in
            if (isset($_SESSION['user'])) {
                return true;
            } else {
                return false;
            }
        }
        
        // sends the mail to the user with the reset link
        public static function resetRequest()
        {

            //generates a random string of bytes
            $token = random_bytes(32);

            //defines how long the token is valid
            $expires = date("U") + 86400;

            $conn = DB::getConnection();

            $userEmail = $_POST['email'];

            $config = Config::getConfig();

            $url = $config['url'] . "create-new-password.php?validator=" . bin2hex($token) . "&selector=" . $userEmail;
            
            $statement = $conn->prepare("DELETE FROM pwdreset WHERE pwdResetEmail=:email");
            $statement->bindValue(":email", $userEmail);
            $statement->execute();

            $options = [
                'cost' => 12,
            ];
            $tokenHash = password_hash($token, PASSWORD_DEFAULT, $options);
            
            $statementTwo = $conn->prepare("INSERT INTO pwdreset (pwdResetEmail, pwdResetToken, pwdResetExpires) VALUES (:email, :token, :expires)");
            $statementTwo->bindValue(":email", $userEmail);
            $statementTwo->bindValue(":token", $tokenHash);
            $statementTwo->bindValue(":expires", $expires);
            $statementTwo->execute();

            Mail::sendResetMail($userEmail, $url);
        }

        public static function resetPassword()
        {
            $conn = DB::getConnection();
            $token = $_POST['validator'];
            $userEmail = $_POST['selector'];
            $newPassword = $_POST['password'];
            $newPasswordRepeat = $_POST['passwordrepeat'];
            $statement = $conn->prepare("SELECT * FROM pwdreset WHERE pwdResetEmail=:email");
            $statement->bindValue(":email", $userEmail);
            $statement->execute();
            $user = $statement->fetch();
            $tokenHash = $user["pwdResetToken"];
            $expires = $user["pwdResetExpires"];
            $tokenBin = hex2bin($token);

            //for password check
            $uppercase = preg_match('@[A-Z]@', $newPasswordRepeat);
            $lowercase = preg_match('@[a-z]@', $newPasswordRepeat);
            $number = preg_match('@[0-9]@', $newPasswordRepeat);
            $specialChars = preg_match('@[^\w]@', $newPasswordRepeat);

            if (password_verify($tokenBin, $tokenHash)) {
                if ($expires < time()) {
                    throw new Exception("Link has expired");
                } else {
                    if ($newPassword != $newPasswordRepeat) {
                        throw new Exception("Passwords do not match");
                    } elseif (empty($newPassword) || empty($newPasswordRepeat)) {
                        throw new Exception("Password cannot be empty");
                    } elseif (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($newPasswordRepeat) < 6) {
                        throw new Exception("Password must contain at least one uppercase letter, one lowercase letter, one number and one special character, and at least 6 characters");
                    }
                    $options = [
                            'cost' => 12,
                        ];
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT, $options);
                    $statement = $conn->prepare("UPDATE users SET password=:password WHERE email=:email");
                    $statement->bindValue(":password", $newPasswordHash);
                    $statement->bindValue(":email", $userEmail);
                    $statement->execute();
                    $statement = $conn->prepare("DELETE FROM pwdreset WHERE pwdResetEmail=:email");
                    $statement->bindValue(":email", $userEmail);
                    $statement->execute();

                    $statementFour = $conn->prepare("DELETE FROM pwdreset WHERE pwdResetEmail=:email");
                    $statementFour->bindValue(":email", $userEmail);
                    $statementFour->execute();

                    header("Location: login.php?pwreset=success");
                }
            } else {
                throw new Exception("Invalid token");
            }
        }
    }
