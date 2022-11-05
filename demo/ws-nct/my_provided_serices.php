<?php
    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/my_provided_services-nct/class.my_provided_services-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='my_provided_services-nct';
	$pageNo = issetor($pageNo,1);

	$bookingId = issetor($bookingId,0);
	$type = issetor($type);
	$contentArray = array("module"=>$module,'userId'=>$user_id,'pageNo'=>$pageNo,'bookingId'=>$bookingId,'type'=>$type);

	$objServices = new MyProvidedServices($contentArray);

	if($_REQUEST['action'] == 'getMyServices'){
		if($user_id > 0){
			$response = $objServices->getServiceList($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}else if($_REQUEST['action'] == 'addService'){
		if($user_id > 0){
			$response = $objServices->submitAddService($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}else if($_REQUEST['action'] == 'deleteService'){
		if($user_id > 0){
			$response = $objServices->deleteService($_REQUEST,'mobile');			
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
$response['data']['language_id'] = $langId;
	echo json_encode($response);
	exit;