<?php

namespace imdmedia\Feed;

use imdmedia\Data\DB;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

use Exception;

Configuration::instance([
        'cloud' => [
          'cloud_name' => 'dzhrxvqre',
          'api_key' => '387513213267173',
          'api_secret' => '1lBrjQy2GXP39NT1pwnvD1SxyKo'],
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

        public function upload()
        {
            $file = $this->file;
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
   
  
            if ($fileError === 0) {
                if ($fileSize < 1000000) {

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
            $statement = $conn->prepare("insert into posts (title, userid, tags, filePath, userName) values (:title, :userid, :tags, :filepath, :username)");
            $statement->bindValue(":title", $this->title);
            $statement->bindValue(":userid", $this->userid);
            $statement->bindValue(":tags", $this->tags);
            $statement->bindValue(":filepath", $this->filePath);
            $statement->bindValue(":username", $this->username);
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

        public static function getRowCount()
        {
            $conn = DB::getConnection();
            $result = $conn->query("select count(*) from posts;");
            return $result->fetchColumn();
        }
        public static function getPage($page)
        {
            $maxResults = 10;
            $conn = DB::getConnection();
            $result = $conn->query("select * from posts limit " . (($page - 1) * $maxResults) . ", 10;");
            return $result->fetchAll();
        }
    }
