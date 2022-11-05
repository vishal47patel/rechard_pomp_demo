<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
include("class.banner-nct.php");
$module = "banner-nct";
$table = "tbl_banner";


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

$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage') . ' Banner Image';
$winTitle = $headTitle . ' - ' . SITE_NM;
$breadcrumb = array($headTitle);


if(isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        /*pri($_FILES);*/
        extract($_POST);
        $objPost->file = '';

        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] !="")
        {
            $imageName = $_FILES['file']['name'];
            $ext = '.'.strtolower(getExt($imageName));
            $newName = rand().time().$ext;
            $objPost->file = $newName;

            $tmp_name = $_FILES['file']['tmp_name'];
            $imageType = $_FILES['file']['type'];
            $imageSize = $_FILES['file']['size'];

            if($imageType == 'video/mp4' || $imageType == 'video/ogg' || $imageType == 'video/webm')
            {
                //video upload code
                $file_type = 'video';
                $upload_dir = DIR_UPD.'banner/';
                $oldFile = getTableValue("tbl_banner",'file');
                @unlink($upload_dir.$oldFile);
                move_uploaded_file($_FILES["file"]["tmp_name"],$upload_dir.$newName);
            }
            else
            {
                $_SESSION["toastr_message"] = disMessage(array('type'=>'err','var'=>'invalidimage'));
                redirectPage(SITE_ADM_MOD.$module);
            }
        }else  if(isset($hiddenImg) && $hiddenImg != '') {
            $file_type = 'image';

            $objPost->file = $imagename = $image =  $hiddenImg;

            $upload_dir = DIR_UPD.'banner/';

            if(!file_exists($upload_dir))
            {
                mkdir($upload_dir,0777);
            }

            $oldFile = getTableValue("tbl_banner",'file');
            @unlink($upload_dir.$oldFile);
            copy($dest_dir_folder.$imagename, $upload_dir.$imagename);

            $tempFile = glob(DIR_UPD."banner/temp_dir/*"); // get all file names
            foreach($tempFile as $fileList)
            { // iterate files
                if(is_file($fileList))
                    unlink($fileList); // delete file
            }


        }

        $objPost->isActive= isset($isActive) ? $isActive : '';

        
        $arr = array('isActive'=>$objPost->isActive);

        $arr['title'] = filtering(reset($title),'input');
        $arr['detail'] = filtering(reset($detail),'input','text');

        if($objPost->file!="") {
            $arr['file_type'] = $file_type;
            $arr["file"] = $objPost->file;
        }
        foreach($title as $k=>$v){
                $arr['title_'.$k] = filtering($v,'input');
        }

        foreach($detail as $k=>$v){
                $arr['detail_'.$k] = filtering($v,'input','text');
        }

        if($type == 'edit' && $id > 0){
            if (in_array('edit', $Permission)) {
                $db->update($table, $arr , array("id"=>$id));

                $_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'recEdited'));
            }else{
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
            }
        }
        else {
            if (in_array('add', $Permission)) {
                $arr["createdDate"] = date('Y-m-d H:i:s');

                $db->insert($table, $arr);
                $_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'recAdded'));
            } else {
                $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
            }
        }
        redirectPage(SITE_ADM_MOD.$module);
        
    }

$objBanner = new Banner($module);
$pageContent = $objBanner->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
