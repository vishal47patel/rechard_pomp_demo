<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

    require_once("../includes-nct/config-nct.php");
    require_once ("../modules-nct/edit_profile-nct/class.edit_profile-nct.php");

    $response = array();
    $response['status'] = false;
    $response['message'] = WENT_WRONG;
    extract($_REQUEST);
    $module ='edit_profile-nct';
    $pageNo = issetor($pageNo,1);
    $contentArray = array("module" =>$module,'userId'=>$user_id,'pageNo'=>$pageNo);
    $objEditProfile = new edit_profile($contentArray);
	if ($_REQUEST['action'] == 'editAboutUs') {
		
        if($user_id > 0 && $about_us != ''){
            $response = $objEditProfile->submitUpdateAboutUs($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    if ($_REQUEST['action'] == 'editProfile') {

        if($user_id > 0){
            $response = $objEditProfile->submitUpdateProfile($_REQUEST,$_FILES);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    if ($_REQUEST['action'] == 'setAvailabilityById') {

        if($user_id > 0){
            $response = $objEditProfile->setAvailabilityById($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    if ($_REQUEST['action'] == 'setAvailability') {

        if($user_id > 0){
            $response = $objEditProfile->setAvailability($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    if ($_REQUEST['action'] == 'setManualAvailability') {

        if($user_id > 0){
            $response = $objEditProfile->setManualAvailability($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    if ($_REQUEST['action'] == 'setTaxiAvailability') {

        if($user_id > 0){
            $response = $objEditProfile->setTaxiAvailability($_REQUEST);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
	
$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;