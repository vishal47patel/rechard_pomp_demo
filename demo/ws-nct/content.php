<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

    require_once("../includes-nct/config-nct.php");
    require_once ("../modules-nct/content-nct/class.content-nct.php");

    $response = array();
    $response['status'] = false;
    $response['message'] = WENT_WRONG;
    extract($_REQUEST);
    $module ='content-nct';

    $contentArray = array("module" =>$module,'userId'=>$user_id);
    $objContent = new Content($contentArray);

    if($_REQUEST['action'] == 'getPageContent'){
       
        $_REQUEST['langId']=$langId;
        $response = $objContent->getContentDesc($_REQUEST);
    }
$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;