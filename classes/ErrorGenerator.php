<?php

// class for throwing errors
// is voor wanneer je error's wil throwen in een .inc file
    class ErrorGenerator {

        public static function getError($msg){

            if($msg == "empty") {
                throw new Exception("Password fields cannot empty.");
            }
            else if($msg == "doesnotmatch") {
                throw new Exception("Passwords don't match.");
            }
            else if($msg == "Incorrect") {
                throw new Exception("Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character.");
            }
            else {
                throw new Exception("An unknown error has occured.");
            }




        }
    }