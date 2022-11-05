<?php

$reqAuth = true;
require_once("../../../includes-nct/config-nct.php");
require_once("class.constant-nct.php");

$module = "constant-nct";
$table = "tbl_constant";
chkPermission($module);
$Permission = chkModulePermission($module);

$styles = array(array("data-tables/DT_bootstrap.css", SITE_ADM_PLUGIN),
    array("bootstrap-switch/css/bootstrap-switch.min.css", SITE_ADM_PLUGIN));

$scripts = array("core/datatable.js",
    array("data-tables/jquery.dataTables.js", SITE_ADM_PLUGIN),
    array("data-tables/DT_bootstrap.js", SITE_ADM_PLUGIN),
    array("bootstrap-switch/js/bootstrap-switch.min.js", SITE_ADM_PLUGIN));

$metaTag = getMetaTags(array("description" => "Admin Panel",
    "keywords" => 'Admin Panel',
    "author" => SITE_NM));
$id = isset($_GET["id"]) ? (int) trim($_GET["id"]) : 0;
$postType = isset($_POST["type"]) ? trim($_POST["type"]) : '';
$type = isset($_GET["type"]) ? trim($_GET["type"]) : $postType;
$ctypeTxt = isset($_REQUEST["ctype"]) ? trim($_REQUEST["ctype"]) : "f";
$ctype = $ctypeTxt == 'pages' ? 't' : ($ctypeTxt == 'messages' ? 'm' : 'f' );
$headTitle = $type == 'add' ? 'Add' : ($type == 'edit' ? 'Edit' : 'Manage ') . ' Language Constants';
$winTitle = $headTitle . ' - ' . SITE_NM;

$constObj = new Constant($id = 0, array("ctype"=>$ctype), $type = 'langArray');

if (isset($_POST["submitAddForm"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    //p($_POST);
//                echo "<pre>";
//                print_r($_POST);
//                exit;

    extract($_POST);
    $objPost->constantName = isset($constantName) ? $constantName : '';
    if ($type == 'edit' && $id > 0) {
        if (in_array('edit', $Permission)) {
            $counter = 1;

            foreach ($constantValue as $k => $v) {
                $qrySel = 'SELECT id FROM tbl_constant WHERE (id = ?)';
                $q = $db->pdoQuery($qrySel, array($id));
                $qrysel1 = $q->result();

                $numRows = $q->affectedRows();
                if ($numRows > 0) {
                    $objPost->constantValue = ($v);
                    $value_data = 'value_' . $k;
                    $db->update($table, array('status' => $status, $value_data => $objPost->constantValue), array("id" => $qrysel1['id']));
                }
                $counter++;
            }
            makeConstantFile();
            $activity_array = array("id" => $id, "module" => $module, "activity" => 'edit');
            add_admin_activity($activity_array);

            $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'recEdited'));
        } else {
            $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
        }
    } else {
        if (in_array('add', $Permission)) {
            $isConstantExist = $constObj->checkConstantExist($objPost->constantName);
            if (!$isConstantExist) {
                $counter = 1;
                $constant_last_id = 0;

                foreach ($constantValue as $k => $v) {
                    $objPost->constantValue = addslashes($v);

                    if ($_GET['ctype'] == 'labels') {
                        $objPost->type = 'f';
                    } else if ($_GET['ctype'] == 'messages') {
                        $objPost->type = 'm';
                    } else if ($_GET['ctype'] == 'pages') {
                    } else{

                        $objPost->type = 't';
                    }

                    $objPost->createdDate = date('Y-m-d H:i:s');
                    $value_data = 'value_' . $k;
                    $valArray = array(
                        "constantName" => $objPost->constantName,
                        "value" => $objPost->constantValue,
                        $value_data => $objPost->constantValue,
                        "created_date" => $objPost->createdDate,
                        "type" => $objPost->type
                    );
                    if ($counter == 1) {
                        $valArray = array_merge($valArray, array('status' => $status));
						// print_r($valArray);
                        $constant_last_id = $db->insert($table, $valArray);//->getLastInsertId();
                    } else {
                        $db->update($table, array($value_data => $objPost->constantValue), array("id" => $constant_last_id));
                    }
                    //$counstantId = ($counter==1)?$insertId : $counstantId;
                    $counter++;
                }

                $activity_array = array("id" => $constant_last_id, "module" => $module, "activity" => 'add');

                add_admin_activity($activity_array);
                $_SESSION["toastr_message"] = disMessage(array('type' => 'suc', 'var' => 'recAdded'));
            } else {
                $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'recExist'));
            }
        } else {
            $toastr_message = $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'NoPermission'));
        }
    }
    makeConstantFile();
    redirectPage($_SERVER['REQUEST_URI']);
}

$pageContent = $constObj->getPageContent();
require_once(DIR_ADMIN_TMPL . "parsing-nct.tpl.php");
