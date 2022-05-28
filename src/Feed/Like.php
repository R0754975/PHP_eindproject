<?php

    namespace imdmedia\Feed;

    use imdmedia\Data\DB;
    use PDO;

    class Like {

        private $postId;
        private $userId;

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
        public function saveLike() {
                
            $conn = DB::getConnection();
            $statement = $conn->prepare("INSERT INTO likes (postId, userId) VALUES (:postId, :userId)");
            $statement->bindValue(":postId", $this->postId);
            $statement->bindValue(":userId", $this->userId);
            $statement->execute();
    
        }
        public function unLike() {
                    
            $conn = DB::getConnection();
            $statement = $conn->prepare("DELETE FROM likes WHERE postId = :postId AND userId = :userId");
            $statement->bindValue(":postId", $this->postId);
            $statement->bindValue(":userId", $this->userId);
            $statement->execute();
        
        }

        public static function checkLiked($user, $post) {                    
                  $conn = DB::getConnection();
                  $statement = $conn->prepare("SELECT * FROM likes WHERE postId = :postId AND userId = :userId");
                  $statement->bindValue(":postId", $post);
                  $statement->bindValue(":userId", $user);
                  $statement->execute();
                  $rowcount = $statement->rowCount();

                 if($rowcount > 0) {
                        $like = "1";
                        return $like;
                 }   else {
                        $like = "0";
                        return $like;
                }
        

        }

        public static function deletePostLikes($post) {
                    
            $conn = DB::getConnection();
            $statement = $conn->prepare("DELETE FROM likes WHERE postId = :postId");
            $statement->bindValue(":postId", $post);
            $result = $statement->execute();
            return $result;
        
        }
        
        public static function getAll($post) {
                
                $conn = DB::getConnection();
                $statement = $conn->prepare("SELECT * FROM likes WHERE postId = :postId");
                $statement->bindValue(":postId", $post);
                $statement->execute();
                $rowcount = $statement->rowCount();
                return $rowcount;
        
        }
    }