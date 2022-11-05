<?php
$reqAuth = true;
$module = 'second_step-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.second_step-nct.php";

$isCompleted = getTableValue("tbl_users" , "second_step_complete" , array("id" => $sessUserId));

if($isCompleted == 'y') {
	$_SESSION["msgType"] = disMessage(array('type'=> 'err','var'=>WENT_WRONG));
	redirectPage(SITE_URL);
}

extract($_REQUEST);

/*load script*/
$scripts = array(
        	array("cropper.min.js", SITE_JS),
        	array($module.".js", SITE_JS_MOD));
/*load script*/
$styles = array(
		array("cropper.min.css", SITE_CSS));


$winTitle = AFTER_REGISTRATION.' - ' . SITE_NM;
$headTitle = AFTER_REGISTRATION;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));
$contentArray = array('module'=>$module);
$obj = new second_step($contentArray);

if(isset($_POST['btnSecondStep'])){
	$response = $obj->submitUserData($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);exit;
}

$pageContent = $obj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>