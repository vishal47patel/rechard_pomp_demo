<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/login-nct/class.login-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='login-nct';

	$contentArray = array("module" =>$module);
	$objLogin = new Login($contentArray);
	if ($_REQUEST['action'] == 'login') {
		if($device_id != ''){
			$response = $objLogin->submitLogin($_REQUEST);
			if($response['status'] == true){
				manageDeviceId($response['data']['id'],$device_id);
			}
		}else{
			$response['status'] = false;
			$response['message'] = NO_DEVICE_ID_FOUND;
		}

	}else if($action == 'logout'){
		if($device_id != '' && $user_id > 0){
			$affRows = $db->pdoQuery("SELECT id FROM tbl_users_tokens WHERE userId = ? AND device_id = ?",array($user_id,$device_id))->affectedRows();
			if($affRows>0){
				$db->query("UPDATE tbl_users_tokens SET isLoggedIn = 'n',updatedDate = '".date('Y-m-d H:i:s')."' WHERE userId = '".$user_id."' AND device_id ='".$device_id."'");
			}
			$response['status'] = true;
			$response['message'] = SUC_LOG_OUT;
		}else {
			$response['status'] = false;
			$response['message'] = WENT_WRONG;
		}
	}else if($action == 'forgotPassword'){
		if($email != ""){
			$response = $objLogin->forgotPassword($_REQUEST);
		}else{
			$response['status'] = false;
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}else if($action == 'resendVerificationMail'){
		if($email != ""){
			$response = $objLogin->resendVerificationMail($_REQUEST);
		}else{
			$response['status'] = false;
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}

$response['data']['language_id'] = $langId;

echo json_encode($response);
exit;