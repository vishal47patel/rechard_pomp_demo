<?php
class NewServiceRequest{
	function __construct($contentArray = array()) {

		global $sessUserId, $fields;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);
		
		$this->id = $id;

		$this->type     = $type;
		$this->module     = $module;
		$this->fields    = $fields;
		$this->sessUserId = isset($userId) && $userId > 0 ? $userId : $this->sessUserId;
		$this->pageNo     = isset($pageNo) ? $pageNo : 1;
		$this->action = $action;
	}
	public function getPageContent() {
		$final_content="";

		$serviceReqList=$this->getServiceReqList();

		$replace = array(			
			'%SERVICE_REQ_LIST%' => $serviceReqList['retData']['html'],
			'%SERVICE_REQ_PAGINATION%' => $serviceReqList['retData']['pagination']
		);

		$final_content= get_view(DIR_TMPL . "{$this->module}/{$this->module}.tpl.php",$replace);
		return $final_content;

	}

	public function acceptRejectRequest($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$type = isset($type) ? ($type): '';
				//print_r($type);exit;
				if($type!=""){
					
					$this->db->query("UPDATE tbl_service_requests SET request_status = '".$type."' WHERE id = '".$id."' AND provider_id='".$this->sessUserId."' ");

					if($type=='a'){
						$msg=SER_REQ_ACCEPTED;

						$customerId = getTableValue("tbl_service_requests" , "customer_id" , array("id" => $id));

						$mailConstant = 'request_accepted';
						$notificationMsg = REQUEST_ACCEPTED_NOTI_MSG;
						
						$notify_type = 'assigned_customer';

						$notification = getTableValue('tbl_email_notification_setting' , $notify_type , array('userId' => $customerId));
						if($notification == 'y') {
							//send mail to customer
							$userInfo = $this->db->pdoQuery("SELECT firstName,lastName,email FROM tbl_users WHERE id=" . $customerId)->result();
							$to = $userInfo['email'];

							$serviceLink = SITE_URL . 'service-detail/' . $id;
							$arrayCont = array(
								'greetings'=>$userInfo['firstName'] . ' ' . $userInfo['lastName'],
								'providerName' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
								'serviceLink' => "<a href='".$serviceLink."'>Click Here</a>",
								 );
							$array = generateEmailTemplate($mailConstant , $arrayCont);

							sendEmailAddress($to,$array['subject'],$array['message']);

							$insertNotify = array(									
									'receiverId' => $customerId,
									'notification' => $notificationMsg,
									'notify_data' => array("request_id" => $id),
									'notify_action' => 'service_provider_assigned'
								);
							sendUserNotification($insertNotify);
						}
					}else{
						$msg=SER_REQ_REJECTED;
					}
					
					$returnResponse = array(
				        'redirectLink'  => SITE_URL."new-service-request",
				        'status'        => true,
				        'message'       => $msg,
				        'data'          => '');

					return $returnResponse;

				}else{
		    		throw new Exception(MSG_FILL_ALL_VALUE);
		    	}

			}else{
				throw new Exception(MSG_FILL_ALL_VALUE);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'new-service-request',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}

	public function getServiceReqList(){

		$final_content = "";

		$serviceQry="SELECT sr.*,u.firstName,u.lastName,u.profileImg,u.contactNo FROM tbl_service_requests as sr
		LEFT JOIN tbl_users as u ON u.id=sr.customer_id WHERE sr.provider_id = '".$this->sessUserId."' ORDER BY sr.id DESC";

		$affRows = $this->db->pdoQuery($serviceQry)->affectedRows();

		$pageNo = isset($this->pageNo) ? $this->pageNo : 1;

		$pager = getPagerData($affRows, SCROLL_LIMIT, $pageNo);
		if ($this->sessRequestType == 'app') {
			$pagination['current_page'] = issetor($pager->page, 0);
			$pagination['total_pages']  = issetor($pager->numPages, 0);
			$pagination['total']        = issetor($affRows, 0);
		} else {
			$pagination = pagination($pager, $this->pageNo, $affRows);
		}

		if ($pageNo <= $pager->numPages){
			$offset = $pager->offset;
			if ($offset < 0) {
				$offset = 0;
			}

			$limit = $pager->limit;

			$page = $pager->page;

			$limit_cond = " LIMIT $offset, $limit";

			$qryQuery = $this->db->pdoQuery($serviceQry . $limit_cond);
			$NoOfrows   = $qryQuery->affectedRows();

			if ($NoOfrows > 0) {
				$qryRes = $qryQuery->results();
				
				foreach ($qryRes as $key => $fetchRes) {
					$service_type="";

					$customer_name=$fetchRes['firstName'].' '.$fetchRes['lastName'];
					$message = ($fetchRes['message'] != "") ? $fetchRes['message'] : "N/A";
					$message = myTruncate($message , "100");
					$customer_img=checkImage('profile/'.$fetchRes['customer_id'].'/th2_',$fetchRes['profileImg']);
					$customer_img_main=checkImage('profile/'.$fetchRes['customer_id'].'/th2_',$fetchRes['profileImg'] , "mainImage");

					if($fetchRes['service_type']=='mechanic'){
						$service_type=MECHANIC_SERVICE;
						$dest_detail = '';
						$num_pass = '';
					}else{
						$service_type=TAXI_SERVICE;
						$dest_detail = "<p>".DEST_DETAIL." : ".$fetchRes['dest_detail']."</p>";
						$num_pass = "<p>".NUM_PASS." : ". $fetchRes['num_pass']."</p>";
						
					}
					$service_date=date("Y-m-d",strtotime($fetchRes['service_date']));

					$detailBtn = "";
					if($fetchRes['request_status']=='p'){
						$request_btn='<div class="col-md-6"><a class="btn-main btn-main-red w-100 mb-2 min-width-0 acpt_rej_req" href="javascript:void(0);" data-id="'.$fetchRes['id'].'" data-type="a">'.ACCEPT.'</a></div><div class="col-md-6"><a class="btn-main btn-red-outer w-100 mb-2 min-width-0 acpt_rej_req" href="javascript:void(0);" data-id="'.$fetchRes['id'].'" data-type="r">'.REJECT.'</a></div>';	
					}else if($fetchRes['request_status']=='a'){
						$request_btn='<div class="col-md-12"><a class="btn-main btn-main-gray w-100 mb-2 min-width-0" href="javascript:void(0);">'.ACCEPTED.'</a></div>';	
						$detailBtn = '<a class="btn-main btn-main-red w-100" href="'.SITE_URL.'service-detail/'.$fetchRes['id'].'">'.SERVICE_DETAILS.'</a>';	
					}else if($fetchRes['request_status']=='r'){
						$request_btn='<div class="col-md-12"><a class="btn-main btn-main-gray w-100 mb-2 min-width-0" href="javascript:void(0);">'.REJECTED.'</a></div>';	
					}
					$customer_url=SITE_URL."profile/".$fetchRes['customer_id'];

					$address = getTableValue("tbl_users" , "address" , array("id" => $fetchRes['provider_id']));

					if($fetchRes['service_type']=='mechanic'){
						$dispStartDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['service_date']));
						
						$dispServiceDate = $dispStartDate . ' ' . ($fetchRes['service_time_slot'] - 1) . ":00" . ' - ' . ($fetchRes['service_time_slot']) . ":00";
					}
					else {
						$dispStartDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['start_date']));

						$dispEndDate = date("H:i" , strtotime($fetchRes['end_date']));

						$dispServiceDate = $dispStartDate . " - " . $dispEndDate;
					}
					
					$statusData = '';
					$statusData_api = '';
					if($fetchRes['service_status'] == 'upcoming') {
						$statusData_api = UPCOMING;
						$statusData = '<span class="lbl-upcoming status-lbl-redius">'.UPCOMING.'</span>';
					}
					else if($fetchRes['service_status'] == 'ongoing') {
						$statusData_api = ONGOING;
						$statusData = '<span class="lbl-ongoing status-lbl-redius">'.ONGOING.'</span>';
					}
					else if($fetchRes['service_status'] == 'complete') {
						$statusData_api = COMPLETED;
						$statusData = '<span class="lbl-complete status-lbl-redius">'.COMPLETED.'</span>';
					}
					else if($fetchRes['service_status'] == 'cancel') {
						$statusData_api = CANCELLED;
						$statusData = '<span class="lbl-cancel status-lbl-redius">'.CANCELLED.'</span>';
					}
					
					$replace = array(
							'%ID%'=>$fetchRes['id'],
							'%CUSTOMER_NAME%'=>$customer_name,
							'%CUSTOMER_IMG%'=>$customer_img,
							"%CUSTOMER_IMG_MAIN%" => $customer_img_main, 
							'%CUSTOMER_URL%'=>$customer_url,
							'%SERVICE_TYPE%'=>$service_type,
							'%SERVICE_DATE%'=>$dispServiceDate,
							'%ADDRESS%'=>$address,
							'%REQ_BTN%'=>$request_btn,
							'%CONTACT_NO%'=>$fetchRes['contactNo'],
							"%DETAIL_BTN%" => $detailBtn,
							"%MESSAGE%" => $message,
							"%STATUS%" => $statusData,
							"%DEST_DETAIL%" => $dest_detail,
							"%NUM_PASS%" => $num_pass,
							// "type"  => $service_type
						);
					$final_content .= get_view(DIR_TMPL .$this->module. "/service_req_row-nct.tpl.php",$replace);
					$service_list[$key]['id']            = $fetchRes['id'];
					$service_list[$key]['customer_id'] = $fetchRes['customer_id'];
					$service_list[$key]['customer_name'] = $customer_name;
					$service_list[$key]['customer_img'] = $customer_img;
					$service_list[$key]['customer_url'] = $customer_url;
					$service_list[$key]['service_type'] = $service_type;
					$service_list[$key]['service_date'] = $service_date;
					$service_list[$key]['service_time_slot'] = $fetchRes['service_time_slot'];
					$service_list[$key]['start_date'] = $fetchRes['start_date'];
					$service_list[$key]['end_date'] = $fetchRes['end_date'];
					$service_list[$key]['address'] = $address;
					$service_list[$key]['request_status'] = $fetchRes['request_status'];
					
					$service_list[$key]['contactNo'] = $fetchRes['contactNo'];
					$service_list[$key]['message'] = $message;
					$service_list[$key]['status'] = $statusData_api;
				}
				if ($this->sessRequestType == 'app') {
					$returnResponse = array(
						'status'     => true,
						'message'    => 'success',
						'data'    => array('pagination' => $pagination,"service_list" => $service_list));
				} else {

					$retData['html']       = $final_content;
					$retData['pagination'] = $pagination;

					$returnResponse = array(
						'status'  => true,
						'message' => '',
						'retData' => $retData);
				}
			}else{
				if ($this->sessRequestType == 'app') {
					$returnResponse = array(						
						'status'     => false,
						'message'    => NO_ANY_SER_REQ_REC,
						'data'    => array('pagination' => $pagination));
				} else {

					$retData['html']       = '<div class="col-12 col-md-12 col-lg-12 card-deck"><a href="javascript:void(0);" class="btn-main btn-blue-outer w-100">'.NO_ANY_SER_REQ_REC.'</a></div>';
					$retData['pagination'] = $pagination;
					$returnResponse        = array(
						'status'  => false,
						'message' => NO_ANY_SER_REQ_REC,
						'retData' => $retData);
				}
			}
		}else{
			if ($this->sessRequestType == 'app') {
				$returnResponse = array(						
					'status'     => false,
					'message'    => NO_ANY_SER_REQ_REC,
					'data'    => array('pagination' => $pagination));
			} else {

				$retData['html']       = '<div class="col-12 col-md-12 col-lg-12 card-deck"><a href="javascript:void(0);" class="btn-main btn-blue-outer w-100">'.NO_ANY_SER_REQ_REC.'</a></div>';
				$retData['pagination'] = "";
				$returnResponse        = array(
					'status'  => false,
					'message' => NO_ANY_SER_REQ_REC,
					'retData' => $retData);
			}
		}
		return $returnResponse;
	}
}
?>