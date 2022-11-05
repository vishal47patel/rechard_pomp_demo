<?php

$content = '';
require_once("../../../includes-nct/config-nct.php");
if ($adminUserId == 0) {
    die('Invalid request');
}
include("class.manage_subscriber-nct.php");

$module = 'manage_subscriber-nct';
chkPermission($module);
$Permission = chkModulePermission($module);
$table = 'tbl_subscribers';
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

        $setVal = array('isActive' => ($value == 'a' ? 'y' : 'n'));
        $db->update($table, $setVal, array("id" => $id));
        echo json_encode(array('type' => 'success', 'Subscriber ' . ($value == 'a' ? 'activated ' : 'deactivated ') . 'successfully'));
        $activity_array = array("id" => $id, "module" => $module, "activity" => 'status', "action" => $value);
        add_admin_activity($activity_array);
    }else{
        echo json_encode(array('type' => 'error', 'You don\'t have permission to access this action , Please refresh the page and try again.'));
    }exit;
}  else if ($action == "view" && in_array('view', $Permission)) {
    $activity_array = array("id" => $id, "module" => $module, "activity" => 'view');
    add_admin_activity($activity_array);
} else if ($action == "delete") {
    if(in_array('delete',$Permission)){
        $aWhere = array("id" => $id);
        $affected_rows = $db->delete($table, $aWhere)->affectedRows();

        if ($affected_rows && $affected_rows > 0) {
            echo json_encode(array('type' => 'success', 'message' => "Subscriber has been deleted successfully."));
            exit;
        } else {
            echo json_encode(array('type' => 'error', 'message' => "There seems to be an issue deleting Subscriber."));
            exit;
        }
    }else{
        echo json_encode(array('type' => 'error','message' => 'You don\'t have permission to access this action , Please refresh the page and try again.'));
    }
}

$mainObject = new Report_Users($module, $id, NULL, $searchArray, $action);
extract($mainObject->data);
echo ($content);
exit;