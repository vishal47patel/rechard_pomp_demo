<?php

$module = 'contact_us-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.contact_us-nct.php";


extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),
	);
/*load script*/

$winTitle = CONTACT_US.' - ' . SITE_NM;

$headTitle = CONTACT_US.'' . SITE_NM;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

$contentArray = array("module"=>$module,"id"=>0,"token"=>issetor($token));

$obj = new contact_us($contentArray);


$pageContent = $obj->getPageContent();

require_once DIR_TMPL . "parsing-nct.tpl.php";
?>