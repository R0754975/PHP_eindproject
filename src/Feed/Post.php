<?php

namespace imdmedia\Feed;

use imdmedia\Data\DB;
use imdmedia\Feed\Comment;
use imdmedia\Feed\Like;
use imdmedia\Data\Config;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use PDO;
use Exception;

$config = Config::getConfig();

Configuration::instance([
    'cloud' => [
      'cloud_name' => $config['cloud_name'],
      'api_key' => $config['api_key'],
      'api_secret' => $config['api_secret']],
    'url' => [
      'secure' => true]]);

    class Post
    {
        private $title;
        private $userid;
        private $username;
        private $tags;
        private $filePath;
        private $file;
        private $search;
        private $description;

        public function getTitle()
        {
            return $this->title;
        }

        public function setTitle($title)
        {
            if (empty($title)) {
                throw new Exception("Your post must have a title");
            }
            $this->title = $title;

            return $this;
        }

        public function getUserid()
        {
            return $this->userid;
        }

        public function setUserid($userid)
        {
            $this->userid = $userid;

            return $this;
        }

        public function getTags()
        {
            return $this->tags;
        }

        public function setTags($tags)
        {
            $tags = str_replace(' ', '', $tags);
            $tags = explode(',', $tags);
            $this->tags = json_encode($tags);
            return $this;
        }

        public function getFilePath()
        {
            return $this->filePath;
        }


        public function setFilePath($filePath)
        {
            $this->filePath = $filePath;

            return $this;
        }

        public function getFile()
        {
            return $this->file;
        }

        public function setFile($file)
        {
            $this->file = $file;

            return $this;
        }

        public function getUsername()
        {
            return $this->username;
        }

        public function setUsername($username)
        {
            $this->username = $username;

            return $this;
        }

        public function getDescription()
        {
                return $this->description;
        }

        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        public function upload()
        {
            $file = $this->file;
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
   
  
            if ($fileError === 0) {
                if ($fileSize < 5000000) {

                            //uploads file to cloudinary
                    $cloudinary = (new uploadApi())->upload(
                        $fileTmpName,
                        [
                                'folder' => 'Posts/',
                                "format" => "webp",
                                ]
                    );
                    //stores the new url in the class
                    $this->setFilePath($cloudinary['url']);
                } else {
                    throw new Exception("Your file is too big!");
                }
            } else {
                throw new Exception("There was an error uploading your file!");
            }
        }
        public function save()
        {
            $conn = DB::getConnection();
            $statement = $conn->prepare("insert into posts (title, userid, tags, filePath, userName, description) values (:title, :userid, :tags, :filepath, :username, :description)");
            $statement->bindValue(":title", $this->title);
            $statement->bindValue(":userid", $this->userid);
            $statement->bindValue(":tags", $this->tags);
            $statement->bindValue(":filepath", $this->filePath);
            $statement->bindValue(":username", $this->username);
            $statement->bindValue(":description", $this->description);
            return $statement->execute();
        }
        
        public function delete()
        {
            $conn = DB::getConnection();
            $statement = $conn->prepare("delete from posts where filePath = :filepath");
            $statement->bindValue(":filepath", $this->filePath);
            return $statement->execute();
        }

        public static function getAll()
        {
            $conn = DB::getConnection();
            $result = $conn->query("select * from posts;");
            return $result->fetchAll();
        }

        public function getSearch()
        {
            return $this->search;
        }

        public function setSearch($search)
        {
            $this->search = $search;

            return $this;
        }

        public static function searchAll($search)
        {
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from posts where title like :keyword or tags like :keyword");
            //$result = $conn->query("select * from posts where title like concat('%', :searchValue , '%');");
            $statement->bindValue(":keyword", "%" . $search . "%");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getRowCount()
        {
            $conn = DB::getConnection();
            $result = $conn->query("select count(*) from posts;");
            return $result->fetchColumn();
        }
        public static function getPage($page)
        {
            $conn = DB::getConnection();
            $result = $conn->prepare("select * from posts limit :page , 10;");
            $result->bindValue(":page", $page, PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll();
        }

        public static function getPostById($postId){
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from posts where id = :id");
            $statement->bindValue(':id', $postId);
            $statement->execute();
            return $statement->fetch();
        }

        public static function getPostByTags($postTags){
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from posts where tags like :tags");
            $statement->bindValue(':tags', "%" . $postTags ."%");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }
        public static function getDetailPostsByTags($postTags, $postId){
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from posts where tags like :tags and id != :id limit 4");
            $statement->bindValue(':tags', "%" . $postTags ."%");
            $statement->bindValue(':id', $postId);
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function deletePostById($postId){
            $conn = DB::getConnection();
            Comment::deletePostComments($postId);
            Like::deletePostLikes($postId);
            $statement = $conn->prepare("delete from posts where id like :id");
            $statement->bindValue(':id', $postId);
            return $statement->execute();
        }

        public function changeTitle($title, $postId){
            $conn = DB::getConnection();
            $statement = $conn->prepare("UPDATE posts SET title = :title where id = :id");
            $statement->bindValue(':title',  $title);
            $statement->bindValue(':id', $postId);
            $_SESSION["post"]["title"] = $title;
            return $statement->execute();
        }

        public function changeTag($postId){
            $conn = DB::getConnection();
            $statement = $conn->prepare("UPDATE posts SET tags = :tags where id = :id");
            $statement->bindValue(':tags', $this->tags);
            $statement->bindValue(':id', $postId);
            $_SESSION["post"]["tags"] = $this->tags;
            return $statement->execute();
        }

        public static function getAllUserPosts($user) {
            $conn = DB::getConnection();
            $statement = $conn->prepare("select * from posts where userid = :userid");
            $statement->bindValue(':userid', $user);
            $statement->execute();
            return $statement->fetchAll();
        }

    }
