<?php
require_once("../../includes-nct/config-nct.php");

if($_POST){
	$toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'Payment is successfully done.'));
	redirectPage(ADMIN_URL . 'modules-nct/manage_ride_payments-nct/');
}
exit;
?>