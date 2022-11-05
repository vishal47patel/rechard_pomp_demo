<?php
    global $langId,$currId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	require_once ("../modules-nct/search-nct/class.search-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	$module ='search-nct';
	$pageNo = issetor($pageNo,1);
	$contentArray = array("module" =>$module,'userId'=>$user_id,'pageNo'=>$pageNo);
	$objsearch = new search($contentArray);

	if ($_REQUEST['action'] == 'getSearchProviders') {
		if($service_type != ""){
			$response = $objsearch->getSearchResults($_REQUEST);
		}else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
global $cSign;
$response['data']['language_id'] = $langId;
	echo json_encode($response);
	exit;