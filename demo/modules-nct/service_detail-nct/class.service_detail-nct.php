<?php
class service_detail {
	function __construct($requestArr = array()) {
		global $sessUserId, $sessRequestType;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($requestArr);
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId = isset($userId) && $userId ? $userId : $sessUserId;
		$this->module = $module;
		$this->request_id = $request_id;
	}
	
	public function getPageContent() {

		$replaceArray = $dataArray = $appData = array();
		
		$requestDetails = $this->db->pdoQuery("SELECT tsr.* FROM tbl_service_requests AS tsr WHERE tsr.id = ?" , array($this->request_id))->result();

		$appData = $requestDetails;

		if($requestDetails['provider_id'] == $this->sessUserId) {	
			
			$considerUsrId = $requestDetails['customer_id'];
		}
		else {
			$considerUsrId = $requestDetails['provider_id'];
		}

		$statusData = '';
		if($requestDetails['service_status'] == 'upcoming') {
			$statusData = '<span class="lbl-upcoming">'.UPCOMING.'</span>';
		}
		else if($requestDetails['service_status'] == 'ongoing') {
			$statusData = '<span class="lbl-ongoing">'.ONGOING.'</span>';
		}
		else if($requestDetails['service_status'] == 'complete') {
			$statusData = '<span class="lbl-complete">'.COMPLETED.'</span>';
		}
		else if($requestDetails['service_status'] == 'cancel') {
			$statusData = '<span class="lbl-cancel">'.CANCELLED.'</span>';
		}

		$bookingDate = date(PHP_DATE_FORMAT , strtotime($requestDetails['created_date']));
		$appData['booking_date'] = $bookingDate;

		$userQry = $this->db->pdoQuery("SELECT user.* , ROUND(AVG(review.rating),1) as averageRating FROM tbl_users AS user 
			LEFT JOIN tbl_reviews as review ON review.receiver_id=user.id AND review.status='y' 
			WHERE user.id = ?" , array($considerUsrId))->result();

		$userName = filtering($userQry['firstName'] . ' ' . $userQry['lastName'] , 'output' , 'string');
		$email = filtering($userQry['email'],'output','string');
		$contactNo = $userQry['contactNo'] != '' ? filtering($userQry['contactNo'],'output','string') : 'N/A';
		$userImage = checkImage('profile/'.$considerUsrId.'/th2_',$userQry['profileImg']);
		$userImage_main = checkImage('profile/'.$considerUsrId.'/th2_',$userQry['profileImg'] , "mainImage");
		$averageRating = ($userQry['averageRating'] > 0) ? $userQry['averageRating'] : '0';
		$ratingHtml = renderStarRating($averageRating);
		$message = filtering($requestDetails['message'],'output','string');
		
		$appData['user_details']['id'] = $considerUsrId;
		$appData['user_details']['name'] = $userName;
		$appData['user_details']['email'] = $email;
		$appData['user_details']['contactNo'] = $contactNo;
		$appData['user_details']['rating'] = $averageRating;
		$appData['user_details']['user_img'] = $userImage;

		$userData = array(
				"%USER_ID%" => $considerUsrId,
				"%USER_NAME%" => $userName,
				"%EMAIL%" => $email,
				"%USER_IMG%" => $userImage,
				"%USER_IMG_MAIN%" => $userImage_main,
				"%CONTACT_NO%" => $contactNo,
				"%RATING%" => $ratingHtml
					);

		if($requestDetails['provider_id'] == $this->sessUserId) {
			$dataArray["%USER_DETAILS%"] = get_view(DIR_TMPL . $this->module."/customer_details-nct.tpl.php",$userData);
		}
		else {
			$dataArray["%USER_DETAILS%"] = get_view(DIR_TMPL . $this->module."/provider_details-nct.tpl.php",$userData);
		}

		$userAddrDetails = $this->db->pdoQuery("SELECT address, addLat , addLong FROM tbl_users WHERE id = ?" , array($requestDetails['provider_id']))->result();

		$dataArray["%SERVICE_STATUS%"] = $statusData;
		$dataArray["%BOOKING_DATE%"] = $bookingDate;
		$dataArray["%ADDRESS%"] = $userAddrDetails['address'];
		$dataArray["%ADD_LAT%"] = $userAddrDetails['addLat'];
		$dataArray["%ADD_LONG%"] = $userAddrDetails['addLong'];

		$appData['address'] = $userAddrDetails['address'];
		$appData['addLat'] = $userAddrDetails['addLat'];
		$appData['addLong'] = $userAddrDetails['addLong'];

		if($requestDetails['service_type'] == 'mechanic') {			

			$serviceDate = date(PHP_DATE_FORMAT , strtotime($requestDetails['service_date']));
			$timeSlot = getSlotFromId($requestDetails['service_time_slot']);

			$appData['serviceDateFormatted'] = $serviceDate;
			$appData['timeSlotDisp'] = $timeSlot;

			$serviceDateTime = date("Y-m-d H:i" , strtotime($requestDetails['service_date'] . ' ' . ($requestDetails['service_time_slot'] - 1) . ":00" ));

			$endDateTime = date("Y-m-d H:i" , strtotime($requestDetails['service_date'] . ' ' . ($requestDetails['service_time_slot']) . ":00" ));

			$dataArray["%SERVICE_ICON%"] = "icon-car-service";
			$dataArray["%SERVICE_TEXT%"] = AUTO_SERVICES;

			$dataArray["%CONTENT%"] = get_view(DIR_TMPL . $this->module."/mechanic_details-nct.tpl.php",array(
					"%SERVICE_DATE%" => $serviceDate,
					"%TIME_SLOT%" => $timeSlot
			));
		}
		else {
			$startDate = date(PHP_DATE_FORMAT , strtotime($requestDetails['start_date']));
			$endDate = date("H:i" , strtotime($requestDetails['end_date']));

			$appData['startDateFormatted'] = $startDate;
			$appData['endDateFormatted'] = $endDate;

			$dataArray["%SERVICE_ICON%"] = "icon-taxi-driver";
			$dataArray["%SERVICE_TEXT%"] = TAXI_SERVICE;

			$dataArray["%CONTENT%"] = get_view(DIR_TMPL . $this->module."/taxi_details-nct.tpl.php",array(
					"%START_DATE%" => $startDate,
					"%END_DATE%" => $endDate,
					"%LOCATION_DETAILS%" => ($requestDetails['location_details'] != "") ? $requestDetails['location_details'] : '-'
			));
		}

		$startServiceSection = '';

		if($requestDetails['provider_id'] == $this->sessUserId) {
			if(/*(date('Y-m-d H:i') >= $serviceDateTime) && (date('Y-m-d H:i') < $endDateTime) &&*/ ($requestDetails['request_status'] == 'a') && ($requestDetails['service_status'] == 'upcoming')) {
				$startServiceSection = '<a href="javascript:void(0);" class="btn-main btn-main-red service-detail-btn" id="startService">' .START_SERVICE . '</a>';
			}		
		}	

		$cancelServiceSection = '';
		if(($requestDetails['request_status'] == 'a') && ($requestDetails['service_status'] == 'upcoming')) {

			if($requestDetails['provider_id'] == $this->sessUserId) {
				$cancelServiceSection = '<a href="javascript:void(0);" class="btn-main btn-red-outer service-detail-btn" id="cancelService" userType="provider">' . CANCEL_SERVICE . '</a>';
			}
			else if($requestDetails['customer_id'] == $this->sessUserId) {
				$cancelServiceSection = '<a href="javascript:void(0);" class="btn-main btn-red-outer service-detail-btn" id="cancelService" userType="customer">' . CANCEL_SERVICE . '</a>';	
			}
		}

		$completeServiceSection = '';
		if(($requestDetails['request_status'] == 'a') && ($requestDetails['service_status'] == 'ongoing')) {

			if($requestDetails['provider_id'] == $this->sessUserId && ($requestDetails['complete_provider'] == 'n')) {
				$cancelServiceSection = '
				<form id="completionForm" method="POST" action="" class="p-2">
				<textarea id="completionMessage" name="completionMessage" class="form-control" placeholder="'.ENTER ." ". COMPLETION_MSG ." ". MEND_SIGN.'"></textarea>
				<div class="form-group accept-paypal">
				<label class="">'.ACCEPT_PAYPAL.'</label>
				<div class="form-group d-inline-block mr-2">
			        <label class="container-radio"> '.LBL_YES.'
			            <input type="radio" id="paypal_yes" name="accept_paypal" value="y" style="display: block !important;" checked="true">
			            <span class="checkmark"></span>
			        </label>
			    </div>
			    <div class="form-group d-inline-block">
			        <label class="container-radio"> '.LBL_NO.'
			            <input type="radio" id="paypal_no" name="accept_paypal" value="n" style="display: block !important;">
			            <span class="checkmark"></span>
			        </label>
			    </div>
			    </div>

			    <div class="form-group">
					<input type="text" id="amountVal" name="amountVal" class="form-control" placeholder="'.ENTER. ' '.AMOUNT.'  ('.DEFAULT_CURRENCY_SIGN.')'.MEND_SIGN.'" />
					<div class="text-center all-btns mt-3">
						<input type="hidden" name="service_request_id" value="'.$this->request_id.'" />
					</div>
				</div>

				</form>
				<a href="javascript:void(0);" class="btn-main btn-red-outer service-detail-btn" id="completeService" userType="provider">' . COMPLETE_SERVICE . '</a>';
			}
			else if($requestDetails['customer_id'] == $this->sessUserId && ($requestDetails['complete_customer'] == 'n') && ($requestDetails['complete_provider'] == 'y')) {
				$cancelServiceSection = '<form id="completionForm" method="POST" action="" class="p-2"><div class="amount-display">' . COMPLETION_MSG . ' : '.$requestDetails['completionMessage'].'</div>';
				$cancelServiceSection .= '<div class="amount-display">' . PROIVDER_ADDED_AMOUNT . ' : '.DEFAULT_CURRENCY_SIGN.$requestDetails["booking_amount"].'</div>';
				$cancelServiceSection .= '<div class="amount-display">' . PROV_ACCEPT_PAYPAL . ' : '.( ($requestDetails['accept_paypal'] == 'y') ? LBL_YES : LBL_NO).'</div>';

				if($requestDetails['accept_paypal'] == 'y') {
					$cancelServiceSection .= '<div class="payment-method text-left"><div class="form-group d-inline-block mr-2">
					        <label class="container-radio"> '.PAY_VIA_PAYPAL.'
					            <input type="radio" id="online" name="payment_method" value="online" style="display: block !important;" checked="true">
					            <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="form-group d-inline-block">
					        <label class="container-radio"> '.PAY_MANUAL.'
					            <input type="radio" id="offline" name="payment_method" value="offline" style="display: block !important;">
					            <span class="checkmark"></span>
					        </label>
					    </div></div>';
				}
				else {

				}
				$cancelServiceSection .= '</form><a href="javascript:void(0);" class="btn-main btn-red-outer service-detail-btn" id="completeService" userType="customer">' . COMPLETE_SERVICE . '</a>';
			} 
		}

		$addAmountSection = '';

		/*if( ($requestDetails['provider_id'] == $this->sessUserId) && ($requestDetails['service_status'] == 'complete') ){
			if($requestDetails["booking_amount"] == "") {
				$addAmountSection = get_view(DIR_TMPL . $this->module."/add_amount-nct.tpl.php",array("%SERVICE_REQ_ID%" => $this->request_id));
			}
		}*/
		
		$displayAmount = "";
		$paymentMethodSection = "";
		if($requestDetails["booking_amount"] != "") {
			if(($requestDetails['provider_id'] == $this->sessUserId)) {
				$displayAmount = get_view(DIR_TMPL . $this->module."/display_amount-nct.tpl.php",array("%AMOUNT%" => $requestDetails["booking_amount"]));
			}
			if(($requestDetails['customer_id'] == $this->sessUserId) && ($requestDetails['payment_method'] == "")) {

				if($requestDetails['payment_status'] == 'running') {
					$paymentMethodSection = '<div>'.ALRDY_INITIATED_PAYMENT_WAIT.'</div>';
				}
				else {
					//$paymentMethodSection = get_view(DIR_TMPL . $this->module."/payment_method-nct.tpl.php",array("%SERVICE_REQ_ID%" => $this->request_id));
				}
			}
		}

		$reviewSection = '';

		$alreadyRated = getTableValue("tbl_reviews" , "id" , array("sender_id" => $this->sessUserId , "service_request_id" => $this->request_id));

		$appData['alreadyRated'] = ($alreadyRated == '') ? 'n' : 'y';

		if($requestDetails['customer_id'] == $this->sessUserId && ($requestDetails['service_status'] == 'complete') && ($alreadyRated == '')) {
			$reviewArray = array();

			$reviewSection = get_view(DIR_TMPL . $this->module."/add_review-nct.tpl.php",$reviewArray);
		}
		
		$dataArray["%ADD_REVIEW_SECTION%"] = $reviewSection;
		$dataArray["%START_SERVICE_SECTION%"] = $startServiceSection;
		$dataArray["%CANCEL_SERVICE_SECTION%"] = $cancelServiceSection;
		$dataArray["%COMPLETE_SERVICE_SECTION%"] = $completeServiceSection;
		$dataArray["%ADD_AMOUNT_SECTION%"] = $addAmountSection;
		$dataArray["%BOOKING_AMT_SECTION%"] = $displayAmount;
		$dataArray["%PAYMENT_METHOD_SECTION%"] = $paymentMethodSection;
		$dataArray["%MESSAGE%"] = $message;

		$replaceArray["%CONTENT%"] = get_view(DIR_TMPL . $this->module."/common_details-nct.tpl.php",$dataArray);

		$replaceArray["%REQUEST_ID%"] = $this->request_id;
		$replaceArray["%RECEIVER_ID%"] = $considerUsrId;

		if($this->sessRequestType == 'app'){
			$returnResponse = array(
					'status'		=> true,
					'message'  	 	=> 'success',
					'data' => $appData);

			return $returnResponse;
		}else{
			return get_view(DIR_TMPL . $this->module."/".$this->module.".tpl.php",$replaceArray);
		}
	}

	public function cancelService($request = array()) {
		try{
// echo '<pre>';			
		// print_r($request); exit;
		// $this->db->query("UPDATE tbl_service_requests SET request_status = 'r' WHERE id = '".$request['request_id']."'");
			$requestDetails = $this->db->pdoQuery("SELECT tsr.* FROM tbl_service_requests AS tsr WHERE tsr.id = ?" , array($request["request_id"]))->result();

			if(($requestDetails['request_status'] == 'a') && ($requestDetails['service_status'] == 'ongoing')) {
				$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
				'status'		=> false,
				'message'  	 	=> NOT_CANCEL_ONGOING_SERVICE,
				'data'  		=> array());

				return $returnResponse;
			}
			else {
	            $this->db->update('tbl_service_requests' , array('service_status' => "cancel", 'request_status' => "r" , "cancelled_by" => $request["userType"]) , array('id' => $request["request_id"]));
				
				if($request["userType"] == 'provider') {
					$receiverId = $requestDetails['customer_id'];

					$mailConstant = 'service_cancelled_by_provider';
					$notificationMsg = CANCEL_BY_PROVIDER;
				}
				else {
					$receiverId = $requestDetails['provider_id'];
					$mailConstant = 'service_cancelled_by_customer';
					$notificationMsg = CANCEL_BY_CUSTOMER;
				}
				$notify_type = 'service_cancelled';

				$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $receiverId));
				if($notification == 'y') {
					//send mail to customer
					$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $receiverId)->result();
					$to = $userInfo['email'];

					$serviceLink = SITE_URL . 'service-detail/' . $request['request_id'];
					$arrayCont = array(
						'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
						'serviceLink' => "<a href='".$serviceLink."'>Click Here</a>",
						 );
					$array = generateEmailTemplate($mailConstant , $arrayCont);

					sendEmailAddress($to,$array['subject'],$array['message']);

					$insertNotify = array(									
									'receiverId' => $receiverId,
									'notification' => $notificationMsg,
									'notify_data' => array("request_id" => $request['request_id']),
									'notify_action' => 'service_cancelled'
								);
					sendUserNotification($insertNotify);
				}

