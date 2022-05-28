<?php

use imdmedia\Data\Report;
require dirname(__DIR__, 1) . "/vendor/autoload.php";

if(!empty($_POST)) {

    $report = new Report();
    $report->setReporting_user($_POST['reportingUser']);
    $report->setReported_user($_POST['reportedUser']);

    if($_POST['report'] == "0") {
        $report->reportUser();
        $response = [
            'status' => 'success',
            'body' => '1',
            'message' => 'You succesfully reported this user.'
        ];
    } else if ($_POST['report'] == "1") {
        $report->unreportUser();
        $response = [
            'status' => 'success',
            'body' => '0',
            'message' => 'You succesfully removed your report.'
        ];
    }

    echo json_encode($response);



}