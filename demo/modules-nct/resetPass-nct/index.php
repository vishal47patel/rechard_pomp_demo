<?php
$reqAuth = false;
$module = 'resetPass-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.resetPass-nct.php";
if(isset($_SESSION['user_id'])){
	redirectPage(SITE_URL);
}
extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD)
	);
/*load script*/

/*load js variable*/
$winTitle = RESET_PASSWORD . ' - ' . SITE_NM;

$headTitle = RESET_PASSWORD . SITE_NM;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['btnResetPwd'])) {
	$obj = new ResetPassword(array('module'=>$module,'id'=>$_POST['userId']));
	$response = $obj->submitResetPassword($_POST);
	
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}
else if (isset($_GET['action']) && $_GET['action'] == 'reset_password' && isset($_GET['activationCode']) && isset($_GET['userId'])) {

	$obj = new ResetPassword(array('module'=>$module,'id'=>base64_decode($_GET['userId'])));
	$response = $obj->resetPassword($_GET);	

	if(!$response['status']) {
		$_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>$response['message']));
		redirectPage($response['redirectLink']);
	}	
}

$pageContent = $obj->getPageContent();

require_once DIR_TMPL . "parsing-nct.tpl.php";
?>