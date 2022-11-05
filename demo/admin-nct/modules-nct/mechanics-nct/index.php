<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
include("class.mechanics-nct.php");
$module = "mechanics-nct";
$table = "tbl_users";


$styles = array(array("data-tables/DT_bootstrap.css", SITE_ADM_PLUGIN),
    array("bootstrap-switch/css/bootstrap-switch.min.css", SITE_ADM_PLUGIN),
    array("cropper.min.css", SITE_ADM_CSS));

$scripts = array("core/datatable.js",
    array("data-tables/jquery.dataTables.js", SITE_ADM_PLUGIN),
    array("data-tables/DT_bootstrap.js", SITE_ADM_PLUGIN),
    array("bootstrap-switch/js/bootstrap-switch.min.js", SITE_ADM_PLUGIN),
    array("cropper.min.js", SITE_ADM_JS));

chkPermission($module);
$Permission = chkModulePermission($module);

$metaTag = getMetaTags(array("description" => "Admin Panel",
    "keywords" => 'Admin Panel',
    'author' => AUTHOR));

$id = isset($_GET["id"]) ? (int) trim($_GET["id"]) : 0;
$postType = isset($_POST["type"]) ? trim($_POST["type"]) : '';
$type = isset($_GET["type"]) ? trim($_GET["type"]) : $postType;

$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage') . ' Provider';
$winTitle = $headTitle . ' - ' . SITE_NM;
$breadcrumb = array($headTitle);

if (isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "<pre>";print_r($_POST);exit;
    extract($_POST);
    $objPost->id        = isset($id) ? $id : '';
    $hiddenImg     = isset($hiddenImg) ? $hiddenImg : '';
    /*$objPost->address     = isset($address) ? $address : '';
    $objPost->addLat     = isset($addLat) ? $addLat : '';
    $objPost->addLong     = isset($addLong) ? $addLong : '';*/
    $objPost->firstName     = isset($first_name) ? $first_name : '';
    $objPost->lastName     = isset($last_name) ? $last_name : '';
    $objPost->isActive    = isset($isActive) ? $isActive : 'y';

    if ($objPost->firstName != "" && $objPost->lastName != "") {
        if ($type == 'edit' && $id > 0) {
            if (in_array('edit', $Permission)) {
                if(isset($hiddenImg) && $hiddenImg != '') {
                    $imagename = $image =  $hiddenImg;

                    $upload_dir = DIR_UPD.'profile/'.$id.'/';
                    $temp_dir = DIR_UPD.'profile/temp_dir/'.$id.'/';
                    if(!file_exists($upload_dir))
                    {
                        mkdir($upload_dir,0777);
                    }

                    $oldfiles = glob(DIR_UPD."profile/".$id."/*"); // get all file names
                    foreach($oldfiles as $fileList)
                    { // iterate files
                        if(is_file($fileList))
                            unlink($fileList); // delete file
                    }
                    copy($temp_dir.$imagename, $upload_dir.$imagename);

                    $thumbnailArray[0] = array('newWidth'=>100,'newHeight'=>100);
                    $thumbnailArray[1] = array('newWidth'=>120,'newHeight'=>120);
                    uploadImagewithResize($upload_dir,$upload_dir.$imagename,$temp_dir.$imagename,$imagename,$thumbnailArray);
                    convertToWebP($upload_dir.'th1_'.$imagename);
                    convertToWebP($upload_dir.'th2_'.$imagename);

                   /* $image1 =  resizeImage($temp_dir . $imagename, $upload_dir . 'th1_' . $imagename,45,45);
                    $image2 =  resizeImage($temp_dir . $imagename, $upload_dir . 'th2_' . $imagename,70,70);
                    $image3 =  resizeImage($temp_dir . $imagename, $upload_dir . 'th3_' . $imagename,125,125);*/

                    $db->update($table,array("profileImg"=>$image), array("id"=>$id));

                    $oldfiles = glob(DIR_UPD."profile/temp_dir/".$id."/*"); // get all file names
                    foreach($oldfiles as $fileList)
                    { // iterate files
                        if(is_file($fileList))
                            unlink($fileList); // delete file
                    }
                }
                $db->update($table, array(
                    "firstName" => $objPost->firstName,
                    "lastName" => $objPost->lastName,
                    /*"address"  => $objPost->address,
                    "addLat"    => $objPost->addLat,
                    "addLong"    => $objPost->addLong,*/
                    "isActive"    => $objPost->isActive
                        ), array("id" => $id));

                $activity_array = array("id" => $id, "module" => $module, "activity" => 'edit');
                add_admin_activity($activity_array);
                $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'User has been updated successfully.'));
            } else {
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
            }
        }
        redirectPage(SITE_ADM_MOD . $module);
    } else {
        $toastr_message =  $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'fillAllvalues'));
    }
}

$objUsers = new Users($module);
$pageContent = $objUsers->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
