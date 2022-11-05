<?php

$reqAuth = false;
$module = 'service_book-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.service_book-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(
        array("bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js",SITE_PLUGIN),
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD));
/*load script*/

$styles = array(
        array("bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.css",SITE_PLUGIN),
        //array("dev_style-nct.css",SITE_CSS),
            );

$winTitle = SERVICE_BOOK_DETAIL.' - ' . SITE_NM;
$headTitle = SERVICE_BOOK_DETAIL;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

$pageNo = issetor($_REQUEST['pageNo'],1);
$requestArr = array('module' => $module , 'pageNo' => $pageNo);
$obj = new ServiceBook($requestArr);

if(isset($_POST['action']) && ($_POST['action'] == 'getSearchResults')) {
    $response = array();
    $response = $obj->getSearchResults($_POST);
    $content = $response['retData']['html'];
    $pagination = $response['retData']['pagination'];
    echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'pagination'=>$pagination,'success'=>true ));
    exit;
}
else if(isset($_POST['action']) && ($_POST['action'] == 'getVINDetails')) {
    $response = array();
    $response = $obj->getVINDetails($_POST);
    $content = $response['retData']['html'];
    echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'success'=>true ));
    exit;
}
else if(isset($_POST['action']) && $_POST['action'] == 'addServiceRecord'){

    $response = $obj->addServiceRecord($_POST);
    $_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    redirectPage($response['redirectLink']);
}

$pageContent = $obj->getPageContent($_GET);
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>