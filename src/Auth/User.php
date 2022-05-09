<?php

    namespace imdmedia\Auth;

    use Exception;
    use imdmedia\Data\DB;
    use PDO;

    class User
    {
        protected $username;
        protected $email;
        protected $initialPassword;
        protected $repeatPassword;
        protected $profile_pic;
        

        public static function getUserbyId($id){
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from users where id = :id");
            $statement->bindValue(':id', $id);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
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
            if (empty($username)) {
                throw new Exception("Your username is not long enough.");
            }
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
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindValue("email", $email);
            $statement->execute();
            $emailDB = $statement->fetch();

            if (!strpos($email, '@student.thomasmore.be') && !strpos($email, '@thomasmore.be')) {
                throw new Exception("Sign up with your Thomas More mailadres.");
            }
            $this->email = $email;
            return $this;
        }

        /**
         * Get the value of initialPassword
         */
        public function getPassword()
        {
            return $this->initialPassword;
        }

        /**
         * Set the value of initialPassword
         *
         * @return  self
         */
        public function setPassword($initialPassword)
        {
            $uppercase = preg_match('@[A-Z]@', $initialPassword);
            $lowercase = preg_match('@[a-z]@', $initialPassword);
            $number = preg_match('@[0-9]@', $initialPassword);
            $specialChars = preg_match('@[^\w]@', $initialPassword);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($initialPassword) < 6) {
                throw new Exception("Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character.");
            }
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
            if ($this->initialPassword != $repeatPassword) {
                throw new Exception("The two given passwords are not the same.");
            }
            $this->repeatPassword = $repeatPassword;

            return $this;
        }
                
             
        /**
         * Get the value of profile_pic
         */
        public function getProfile_pic()
        {
            return $this->repeatPassword;
        }

        /**
         * Set the value of profile_pic
         */
        public function setProfile_pic($profile_pic)
        {
            $this->profile_pic = $profile_pic;
            return $this;
        }

        public function canLogin()
        {
            $password = $this->initialPassword;
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            $hash = $user["password"];
            if (password_verify($password, $hash)) {
                return $user;
            } else {
                throw new Exception("Wrong password");
            }
        }

        public function save()
        {
            $conn = DB::getConnection();
            $statementA = $conn->prepare("select * from users where email = :email");
            $statementA->bindValue("email", $this->email);
            $statementA->execute();
            $emailDB = $statementA->fetch();
            if ($emailDB != false) {
                throw new Exception("This email has already an account, please sign in with another one.");
            }
            $options=[
                        'cost' => 12,
                ];
            $passwordHash = password_hash($this->repeatPassword, PASSWORD_DEFAULT, $options);
            $conn = DB::getConnection();
            $statement = $conn->prepare("insert into users (username, email, password) values (:username, :email, :password)");
            $statement->bindValue("username", $this->username);
            $statement->bindValue("email", $this->email);
            $statement->bindValue("password", $passwordHash);
            $statement->execute();

            $userId = $conn->lastInsertId();
            return $this->getUserById($userId);
        }

        public static function validateUser($username, $password){
            var_dump("in validatefunction");
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from users where username = :username");
            $statement->bindValue(":username", $username);
            $statement->execute();
            $validatedUser = $statement->fetch();//(PDO::FETCH_ASSOC);
            if(!empty($validatedUser)){
                var_dump("in if functie");
                $hash = $validatedUser["password"];
                    if (password_verify($password, $hash)) {
                        var_dump($password);
                        var_dump($hash);
                        return true;
                    } else {
                        throw new Exception("Wrong password");
                    }
            }
        }
 
        public static function deleteUser($email, $id)
        {
                $conn = DB::getConnection();
                $statementA=$conn->prepare("DELETE FROM users where email = :email");
                $statementB=$conn->prepare("DELETE FROM posts where userid = :id");
                $statementA->bindValue("email", $email);
                $statementB->bindValue("id", $id);
                $statementA->execute();
                $statementB->execute();
                return true;
        }

        public function __toString()
        {
            return $this->username . " " . $this->email;
        }

        public function getAll() 
        {
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->execute();
            $user = $statement->fetch();
            return $user;
        }

        public function changeSettings($username, $email, $password, $profile_pic, $newpassword)
        {
            $conn = DB::getConnection();
            $statementA = $conn->prepare("select * from users where email = :email");
            $statementA->bindValue("email", $this->email);
            $statementA->execute();
            $result = $statementA->fetch();

            if(password_verify($newpassword, $result['wachtwoord']) ){
                //if ($userExist == 0) {
                    //username bestaat niet of is niet veranderd, gegevens aanpassen
            
                    $conn =  Db::getConnection();
                    $statement = $conn->prepare("UPDATE users SET username=:username, wachtwoord=:wachtwoord, profile_pic=:profile_pic, WHERE email = :email");
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":wachtwoord", $password);
                    $statement->bindParam(":profile_pic", $profile_pic);
                    $statement->bindParam(":email", $email);
                

                    if($statement->execute()){
                        return true;
                    }else{
                        echo "Er is iets foutgelopen bij het updaten.";
                    }
                // }else{
                //     //username bestaat wel, mag niet veranderd worden
                //     return "ERROR: Gelieve een andere username te kiezen";
                // }
            } else {
                echo "Fout wachtwoord.";
                return false;
            }
        }
    }
