<?php
require_once("../../includes-nct/config-nct.php");

/*
$content = "\n\n-----------------------------------------------------------------------------------\n\n" . date("Y-m-d H:i:s")."\n\n-----------------------------------------------------------------------------------\n\n";
foreach ($_REQUEST as $k => $v) {
    $content .= "\n\nkey=" . $k . "======>value=" . $v;
}
$h = fopen("notify.txt", "a");
$r = fwrite($h, $content);
fclose($h);

$message = SITE_URL."<BR><BR>";
$message .= "<pre>" . print_r($_REQUEST, TRUE);

sendEmailAddress('gaurav.chavda@ncrypted.com', 'Notify - ' . SITE_NM, $message);*/

if($_POST){
	$id = getTableValue('tbl_payment_history' , 'id' , array('transactionId' => $_POST['txn_id']));

	list($userType,$cancellationFee) = explode('__',$_POST["custom"]);

	if($id <= 0){
		if($userType == 'driver') {
			$rideId = ($_POST['item_number'] > 0) ? $_POST['item_number'] : 0;
			$bookingId = 0;
			$recieverId = getTableValue('tbl_rides' , 'driverId' , array('id' => $rideId));
			$transaction_type = $mailType = 'admin_payment';
			$notificationConstant = 'ADMIN_PAYMENT';

			$updateArray = array(
						'isPaidToDriver' => 'y'
					);
			$whereArray = array('rideId' => $rideId , 'bookingStatus' => 'booked');
		}
		else {
			$bookingId = ($_POST['item_number'] > 0) ? $_POST['item_number'] : 0;
			$rideId = getTableValue('tbl_booking' , 'rideId' , array('id' => $bookingId));
			$recieverId = getTableValue('tbl_booking' , 'customerId' , array('id' => $bookingId));
			$transaction_type = $mailType = 'admin_refund';
			$notificationConstant = 'ADMIN_REFUND';

			$updateArray = array(
						'isPaidToCustomer' => 'y'
					);

			$whereArray = array('id' => $bookingId);
		}

		$db->update('tbl_booking' , $updateArray , $whereArray);

		$insertHistoryArray = array(
						'userId' => $recieverId,
						'rideId' => $rideId,
						'txn_type' => $transaction_type,
						'amount' => $_POST['mc_gross'],
						'paymentStatus' => 'completed',
						'transactionId' => $_POST['txn_id'],
						'jsonDetails' => json_encode($_POST),
						'createdDate' => date('Y-m-d H:i:s'),
						'ipAddress' => get_ip_address(),
						'paypal_fees' => $_POST['payment_fee'],
						'bookingId' => $bookingId
					);

		$db->insert('tbl_payment_history' , $insertHistoryArray);

		//send mail to user

		$userInfo = $db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $recieverId)->result();
		$to = $userInfo['email'];

		$rideLink = "<a href='".SITE_URL . "ride-detail/" . $rideId."'>Ride</a>";

		$cancel_text = '';
		if($cancellationFee > 0) {
			$cancel_text = 'Cancellation Charge : $' . $cancellationFee . '.';
		}
		$arrayCont = array(
			'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
			'ride' => $rideLink,
			'amount' => '$' . $_POST['mc_gross'],
			'cancel_text' => $cancel_text
			 );

		$array = generateEmailTemplate($mailType , $arrayCont);
		sendEmailAddress($to,$array['subject'],$array['message']);

		//entry in notification table
		$notificationMsg = $notificationConstant;
		$insertNotify = array(
							'senderId' => '0',
							'receiverId' => $recieverId,
							'driverId' => '0',
							'customerId' => '0',
							'rideId' => $rideId,
							'notification' => $notificationMsg,
							'notification_type' => $mailType
						);

		sendUserNotification($insertNotify);
	}
	if($_SERVER["SERVER_NAME"] == '192.168.100.128' || $_SERVER["SERVER_NAME"] == 'localhost' || $_SERVER["SERVER_NAME"] == 'nct128' )
    {
		$toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'suc','var'=>'Payment is successfully done.'));
    	redirectPage(ADMIN_URL . 'modules-nct/manage_ride_payments-nct/');

    }
}
exit;
?>