<?php
class service_request {
	function __construct($contentArray = array()) {
		global $sessUserId,$sessRequestType,$objHome;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;

		}
		extract($contentArray);
		$this->module = $module;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId = isset($userId) && $userId ? $userId : $sessUserId;
		$this->objHome = $objHome;
		$this->provider_id = $provider_id;
	}

	public function saveMechService($request = array()){
			try{
				if(!empty($request)){

					$checkAvailability = $this->checkProviderAvailability($request);
					if($checkAvailability['data']['result'] == 'fail') {
						$returnResponse = array(
							'redirectLink'	=> SITE_URL . 'new-service-request',
							'status'		=> false,
							'message'   	=> PROV_NOT_AVAILABLE,
							'data'  		=> array());

						return $returnResponse;
					}

					$service_time_slot  = isset($request['service_time_slot']) ? filtering($request['service_time_slot'],'input'): '';
					//$address  = isset($request['address']) ? filtering($request['address'],'input'): '';
					$service_date = date("Y-m-d" , strtotime($request['service_date']));
					$message  = isset($request['cust_message']) ? filtering($request['cust_message'],'input'): '';

					if($service_time_slot != ''){
							
							$insertarray = array(
								"service_time_slot"  => $service_time_slot,
								"service_date"       => $service_date,
								"message"            => $message,
								"provider_id"        => $request['provider_id'],
								"customer_id"        => $this->sessUserId,
								"unique_id"          => uniqid(),
								"service_type"       => "mechanic",
								"address"            => "",
								"addLat"             => "",
								"addLong"            => "",
								"dest_detail" => isset($request['dest_detail']) ? $request['dest_detail'] : "",
								"num_pass" => isset($request['num_pass']) ? $request['num_pass'] : ""
								);
							$insert_id=$this->db->insert('tbl_service_requests',$insertarray)->getLastInsertId();


							$mailConstant = 'request_received';
							$notificationMsg = REQUEST_RECEIVED_NOTI_MSG;
							
							$notify_type = 'request_received';

							$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $request['provider_id']));
							if($notification == 'y') {
								//send mail to provider
								$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $request['provider_id'])->result();
								$to = $userInfo['email'];

								$serviceLink = SITE_URL . 'new-service-request';
								$arrayCont = array(
									'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
									'customerName' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
									'serviceLink' => "<a href='".$serviceLink."'>". CLICK_HERE . "</a>",
									 );
								$array = generateEmailTemplate($mailConstant , $arrayCont);

								sendEmailAddress($to,$array['subject'],$array['message']);
							}

							$returnResponse = array(
								'redirectLink' 	=> SITE_URL,
								'status'		=> true,
								'message'   	=> MSG_SERVICE_REQ_ADDED,
								'data'  		=> array());

							return $returnResponse;

					}else{
							throw new Exception(FILL_VALUES);
					}
				}else{
					throw new Exception(FILL_VALUES);
				}
			}
			catch(Exception $e){
				$returnResponse = array(
					'redirectLink'	=> SITE_URL,
					'status'		=> false,
					'message'   	=> $e->getMessage(),
					'data'  		=> array());

				return $returnResponse;
			}
	}

	public function saveTaxiService($request = array()){
			try{
				if(!empty($request)){

					$checkAvailability = $this->checkTaxiProvAvailability($request);
					if($checkAvailability['data']['result'] == 'fail') {
						$returnResponse = array(
							'redirectLink'	=> SITE_URL . 'new-service-request',
							'status'		=> false,
							'message'   	=> PROV_NOT_AVAILABLE,
							'data'  		=> array());

						return $returnResponse;
					}
					
					$start_date  = isset($request['start_date']) ? filtering($request['start_date'],'input'): '';
					$end_date  = isset($request['end_date']) ? filtering($request['end_date'],'input'): '';
					$location_details  = isset($request['location_details']) ? filtering($request['location_details'],'input'): '';
					
					$start_date = date("Y-m-d" , strtotime($start_date));
					$end_date = date("H:i" , strtotime($end_date));

					$message  = isset($request['cust_message']) ? filtering($request['cust_message'],'input'): '';

					if($start_date != '' && $end_date != ''){
							
							$insertarray = array(
								"start_date"  => $start_date,
								"end_date"       => $end_date,
								"message"           => $message,
								"provider_id"        => $request['provider_id'],
								"customer_id"        => $this->sessUserId,
								"unique_id"          => uniqid(),
								"service_type"       => "taxi",
								"location_details"   => $location_details,
								"address"            => "",
								"addLat"             => "",
								"addLong"            => "",
								"dest_detail" => isset($request['dest_detail']) ? $request['dest_detail'] : "",
								"num_pass" => isset($request['num_pass']) ? $request['num_pass'] : ""
								);
							$insert_id=$this->db->insert('tbl_service_requests',$insertarray)->getLastInsertId();

							$mailConstant = 'request_received';
							$notificationMsg = REQUEST_RECEIVED_NOTI_MSG;
							
							$notify_type = 'request_received';

							$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $request['provider_id']));
							if($notification == 'y') {
								//send mail to provider
								$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $request['provider_id'])->result();
								$to = $userInfo['email'];

								$serviceLink = SITE_URL . 'new-service-request';
								$arrayCont = array(
									'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
									'customerName' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
									'serviceLink' => "<a href='".$serviceLink."'>Click Here</a>",
									 );
								$array = generateEmailTemplate($mailConstant , $arrayCont);

								sendEmailAddress($to,$array['subject'],$array['message']);

								$insertNotify = array(									
									'receiverId' => $receiverId,
									'notification' => $notificationMsg,
									'notify_data' => array("request_id" => $insert_id),
									'notify_action' => 'request_received'
								);
								sendUserNotification($insertNotify);
							}

							$returnResponse = array(
								'redirectLink' 	=> SITE_URL,
								'status'		=> true,
								'message'   	=> MSG_SERVICE_REQ_ADDED,
								'data'  		=> array());

							return $returnResponse;

					}else{
							throw new Exception(FILL_VALUES);
					}
				}else{
					throw new Exception(FILL_VALUES);
				}
			}
			catch(Exception $e){
				$returnResponse = array(
					'redirectLink'	=> SITE_URL,
					'status'		=> false,
					'message'   	=> $e->getMessage(),
					'data'  		=> array());

				return $returnResponse;
			}
	}

	public function checkProviderAvailability($request = array()) {
		try{
			if(!empty($request)){
				$data = array();
        
		        $service_date = date("Y-m-d" , strtotime($request['service_date']));

		        $recordExist = $this->db->pdoQuery("SELECT id FROM tbl_provider_availability WHERE start_date = '".$service_date."' AND slot = " . $request['service_time_slot'] . " AND provider_id = " . $request['provider_id'])->affectedRows();

		        if($recordExist > 0) {
		                $data['result'] = 'fail';
		        }
		        else {
		                $data['result'] = 'success';
		        }

		        $returnResponse = array(
					'redirectLink' 	=> SITE_URL,
					'status'		=> true,
					'message'   	=> "",
					'data'  		=> $data);

				return $returnResponse;
			}else{
				throw new Exception(FILL_VALUES);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL,
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function checkTaxiProvAvailability($request = array()) {
		try{
			if(!empty($request)){
				$data = array();
        
		        $start_date = date("Y-m-d" , strtotime($request['start_date']));
		        $end_date = date("Y-m-d" , strtotime($request['end_date']));

		        /*$recordExist = $this->db->pdoQuery("SELECT id FROM tbl_provider_availability WHERE start_date >= '".$start_date."' AND start_date <= '" . $end_date . "' AND provider_id = " . $request['provider_id'])->affectedRows();*/
		        $recordExist = $this->db->pdoQuery("SELECT id FROM tbl_provider_availability WHERE start_date = '".$start_date."'  AND provider_id = " . $request['provider_id'])->affectedRows();

		        if($recordExist > 0) {
		                $data['result'] = 'fail';
		        }
		        else {
		                $data['result'] = 'success';
		        }

		        $returnResponse = array(
					'redirectLink' 	=> SITE_URL,
					'status'		=> true,
					'message'   	=> "",
					'data'  		=> $data);

				return $returnResponse;
			}else{
				throw new Exception(FILL_VALUES);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL,
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function getPageContent() {

		$providerType = getTableValue("tbl_users" , "service_type" , array("id" => $this->provider_id));		

		$replaceArr = array(
			"%PROVIDER_ID%" => $this->provider_id
		);
		// remaining to remove debug data 
		if(($_SESSION['user_type'] == 'provider' && $_SESSION['service_type'] == 'mechanic') || $providerType == 'mechanic') {
			$dest_location_input='
	<div class="col-md-12">
        <div class="form-group">
            <textarea id="cust_message" name="cust_message" placeholder="'.ENTER_MSG.'" class="form-control"></textarea>
        </div>
    </div>';
			
		}else {
			$dest_location_input='<div class="col-md-6">
        <div class="form-group">
            <textarea id="cust_message" name="cust_message" placeholder="'.ENTER_MSG.'" class="form-control"></textarea>
        </div>
    </div>
	<div class="col-md-6">
        <div class="form-group">
            <input type="text" id="dest_detail" name="dest_detail" placeholder="'.DEST_DETAIL.'" class="form-control" >
        </div>
    </div>
	<div class="col-md-6">
        <div class="form-group">
            <input type="text" id="num_pass" name="num_pass" placeholder="'.NUM_PASS.'" class="form-control">
        </div>
    </div>';
			
		}
		
		if($providerType == 'mechanic') {			
			$replaceArr["%TIME_SLOTS%"] = prepare_time_slots();
			$formData = get_view(DIR_TMPL . $this->module . "/mechanic-nct.tpl.php",$replaceArr);
		}
		else {			
			$formData = get_view(DIR_TMPL . $this->module . "/taxi-nct.tpl.php",$replaceArr);
		}

		$array=array(
						"%FORM_DATA%" => $formData,
						"%USR_SERVICE_TYPE%" => $providerType,
						"%DEST_LOCATION_INPUT%" => $dest_location_input,
					);

		$returnResponse = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php",$array);
		return $returnResponse;
	}
}

?>
