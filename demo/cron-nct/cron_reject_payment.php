<?php

//15 minutes

require_once "../includes-nct/config-nct.php";

$bookings = $db->pdoQuery("SELECT id FROM tbl_service_requests WHERE payment_status='running' AND (DATE_ADD(processingStartTime , INTERVAL 10 MINUTE) <= NOW())")->results();

foreach ($bookings as $bookingDetail) {
	$updateArray = array(
					'payment_status' => 'pending',
					'payment_method' => ''
				);

	$db->update('tbl_service_requests' , $updateArray , array('id' => $bookingDetail['id']));
}
?>