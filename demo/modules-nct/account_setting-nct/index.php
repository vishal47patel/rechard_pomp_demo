<?php
$reqAuth = true;
$module = 'account_setting-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.account_setting-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(array($module.".js", SITE_JS_MOD));
/*load script*/



$winTitle = WIN_ACCOUNT_SETTING.' - ' . SITE_NM;
$headTitle = WIN_ACCOUNT_SETTING;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));
$requestArr = array('module'=>$module);
$obj = new AccountSetting($requestArr);

if(isset($_GET['action']) && $_GET['action'] == 'getMobileAppConfig'){
	echo "here";
	exit;
	$response = $obj->getMobileAppConfig();
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message'], ,'data'=>$response['data']));
	redirectPage($response['redirectLink']);
}

if(isset($_POST['action']) && $_POST['action'] == 'notiSettings' && isset($_POST['notification_type']) && $_POST['notification_type'] != '') {
	$response = $obj->submitEmailNotification($_POST);
	echo json_encode(array('type'=>$response['status'] == true ? 'success' : 'error' ,'message'=>$response['message']));exit;
}

if(isset($_POST['oldPwd']) && $_POST['oldPwd'] != '' && isset($_POST['method']) && $_POST['method'] == 'checkValidate') {
	if(isPasswordValid($sessUserId,$_POST['oldPwd'])){
		echo 'true';
	}else{
		echo 'false';
	}exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'changePassword'){
	$response = $obj->submitChangePassword($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

if(isset($_POST['action']) && $_POST['action'] == 'changeEmail'){
	$response = $obj->submitChangeEmail($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

if(isset($_POST['action']) && $_POST['action'] == 'changePaymentID'){
	$response = $obj->submitPaypalEmail($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'deleteAccount'){
	$response = $obj->deleteAccount();

	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
	exit;
}

/*if(isset($_POST['action']) && $_POST['action'] == 'changeMizutechDetails'){
	$response = $obj->changeMizutechDetails($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}
*/
$pageContent = $obj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>