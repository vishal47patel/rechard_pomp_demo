<?php
    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/service_request-nct/class.service_request-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='service_request-nct';
	$contentArray = array("module" =>$module,'userId'=>$user_id);
	$objsearch = new service_request($contentArray);

	if ($_REQUEST['action'] == 'saveMechService') {
		if($service_time_slot != "" && $service_date != ""){
			$response = $objsearch->saveMechService($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'checkProviderAvailability') {
		if($service_time_slot != "" && $service_date != ""){
			$response = $objsearch->checkProviderAvailability($_REQUEST);
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
	else if ($_REQUEST['action'] == 'checkTaxiProvAvailability') {
		if($start_date != "" && $end_date != ""){
			$response = $objsearch->checkTaxiProvAvailability($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}

$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;