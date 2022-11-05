<?php

	$reqAuth = true;
	require_once("../../../includes-nct/config-nct.php");
	include("class.manage_review-nct.php");
	$module = "manage_review-nct";
	$table = "tbl_product_reviews";

	$styles = array(array("data-tables/DT_bootstrap.css", SITE_ADM_PLUGIN),
	    array("bootstrap-switch/css/bootstrap-switch.min.css", SITE_ADM_PLUGIN),
	    array("jquery.rateyo.min.css", SITE_CSS));

	$scripts = array("core/datatable.js",
	    array("data-tables/jquery.dataTables.js", SITE_ADM_PLUGIN),
	    array("data-tables/DT_bootstrap.js", SITE_ADM_PLUGIN),
	    array("bootstrap-switch/js/bootstrap-switch.min.js", SITE_ADM_PLUGIN),
	    array("jquery.rateyo.min.js", SITE_JS));

	chkPermission($module);
	$Permission = chkModulePermission($module);

	$metaTag = getMetaTags(array("description" => "Admin Panel",
	    "keywords" => 'Admin Panel',
	    'author' => AUTHOR));

	$id = isset($_GET["id"]) ? (int) trim($_GET["id"]) : 0;
	$postType = isset($_POST["type"]) ? trim($_POST["type"]) : '';
	$type = isset($_GET["type"]) ? trim($_GET["type"]) : $postType;

	$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage') . ' Service Reviews';
	$winTitle = $headTitle . ' - ' . SITE_NM;
	$breadcrumb = array($headTitle);

	if(isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST") 
	{
		extract($_POST);
		if(in_array('edit',$Permission))
		{
			if(trim($description) != "") {
				$updateArr = array('description' => $description);
				$db->update("tbl_product_reviews", $updateArr, array("id"=>$id));

				$msgType = $_SESSION["msgType"] = disMessage(array('type'=>'suc','var'=>'recEdited'));
			}
			else {
				$msgType = $_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>'fillAllvalues'));
			}
		}	
	}

	$objTemplate = new Review($module);
	$pageContent = $objTemplate->getPageContent();
	require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");