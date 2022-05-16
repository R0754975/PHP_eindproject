<?php
use imdmedia\Data\DB;
require dirname(__DIR__, 1) . "/vendor/autoload.php";

if(isset($_POST['type']) == 1){
    if (isset($_POST['email'])) {
        $email =$_POST['email'];
        $con = DB::getConnection();
        $statement = $con->prepare("select * from users where email = :email");
        $statement->bindValue("email", $email);
        $statement->execute();
        $rowcount = $statement->rowCount();
        if ($rowcount >0) {
            echo "<span class='status-not-available'> Email Not Available.</span>";
        } else {
            echo "<span class='status-available'> Email Available.</span>";
        }
    }
    if (isset($_POST['username'])) {
        $username =$_POST['username'];
        $con = DB::getConnection();
        $statement = $con->prepare("select * from users where username = :username");
        $statement->bindValue("username", $username);
        $statement->execute();
        $rowcount = $statement->rowCount();
        if ($rowcount >0) {
            echo "<span class='status-not-available'> Username Not Available.</span>";
        } else {
            echo "<span class='status-available'> Username Available.</span>";
        }
    }    
}