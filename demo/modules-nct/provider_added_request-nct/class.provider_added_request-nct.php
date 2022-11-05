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
		$this->provider_id = $this->sessUserId;
		$this->customer_id = $customer_id;
	}

	public function checkProviderAvailability($request = array()) {
		try{
			if(!empty($request)){
				$data = array();
        
		        $service_date = date("Y-m-d" , strtotime($request['service_date']));

		        $recordExist = $this->db->pdoQuery("SELECT id FROM tbl_provider_availability WHERE start_date = '".$service_date."' AND slot = " . $request['service_time_slot'] . " AND provider_id = " . $this->sessUserId)->affectedRows();

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
		        $recordExist = $this->db->pdoQuery("SELECT id FROM tbl_provider_availability WHERE start_date = '".$start_date."'  AND provider_id = " . $this->sessUserId)->affectedRows();

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
					
					if($service_time_slot != ''){
							
							$insertarray = array(
								"service_time_slot"  => $service_time_slot,
								"service_date"       => $service_date,
								"provider_id"        => $this->sessUserId,
								"customer_id"        => $request['customer_id'],
								"unique_id"          => uniqid(),
								"service_type"       => "mechanic",
								"request_status"     => "a",
								"address"            => "",
								"addLat"             => "",
								"addLong"            => "",
								"dest_detail" => isset($request['dest_detail']) ? $request['dest_detail'] : "",
								"num_pass" => isset($request['num_pass']) ? $request['num_pass'] : ""
								);
							$insert_id=$this->db->insert('tbl_service_requests',$insertarray)->getLastInsertId();

							$customerId = $request['customer_id'];

							$mailConstant = 'request_accepted';
							$notificationMsg = REQUEST_ACCEPTED_NOTI_MSG;
							
							$notify_type = 'assigned_customer';

							$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $customerId));
							if($notification == 'y') {
								//send mail to customer
								$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $customerId)->result();
								$to = $userInfo['email'];

								$serviceLink = SITE_URL . 'service-detail/' . $insert_id;
								$arrayCont = array(
									'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
									'providerName' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
									'serviceLink' => "<a href='".$serviceLink."'>Click Here</a>",
									 );
								$array = generateEmailTemplate("request_by_provider" , $arrayCont);

								sendEmailAddress($to,$array['subject'],$array['message']);

								$insertNotify = array(									
										'receiverId' => $customerId,
										'notification' => $notificationMsg,
										'notify_data' => array("request_id" => $insert_id),
										'notify_action' => 'service_provider_assigned'
									);
								sendUserNotification($insertNotify);
							}

							$returnResponse = array(
								'redirectLink' 	=> SITE_URL . 'new-service-request',
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
		// print_r($request);exit;
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

					if($start_date != '' && $end_date != ''){
							
							$insertarray = array(
								"start_date"  => $start_date,
								"end_date"       => $end_date,
								"provider_id"        => $this->sessUserId,
								"customer_id"        => $request['customer_id'],
								"unique_id"          => uniqid(),
								"service_type"       => "taxi",
								"request_status"     => "a",
								"location_details"   => $location_details,
								"address"            => "",
								"addLat"             => "",
								"addLong"            => "",
								"dest_detail" => isset($request['dest_detail']) ? $request['dest_detail'] : "",
								"num_pass" => isset($request['num_pass']) ? $request['num_pass'] : ""
								);
							// print_r($insertarray);exit;
							$insert_id=$this->db->insert('tbl_service_requests',$insertarray)->getLastInsertId();

							$customerId = $request['customer_id'];

							$mailConstant = 'request_accepted';
							$notificationMsg = REQUEST_ACCEPTED_NOTI_MSG;
							
							$notify_type = 'assigned_customer';

							$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $customerId));
							if($notification == 'y') {
								//send mail to customer
								$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $customerId)->result();
								$to = $userInfo['email'];

								$serviceLink = SITE_URL . 'service-detail/' . $insert_id;
								$arrayCont = array(
									'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
									'providerName' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
									'serviceLink' => "<a href='".$serviceLink."'>Click Here</a>",
									 );
								$array = generateEmailTemplate("request_by_provider" , $arrayCont);

								// sendEmailAddress($to,$array['subject'],$array['message']);

								$insertNotify = array(									
										'receiverId' => $customerId,
										'notification' => $notificationMsg,
										'notify_data' => array("request_id" => $insert_id),
										'notify_action' => 'service_provider_assigned'
									);
								// sendUserNotification($insertNotify);
							}

							$returnResponse = array(
								'redirectLink' 	=> SITE_URL . 'new-service-request',
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

	public function getCustomerList() {
		// echo "dfasdfs ";exit;
		$customerList = '';
		$appCustomerData = array();
		$query = "SELECT id , createdDate, address , firstName , lastName FROM tbl_users WHERE user_type = 'customer' AND isActive = 'y' AND isEmailVerify = 'y'";
		if($this->sessRequestType == 'app') {
			if(!isset($_REQUEST['provider_id']) || (isset($_REQUEST['provider_id']) && trim($_REQUEST['provider_id']) == '')){
				$returnResponse = array(
										'redirectLink' 	=> "",
										'status'		=> false,
										'message'   	=> MSG_PROVIDER_ID_REQ,
										'data'  		=> "",
										);	
										
				return $returnResponse;
			}
		}
		if($this->sessRequestType == 'app' && ($_REQUEST['api_call'] && $_REQUEST['api_call'] == 'api_call')) {
			// print_r($_REQUEST);exit;
			$query = "SELECT tbl_service_requests.id as id, tbl_users.id as user_id, tbl_service_requests.*, tbl_users.* FROM tbl_service_requests";
			$query .= " LEFT JOIN tbl_users ON tbl_service_requests.provider_id = tbl_users.id";
			$query .= " WHERE tbl_users.user_type = 'customer' AND tbl_users.isActive = 'y' AND tbl_users.isEmailVerify = 'y'";
			$flag=0;
			if($_REQUEST['customer_id'] && $_REQUEST['customer_id'] > 0){
				$flag=1;
				$query .= " AND tbl_service_requests.customer_id = ".$_REQUEST['customer_id'];
			}
			if($_REQUEST['provider_id'] && $_REQUEST['provider_id'] > 0){
				$flag=1;
				$query .= " AND provider_id = ".$_REQUEST['provider_id'];
			}
			if($flag==0){
				$query .= " AND provider_id = 0";
			}
			$query .= " GROUP BY tbl_users.id";
		}
		// echo $query1;
		$customerQry = $this->db->pdoQuery($query)->results();
		// print_r($customerQry);exit;

		foreach ($customerQry as $key => $customer) {
			if($this->sessRequestType == 'app') {
				
				$appCustomerData[] = $customer;
				$data['id'] = $customer['id'];
				$data['firstName'] = $customer['firstName'];
				$data['lastName'] = $customer['lastName'];
				// $data['user_id'] = $customer['id'];
				
				// $data['start_date'] = date("d-m-Y", strtotime($customer['createdDate']));
				// $data['end_date'] = date("h:m", strtotime($customer['createdDate']));
				// $data['location_details'] = $customer['address'];
				// $data['customer_id'] = $customer['id'];
				// $data['language_id'] = $_REQUEST['language_id'];
				
				$appCustomerData_new[] = $data;
			}
			else {
				$selected = "";
				if($this->customer_id == $customer['id']) {
					$selected = "selected='selected'";
				}
				$customerList .= "<option value='".$customer['id']."' ".$selected.">".filtering($customer['firstName'] . ' ' . $customer['lastName'])."</option>";
			}			
		}
		if($this->sessRequestType == 'app') {
			// $appCustomerData['language_id'] = $_REQUEST['language_id'];
			// print_r($appCustomerData_new);exit;
			$returnResponse = array(
									'redirectLink' 	=> "",
									'status'		=> true,
									'message'   	=> "",
									'data'  		=> array("customers" => $appCustomerData_new,'language_id'=>$_REQUEST['language_id'])
									);
			// print_r($returnResponse);exit;
			return $returnResponse;
		}
		else {
			return $customerList;
		}
	}

	public function getPageContent() {

		$providerType = getTableValue("tbl_users" , "service_type" , array("id" => $this->provider_id));

		

		$replaceArr = array(
			"%PROVIDER_ID%" => $this->provider_id,
			"%CUSTOMER_LIST%" => $this->getCustomerList()
		);

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
					);

		$returnResponse = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php",$array);
		return $returnResponse;
	}
}

?>