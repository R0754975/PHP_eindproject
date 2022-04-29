<?php
 
 function boot()
 {
     //needed for setup
     session_start();
 }

function checkAuthorisation()
{
    //check if a user is logged in
    if (isset($_SESSION['user'])) {
        //can use the page
    } else {
        //needs to login
        header("Location: login.php");
        exit();
    }
}

function checkLoggedIn()
{
    //check if a user is logged in
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}
