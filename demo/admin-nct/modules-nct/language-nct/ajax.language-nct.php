<?php

$content = '';
require_once("../../../includes-nct/config-nct.php");
if ($adminUserId == 0) {
    die('Invalid request');
}
include("class.language-nct.php");

$module = 'language-nct';
chkPermission($module);
$Permission = chkModulePermission($module);
$table = 'tbl_language';
$action = isset($_GET["action"]) ? trim($_GET["action"]) : (isset($_POST["action"]) ? trim($_POST["action"]) : 'datagrid');


$id    = isset($_GET["id"]) ? trim($_GET["id"]) : (isset($_POST["id"]) ? trim($_POST["id"]) : 0);
$value = isset($_POST["value"]) ? trim($_POST["value"]) : isset($_GET["value"]) ? trim($_GET["value"]) : '';
$page  = isset($_POST['iDisplayStart']) ? intval($_POST['iDisplayStart']) : 0;
$rows  = isset($_POST['iDisplayLength']) ? intval($_POST['iDisplayLength']) : 25;
$sort  = isset($_POST["iSortTitle_0"]) ? $_POST["iSortTitle_0"] : NULL;
$order = isset($_POST["sSortDir_0"]) ? $_POST["sSortDir_0"] : NULL;
$chr   = isset($_POST["sSearch"]) ? $_POST["sSearch"] : NULL;
$sEcho = isset($_POST['sEcho']) ? $_POST['sEcho'] : 1;

extract($_GET);
$searchArray = array("page" => $page, "rows" => $rows, "sort" => $sort, "order" => $order, "offset" => $page, "chr" => $chr, 'sEcho' => $sEcho);

 if ($action == "updateStatus") {
    if( in_array('status',$Permission)) {

        $setVal = array('status' => ($value == 'a' ? 'a' : 'd'));
        $db->update($table, $setVal, array("id" => $id));
        echo json_encode(array('type' => 'success', 'Language ' . ($value == 'a' ? 'activated ' : 'deactivated ') . 'successfully'));
        $activity_array = array("id" => $id, "module" => $module, "activity" => 'status', "action" => $value);
        add_admin_activity($activity_array);
    }else{
        echo json_encode(array('type' => 'error', 'You don\'t have permission to access this action , Please refresh the page and try again.'));
    }
    exit;
} else if ($action == "delete_old") {
    $aWhere = array("id" => $id);
    //$db->delete($table, $aWhere);
    $affected_rows = $db->delete($table, $aWhere)->affectedRows();

    $activity_array = array("id" => $id, "module" => $module, "activity" => 'delete');
    add_admin_activity($activity_array);

    if ($affected_rows && $affected_rows > 0) {
        echo json_encode(array('type' => 'success', 'message' => "Language has been deleted successfully."));
        exit;
    } else {
        echo json_encode(array('type' => 'error', 'message' => "There seems to be an issue deleting user."));
        exit;
    }
} else if($action == "delete") {
    if( in_array('status',$Permission)) {

            /*drop column for constant */
            $fetchRes = $db->pdoQuery("SHOW COLUMNS FROM tbl_constant")->results();
            foreach ($fetchRes as $k => $v) {
                if (endsWith($v["Field"],"_" . $id)) {
                    $alterTable3 = $db->prepare("ALTER TABLE  tbl_constant DROP COLUMN ".$v["Field"]);
                    $alterTable3->execute();
                }
            }

            /*drop column for page title,desc ,meta key ,meta desc*/

            $fetchRes = $db->pdoQuery("SHOW COLUMNS FROM tbl_content")->results();
            foreach ($fetchRes as $k => $v) {
                if (endsWith($v["Field"],"_" . $id)) {
                    $alterTable3 = $db->prepare("ALTER TABLE  tbl_content DROP COLUMN ".$v["Field"]);
                    $alterTable3->execute();
                }
            }
            
            $q = $db->pdoQuery("DELETE FROM tbl_language WHERE id = ? ",array($id))->affectedRows();
            if($q > 0)
            {
                @unlink(DIR_INC.'language-nct/'.$id.'.php');
                @unlink(DIR_INC.'language-nct/js/'.$id.'.js');
            }

            if ($q && $q > 0) {
                echo json_encode(array('type' => 'success', 'message' => "Language has been deleted successfully."));
                exit;
            } else {
                echo json_encode(array('type' => 'error', 'message' => "There seems to be an issue deleting Language."));
                exit;
            }
    }else{
        echo json_encode(array('type' => 'error','message' => 'You don\'t have permission to access this action , Please refresh the page and try again.'));
    }

} else if ($action == "view" && in_array('view', $Permission)) {
    $activity_array = array("id" => $id, "module" => $module, "activity" => 'view');
    add_admin_activity($activity_array);
}
$mainObject = new Language($module, $id, NULL, $searchArray, $action);
extract($mainObject->data);
echo ($content);
exit;
