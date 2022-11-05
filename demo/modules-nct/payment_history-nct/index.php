<?php
$reqAuth = true;
$module = 'payment_history-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.payment_history-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),
	);

$table = "tbl_reviews";
$objPost = new stdClass();
$pageNo = issetor($pageNo,1);
$type = issetor($type);
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
$requestArr = array("module"=>$module,'pageNo'=>$pageNo,'type'=>$type,'action'=>$action);

$mainObj = new PaymentHistory($requestArr);

$winTitle = PAYMENT_HISTORY.' - ' . SITE_NM;
$headTitle = PAYMENT_HISTORY;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ajaxPagination'){
	$response = $mainObj->getPaymentHistory();
	$content = $response['retData']['html'];
	$pageContent = $response['retData']['pagination'];
	echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'pageContent'=>$pageContent,'success'=>true ));
	exit;
}

$pageContent = $mainObj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>