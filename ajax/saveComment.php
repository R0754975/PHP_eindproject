<?php

    use imdmedia\Feed\Comment;
    use imdmedia\Auth\User;
    require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
    session_start();

    if(!empty($_POST)) {

        $username = User::getUserbyId($_SESSION['user']['id']);

        $comment = new Comment();
        $comment->setComment($_POST['comment']);
        $comment->setPostId($_POST['postId']);
        $comment->setUserId($_SESSION['user']['id']);

        $comment->save();

        $response = [
            'status' => 'success',
            'username' => htmlspecialchars($username['username']),
            'body' => htmlspecialchars($comment->getComment()),
            'message' => 'Comment saved'
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);

    }