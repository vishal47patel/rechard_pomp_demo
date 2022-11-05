<?php
$reqAuth = false;

global $langId;
$langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

require_once "includes-nct/config-nct.php";

$data = array();

$sessUserId = isset($_REQUEST["user_id"]) && $_REQUEST["user_id"] ? $_REQUEST["user_id"] : 0;

$unavailability = $db->pdoQuery("SELECT * FROM tbl_provider_availability WHERE provider_id = " . $sessUserId)->results();

foreach ($unavailability as $value) {

	$data[] = array(
	  'id'   => $value['id'],
	  'title'   => UNAVAILABLE,
	  'start'   => $value['start_date'],
	  'end'   => $value['start_date'],
	  'backgroundColor' => "red",
	  "type" => "availability"
	 );
}

$bookedServices = $db->pdoQuery("SELECT * FROM tbl_service_requests WHERE provider_id = " . $sessUserId . " AND request_status = 'a' AND service_status != 'cancel' GROUP BY start_date")->results();

foreach ($bookedServices as $value) {

	$data[] = array(
	  'id'   => $value['id'],
	  'title'   => BOOKED,
	  'start'   => $value['start_date'],
	  //'end'   => date('Y-m-d', strtotime($value['end_date'] . ' +1 day')),
	  'end' => $value['start_date'],
	  'backgroundColor' => "blue",
	  'type' => 'booking'
	 );
}

if($sessRequestType == 'app'){
	$response = array();

	$response['status'] = true;
    $response['message'] = "";
    $response['data']['unavailable_data'] = $data;
    $response['data']['language_id'] = $langId;
	echo json_encode($response);
	exit;
}
else {
	echo json_encode($data);
}

?>
