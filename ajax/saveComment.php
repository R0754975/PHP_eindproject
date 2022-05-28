<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
use imdmedia\Feed\Comment;

    if(!empty($_POST)){
        $c = new Comment();

        $c->setPostId($_GET['Post']);

        $c->setMessage($_POST['message']);

        $c->setUserId(1);

        $c->save();

        $response = [
            'status' => 'succes',
            'body' => 'test',
            'message' => 'Comment saved'
        ];

        
        echo json_encode($response);
    }

?>