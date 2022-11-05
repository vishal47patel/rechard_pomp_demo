<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;
    
    require_once("../includes-nct/config-nct.php");
    require_once ("../modules-nct/account_setting-nct/class.account_setting-nct.php");

    $response = array();
    $response['status'] = false;
    $response['message'] = WENT_WRONG;
    extract($_REQUEST);
    $module ='account_setting-nct';

    $contentArray = array("module" =>$module,'userId'=>$user_id);
    $objAccSett = new AccountSetting($contentArray);

    if ($_REQUEST['action'] == 'changePassword') {
		// echo "here";
		// die();
        if($user_id > 0){
            $response = $objAccSett->submitChangePassword($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }

    }else if ($_REQUEST['action'] == 'changeEmail'){
        if($user_id > 0){
            $response = $objAccSett->submitChangeEmail($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if ($_REQUEST['action'] == 'changePaypalEmail'){
        if($user_id > 0){
            $response = $objAccSett->submitPaypalEmail($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if($action  == 'getNotificationData'){
        if($user_id > 0){
            $response = $objAccSett->getEmailNotificationList($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if($action  == 'setNotificationData'){
        if($user_id > 0){
            $response = $objAccSett->submitEmailNotification($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
        /*if($user_id > 0){
            foreach ($arrNotification as $key => $value) {
                $notiArr = array($key => $value);
                $db->update("tbl_email_notification_setting", $notiArr, array("userId"=>$user_id));
            }
            $response['status'] = true;
            $response['message'] = EMAIL_NOTI_CHANGED;
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }*/
    }else if($action  == 'deleteAccount'){
        if($user_id > 0){
            $response = $objAccSett->deleteAccount($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    else if ($_REQUEST['action'] == 'changeMizutechDetails'){
        if($user_id > 0 && $mizutech_name != "" && $mizutech_pwd != ""){
            $response = $objAccSett->changeMizutechDetails($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }	
	else if ($_REQUEST['action'] == 'getCompanyDetatil'){		
		$response = $objAccSett->getCompanyDetatil($_REQUEST);
		// echo $response;        
    }

$response['language_id'] = $langId;
echo json_encode($response);
exit;