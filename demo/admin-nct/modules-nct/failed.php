<?php
require_once("../../includes-nct/config-nct.php");

$rideId = $_GET['rideId'];
$bookingId = $_GET['bookingId'];

if($rideId){
	if($bookingId == '') {
			$bookingId = 0;
			$recieverId = getTableValue('tbl_rides' , 'driverId' , array('id' => $rideId));			
			$transaction_type = 'admin_payment';
		}
		else {
			$rideId = getTableValue('tbl_booking' , 'rideId' , array('id' => $bookingId));
			$recieverId = getTableValue('tbl_booking' , 'customerId' , array('id' => $bookingId));
			$transaction_type = 'admin_refund';
		}
		
		$insertHistoryArray = array(
						'userId' => $recieverId,
						'rideId' => $rideId,
						'txn_type' => $transaction_type,
						'amount' => '0',
						'paymentStatus' => 'cancelled',
						'createdDate' => date('Y-m-d H:i:s'),
						'ipAddress' => get_ip_address(),
						'bookingId' => $bookingId
					);

		$db->insert('tbl_payment_history' , $insertHistoryArray);

	$toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'err','var'=>'Your payment is failed.'));
	redirectPage(ADMIN_URL . 'modules-nct/manage_ride_payments-nct/');
}

exit;
?>