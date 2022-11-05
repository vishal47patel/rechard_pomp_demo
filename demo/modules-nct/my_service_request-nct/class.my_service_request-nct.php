<?php
class MyServiceRequest{
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

	public function getServiceReqList(){

		$final_content = "";

		$serviceQry="SELECT sr.*,u.firstName,u.lastName,u.profileImg,u.contactNo FROM tbl_service_requests as sr
		LEFT JOIN tbl_users as u ON u.id=sr.provider_id WHERE sr.customer_id = '".$this->sessUserId."' ORDER BY sr.id DESC";
		
		// $serviceQry="SELECT sr.*,u.firstName,u.lastName,u.profileImg,u.contactNos,u.status FROM tbl_service_requests as sr
		// LEFT JOIN tbl_users as u ON u.id=sr.provider_id WHERE sr.customer_id = '".$this->sessUserId."' ORDER BY sr.id DESC";

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

					$provider_name=$fetchRes['firstName'].' '.$fetchRes['lastName'];
					$provider_img=checkImage('profile/'.$fetchRes['provider_id'].'/th2_',$fetchRes['profileImg']);

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
						$request_btn='<div class="w-100"><a class="btn-main btn-main-gray w-100 mb-2 min-width-0" href="javascript:void(0);">'.PENDING.'</a></div>';	
					}else if($fetchRes['request_status']=='a'){
						$request_btn='<div class="w-100"><a class="btn-main btn-main-gray w-100 mb-2 min-width-0" href="javascript:void(0);">'.ACCEPTED.'</a></div>';	
						$detailBtn = '<a class="btn-main btn-main-red w-100" href="'.SITE_URL.'service-detail/'.$fetchRes['id'].'">'.SERVICE_DETAILS.'</a>';	
					}else if($fetchRes['request_status']=='r'){
						$request_btn='<div class="w-100"><a class="btn-main btn-main-gray w-100 mb-2 min-width-0" href="javascript:void(0);">'.REJECTED.'</a></div>';	
					}
					$provider_url=SITE_URL."profile/".$fetchRes['provider_id'];

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
					$statusData_api = '';
					$statusData = '';
					if($fetchRes['service_status'] == 'upcoming') {
						$statusData = '<span class="lbl-upcoming status-lbl-redius">'.UPCOMING.'</span>';
						$statusData_api = UPCOMING;
					}
					else if($fetchRes['service_status'] == 'ongoing') {
						$statusData = '<span class="lbl-ongoing status-lbl-redius">'.ONGOING.'</span>';
						$statusData_api = ONGOING;
					}
					else if($fetchRes['service_status'] == 'complete') {
						$statusData = '<span class="lbl-complete status-lbl-redius">'.COMPLETED.'</span>';
						$statusData_api = COMPLETED;
					}
					else if($fetchRes['service_status'] == 'cancel') {
						$statusData = '<span class="lbl-cancel status-lbl-redius">'.CANCELLED.'</span>';
						$statusData_api = CANCELLED;
					}			

					$replace = array(
							'%ID%'=>$fetchRes['id'],
							'%PROVIDER_NAME%'=>$provider_name,
							'%PROVIDER_IMG%'=>$provider_img,
							'%PROVIDER_URL%'=>$provider_url,
							'%SERVICE_TYPE%'=>$service_type,
							'%SERVICE_DATE%'=>$dispServiceDate,
							'%ADDRESS%'=>$address,
							'%REQ_BTN%'=>$request_btn,
							'%CONTACT_NO%'=>$fetchRes['contactNo'],
							"%DETAIL_BTN%" => $detailBtn,
							"%STATUS%" => $statusData,
							"%DEST_DETAIL%" => $dest_detail,
							"%NUM_PASS%" => $num_pass,
							// "type"  => $service_type
						);
						// echo "<pre>";
						// print_r
					$final_content .= get_view(DIR_TMPL .$this->module. "/service_req_row-nct.tpl.php",$replace);
					$service_list[$key]['id']            = $fetchRes['id'];
					$service_list[$key]['provider_id']   = $fetchRes['provider_id'];
					$service_list[$key]['provider_name'] = $provider_name;
					$service_list[$key]['provider_img'] = $provider_img;
					$service_list[$key]['provider_url'] = $provider_url;
					$service_list[$key]['service_type'] = $service_type;
					$service_list[$key]['service_date'] = $service_date;
					$service_list[$key]['service_time_slot'] = $fetchRes['service_time_slot'];
					$service_list[$key]['service_time_slot_disp'] = getSlotFromId($fetchRes['service_time_slot']);
					$service_list[$key]['start_date'] = $fetchRes['start_date'];
					$service_list[$key]['end_date'] = $fetchRes['end_date'];
					$service_list[$key]['address'] = $address;
					$service_list[$key]['request_status'] = $fetchRes['request_status'];					
					$service_list[$key]['contactNo'] = $fetchRes['contactNo'];
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
						'message'    => NO_REQUEST_SENT,
						'data'    => array('pagination' => $pagination));
				} else {

					$retData['html']       = '<div class="col-12 col-md-12 col-lg-12 card-deck"><a href="javascript:void(0);" class="btn-main btn-blue-outer w-100">'.NO_REQUEST_SENT.'</a></div>';
					$retData['pagination'] = $pagination;
					$returnResponse        = array(
						'status'  => false,
						'message' => NO_REQUEST_SENT,
						'retData' => $retData);
				}
			}
		}else{
			if ($this->sessRequestType == 'app') {
				$returnResponse = array(						
					'status'     => false,
					'message'    => NO_REQUEST_SENT,
					'data'    => array('pagination' => $pagination));
			} else {

				$retData['html']       = '<div class="col-12 col-md-12 col-lg-12 card-deck"><a href="javascript:void(0);" class="btn-main btn-blue-outer w-100">'.NO_REQUEST_SENT.'</a></div>';
				$retData['pagination'] = "";
				$returnResponse        = array(
					'status'  => false,
					'message' => NO_REQUEST_SENT,
					'retData' => $retData);
			}
		}
		return $returnResponse;
	}
}
?>