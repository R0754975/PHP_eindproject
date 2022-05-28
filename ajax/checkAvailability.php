<?php
use imdmedia\Auth\User;
require dirname(__DIR__, 1) . "/vendor/autoload.php";

if(isset($_POST['type']) == 1){
    if (isset($_POST['email'])) {
        $email =$_POST['email'];
        $rowcount = User::checkEmailAvailability($email);
        if ($rowcount >0) {
            echo "<span class='status-not-available'> Email Not Available.</span>";
        } else {
            echo "<span class='status-available'> Email Available.</span>";
        }
    }
    if (isset($_POST['username'])) {
        $username =$_POST['username'];
        $rowcount = User::checkUsernameAvailability($username);
        if ($rowcount >0) {
            echo "<span class='status-not-available'> Username Not Available.</span>";
        } else {
            echo "<span class='status-available'> Username Available.</span>";
        }
    }    
}