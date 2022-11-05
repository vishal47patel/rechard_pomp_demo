<?php
global $langId;
$langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

require_once("../includes-nct/config-nct.php");
require_once ("../modules-nct/payment_history-nct/class.payment_history-nct.php");

$response = array();
$response['status'] = false;
$response['message'] = WENT_WRONG;
extract($_REQUEST);
$module ='payment_history-nct';
$pageNo = issetor($pageNo,1);

$bookingId = issetor($bookingId,0);
$type = issetor($type);
$contentArray = array("module"=>$module,'userId'=>$user_id,'pageNo'=>$pageNo,'type'=>$type);

$objReview = new PaymentHistory($contentArray);

if($_REQUEST['action'] == 'getPaymentHistory'){
	if($user_id > 0){
		$response = $objReview->getPaymentHistory($_REQUEST);
	}else{
		$response['message'] = PLEASE_PROVIDE_VALID_DATA;
	}
}
$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;