<?php

    namespace imdmedia\Auth;

    use Exception;
    use imdmedia\Data\DB;
    use PDO;
    use Cloudinary\Api\Upload\UploadApi;
    use Cloudinary\Configuration\Configuration;

Configuration::instance([
        'cloud' => [
          'cloud_name' => 'dzhrxvqre',
          'api_key' => '387513213267173',
          'api_secret' => '1lBrjQy2GXP39NT1pwnvD1SxyKo'],
        'url' => [
          'secure' => true]]);

    class User
    {
        protected $username;
        protected $email;
        protected $initialPassword;
        protected $repeatPassword;
        protected $profile_pic;
        protected $bio;
        protected $education;
        protected $ig;
        
        private function hashPassword($password){
            $options=[
                'cost' => 12,
            ];

            return password_hash($password, PASSWORD_DEFAULT, $options);
        }

        public static function checkPassword($password){
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                throw new Exception("Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character.");
            }
            return true;
        }

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
            User::checkPassword($initialPassword);
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
         * Get the value of bio
         */
        
        public function getBio() {
            return $this->bio;
        }


        

        /**
         * Set the value of bio
         */
        
        public function setBio($bio) {
            $conn = DB::getConnection();
            $statement = $conn->prepare("UPDATE users SET bio = :bio where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":bio", $bio);
            //execute returns boolean, see if upload was succesful
            $this->bio = $bio;
            $_SESSION["user"]["bio"] = $bio;
            return $statement->execute();
        }

        /**
         * Get the value of education
         */
        
        public function getEducation() {
            return $this->education;
        }

         /**
         * Set the value of education
         */
        
        public function setEducation($education) {
            $conn = DB::getConnection();
            $statement = $conn->prepare("UPDATE users SET education = :education where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":education", $education);
            //execute returns boolean, see if upload was succesful
            $this->education = $education;
            $_SESSION["user"]["education"] = $education;
            return $statement->execute();
        }


        /**
         * Get the value of instagram
         */
        
        public function getIg() {
            return $this->ig;
        }

         /**
         * Set the value of education
         */
        
        public function setIg($ig) {
            $conn = DB::getConnection();
            $statement = $conn->prepare("UPDATE users SET ig = :ig where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":ig", $ig);
            //execute returns boolean, see if upload was succesful
            $this->ig = $ig;
            $_SESSION["user"]["ig"] = $ig;
            return $statement->execute();
        }

        
         
             
        /**
         * Get the value of profile_pic
         */
        public function getProfile_pic()
        {
            return $this->profile_pic;
        }

        /**
         * Set the value of profile_pic
         */
        public function setProfile_pic($profile_pic)
        {
            $this->profile_pic = $profile_pic;
            return $this;
        }

        public function saveProfile_pic() {
            $conn = DB::getConnection();
            $statement = $conn->prepare("UPDATE users SET profile_pic = :profile_pic where email = :email");
            $statement->bindValue(":profile_pic", $this->profile_pic);
            $statement->bindValue(":email", $this->email);
            //execute returns boolean, see if upload was succesful
            $_SESSION["user"]["profile_pic"] = $this->profile_pic;
            return $statement->execute();
        }

        public function uploadProfile_Pic($file) {
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];

            if ($fileError === 0) {
                if ($fileSize < 5000000) {

                            //uploads file to cloudinary
                    $cloudinary = (new uploadApi())->upload(
                        $fileTmpName,
                        [
                                'folder' => 'Profile_Pictures/',
                                "format" => "webp",
                                ]
                    );
                    //stores the new url in the class
                    $this->setProfile_pic($cloudinary['url']);
                    $this->saveProfile_pic();
                } else {
                    throw new Exception("Your file is too big!");
                }
            } else {
                throw new Exception("There was an error uploading your file!");
            }
        }



        






        public function verifyPassword($password){
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            $hash = $user["password"];
            if (password_verify($password, $hash)) {
                return true;
            } else {
                throw new Exception("Wrong password");
            }
        }

        public function changePassword($oldPassword, $newPassword){
            if($this->verifyPassword($oldPassword) && User::checkPassword($newPassword)){
                $conn = DB::getConnection();
                $statement = $conn->prepare("UPDATE users SET password = :pw where email = :email");
                $statement->bindValue(":pw", $this->hashPassword($newPassword));
                $statement->bindValue(":email", $this->email);
                return $statement->execute();
            }
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

        
        public static function getUserbyUsername($user){
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from users where username = :username");
            $statement->bindValue(':username', $user);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
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


    }
