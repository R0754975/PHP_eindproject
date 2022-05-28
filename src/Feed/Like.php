<?php
namespace imdmedia\Feed;
use imdmedia\Data\DB;
use PDO;

    class Like{
        private $postId;
        private $userId;

        public function getPostId() {
            return $this->postId;
        }

        public function setPostId($postId) {
            $this->postId = $postId;
            return $this;
        }

        public function getUserId() {
            return $this->userId;
        }

        public function setUserId($userId) {
            $this->userId = $userId;
            return $this;
        }

        public function save(){
            $conn = DB::getConnection();
            $statement = $conn->prepare("insert into likes (postId, userId) values (:postId, :userId)");

            $postId = $this->getPostId();
            $userId = $this->getUserId();

            $statement->bindValue(":postId", $postId);
            $statement->bindValue(":userId", $userId);

            $result = $statement->execute();
            return $result;
        }

        public static function getAll($postId){
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from likes where postId = :postId");
            $statement->bindValue(":postId", $postId);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>