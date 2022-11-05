<?php
require_once("../includes-nct/config-nct.php");

$updArray = array(									
				'payment_status' => 'pending'
			);

$db->update('tbl_service_requests' , $updArray , array("id" => $request["service_request_id"]));

if($_GET['platformType'] == 'app') {
	redirectPage(SITE_URL . '?action=cancel');
}
else {
	$_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>SERVICE_BOOKING_PAYMENT_FAILED));
	redirectPage(SITE_URL . 'my-service-request');
}

exit;
?>