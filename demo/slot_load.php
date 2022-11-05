<?php
$reqAuth = false;

global $langId;
$langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

require_once "includes-nct/config-nct.php";

$data = array();

$sessUserId = isset($_REQUEST["user_id"]) && $_REQUEST["user_id"] ? $_REQUEST["user_id"] : 0;

$unavailability = $db->pdoQuery("SELECT * FROM tbl_provider_availability WHERE provider_id = " . $sessUserId)->results();

foreach ($unavailability as $value) {

	$start_time = strtotime("00:00");
	$time1 = date("H:i", $start_time + ( ($value['slot'] - 1) * 60 * 60));
	$time2 = date("H:i", $start_time + ($value['slot'] * 60 * 60));

	$data[] = array(
	  'id'   => $value['id'],
	  'title'   => UNAVAILABLE,
	  'start'   => $value['start_date'] . " " . $time1,
	  'end'   => $value['start_date'] . " " . $time2,
	  'backgroundColor' => "red",
	  "type" => "availability",
	  "slot" => $value['slot']
	 );
}

$bookedServices = $db->pdoQuery("SELECT * FROM tbl_service_requests WHERE provider_id = " . $sessUserId . " AND request_status = 'a' AND service_status != 'cancel' GROUP BY service_date , service_time_slot")->results();

foreach ($bookedServices as $value) {

	$start_time = strtotime("00:00");
	$time1 = date("H:i", $start_time + ( ($value['service_time_slot'] - 1) * 60 * 60));
	$time2 = date("H:i", $start_time + ($value['service_time_slot'] * 60 * 60));

	$data[] = array(
	  'id'   => $value['id'],
	  'title'   => BOOKED,
	  'start'   => $value['service_date'] . " " . $time1,
	  'end'   => $value['service_date'] . " " . $time2,
	  'backgroundColor' => "blue",
	  'type' => 'booking',
	  'slot' => $value['service_time_slot']
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
