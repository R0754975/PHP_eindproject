<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
use imdmedia\Feed\ReportPost;

if(!empty($_POST)){
    $postId = $_POST["postId"];
    $userId = $_POST["userId"];

    $reportItem = new ReportPost();
    $reportItem->setPostId($postId);
    $reportItem->setUserId($userId);

    try{
        $check = ReportPost::reportCheck($postId, $userId);
        if($check){

            ReportPost::deleteReport($postId, $userId);

            $response = [
                "status" => "success",
                "message" =>"Dereport was successful"
            ];
        }else{
            $reportItem->save();
                $response = [
                    "status" => "success",
                    "message" => "report was successful"
                ];    
            }; //active report (saven en deleten)
            

    }catch(Throwable $e){
        $response = [
            "status" => "error",
            "message" => "report failed"
        ];
    }

    echo json_encode($response); //$repsonse array omzetten in json
}