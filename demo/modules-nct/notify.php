<?php
require_once("../includes-nct/config-nct.php");

/*$content = "\n\n-----------------------------------------------------------------------------------\n\n" . date("Y-m-d H:i:s")."\n\n-----------------------------------------------------------------------------------\n\n";
foreach ($_REQUEST as $k => $v) {
    $content .= "\n\nkey=" . $k . "======>value=" . $v;
}
$h = fopen("notify.txt", "a");
$r = fwrite($h, $content);
fclose($h);

$message = SITE_URL."<BR><BR>";
$message .= "<pre>" . print_r($_REQUEST, TRUE);

sendEmailAddress('gaurav.chavda@ncrypted.com', 'Notify - ' . SITE_NM, $message);*/

if($_REQUEST){

	$requestId = ($_REQUEST['item_number'] > 0) ? $_REQUEST['item_number'] : 0;
	
	$updateArray = array(
					'payment_status' => 'paid',
					'payment_method' => "online"
				);

	$db->update('tbl_service_requests' , $updateArray , array('id' => $requestId));
	
	$requestDetails = $db->pdoQuery("SELECT customer_id , booking_amount FROM tbl_service_requests WHERE id = " . $requestId)->result();

	$insArray = array(
				"userId" => $requestDetails['customer_id'],
				"request_id" => $requestId,
				"txn_type" => "service_payment",
				"transactionId" => $_REQUEST['txn_id'],
				"amount" => $requestDetails['booking_amount'],
				"payment_method" => "online",
				'jsonDetails' => json_encode($_REQUEST),
				"ipAddress" => get_ip_address()
			);

	$db->insert("tbl_payment_history" , $insArray);
}
exit;
?>