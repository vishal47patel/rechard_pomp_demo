<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

    require_once("../includes-nct/config-nct.php");
    require_once ("../modules-nct/message-nct/class.message-nct.php");

    $response = array();
    $response['status'] = false;
    $response['message'] = WENT_WRONG;
    extract($_REQUEST);
    $module ='message-nct';
    $pageNo = issetor($pageNo,1);
    $receiverId = issetor($receiverId,0);
    $searchName = issetor($searchName);
    $contentArray = array("module" =>$module,'userId'=>$user_id,'searchName'=>$searchName,'pageNo'=>$pageNo,'receiverId'=>$receiverId);
    $objmessage = new Message($contentArray);

    if ($_REQUEST['action'] == 'getUserList') {
        if($user_id != ""){
            $response = $objmessage->getLeftPanel($_REQUEST['tabType']);
        }else{
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if ($_REQUEST['action'] == 'getConversation') {
        if($user_id != ""){
            $response = $objmessage->getMessages($_REQUEST['tabType']);
        }else{
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if($_REQUEST['action'] == 'deleteMessage'){
        if($user_id > 0){
            $response = $objmessage->deleteMessage();
        }else{
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if($_REQUEST['action'] == 'sendMessage'){
        if($user_id > 0){
            $response = $objmessage->sendMessage($_REQUEST);
        }else{
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if($_REQUEST['action'] == 'getNewUser'){
        if($user_id > 0){
            $response = $objmessage->getNewUser($_REQUEST);
        }else{
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if ($_REQUEST['action'] == 'getLastMsg') {
        if($user_id != ""){
            $response = $objmessage->getLastMsg($_REQUEST);
        }else{
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }

$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;