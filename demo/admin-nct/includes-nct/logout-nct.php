<?php
require_once("../../includes-nct/config-nct.php");
if(isset($_SESSION["adminNctBlaUserId"]) && $_SESSION["adminNctBlaUserId"] != "") {

	unset($_SESSION["adminNctBlaUserId"]);
	unset($_SESSION["sessCataId"]);
	$_SESSION["sessCataId"] = $_SESSION["adminNctBlaUserId"] = '';
	$toastr_message = array('from'=>'admin','type'=>'suc','var'=>'succLogout');
	/*$qry = "UPDATE tbl_admin SET where uName = ?";
	$db->pdoQuery(array('admin'));	*/
	//$db->update("tbl_admin",array("sess_id "=>0),array("id"=>$_SESSION["adminNctBlaUserId"]));
}
redirectPage(SITE_ADM_MOD.'login-nct/');
?>
