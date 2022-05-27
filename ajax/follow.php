<?php

use imdmedia\Data\Follow;
require dirname(__DIR__, 1) . "/vendor/autoload.php";

if(!empty($_POST)) {

    $follow = new Follow();
    $follow->setFollowing_user($_POST['followingUser']);
    $follow->setFollowed_user($_POST['followedUser']);

    if($_POST['follow'] == "0") {
        $follow->followUser();
        $response = [
            'status' => 'success',
            'body' => '1',
            'message' => 'You are now following this user.'
        ];
    } else if ($_POST['follow'] == "1") {
        $follow->unfollowUser();
        $response = [
            'status' => 'success',
            'body' => '0',
            'message' => 'You are no longer following this user.'
        ];
    }

    echo json_encode($response);



}