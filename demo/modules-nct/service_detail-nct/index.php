<?php
$reqAuth = true;
$module = 'service_detail-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.service_detail-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),
		array("jquery.rateyo.min.js",SITE_JS),
	);
/*load script*/
$styles = array(
			array("jquery.rateyo.min.css",SITE_CSS)
		);


$winTitle = BOOKED_SERVICE_DETAIL.' - ' . SITE_NM;
$headTitle = BOOKED_SERVICE_DETAIL;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));
$request_id = (isset($_GET['request_id']) && ($_GET['request_id'] != '')) ? $_GET['request_id'] : 0;

$checkUser = $db->pdoQuery("SELECT id FROM tbl_service_requests WHERE customer_id = ? OR provider_id = ?" , array($sessUserId , $sessUserId))->affectedRows();

if($checkUser == 0) {
    $_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>WENT_WRONG));
    redirectPage(SITE_URL);
}

$requestArr = array('module'=>$module,'request_id'=>$request_id);
$obj = new service_detail($requestArr);


if (isset($_POST['action']) && $_POST['action'] == 'cancelService') {
    $response = $obj->cancelService($_POST);
    $_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    echo json_encode($response);
    exit;
}
else if (isset($_POST['action']) && $_POST['action'] == 'startService') {
    $response = $obj->startService($_POST);
    $_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    echo json_encode($response);
    exit;
}
else if (isset($_POST['action']) && $_POST['action'] == 'completeService') {
    $response = $obj->completeService($_POST);
    $_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    echo json_encode($response);
    exit;
}
else if (isset($_POST['action']) && $_POST['action'] == 'postReview') {
	$response = $obj->postReview($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    echo json_encode($response);
    exit;
}
else if (isset($_POST['addAmountBtn'])) {
    $response = $obj->saveAmount($_POST);
    $_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    redirectPage($response["redirectLink"]);
}
else if (isset($_POST['paymentMethod'])) {
    $response = $obj->savePaymentMethod($_POST);
    $_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    redirectPage($response["redirectLink"]);
}

$pageContent = $obj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>