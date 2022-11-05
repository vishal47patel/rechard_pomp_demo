<?php
$reqAuth = true;
$module = 'provider_added_request-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.provider_added_request-nct.php";

extract($_REQUEST);


/*load script*/
$scripts = array(
                array("bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js",SITE_PLUGIN),
                array("clockpicker/src/clockpicker.js",SITE_PLUGIN),
		array("nct-js.js",SITE_JS),                
		array($module.".js", SITE_JS_MOD),
		);

/*load script*/
$styles = array(
                array("bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.css",SITE_PLUGIN),
                array("clockpicker/src/clockpicker.css",SITE_PLUGIN),
                );

$winTitle = SERVICE_REQUEST.' - ' . SITE_NM;

$headTitle = SERVICE_REQUEST.'' . SITE_NM;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

$customer_id = (isset($_GET['customer_id']) && ($_GET['customer_id'] != '')) ? $_GET['customer_id'] : 0;

$contentArray = array("module"=>$module,"id"=>0,"token"=>issetor($token),"customer_id" => $customer_id);
$obj = new service_request($contentArray);

if(isset($_POST['action']) && $_POST['action'] == 'checkProviderAvailability')
{
        $response = $obj->checkProviderAvailability($_POST);
        echo json_encode($response['data']);
        exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'checkTaxiProvAvailability')
{
        $response = $obj->checkTaxiProvAvailability($_POST);
        echo json_encode($response['data']);
        exit;
}

if($_POST['action'] == 'saveMechService'){
	$response = $obj->saveMechService($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

if($_POST['action'] == 'saveTaxiService'){
	// echo "here";
	// exit;
	$response = $obj->saveTaxiService($_POST);
	// print_r($response);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

$pageContent = $obj->getPageContent();

require_once DIR_TMPL . "parsing-nct.tpl.php";
?>