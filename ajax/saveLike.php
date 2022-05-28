<?php
use imdmedia\Feed\Like;

    if(!empty($_POST)){
        $c = new Like();

        $c->setPostId($_GET['Post']);

        $c->setUserId(session_id());

        $c->save();

        $response = [
            'status' => 'succes',
            'message' => 'Like saved'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

?>