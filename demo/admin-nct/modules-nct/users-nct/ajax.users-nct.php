<?php

$content = '';
require_once("../../../includes-nct/config-nct.php");
if ($adminUserId == 0) {
    die('Invalid request');
}
include("class.users-nct.php");

$module = 'users-nct';
chkPermission($module);
$Permission = chkModulePermission($module);
$table = 'tbl_users';
$action = isset($_GET["action"]) ? trim($_GET["action"]) : (isset($_POST["action"]) ? trim($_POST["action"]) : 'datagrid');


$id    = isset($_GET["id"]) ? trim($_GET["id"]) : (isset($_POST["id"]) ? trim($_POST["id"]) : 0);
$value = isset($_POST["value"]) ? trim($_POST["value"]) : isset($_GET["value"]) ? trim($_GET["value"]) : '';
$page  = isset($_POST['iDisplayStart']) ? intval($_POST['iDisplayStart']) : 0;
$rows  = isset($_POST['iDisplayLength']) ? intval($_POST['iDisplayLength']) : 25;
$sort  = isset($_POST["iSortTitle_0"]) ? $_POST["iSortTitle_0"] : NULL;
$order = isset($_POST["sSortDir_0"]) ? $_POST["sSortDir_0"] : NULL;
$chr   = isset($_POST["sSearch"]) ? $_POST["sSearch"] : NULL;
$sEcho = isset($_POST['sEcho']) ? $_POST['sEcho'] : 1;
$activeStatus = isset($_POST["activeStatus"]) ? $_POST["activeStatus"] : "";

extract($_GET);
$searchArray = array("page" => $page, "rows" => $rows, "sort" => $sort, "order" => $order, "offset" => $page, "chr" => $chr, 'sEcho' => $sEcho, 'activeStatus' => $activeStatus);

if (isset($_GET['day']) && $_GET['day'] != '') {
    $searchArray['day'] = filtering($_GET['day'], 'input', 'int');
}
if (isset($_GET['month']) && $_GET['month'] != '') {
    $searchArray['month'] = filtering($_GET['month'], 'input', 'int');
}
if (isset($_GET['year']) && $_GET['year'] != '') {
    $searchArray['year'] = filtering($_GET['year'], 'input', 'int');
}

if ($action == "updateStatus") {
    if( in_array('status',$Permission)) {

        $setVal = array('isActive' => ($value == 'a' ? 'y' : 'n'));
        $db->update($table, $setVal, array("id" => $id));
        echo json_encode(array('type' => 'success', 'Customer ' . ($value == 'a' ? 'activated ' : 'deactivated ') . 'successfully'));
        $activity_array = array("id" => $id, "module" => $module, "activity" => 'status', "action" => $value);
        add_admin_activity($activity_array);
    }else{
        echo json_encode(array('type' => 'error', 'You don\'t have permission to access this action , Please refresh the page and try again.'));
    }exit;
} else if ($action == "delete") {
    if(in_array('delete',$Permission)){
        $aWhere = array("id" => $id);
        $setVal = array('isActive' => "r");
        $affected_rows = $db->update($table, $setVal, $aWhere)->affectedRows();

        $insertNotify = array(                                  
                'receiverId' => $id,
                'notification' => "Admin deletes user.",
                'notify_data' => array("user_id" => $id),
                'notify_action' => 'admin_delete_user'
            );
        sendUserNotification($insertNotify);

        $activity_array = array("id" => $id, "module" => $module, "activity" => 'delete');
        add_admin_activity($activity_array);

        if ($affected_rows && $affected_rows > 0) {
            echo json_encode(array('type' => 'success', 'message' => "Customer has been deleted successfully."));
            exit;
        } else {
            echo json_encode(array('type' => 'error', 'message' => "There seems to be an issue deleting user."));
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

$mainObject = new Users($module, $id, NULL, $searchArray, $action);
extract($mainObject->data);
echo ($content);
exit;
