<?php

    namespace imdmedia\Feed;

    use imdmedia\Data\DB;
    use DateTime;
    

    class ReportPost{
        private $postId;
        private $userId;

        /**
         * Get the value of postId
         */ 
        public function getPostId()
        {
                return $this->postId;
        }

        /**
         * Set the value of postId
         *
         * @return  self
         */ 
        public function setPostId($postId)
        {
                $this->postId = $postId;

                return $this;
        }

        /**
         * Get the value of userId
         */ 
        public function getUserId()
        {
                return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUserId($userId)
        {
                $this->userId = $userId;

                return $this;
        }

        private function getDateTime(){
                $dateTime = new DateTime();
                $dateTime = $dateTime->format('Y-m-d H:i:s');
                return $dateTime;
            }
        
        public function save(){
            $conn = DB::getConnection();
            $statement = $conn->prepare("insert into reportItem (postId, userId, reportDate) values (:postid, :userid, :date)");
            $statement->bindValue(":postid", $this->getPostId());
            $statement->bindValue(":userid", $this->getUserId());
            $statement->bindValue(":date", $this->getDateTime());
            return $statement->execute();
        }

        public static function deleteReport($postId, $userId){
                $conn = DB::getConnection();
                $statement = $conn->prepare("delete from reportItem where postId = :postId and userId = :userId");
                $statement->bindValue(":postId", $postId);
                $statement->bindValue(":userId", $userId);
                return $statement->execute();
        } 

        public static function reportCheck($postId, $userId){
                $conn = DB::getConnection();
                $statement = $conn->prepare("select * from reportItem where postId =:postId and userId = :userId");
                $statement->bindValue(":postId",  $postId );
                $statement->bindValue(":userId", $userId);
                $statement->execute();
                return $statement->fetch();
                /*
                if($statement === NULL){
                        return false;
                }else{
                        return true;
                } */
            }

    }