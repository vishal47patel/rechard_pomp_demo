<?php
$reqAuth = true;
$module = 'my_received_reviews-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.my_received_reviews-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),
	);

$table = "tbl_services";
$objPost = new stdClass();
$pageNo = issetor($pageNo,1);
$type = issetor($type);
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
$requestArr = array("module"=>$module,'pageNo'=>$pageNo,'type'=>$type,'action'=>$action);

$mainObj = new MyReceivedReviews($requestArr);

$winTitle = MY_REC_REVIEWS.' - ' . SITE_NM;
$headTitle = MY_REC_REVIEWS;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

if(isset($_POST['action']) && $_POST['action'] == 'add_review_reply'){

	$response = $mainObj->submitReviewReply($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ajaxPagination'){
	$response = $mainObj->getReviewList();
	$content = $response['retData']['html'];
	$pageContent = $response['retData']['pagination'];
	echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'pageContent'=>$pageContent,'success'=>true ));
	exit;
}

$pageContent = $mainObj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>