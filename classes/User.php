<?php

    class User{
    
        protected $username;
        protected $email;
        protected $initialPassword;
        protected $repeatPassword;
        
        
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

        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
               

                $this->username = $username;
                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of initialPassword
         */ 
        public function getInitialPassword()
        {
                return $this->initialPassword;
        }

        /**
         * Set the value of initialPassword
         *
         * @return  self
         */ 
        public function setInitialPassword($initialPassword)
        {
                $this->initialPassword = $initialPassword;

                return $this;
        }
        /**
         * Get the value of repeatPassword
         */ 
        public function getRepeatPassword()
        {
                return $this->repeatPassword;
        }

        /**
         * Set the value of repeatPassword
         *
         * @return  self
         */ 
        public function setRepeatPassword($repeatPassword)
        {
            if($this->initialPassword != $repeatPassword){
               throw new Exception("The two given passwords are not the same.");
        }  
        $this->repeatPassword = $repeatPassword;

        return $this;
            }
                
        
    }

