<?php

    class User{
        public function save(){
            $conn = DB::getConnection();
            $statement = $conn->prepare("insert into users (username, email, password) values (:username, :email, :password)");
            $statement->bindValue("username", $this->username);
            $statement->bindValue("email", $this->email);
            $statement->bindValue("password", $this->password);
            return $statement->execute();
        }

        public function __toString()
        {
            return $this->username . " " . $this->email;
        }
    }
