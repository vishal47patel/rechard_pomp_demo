<?php
$module = 'logout-nct';
require_once "../../includes-nct/config-nct.php";
 
if ($sessUserId > 0) {
	unset($_SESSION["user_id"]);
	unset($_SESSION["first_name"]);
	unset($_SESSION["last_name"]);
	unset($_SESSION["user_type"]);
	unset($_SESSION["service_type"]);
	unset($_SESSION["login_time"]);
}

$response = $db->pdoQuery("SELECT mizutech_name , mizutech_pwd FROM tbl_users WHERE id = " . $sessUserId)->result();

if(($response['mizutech_name'] != "") && ($response['mizutech_pwd'] != "")) {
	$_SESSION["isLogout"] = "y";
}

redirectPage(SITE_URL);
?>
