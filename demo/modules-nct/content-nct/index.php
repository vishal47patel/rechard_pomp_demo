<?php


	$reqAuth = false;
	$module = 'content-nct';
	require_once "../../includes-nct/config-nct.php";
	require_once "class.content-nct.php";
	/*error_reporting(E_ALL);*/
 	$slug = isset($_GET["slug"]) ? $_GET["slug"] : 0;
 	$result = $db->select("tbl_content", array("*"), array("page_slug" => $slug));
	if ($result->affectedRows() == 0) {
		$_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>MSG_NO_PAGE_FOUND));
        redirectPage(SITE_URL);
	} else {
		$result = $result->result();
	}
	$table = "tbl_content";
	$objPost = new stdClass();
	$mainObj = new Content($module, $result['pId']);

	$winTitle = $result['pageTitle_'.$lId].' - ' . SITE_NM;
    $headTitle = $result['pageTitle_'.$lId];
    $metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

	$pageContent = $mainObj->getPageContent();
	require_once DIR_TMPL . "parsing-nct.tpl.php";
?>