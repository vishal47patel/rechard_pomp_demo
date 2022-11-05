<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
include("class.sub_admin-nct.php");
$module = "sub_admin-nct";
$table = "tbl_admin";


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

$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage') . ' Sub Admin';
$winTitle = $headTitle . ' - ' . SITE_NM;
$breadcrumb = array($headTitle);

if (isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    $id= isset($id) ? $id : '';
    $objPost->uName = isset($uName) ? $uName : '';
    $objPost->uEmail     = isset($uEmail) ? $uEmail : '';
    $objPost->isActive    = isset($isActive) ? $isActive : 'a';

    if ($objPost->uName != "" && strlen($objPost->uName) > 0) {
        if ($type == 'edit' && $id > 0) {
            if (in_array('edit', $Permission)) {


                $get_id = $db->pdoQuery("SELECT id FROM tbl_admin WHERE (uEmail = ? OR uName = ?) AND id != ?",array($uEmail,$uName,$id))->affectedRows();
                if($get_id <= 0 ){
                    if($uPass != ""){
                        $objPost->uPass     = isset($uPass) ? md5($uPass) : '';
                    }

                    $db->update($table, (array)$objPost, array("id" => $id));

                    $db->delete('tbl_admin_permission',array('admin_id'=>$id));

                    foreach ($moduleArr as $key => $value) {
                        $objPostPermission->admin_id = $id;
                        $objPostPermission->page_id = $key;
                        $objPostPermission->permission = implode(',',$value);
                        $objPostPermission->created_date = date('Y-m-d H:i:s');
                        $db->insert('tbl_admin_permission',(array)$objPostPermission);
                    }
                    $activity_array = array("id" => $id, "module" => $module, "activity" => 'edit');
                    add_admin_activity($activity_array);
                    $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'Admin User has been updated successfully.'));
                }else{
                    $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'alreadytaken'));
                }
            } else {
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
            }
        }else{
            if (in_array('add', $Permission)) {

                $get_id = $db->pdoQuery("SELECT id FROM tbl_admin WHERE (uEmail = ? OR uName = ?)",array($uEmail,$uName))->affectedRows();

                if($get_id <= 0 ){
                    $objPost->uPass     = isset($uPass) ? md5($uPass) : '';
                    $objPost->created_date = date('Y-m-d H:i:s');

                    $last_id = $db->insert($table, (array)$objPost)->getLastInsertId();

                    foreach ($moduleArr as $key => $value) {
                        $objPostPermission->admin_id = $last_id;
                        $objPostPermission->page_id = $key;
                        $objPostPermission->permission = implode(',',$value);
                        $objPostPermission->created_date = date('Y-m-d H:i:s');
                        $db->insert('tbl_admin_permission',(array)$objPostPermission);
                    }
                    $activity_array = array("id" => $id, "module" => $module, "activity" => 'add');
                    add_admin_activity($activity_array);
                    $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'Admin User has been Added successfully.'));
                }else{
                    $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'alreadytaken'));
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

$objSubAdmin = new SubAdmin($module);
$pageContent = $objSubAdmin->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
