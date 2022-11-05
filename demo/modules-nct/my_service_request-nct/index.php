<?php
$reqAuth = true;
$module = 'my_service_request-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.my_service_request-nct.php";

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

$mainObj = new MyServiceRequest($requestArr);

$winTitle = MY_SERVICE_REQUEST.' - ' . SITE_NM;
$headTitle = MY_SERVICE_REQUEST;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ajaxPagination'){
	$response = $mainObj->getServiceReqList();
	$content = $response['retData']['html'];
	$pageContent = $response['retData']['pagination'];
	echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'pageContent'=>$pageContent,'success'=>true ));
	exit;
}

$pageContent = $mainObj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>