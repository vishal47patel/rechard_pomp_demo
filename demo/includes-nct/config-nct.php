<?php

ob_start();
$one_day_second = 86400;
$month = 30;
$total_timeout = $one_day_second * $month;
$total_timeout = 120;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Set the maxlifetime of the session
// ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] . '/sessions');
// ini_set('session.gc_divisor', 100);
// ini_set( "session.gc_maxlifetime", $total_timeout );

session_start();
set_time_limit(0);

// check error_reporting() in database.php file

// session_set_cookie_params($total_timeout);
//session_name('NCT');
date_default_timezone_set('Asia/Kolkata');

$include_sharing_js = false;

$header_panel = true;
$footer_panel = true;
$styles = array();
$scripts = array();

$reqAuth = isset($reqAuth) ? $reqAuth : false;

$allowedUserType = isset($allowedUserType) ? $allowedUserType : 'a';


$adminUserId = (isset($_SESSION["adminNctBlaUserId"]) && $_SESSION["adminNctBlaUserId"] > 0 ? (int) $_SESSION["adminNctBlaUserId"] : 0);

$sessUserId = (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ? (int) $_SESSION["user_id"] : 0);
$sessFirstName = (isset($_SESSION["first_name"]) && $_SESSION["first_name"] != '' ? $_SESSION["first_name"] : NULL);
$sessLastName = (isset($_SESSION["last_name"]) && $_SESSION["last_name"] != '' ? $_SESSION["last_name"] : NULL);
$sessUserType = (isset($_SESSION["user_type"]) && $_SESSION["user_type"] != '' ? $_SESSION["user_type"] : '');

$toastr_message = isset($_SESSION["toastr_message"]) ? $_SESSION["toastr_message"] : NULL;
unset($_SESSION['toastr_message']);

global $sessRequestType;
$sessRequestType = $_SESSION["sessRequestType"] = (strpos($_SERVER['REQUEST_URI'], "ws-") !== false) ? "app" : "web";

global $lId,$cId;

if (isset($langId) && $langId > 0){
  $_SESSION['lId'] =  $lId = $langId;
}
else if(isset($_SESSION['lId']) && $_SESSION['lId'] > 0)
{
    $lId = $_SESSION['lId'];
}else{
    $lId = 1;
}


$memberId = isset($sessUserId)?$sessUserId : 0;
global $db, $helper, $fields, $module, $adminUserId, $sessUserId, $objHome, $main_temp, $breadcrumb, $Permission, $memberId;
global $head, $header, $left, $right, $footer, $content, $title, $resend_email_verification_popup,$old_error_handler,$css_array,$js_variables,$scripts,$styles;

//default language 1 for english
//default currency 149 for USD


$_SESSION["lId"] = $lId = (isset($_SESSION["lId"]) && $_SESSION["lId"] > 1 ? (int) $_SESSION["lId"] : $_SESSION["lId"] = 1);

if (strpos($_SERVER["SERVER_NAME"], 'localhost') !== false) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/autoservice_global_temp/install-nct/install_config.php');
} else {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/demo/install-nct/install_config.php');
}
define('SITENAME', $_SERVER['SERVER_NAME']);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";


if (strpos($_SERVER["SERVER_NAME"], 'localhost') !== false) {

    $rootfile = $_SERVER["DOCUMENT_ROOT"] . '/autoservice_global_temp/demo.txt';
    if (!file_exists($rootfile)) {
        header('Location: ' . $protocol . SITENAME . '/autoservice_global_temp/install');
        exit;
    }
} else {
    $rootfile = $_SERVER["DOCUMENT_ROOT"] . '/demo/demo.txt';
    if (!file_exists($rootfile)) {
        header('Location: ' . $protocol . SITENAME . '/install');
        exit;
    }
}

// error_reporting(0);

require_once('database-nct.php');


require_once('functions-nct/class.pdohelper.php');
require_once('functions-nct/class.pdowrapper.php');
require_once('functions-nct/class.pdowrapper-child.php');
require_once('mime_type_lib.php');

$dbConfig = array("host" => DB_HOST, "dbname" => DB_NAME, "username" => DB_USER, "password" => DB_PASS);
$db = new PdoWrapper($dbConfig);
if(ENVIRONMENT == 'd'){
    $db->setErrorLog(true);
}else{
    $db->setErrorLog(false);
}


if($sessUserId > 0){

    $getUserData = $db->select('tbl_users',array('defLanguage'),array('id'=>$sessUserId))->result();

    $userLanguage = isset($getUserData['defLanguage']) ? $getUserData['defLanguage'] : 1;

    $getlanguageId = $db->select('tbl_language',array('id'),array('id'=>$userLanguage,'status'=>'a'))->result();

    if($getlanguageId > 0){
        $_SESSION["lId"] = $lId = $getlanguageId['id'];
    }
}

$helper = new PDOHelper();

require_once('constant-nct.php');

require_once('functions-nct/functions-nct.php');

/*update_currency_rates();*/

if (file_exists(DIR_INC . 'language-nct/' . $lId . '.php')) {
    require_once DIR_INC . 'language-nct/' . $lId . '.php';
}else{

    $lId = $_SESSION["lId"] = 1;
    require_once DIR_INC . 'language-nct/1.php';
}
curPageURL();
curPageName();

checkIfIsActive();
Authentication($reqAuth, true, $allowedUserType);

require("class.main_template-nct.php");

$main = new MainTemplater();
$msgType = isset($_SESSION["msgType"])?$_SESSION["msgType"]:NULL;
unset($_SESSION['msgType']);

if (domain_details('dir') == 'admin-nct') {
    $left_panel = true;
    require_once(DIR_ADM_INC . 'functions-nct/admin-function-nct.php');

    require_once(DIR_ADM_MOD . 'home-nct/class.home-nct.php');
    $objHome = new Home($module, 0);
} else {

    require_once(DIR_MOD . 'home-nct/class.home-nct.php');
    $homeArr = array('module'=>'home-nct');
    $objHome = new Home($homeArr);
}

$objPost = new stdClass();

$description = SITE_NM;
$keywords = "";