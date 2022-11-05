<?php

$reqAuth = true;
$analytic_total_views = 0;
require_once("../../../includes-nct/config-nct.php");

$module = "home-nct";
$page_name = "home";

$winTitle = 'Welcome to Admin Panel - ' . SITE_NM;
$headTitle = 'Welcome to Admin Panel';

$styles = '';

$scripts = '';

$scripts = array("custom/charts.js",
    array("flot/jquery.flot.min.js", SITE_ADM_PLUGIN),
    array("flot/jquery.flot.resize.min.js", SITE_ADM_PLUGIN),
    array("flot/jquery.flot.pie.min.js", SITE_ADM_PLUGIN),
    array("flot/jquery.flot.stack.min.js", SITE_ADM_PLUGIN),
    array("flot/jquery.flot.crosshair.min.js", SITE_ADM_PLUGIN),
    array("flot/jquery.flot.categories.min.js", SITE_ADM_PLUGIN),
    array("flot/jquery.flot.time.min.js", SITE_ADM_PLUGIN),
    array("flot/jquery.flot.grow.js", SITE_ADM_PLUGIN),
    array("flot/plugins/jquery_flot_animator/jquery.flot.animator.min.js", SITE_ADM_PLUGIN));

$metaTag = getMetaTags(array("description" => "Admin Panel",
    "keywords" => 'Admin Panel',
    'author' => AUTHOR));

$breadcrumb = array("Dashboard");

$mainObj = new Home();
$mainContent = $mainObj->index();
$pageContent = $mainObj->getPageContent();

require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
