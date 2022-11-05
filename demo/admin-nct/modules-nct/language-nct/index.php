<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
include("class.language-nct.php");
$module = "language-nct";
$table = "tbl_language";


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

$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage') . ' Language';
$winTitle = $headTitle . ' - ' . SITE_NM;
$breadcrumb = array($headTitle);

$objLanguage = new Language($module);

if(isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST")
{
    extract($_POST);

    //_print_r($_POST);exit;
    $objPost->languageName = isset($languageName) ? $languageName : '';
    /*$objPost->url_constant = isset($url_constant) ? $url_constant : '';*/
    $objPost->status       = isset($status) ? $status : 'n';
    /*$objPost->default_lan  = isset($default_lan) ? $default_lan : '';*/
    if($objPost->languageName != "" /*&& $objPost->url_constant != ""*/)
    {
        if($type == 'edit' && $id > 0)
        {
            if(in_array('edit',$Permission))
            {
                $temp = array();
                $temp['languageName'] = $objPost->languageName;
                /*$temp['default_lan'] = $objPost->default_lan;*/
                //$temp['status'] = $objPost->status;
                if(in_array('status',$Permission))
                {
                    $temp['status'] = $objPost->status;
                }

                /*$temp['url_constant'] = $objPost->url_constant;*/

                if($objPost->default_lan=='y')
                {
                    /*$update_lang = $db->update($table,array('default_lan'=>'n'),array("1"=>"1"));*/
                }

                $db->update($table,$temp, array("id"=>$id));

                // $db->update($table, $temp, array("id"=>$id));

                $activity_array = array("id"=>$id,"module"=>$module,"activity"=>'edit');
                add_admin_activity($activity_array);
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'recEdited'));
            }else{
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'err','var'=>'NoPermission'));
            }
        } else {
            if(in_array('add',$Permission))
            {
                $getlang  = $db->select($table, array('id'), array("languageName"=>$objPost->languageName))->affectedRows();
                if(!$getlang)
                {
                    $objPost->createdDate = date('Y-m-d H:i:s');
                    if($objPost->default_lan=='y')
                    {
                        /*$update_lang = $db->update($table,array('default_lan'=>'n'),array("1"=>"1"));*/
                    }

                    $valArray = array();
                    $valArray['languageName'] = $objPost->languageName;
                    /*$valArray['default_lan'] = $objPost->default_lan;*/
                    //$valArray['status'] = $objPost->status;
                    if(in_array('status', $Permission))
                    {
                        $valArray['status'] = $objPost->status;
                    }
                    $valArray['created_date'] = $objPost->createdDate;
                    /*$valArray['url_constant'] = $objPost->url_constant;*/

                    $insertId = $db->insert($table ,$valArray)->getLastInsertId();


                    $activity_array = array("id"=>$insertId,"module"=>$module,"activity"=>'add');

                    add_admin_activity($activity_array);

                    //start:: alter tabel

                    /*Constant name*/

                    $alterTablevalue=$db->prepare("ALTER TABLE `tbl_constant`  ADD `value_".$insertId."` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER value");
                    $alterTablevalue->execute();


                    $updateTablevalue=$db->prepare("UPDATE `tbl_constant` SET  value_".$insertId." = value");
                    $updateTablevalue->execute();

                    makeConstantFile();                    

                     /*content pageTitle*/

                    $alterTablepageTitle=$db->prepare("ALTER TABLE `tbl_content`  ADD `pageTitle_".$insertId."` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER pageTitle");
                    $alterTablepageTitle->execute();

                    $updateTablepageTitle=$db->prepare("UPDATE `tbl_content` SET  pageTitle_".$insertId." = pageTitle");
                    $updateTablepageTitle->execute();

                    /*content pageDesc*/

                    $alterTablepageDesc=$db->prepare("ALTER TABLE `tbl_content`  ADD `pageDesc_".$insertId."` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER pageDesc");
                    $alterTablepageDesc->execute();

                    $updateTablepageDesc=$db->prepare("UPDATE `tbl_content` SET  pageDesc_".$insertId." = pageDesc");
                    $updateTablepageDesc->execute();

                    /*content metaKeyword*/

                    $alterTablemetaKeyword=$db->prepare("ALTER TABLE `tbl_content`  ADD `metaKeyword_".$insertId."` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER metaKeyword");
                    $alterTablemetaKeyword->execute();

                    $updateTablemetaKeyword=$db->prepare("UPDATE `tbl_content` SET  metaKeyword_".$insertId." = metaKeyword");
                    $updateTablemetaKeyword->execute();

                    /*content metaDesc*/

                    $alterTablemetaDesc=$db->prepare("ALTER TABLE `tbl_content`  ADD `metaDesc_".$insertId."` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER metaDesc");
                    $alterTablemetaDesc->execute();

                    $updateTablemetaDesc=$db->prepare("UPDATE `tbl_content` SET  metaDesc_".$insertId." = metaDesc");
                    $updateTablemetaDesc->execute();
                    
                    $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'recAdded'));
                }else{
                    $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'err','var'=>'recExist'));
                }
            }else{
                    $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'err','var'=>'NoPermission'));
            }
        }


        redirectPage(SITE_ADM_MOD.$module);
    }
    else {
        $toastr_message = disMessage(array('type'=>'err','var'=>'fillAllvalues'));
    }
}
$pageContent = $objLanguage->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
