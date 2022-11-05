<?php

$content = '';
require_once("../../../includes-nct/config-nct.php");
if ($adminUserId == 0) {
    die('Invalid request');
}
include("class.contactus-nct.php");

$module = 'contactus-nct';
chkPermission($module);
$Permission = chkModulePermission($module);

$table = 'tbl_contact_us';
$action = isset($_GET["action"]) ? trim($_GET["action"]) : (isset($_POST["action"]) ? trim($_POST["action"]) : 'datagrid');
$id = isset($_GET["id"]) ? trim($_GET["id"]) : (isset($_POST["id"]) ? trim($_POST["id"]) : 0);
$value = isset($_POST["value"]) ? trim($_POST["value"]) : isset($_GET["value"]) ? trim($_GET["value"]) : '';
$page = isset($_POST['iDisplayStart']) ? intval($_POST['iDisplayStart']) : 0;
$rows = isset($_POST['iDisplayLength']) ? intval($_POST['iDisplayLength']) : 25;
$sort = isset($_POST["iSortTitle_0"]) ? $_POST["iSortTitle_0"] : NULL;
$order = isset($_POST["sSortDir_0"]) ? $_POST["sSortDir_0"] : NULL;
$chr = isset($_POST["sSearch"]) ? $_POST["sSearch"] : NULL;
$sEcho = isset($_POST['sEcho']) ? $_POST['sEcho'] : 1;

extract($_GET);
$searchArray = array("page" => $page, "rows" => $rows, "sort" => $sort, "order" => $order, "offset" => $page, "chr" => $chr, 'sEcho' => $sEcho);
if ($action == "delete") {
    if( in_array('delete',$Permission)) {
	    $db->delete($table, array("id" => $id));
	     echo json_encode(array('type' => 'success', 'message' => "Record has been deleted successfully."));
	 }else{
	    echo json_encode(array('type' => 'error','message' => 'You don\'t have permission to access this action , Please refresh the page and try again.'));
	}
        exit;
}
$mainObject = new ContactUs($module, $id, NULL, $searchArray, $action);
extract($mainObject->data);
echo ($content);
exit;
