<?php

    abstract class DB { 
        private static $conn; 

        private static function getConfig(){
            // get the config file
            return parse_ini_file(__DIR__ . "/../config/config.ini");
        }

        public static function getConnection(){
            if(self::$conn !== null){
                //connection found
                return self::$conn;
        }else{
            $config = self::getConfig();
                $database = $config['database'];
                $user = $config['user'];
                $password = $config['password'];
                $host = $config['host'];

                
                self::$conn = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8mb4', $user, $password);
                return self::$conn;
            }
        }
    }