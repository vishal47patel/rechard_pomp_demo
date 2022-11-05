<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/profile-nct/class.profile-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module = 'profile-nct';
	$otherUserId = (isset($otherUserId) && $otherUserId > 0 ? $otherUserId : 0);
	$contentArray = array('module'=>$module,'userId'=>$user_id,'otherUserId'=>$otherUserId);

	$objUser = new profile($contentArray);

	if(!isUserExist($user_id)){
		$response['status'] = false;
		$response['message'] = "User not Found.";
	}else if ($_REQUEST['action'] == 'getDetail') {

		if($user_id > 0 && $otherUserId > 0){

			$user_type = getTableValue("tbl_users","user_type",array("id"=>$otherUserId));

			if($user_type=='provider'){
				$data = $objUser->getProviderDetails();
			}else{
				$data = $objUser->getCustomerDetails();
			}
			
			$response['status'] = true;
			$response['message'] = "success";
			$response['data'] = $data;
		}else{
			$response['status'] = false;
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
    else  if ($_REQUEST['action'] == 'changeAvailability') {
        
        if($user_id > 0){
            $data = $objUser->changeAvailability($_POST);
            $response['status'] = true;
			$response['message'] = "success";
			$response['data'] = $data;
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    else  if ($_REQUEST['action'] == 'addStatus') {
        
        if($user_id > 0){
            $response = $objUser->addStatus($_POST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    else  if ($_REQUEST['action'] == 'addOpeningHours') {
        
        if($user_id > 0){
            $response = $objUser->addOpeningHours($_POST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if ($_REQUEST['action'] == 'updateService') {

		if($user_id > 0 && $service_name != '' && $service_id > 0){
			$data = '';
			$service_user_id = getTableValue("tbl_services","provider_id",array("id"=>$service_id));
			$service_type = getTableValue("tbl_users","service_type",array("id"=>$user_id));

			if($service_type=='mechanic' && $service_user_id == $user_id){
				$response = $objUser->setUpdateService($_REQUEST);
				
			}else{
				$response['status'] = false;
				$response['data'] = array();
				$response['message'] = PLEASE_PROVIDE_VALID_DATA;
			}			
			
		}else{
			$response['status'] = false;
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
			$response['data'] = array();
		}
	}
$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;
