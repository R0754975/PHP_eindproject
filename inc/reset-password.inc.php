<?php

require '../classes/DB.php';
// system to reset password
if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["password-repeat"];
    $uppercase = preg_match('@[A-Z]@', $passwordRepeat);
    $lowercase = preg_match('@[a-z]@', $passwordRepeat);
    $number = preg_match('@[0-9]@', $passwordRepeat);
    $specialChars = preg_match('@[^\w]@', $passwordRepeat);  

    if (empty($password) || empty($passwordRepeat)) {
        header("Location: http://localhost:8888/PHP_eindproject/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=empty");
        exit();
    } else if($password != $passwordRepeat) {
        header("Location: http://localhost:8888/PHP_eindproject/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=doesnotmatch");
        exit();
    }
    else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($passwordRepeat) < 6){
        header("Location: http://localhost:8888/PHP_eindproject/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=Incorrect");
        exit();
    }

    $currentDate = date("U");

    $conn = DB::getConnection();
    $statement = $conn->prepare("SELECT * FROM pwdreset WHERE pwdResetSelector=:selector AND pwdResetExpires >= $currentDate");
    $statement->bindValue(":selector", $selector);
    $statement->execute();
    $result = $statement->fetch();
    
    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin, $result["pwdResetToken"]);

    if ($tokenCheck === false) {
        throw new Exception("You need to re-submit your reset request.");
        exit();
     
    } else if ($tokenCheck === true) {

        $tokenEmail = $result["pwdResetEmail"];
        $statementTwo = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $statementTwo->bindValue(":email", $tokenEmail);
        $statementTwo->execute();
        $resultTwo = $statementTwo->fetch();

        $statementThree = $conn->prepare("UPDATE users SET password=:pw WHERE email=:email");

        $options = [
            'cost' => 12,
        ];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT, $options);

        $statementThree->bindValue(":pw", $passwordHash);
        $statementThree->bindValue(":email", $tokenEmail);
        $statementThree->execute();

        $statementFour = $conn->prepare("DELETE FROM pwdreset WHERE pwdResetEmail=:email");
        $statementFour->bindValue(":email", $tokenEmail);
        $statementFour->execute();
        header("Location: ../login.php?succes=passwordupdated");

    }
    
    

} else {
    header("Location: login.php");
}