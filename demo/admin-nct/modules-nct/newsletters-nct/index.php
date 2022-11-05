<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
include("class.newsletters-nct.php");
$module = "newsletters-nct";
$table = "tbl_newsletters";
$styles = array(
    array("data-tables/DT_bootstrap.css", SITE_ADM_PLUGIN),
    array("bootstrap-switch/css/bootstrap-switch.min.css", SITE_ADM_PLUGIN),
    array("multiselect/css/multi-select.css", SITE_PLUGIN)
);

$scripts = array(
    "core/datatable.js",
    array("data-tables/jquery.dataTables.js", SITE_ADM_PLUGIN),
    array("data-tables/DT_bootstrap.js", SITE_ADM_PLUGIN),
    array("bootstrap-switch/js/bootstrap-switch.min.js", SITE_ADM_PLUGIN),
    array("multiselect/js/jquery.multi-select.js", SITE_PLUGIN)
);

chkPermission($module);
$Permission = chkModulePermission($module);
$metaTag = getMetaTags(array("description" => "Admin Panel",
    "keywords" => 'Admin Panel',
    "author" => SITE_NM));

$id = isset($_GET["id"]) ? (int) trim($_GET["id"]) : 0;
$postType = isset($_POST["type"]) ? trim($_POST["type"]) : '';
$type = isset($_GET["type"]) ? trim($_GET["type"]) : $postType;

$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage') . ' Newsletter';
$winTitle = $headTitle . ' - ' . SITE_NM;
$breadcrumb = array($headTitle);
if (isset($_POST["submitAddFormNL"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (in_array('sendNL', $Permission)) {
        extract($_POST);
        $sent_on         = date("Y-m-d H:i:s");
        $subscribedUsers = array();
        $subscriberId    = array();
        $nl_id           = isset($id) ? filtering($id, 'input', 'int') : "";
        $subscribedUsers = isset($subscribers) ? $subscribers : "";

        if (!empty($subscribedUsers)) {
            $flagSend = false;
            $qrySelNL = $db->select("tbl_newsletters", "*", array("id" => $nl_id))->result();
            $arrayCont = array();
            $arrayCont['subject'] = $qrySelNL['newsletter_subject'];
            $arrayCont['greetings'] = "";
            $arrayCont['newsletter_content'] = $qrySelNL['newsletter_content'];

            foreach ($subscribedUsers as $single_subscriber_id) {
                $valArray = array(
                    'nl_id' => $nl_id,
                    'subscriber_id' => $single_subscriber_id,
                    "sent_on" => date("Y-m-d H:i:s")
                );
                $email_address = $db->select("tbl_subscribers",array('*'),array("id" => $single_subscriber_id ) )->result();

                $id = $db->insert("tbl_sent_newsletters", $valArray)->getLastInsertId();
                $arrayCont['greetings'] = 'User';
                if ($id) {
                    $link = '<center > If you would prefer not receiving our emails, please <a href = "'.SITE_URL.'unsubscribe/'.base64_encode('nct_'.$single_subscriber_id.'nct_').'" >click here</a> to unsubscribe.</center>';
                    $arrayCont['newsletter_content'] .= $link;

                    $array = generateEmailTemplate('newsletter',$arrayCont);

                    sendEmailAddress($email_address['email'],$arrayCont['subject'],$array['message']);

                    $flagSend = true;
                } else {
                    $flagSend = false;
                }
            }

            if ($flagSend) {
                $activity_array = array("id" => $id, "module" => $module, "activity" => 'add');
                add_admin_activity($activity_array);
                $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'Newsletter sent successfully'));
            } else {
                $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'There seems to be some issue while sending the Newsletter.'));
            }
        }
    }else{
        $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
    }
    redirectPage(SITE_ADM_MOD . $module);
}

if (isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    $objPost->newsletter_name    = isset($newsletter_name) ? filtering($newsletter_name, 'input') : '';
    $objPost->newsletter_subject = isset($newsletter_subject) ? filtering($newsletter_subject, 'input') : '';
    $objPost->newsletter_content = isset($newsletter_content) ? filtering($newsletter_content, 'input', 'text') : '';
    $objPost->isActive             = isset($status) && $status == 'a' ? 'y' : 'n';
    $objPost->createdDate           = date("Y-m-d H:i:s");
    $objPost->updated_on         = date("Y-m-d H:i:s");

    if ($objPost->newsletter_name != "" && $objPost->newsletter_subject != "" && $objPost->newsletter_content != "") {
        if ($type == 'edit' && $id > 0) {
            if (in_array('edit', $Permission)) {
                if (getTotalRows($table, "newsletter_name='" . $objPost->newsletter_name . "' AND id != '" . $id . "'", 'id') == 0) {
                    $db->update($table, array(
                        'newsletter_name'    => $objPost->newsletter_name,
                        'newsletter_subject' => $objPost->newsletter_subject,
                        'newsletter_content' => $objPost->newsletter_content,
                        'isActive'             => $objPost->isActive,
                        "updated_on"         => $objPost->updated_on
                            ), array("id" => $id));

                    $activity_array = array("id" => $id, "module" => $module, "activity" => 'edit');
                    add_admin_activity($activity_array);
                    $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'Newsletter has been updated successfully.'));
                } else {
                    $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'Entered Newsletter already exists!'));
                }
            } else {
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
            }
        } else {
            if (in_array('add', $Permission)) {
                if (getTotalRows($table, "newsletter_name='" . $objPost->newsletter_name . "'", 'id') == 0) {
                    $valArray = array(
                        'newsletter_name'    => $objPost->newsletter_name,
                        'newsletter_subject' => $objPost->newsletter_subject,
                        "newsletter_content" => $objPost->newsletter_content,
                        "isActive"             => $objPost->isActive,
                        "createdDate"           => $objPost->createdDate
                    );
                    $id = $db->insert($table, $valArray)->getLastInsertId();

                    $activity_array = array("id" => $id, "module" => $module, "activity" => 'add');
                    add_admin_activity($activity_array);
                    $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'Newsletter has been added successfully.'));
                } else {
                    $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'Entered Newsletter already exists!'));
                }
            } else {
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
            }
        }
        redirectPage(SITE_ADM_MOD . $module);
    } else {
        $toastr_message = array('type' => 'err', 'var' => 'fillAllvalues');
    }
}

$objNewsletter = new newsletter($module, $id, NULL);
$pageContent = $objNewsletter->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
