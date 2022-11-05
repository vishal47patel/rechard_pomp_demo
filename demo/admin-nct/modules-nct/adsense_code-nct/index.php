<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
require_once("class.adsense_code-nct.php");

$objPost = new stdClass();

$winTitle = 'Google AdSense Code - ' . SITE_NM;
$headTitle = 'Google AdSense Code';
$metaTag = getMetaTags(array("description" => "Admin Panel",
    "keywords" => 'Admin Panel',
    'author' => AUTHOR));

$module = 'adsense_code-nct';
$breadcrumb = array($headTitle);
chkPermission($module);

extract($_POST);

$objPost->adsense_code    = isset($adsense_code) ? $adsense_code : '';

$objUser = new AdsenseCode();

if (isset($_POST["submitChange"])) {

    if ($objPost->adsense_code != "") {
        $db->update("tbl_googleadsense_code" , array("adsense_code" => $objPost->adsense_code) , array("id" => "1"));

        $_SESSION["toastr_message"] = disMessage(array('from' => 'admin', 'type' => 'suc', 'var' => 'Google adsense code updated successfully.'));
        redirectPage(SITE_ADM_MOD . $module);
    }
}

$pageContent = $objUser->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");

?>