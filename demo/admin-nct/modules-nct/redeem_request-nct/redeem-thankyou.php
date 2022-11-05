<?php
require_once ("../../../includes-nct/config-nct.php");

if($_REQUEST){
	$db->pdoQuery("UPDATE tbl_redeem_requests SET paymentStatus = 'initiated' WHERE id = ?",array($_GET['id']));
	$_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'Payment status for this transaction is pending. Amount will be added to user paypal once completed.'));
    redirectPage(SITE_ADM_MOD.'redeem_request-nct/');

}
exit;
?>