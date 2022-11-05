<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);	

	if ($action == 'signup') {
		$module = 'registration-nct';
		require_once ("../modules-nct/registration-nct/class.registration-nct.php");

		$contentArray = array("module"=>$module);
		$objReg = new Registration($contentArray);
		$response = $objReg->submitRegistration($_REQUEST);
	}
	else if ($action == 'second_step') {
		if($user_id > 0){
			$module = 'second_step-nct';
			require_once ("../modules-nct/second_step-nct/class.second_step-nct.php");

			$contentArray = array("module"=>$module , 'userId'=>$user_id);
			$objReg = new second_step($contentArray);
			$response = $objReg->submitUserData($_REQUEST);
		}
		else {
			$response['status'] = false;
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}
$response['data']['language_id'] = $langId;
	echo json_encode($response);
