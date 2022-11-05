<?php
$reqAuth = false;
$module = 'login-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.login-nct.php";

if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) && (isset($_GET['action']) && $_GET['action'] == 'activation' && isset($_GET['emailVerifyCode']))){
	$msgType = $_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>WENT_WRONG));
	redirectPage(SITE_URL);
	exit;
}
else if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) && ($_REQUEST['verify'] != 'verify')){
	redirectPage(SITE_URL);
	exit;
}

extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),
	);
/*load script*/
$winTitle = WIN_LOGIN.' - ' . SITE_NM;

$headTitle = WIN_LOGIN.'' . SITE_NM;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

$contentArray = array("module"=>$module,"id"=>0,"token"=>issetor($token));

$obj = new Login($contentArray);

if (isset($_GET['action']) && $_GET['action'] == 'activation' && isset($_GET['emailVerifyCode'])) {
	if($sessUserId > 0){
	 $msgType =	$_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>WENT_WRONG));
		redirectPage(SITE_URL);
		exit;
	}
	$response = $obj->activateAccount(array('action'=>'activation','emailVerifyCode'=>$_GET['emailVerifyCode']));

 $msgType =	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['action']) && $_POST['action'] == 'forgot_password' && isset($_POST['reset_pwd'])) {

	$response = $obj->forgotPassword($_POST);

 $msgType =	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['action']) && $_POST['action'] == 'resend_verification' && isset($_POST['reset_pwd'])) {

	$response = $obj->resendVerificationMail($_POST);

 $msgType =	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

if(isset($_POST['sbtLogin'])){

	$response = $obj->submitLogin($_POST);
	//if($response['status'] == false){
	 $msgType =	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	//}

	if(isset($_GET['parentUrl']) && $_GET['parentUrl'] != '' ) {
		redirectPage($_GET['parentUrl']);
	}
	else {
		redirectPage($response['redirectLink']);
	}
}

$pageContent = $obj->getPageContent();

require_once DIR_TMPL . "parsing-nct.tpl.php";
?>