<?php
    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/service_book-nct/class.service_book-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='service_book-nct';
	$pageNo = issetor($pageNo,1);
	$contentArray = array("module" =>$module,'userId'=>$user_id,'pageNo'=>$pageNo);
	$objsearch = new ServiceBook($contentArray);

	if ($_REQUEST['action'] == 'getVINDetails') {
		if($vin_number != ""){
			$response = $objsearch->getVINDetails($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'addServiceRecord') {
		if($description!="" && $vin_number!="" && $amount!="" && $service_date!=""){
			$response = $objsearch->addServiceRecord($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
	else if ($_REQUEST['action'] == 'getSearchResults') {
		if($vin_number != ""){
			$response = $objsearch->getSearchResults($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}

$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;