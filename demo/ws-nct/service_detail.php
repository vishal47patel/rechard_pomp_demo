<?php
    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/service_detail-nct/class.service_detail-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='service_detail-nct';
	$contentArray = array("module" =>$module,'userId'=>$user_id,"request_id"=>$request_id);
	$obj = new service_detail($contentArray);

	if ($_REQUEST['action'] == 'getServiceDetails') {
		if($request_id != ""){
			$response = $obj->getPageContent();
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'startService') {
		if($request_id != ""){
			$response = $obj->startService($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'cancelService') {
		if($request_id != ""){
			$response = $obj->cancelService($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'completeService') {
		if($request_id != ""){
			$response = $obj->completeService($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'postReview') {
		if($request_id != ""){
			$response = $obj->postReview($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'saveAmount') {
		if($service_request_id != ""){
			$response = $obj->saveAmount($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'savePaymentMethod') {
		if($service_request_id != ""){
			$response = $obj->savePaymentMethod($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}

$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;