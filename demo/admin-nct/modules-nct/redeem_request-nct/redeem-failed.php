<?php

require_once ("../../../includes-nct/config-nct.php");

$_SESSION["toastr_message"] = disMessage(array('type'=>'err','var'=>'Transaction failed.'));
redirectPage(SITE_ADM_MOD.'redeem_request-nct/');

exit;
?>