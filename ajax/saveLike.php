<?php

use imdmedia\Feed\Like;
require dirname(__DIR__, 1) . "/vendor/autoload.php";
session_start();

if(!empty($_POST)) {

    $like = new Like();
    $like->setPostId($_POST['postId']);
    $like->setUserId($_SESSION['user']['id']);
    
    $liked = Like::checkLiked($_SESSION['user']['id'], $_POST['postId']);

    if($liked == "0") {
        $like->saveLike();
        $totalLikes = Like::getAll($_POST['postId']);
        $response = [
            'status' => 'success',
            'body' => '1',
            'likes' => htmlspecialchars($totalLikes),
            'message' => 'You are now like this post.'
        ];
    } else if ($liked == "1") {
        $like->unLike();
        $totalLikes = Like::getAll($_POST['postId']);
        $response = [
            'status' => 'success',
            'body' => '0',
            'likes' => htmlspecialchars($totalLikes),
            'message' => 'You are no longer like this post.'
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);



}