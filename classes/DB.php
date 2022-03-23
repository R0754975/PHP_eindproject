<?php

    abstract class DB { 
        private static $conn; 

        public static function getConnection(){
            if(self::$conn !== null){
                //connection found
                return self::$conn;
        }else{
            self::$conn = new PDO("mysql:host=localhost;dbname=imdmedia", "root", "root");
            return self::$conn;
            }
        }
    }