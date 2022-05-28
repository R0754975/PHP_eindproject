<?php

    namespace imdmedia\Feed;

    use imdmedia\Data\DB;
    use PDO;

    class Comment {

        private $comment;
        private $postId;
        private $userId;

        public function getComment()
        {
                return $this->comment;
        }
        public function setComment($comment)
        {
                $this->comment = $comment;

                return $this;
        }
        public function getPostId()
        {
                return $this->postId;
        }
        public function setPostId($postId)
        {
                $this->postId = $postId;

                return $this;
        }
        public function getUserId()
        {
                return $this->userId;
        }
        public function setUserId($userId)
        {
                $this->userId = $userId;

                return $this;
        }

        public function save() {

            $conn = DB::getConnection();
            $statement = $conn->prepare("INSERT INTO comments (comment, postId, userId) VALUES (:comment, :postId, :userId)");
            $statement->bindValue(":comment", $this->comment);
            $statement->bindValue(":postId", $this->postId);
            $statement->bindValue(":userId", $this->userId);
            $result = $statement->execute();
            return $result;

        }
        public static function getAll($postId) {
                
            $conn = DB::getConnection();
            $statement = $conn->prepare("SELECT * FROM comments WHERE postId = :postId");
            $statement->bindValue(":postId", $postId);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
    
        }
        public static function deletePostComments($postId) {
                
            $conn = DB::getConnection();
            $statement = $conn->prepare("DELETE FROM comments WHERE postId = :postId");
            $statement->bindValue(":postId", $postId);
            $result = $statement->execute();
            return $result;
    
        }
    }