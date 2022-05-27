<?php

    namespace imdmedia\Data;

    use imdmedia\Data\DB;

    use PDO;


    class Follow {
        private $following_user;
        private $followed_user;

        public function getFollowing_user()
        {
                return $this->following_user;
        }

        public function setFollowing_user($following_user)
        {
                $this->following_user = $following_user;

                return $this;
        }

        public function getFollowed_user()
        {
                return $this->followed_user;
        }

        public function setFollowed_user($followed_user)
        {
                $this->followed_user = $followed_user;

                return $this;
        }

        public function followUser() {

            $conn = DB::getConnection();
            $statement = $conn->prepare("INSERT INTO follows (following_user, followed_user) VALUES (:following_user, :followed_user)");
            $statement->bindValue(":following_user", $this->following_user);
            $statement->bindValue(":followed_user", $this->followed_user);
            $statement->execute();

        }

        public function unfollowUser() {

            $conn = DB::getConnection();
            $statement = $conn->prepare("DELETE FROM follows WHERE following_user = :following_user AND followed_user = :followed_user");
            $statement->bindValue(":following_user", $this->following_user);
            $statement->bindValue(":followed_user", $this->followed_user);
            $statement->execute();

        }

        public static function getFollowCount($user) {

            $conn = DB::getConnection();
            $statement = $conn->prepare("SELECT * FROM follows WHERE followed_user = :followed_user");
            $statement->bindValue(":followed_user", $user);
            $statement->execute();
            $rowcount = $statement->rowCount();

            return $rowcount;

        }

        public static function getFollowedUsers($user) {

            $conn = DB::getConnection();
            $statement = $conn->prepare("SELECT * FROM follows WHERE following_user = :following_user");
            $statement->bindValue(":following_user", $user);
            $statement->execute();
            $FollowedUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $FollowedUsers;
           
        }
    }