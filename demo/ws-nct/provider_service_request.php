<?php
    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/provider_added_request-nct/class.provider_added_request-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='provider_added_request-nct';
	$contentArray = array("module" =>$module,'userId'=>$user_id, 'customer_id'=>$customer_id);
	$objsearch = new service_request($contentArray);

	if ($_REQUEST['action'] == 'saveMechService') {
		if($service_time_slot != "" && $service_date != ""){
			$response = $objsearch->saveMechService($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	if ($_REQUEST['action'] == 'saveTaxiService') {
		if($start_date != "" && $end_date != ""){
			$response = $objsearch->saveTaxiService($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	if ($_REQUEST['action'] == 'getCustomerList') {	
		$_REQUEST['api_call'] = 'api_call';
		$response = $objsearch->getCustomerList($_REQUEST);
	}

$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;