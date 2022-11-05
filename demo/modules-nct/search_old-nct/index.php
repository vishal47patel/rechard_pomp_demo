<?php

$reqAuth = false;
$module = 'search-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.search-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
        array("jquery-ui.js",SITE_JS),
		array($module.".js", SITE_JS_MOD));
/*load script*/

$styles = array(
        array("jquery-ui.css",SITE_CSS));

$winTitle = WIN_SEARCH.' - ' . SITE_NM;
$headTitle = WIN_SEARCH;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

$pageNo = issetor($_REQUEST['pageNo'],1);
$requestArr = array('module' => $module , 'pageNo' => $pageNo);
$obj = new search($requestArr);

if(isset($_POST['action']) && ($_POST['action'] == 'getSearchResults')) {
    $response = array();
    $response = $obj->getSearchResults($_POST);
    $content = $response['retData']['html'];
    $pagination = $response['retData']['pagination'];
    echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'pagination'=>$pagination,'success'=>true ));
    exit;
}

$pageContent = $obj->getPageContent($_GET);
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>