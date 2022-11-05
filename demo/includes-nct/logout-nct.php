<?php
require_once("../includes/config.php");

if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
	/*unset($_SESSION["adminNctBlaUserId"]);*/
	unset($_SESSION["user_id"]);
	unset($_SESSION["sesspUserId"]);
	if(isset($_SESSION['logout']) && $_SESSION['logout']!="")
	{
	  redirectPage($_SESSION['logout']);
	}
	session_destroy();
	redirectPage(SITE_URL);
	$_SESSION["msgType"] = array('from'=>'admin','type'=>'suc','var'=>'succLogout');

}
redirectPage(SITE_URL);
?>
