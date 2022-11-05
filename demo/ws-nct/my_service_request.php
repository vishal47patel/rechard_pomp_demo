<?php
    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/my_service_request-nct/class.my_service_request-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='my_service_request-nct';
	$pageNo = issetor($pageNo,1);

	$type = issetor($type);
	$contentArray = array("module"=>$module,'userId'=>$user_id,'pageNo'=>$pageNo,'type'=>$type);

	$objServiceReq = new MyServiceRequest($contentArray);

	if($_REQUEST['action'] == 'getMyServiceRequest'){
		if($user_id > 0){
			$response = $objServiceReq->getServiceReqList($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
$response['data']['language_id'] = $langId;
	echo json_encode($response);
	exit;