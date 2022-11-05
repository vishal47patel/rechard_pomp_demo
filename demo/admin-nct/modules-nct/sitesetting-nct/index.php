<?php
$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
require_once("class.sitesetting-nct.php");
$objPost = new stdClass();
$winTitle = 'Site Settings - ' . SITE_NM;
$headTitle = 'Site Settings';
$metaTag = getMetaTags(array("description" => "Admin Panel",
    "keywords" => 'Admin Panel',
    "author" => SITE_NM));
$module = 'sitesetting-nct';
$breadcrumb = array("Site Settings");
if (isset($_FILES) && !empty($_FILES)) {
    foreach ($_FILES as $a => $b) {
        $selField = array('type','constant');
        $selWhere = array('id' => $a);
        $type1Sql = $db->select("tbl_site_settings", $selField, $selWhere)->result();

            $type1 = $type1Sql["type"];
            $constant = $type1Sql["constant"];


            if (strtolower($type1) == "filebox") {

                $type = $_FILES[$a]["type"];
                $fileName = $_FILES[$a]["name"];
                $TmpName = $_FILES[$a]["tmp_name"];
                if ($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" || $type == "image/x-png" || $type == "image/jpg" || $type == "image/x-png" || $type == "image/x-jpeg" || $type == "image/pjpeg" || $type == "image/x-icon") {
                    if($constant == "SITE_FAVICON") {
                        $height_width_array = array('height' => 20, 'width' => 20);
                    } else {
                        $height_width_array = array('height' => 130, 'width' => 110);
                    }

                    $fileName = GenerateThumbnail($fileName, DIR_IMG, $TmpName, array($height_width_array));
                    $dataArr = array("value" => $fileName);
                    $dataWhere = array("id" => $a);
                    $db->update('tbl_site_settings', $dataArr, $dataWhere);
                }
            }

    }
}
if (isset($_POST["submitSetForm"])) {
	
    extract($_POST);
    foreach ($_POST as $k => $v) {
        if ((int) $k) {
                $v      = closetags($v);
                $sData  = array("value" => filtering($v, 'input'));
                $sWhere = array("id" => $k);
				// echo "<pre>";
	// print_r($sData);
	// print_r($sWhere);
                $db->update("tbl_site_settings", $sData, $sWhere);
                if ($k == 2) {
                    $data  = array("uEmail" => $v);
                    $where = array("id" => "1", "adminType" => "s");
                    $db->update("tbl_admin", $data, $where);
                }
        }
		
    }
	// exit;
    $toastr_message =$_SESSION['toastr_message'] = disMessage   (array('type'=>'suc','var'=>'recEdited'));
    redirectPage(SITE_ADM_MOD . $module);
}
chkPermission($module);
$objSiteSetting = new SiteSetting();
$pageContent = $objSiteSetting->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
?>