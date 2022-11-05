<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
include("class.contactus-nct.php");
$module = "contactus-nct";
$table = "tbl_contact_us";

$styles = array(array("data-tables/DT_bootstrap.css", SITE_ADM_PLUGIN),
    array("bootstrap-switch/css/bootstrap-switch.min.css", SITE_ADM_PLUGIN));

$scripts = array("core/datatable.js",
    array("data-tables/jquery.dataTables.js", SITE_ADM_PLUGIN),
    array("data-tables/DT_bootstrap.js", SITE_ADM_PLUGIN),
    array("bootstrap-switch/js/bootstrap-switch.min.js", SITE_ADM_PLUGIN));

chkPermission($module);
$Permission = chkModulePermission($module);

$metaTag = getMetaTags(array("description" => "Admin Panel",
    "keywords" => 'Admin Panel',
    'author' => AUTHOR));

$id = isset($_GET["id"]) ? (int) trim($_GET["id"]) : 0;
$postType = isset($_POST["type"]) ? trim($_POST["type"]) : '';
$type = isset($_GET["type"]) ? trim($_GET["type"]) : $postType;

$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage') . ' Contact Us';
$winTitle = $headTitle . ' - ' . SITE_NM;
$breadcrumb = array($headTitle);

if (isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    /*$objPost->firstName     = isset($firstName) ? filtering($firstName, 'input') : '';
    $objPost->lastName      = isset($lastName) ? filtering($lastName, 'input', 'text') : '';
    $objPost->message       = isset($message) ? filtering($message, 'input') : '';*/
    $objPost->replayMessage = isset($replayMessage) ? filtering($replayMessage, 'input') : '';
    //$objPost->email         = isset($email) ? filtering($email, 'input') : '';

    if ($type == 'edit' && $id > 0) {
         if (in_array('reply', $Permission)) {
            $db->update($table,(array)$objPost, array("id" => $id));

            $details = $db->pdoQuery("SELECT * FROM tbl_contact_us WHERE id = " . $id)->result();

            $cont_array      = array(
                'greetings'=>$details['firstName'].' '.$details['lastName'],
                'message'=>$details['message'],
                'reply'=>$objPost->replayMessage
            );

            $array = generateEmailTemplate('contactus_reply' , $cont_array);
            
            sendEmailAddress($details['email'],$array['subject'],$array['message']);

            $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'Reply has been sent successfully.'));
        } else {
            $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
        }
    }
    redirectPage(SITE_ADM_MOD . $module);
}

$objTemplate = new ContactUs($module);
$pageContent = $objTemplate->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