				$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $this->sessUserId));
				if($notification == 'y') {
					//send mail to self
					$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $this->sessUserId)->result();
					$to = $userInfo['email'];

					$serviceLink = SITE_URL . 'service-detail/' . $request['request_id'];
					$arrayCont = array(
						'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
						'serviceLink' => "<a href='".$serviceLink."'>Click Here</a>",
						 );

					$mailConstant = 'service_cancelled_by_you';
					$notificationMsg = CANCEL_BY_YOU;

					$array = generateEmailTemplate($mailConstant , $arrayCont);

					sendEmailAddress($to,$array['subject'],$array['message']);

					$insertNotify = array(									
									'receiverId' => $this->sessUserId,
									'notification' => $notificationMsg,
									'notify_data' => array("request_id" => $request['request_id']),
									'notify_action' => 'service_cancelled'
								);
					sendUserNotification($insertNotify);
				}

				$returnResponse = array(
					'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
					'status'		=> true,
					'message'  	 	=> MSG_SERVICE_CANCELLED_SUC,
					'data'  		=> array());

				return $returnResponse;
			}
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function startService($request = array()) {
		try{			
			$requestDetails = $this->db->pdoQuery("SELECT tsr.* FROM tbl_service_requests AS tsr WHERE tsr.id = ?" , array($request["request_id"]))->result();

			if($requestDetails['service_status'] == 'cancel') {
				$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
				'status'		=> false,
				'message'  	 	=> NOT_START_CANCEL_SERVICE,
				'data'  		=> array());

				return $returnResponse;
			}
			else {
	            $this->db->update('tbl_service_requests' , array('service_status' => "ongoing") , array('id' => $request["request_id"]));
							
				$returnResponse = array(
					'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
					'status'		=> true,
					'message'  	 	=> MSG_SERVICE_STARTED_SUC,
					'data'  		=> array());

				return $returnResponse;
			}
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function completeService($request = array()) {
		try{			
			$updArr = array();

			if($request["userType"] == 'provider') {
				$updArr['complete_provider'] = 'y';
				$updArr['completionMessage'] = $request['completionMessage'];
				$updArr['accept_paypal'] = $request['accept_paypal'];
				$updArr['booking_amount'] = $request['amountVal'];
			}
			else {
				$payment_method = getTableValue("tbl_service_requests" , "payment_method" , array("id" => $request['request_id']));

				if(($payment_method != "")) {
					$returnResponse = array(
						'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
						'status'		=> false,
						'message'  	 	=> ALRDY_PAID,
						'data'  		=> array());

					return $returnResponse;
				}

				$payment_status = getTableValue("tbl_service_requests" , "payment_status" , array("id" => $request['request_id']));

				if(($payment_status == 'running')) {
					$returnResponse = array(
						'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
						'status'		=> false,
						'message'  	 	=> ALRDY_INITIATED_PAYMENT,
						'data'  		=> array());

					return $returnResponse;
				}

				$accept_paypal = getTableValue("tbl_service_requests" , "accept_paypal" , array("id" => $request['request_id']));

				if($accept_paypal != 'y') {
					$request['payment_method'] = 'offline';
				}
				if(($request["payment_method"] == "online") || ($request["payment_method"] == "offline")) {
					$providerId = getTableValue("tbl_service_requests" , "provider_id" , array("id" => $request['request_id']));
					$paypalId = getTableValue("tbl_users" , "paypalEmail" , array("id" => $providerId));

					if(($request["payment_method"] == "online") && ($paypalId == "")) {
						$returnResponse = array(
							'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
							'status'		=> false,
							'message'  	 	=> PROV_HAS_NOT_ADDED_PAYPAL,
							'data'  		=> array());
						return $returnResponse;
					}
				}
				else {
					$returnResponse = array(
						'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
						'status'		=> false,
						'message'  	 	=> FILL_VALUES,
						'data'  		=> array());
					return $returnResponse;
				}

				$updArr['complete_customer'] = 'y';
			}

            $this->db->update('tbl_service_requests' , $updArr , array('id' => $request["request_id"]));

            $providerComplete = getTableValue("tbl_service_requests" , "complete_provider" , array("id" => $request["request_id"]));

            $customerComplete = getTableValue("tbl_service_requests" , "complete_customer" , array("id" => $request["request_id"]));

            if($providerComplete == 'y' && $customerComplete == 'y') {
            	$this->db->update('tbl_service_requests' , array('service_status' => "complete") , array('id' => $request["request_id"]));
            }
			
			if($request["userType"] == 'provider') {
				$receiverId = getTableValue("tbl_service_requests" , "customer_id" , array("id" => $request['request_id']));

				$mailConstant = 'service_complete_by_provider';
				$notificationMsg = COMPLETE_BY_PROVIDER;
			}
			else {
				$receiverId = getTableValue("tbl_service_requests" , "provider_id" , array("id" => $request['request_id']));
				$mailConstant = 'service_complete_by_customer';
				$notificationMsg = COMPLETE_BY_CUSTOMER;
			}
			$notify_type = 'service_completed';

			$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $receiverId));
			if($notification == 'y') {
				//send mail to customer
				$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $receiverId)->result();
				$to = $userInfo['email'];

				$serviceLink = SITE_URL . 'service-detail/' . $request['request_id'];
				$arrayCont = array(
					'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
					'serviceLink' => "<a href='".$serviceLink."'>Click Here</a>",
					 );
				$array = generateEmailTemplate($mailConstant , $arrayCont);

				sendEmailAddress($to,$array['subject'],$array['message']);

				$insertNotify = array(									
								'receiverId' => $receiverId,
								'notification' => $notificationMsg,
								'notify_data' => array("request_id" => $request['request_id']),
								'notify_action' => 'service_completed'
							);
				sendUserNotification($insertNotify);
			}

			if($request["userType"] == 'provider') {
				$returnResponse = array(
					'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
					'status'		=> true,
					'message'  	 	=> MSG_SERVICE_COMPLETED_SUC,
					'data'  		=> array());

				return $returnResponse;
			}
			else {
				$booking_amount = getTableValue("tbl_service_requests" , "booking_amount" , array("id" => $request['request_id']));

				if($request["payment_method"] == "online") {
					
					$updArray = array(									
									'payment_status' => 'running',
									'processingStartTime' => date("Y-m-d H:i")
								);

					$this->db->update('tbl_service_requests' , $updArray , array("id" => $request["request_id"]));

					$url_paypal = PAYPAL_URL;
		            $url_paypal.="?business=".urlencode($paypalId);
		            $url_paypal.="&cmd=".urlencode('_xclick');
		            $url_paypal.="&item_name=".urlencode(SITE_NM);
		            $url_paypal.="&item_number=".urlencode($request['request_id']);
		            $url_paypal.="&custom=".urlencode($this->sessUserId);
		            $url_paypal.="&amount=".urlencode($booking_amount);
		            $url_paypal.="&currency_code=".urlencode(PAYPAL_CURRENCY_CODE);
		            $url_paypal.="&handling=".urlencode('0');
		            $url_paypal.="&rm=2";
		            if($_SERVER["SERVER_NAME"] == '192.168.100.71' || $_SERVER["SERVER_NAME"] == 'localhost' || $_SERVER["SERVER_NAME"] == 'nct71' )
		            {
		                $url_paypal.="&return=".urlencode(SITE_MOD."notify.php");
		            }else{
		                $url_paypal.="&return=".urlencode(SITE_MOD."thankyou.php?platformType=" . $this->sessRequestType . "&user_id=" . $this->sessUserId);
		            }
		            $url_paypal.="&cancel_return=".urlencode(SITE_MOD."failed.php?platformType=" . $this->sessRequestType);
		            $url_paypal.="&notify_url=".urlencode(SITE_MOD."notify.php");

		            $redirectLink = $url_paypal;
				}
				else {
					$redirectLink = SITE_URL . 'service-detail/' . $request['request_id'];

					$updArray = array(
									'payment_method' => "offline",
									'payment_status' => 'paid'
								);

					$this->db->update('tbl_service_requests' , $updArray , array("id" => $request["request_id"]));

					$insArray = array(
								"userId" => $this->sessUserId,
								"request_id" => $request["request_id"],
								"txn_type" => "service_payment",
								"transactionId" => uniqid(),
								"amount" => $booking_amount,
								"payment_method" => "offline",
								"ipAddress" => get_ip_address()
							);

					$this->db->insert("tbl_payment_history" , $insArray);
				}				

				$returnResponse = array(
						'redirectLink' 	=> $redirectLink,
						'status'		=> true,
						'message'  	 	=> MSG_SERVICE_COMPLETED_SUC,
						'data'  		=> array());
				

				return $returnResponse;
			}
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function postReview($request = array()) {
		$alreadyRated = getTableValue("tbl_reviews" , "id" , array("sender_id" => $this->sessUserId , "service_request_id" => $request['request_id']));

		if($alreadyRated == '') {
			$insertArray = array(
								'rating' => $request['rating'],
								'description' => $request['description'],
								'sender_id' => $this->sessUserId,
								'receiver_id' => $request['receiver_id'],
								'service_request_id' => $request['request_id'],
							);

			$this->db->insert('tbl_reviews' , $insertArray);

			$returnResponse = array(
					'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
					'status'		=> true,
					'message'  	 	=> MSG_REVIEW_POSTED_SUC,
					'data'  		=> array());
		}
		else {
			$returnResponse = array(
					'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['request_id'],
					'status'		=> false,
					'message'  	 	=> ALREADY_REVIEWED,
					'data'  		=> array());
		}

		return $returnResponse;
	}
	public function saveAmount($request = array()) {
		$booking_amount = getTableValue("tbl_service_requests" , "booking_amount" , array("id" => $request["service_request_id"]));

		if(($booking_amount == 0) || ($booking_amount == "")) {
			$updArray = array(
								'booking_amount' => $request['amountVal']
							);

			$this->db->update('tbl_service_requests' , $updArray , array("id" => $request["service_request_id"]));

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['service_request_id'],
				'status'		=> true,
				'message'  	 	=> MSG_AMOUNT_ADDED_SUC,
				'data'  		=> array());
		}
		else {
			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['service_request_id'],
				'status'		=> false,
				'message'  	 	=> MSG_ALREADY_AMT_ADDED,
				'data'  		=> array());
		}		

		return $returnResponse;
	}
	public function savePaymentMethod($request = array()) {
		$payment_method = getTableValue("tbl_service_requests" , "payment_method" , array("id" => $request['service_request_id']));

		if(($payment_method != "")) {
			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['service_request_id'],
				'status'		=> false,
				'message'  	 	=> ALRDY_PAID,
				'data'  		=> array());

			return $returnResponse;
		}

		$payment_status = getTableValue("tbl_service_requests" , "payment_status" , array("id" => $request['service_request_id']));

		if(($payment_status == 'running')) {
			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['service_request_id'],
				'status'		=> false,
				'message'  	 	=> ALRDY_INITIATED_PAYMENT,
				'data'  		=> array());

			return $returnResponse;
		}

		if(($request["payment_method"] == "online") || ($request["payment_method"] == "offline")) {
			$providerId = getTableValue("tbl_service_requests" , "provider_id" , array("id" => $request['service_request_id']));
			$paypalId = getTableValue("tbl_users" , "paypalEmail" , array("id" => $providerId));

			if(($request["payment_method"] == "online") && ($paypalId == "")) {
				$returnResponse = array(
					'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['service_request_id'],
					'status'		=> false,
					'message'  	 	=> PROV_HAS_NOT_ADDED_PAYPAL,
					'data'  		=> array());
			}
			else {
				$booking_amount = getTableValue("tbl_service_requests" , "booking_amount" , array("id" => $request['service_request_id']));

				if($request["payment_method"] == "online") {
					
					$updArray = array(									
									'payment_status' => 'running',
									'processingStartTime' => date("Y-m-d H:i")
								);

					$this->db->update('tbl_service_requests' , $updArray , array("id" => $request["service_request_id"]));

					$url_paypal = PAYPAL_URL;
		            $url_paypal.="?business=".urlencode($paypalId);
		            $url_paypal.="&cmd=".urlencode('_xclick');
		            $url_paypal.="&item_name=".urlencode(SITE_NM);
		            $url_paypal.="&item_number=".urlencode($request['service_request_id']);
		            $url_paypal.="&custom=".urlencode($this->sessUserId);
		            $url_paypal.="&amount=".urlencode($booking_amount);
		            $url_paypal.="&currency_code=".urlencode(PAYPAL_CURRENCY_CODE);
		            $url_paypal.="&handling=".urlencode('0');
		            $url_paypal.="&rm=2";
		            if($_SERVER["SERVER_NAME"] == '192.168.100.71' || $_SERVER["SERVER_NAME"] == 'localhost' || $_SERVER["SERVER_NAME"] == 'nct71' )
		            {
		                $url_paypal.="&return=".urlencode(SITE_MOD."notify.php");
		            }else{
		                $url_paypal.="&return=".urlencode(SITE_MOD."thankyou.php?platformType=" . $this->sessRequestType . "&user_id=" . $this->sessUserId);
		            }
		            $url_paypal.="&cancel_return=".urlencode(SITE_MOD."failed.php?platformType=" . $this->sessRequestType);
		            $url_paypal.="&notify_url=".urlencode(SITE_MOD."notify.php");

		            $redirectLink = $url_paypal;
				}
				else {
					$redirectLink = SITE_URL . 'service-detail/' . $request['service_request_id'];

					$updArray = array(
									'payment_method' => "offline",
									'payment_status' => 'paid'
								);

					$this->db->update('tbl_service_requests' , $updArray , array("id" => $request["service_request_id"]));

					$insArray = array(
								"userId" => $this->sessUserId,
								"request_id" => $request["service_request_id"],
								"txn_type" => "service_payment",
								"transactionId" => uniqid(),
								"amount" => $booking_amount,
								"payment_method" => "offline",
								"ipAddress" => get_ip_address()
							);

					$this->db->insert("tbl_payment_history" , $insArray);
				}				

				$returnResponse = array(
						'redirectLink' 	=> $redirectLink,
						'status'		=> true,
						'message'  	 	=> MSG_PAYMENT_METHOD_SUC,
						'data'  		=> array());
			}
		}
		else {
			$returnResponse = array(
				'redirectLink' 	=> SITE_URL . 'service-detail/' . $request['service_request_id'],
				'status'		=> false,
				'message'  	 	=> FILL_VALUES,
				'data'  		=> array());
		}

		return $returnResponse;
	}
}

?>
