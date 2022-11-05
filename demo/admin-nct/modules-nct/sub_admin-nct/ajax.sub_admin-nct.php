<?php

$content = '';
require_once("../../../includes-nct/config-nct.php");
if ($adminUserId == 0) {
    die('Invalid request');
}
include("class.sub_admin-nct.php");

$module = 'sub_admin-nct';
chkPermission($module);
$Permission = chkModulePermission($module);
$table = 'tbl_admin';
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




if (isset($_POST["ajaxvalidate"]) && $_POST["ajaxvalidate"] == true) {
    if($_POST['chkType'] == 'email'){
        $uEmail = $_POST["uEmail"];
        $aWhere['uEmail'] = $uEmail;
    }else{
        $uName = $_POST["uName"];
        $aWhere['uName'] = $uName;
    }
    if ($id > 0) {
        $aWhere["id !="] = (int) $id;
    }
    $sqlCheck = $db->count($table, $aWhere);
    echo ($sqlCheck) > 0 ? 'false' : 'true';
    exit;
} else if ($action == "updateStatus") {
    if( in_array('status',$Permission)) {
        $setVal = array('isActive' => ($value == 'a' ? 'a' : 'd'));
        $db->update($table, $setVal, array("id" => $id));
        echo json_encode(array('type' => 'success', 'Admin User ' . ($value == 'a' ? 'activated ' : 'deactivated ') . 'successfully'));
        $activity_array = array("id" => $id, "module" => $module, "activity" => 'status', "action" => $value);
        add_admin_activity($activity_array);
    }else{
        echo json_encode(array('type' => 'error', 'You don\'t have permission to access this action , Please refresh the page and try again.'));
    }exit;
} else if ($action == "delete") {
    if(in_array('delete',$Permission)){
        $aWhere = array("id" => $id);
        $affected_rows = $db->delete($table, $aWhere)->affectedRows();

        $activity_array = array("id" => $id, "module" => $module, "activity" => 'delete');
        add_admin_activity($activity_array);

        if ($affected_rows && $affected_rows > 0) {
            echo json_encode(array('type' => 'success', 'message' => "Admin User has been deleted successfully."));
            exit;
        } else {
            echo json_encode(array('type' => 'error', 'message' => "There seems to be an issue deleting Admin user."));
            exit;
        }
    }else{
        echo json_encode(array('type' => 'error','message' => 'You don\'t have permission to access this action , Please refresh the page and try again.'));
    }
        exit;
} else if ($action == "view" && in_array('view', $Permission)) {
    $activity_array = array("id" => $id, "module" => $module, "activity" => 'view');
    add_admin_activity($activity_array);
}

$mainObject = new SubAdmin($module, $id, NULL, $searchArray, $action);
extract($mainObject->data);
echo ($content);
exit;
