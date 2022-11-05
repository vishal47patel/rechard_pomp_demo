<?php
    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/new_service_request-nct/class.new_service_request-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='new_service_request-nct';
	$pageNo = issetor($pageNo,1);

	$type = issetor($type);
	$contentArray = array("module"=>$module,'userId'=>$user_id,'pageNo'=>$pageNo,'type'=>$type);

	$objServiceReq = new NewServiceRequest($contentArray);

	if($_REQUEST['action'] == 'getNewServiceRequest'){
		if($user_id > 0){
			$response = $objServiceReq->getServiceReqList($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}else if($_REQUEST['action'] == 'acceptRejectRequest'){
		if($user_id > 0){
			$response = $objServiceReq->acceptRejectRequest($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
$response['data']['language_id'] = $langId;
	echo json_encode($response);
	exit;