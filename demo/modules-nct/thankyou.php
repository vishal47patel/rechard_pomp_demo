<?php
require_once("../includes-nct/config-nct.php");

if($_GET['platformType'] == 'app') {
	redirectPage(SITE_URL . '?action=success');
}
else {
	$_SESSION["msgType"] = disMessage(array('type'=>'suc','var'=> SERVICE_BOOKING_PAYMENT_suc));
	
	$result = $db->pdoQuery("SELECT * FROM tbl_users WHERE id = ?" , array($_REQUEST['user_id']))->result();
	
	extract($result);
	
	$_SESSION["user_id"] = $id;
	$_SESSION["first_name"] = $firstName;
	$_SESSION["last_name"] = $lastName;
	$_SESSION["user_type"] = $user_type;
	$_SESSION["service_type"] = $service_type;
	redirectPage(SITE_URL . 'my-service-request');
}

exit;
?>