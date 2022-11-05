<?php
class MyReceivedReviews{
	function __construct($contentArray = array()) {

		global $sessUserId, $sessRequestType, $fields;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);
		
		$this->id = $id;

		$this->type     = $type;
		$this->module     = $module;
		$this->fields    = $fields;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId = isset($userId) && $userId > 0 ? $userId : $this->sessUserId;
		$this->pageNo     = isset($pageNo) ? $pageNo : 1;
		$this->action = $action;
	}
	public function getPageContent() {
		$final_content="";

		$reviewReceivedList=$this->getReviewList();

		$replace = array(			
			'%REVIEW_LIST%' => $reviewReceivedList['retData']['html'],
			'%REVIEW_PAGINATION%' => $reviewReceivedList['retData']['pagination']
		);

		$final_content= get_view(DIR_TMPL . "{$this->module}/{$this->module}.tpl.php",$replace);
		return $final_content;

	}

	public function submitReviewReply($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$id = isset($id) ? $id: '';
				$description = isset($description) ? $description: '';

				if($id>0){

					$this->db->query("UPDATE tbl_reviews SET replySend = 'y',replyMsg = '".$description."' WHERE id = '".$id."' AND receiver_id='".$this->sessUserId."' ");
					
					$returnResponse = array(
						'redirectLink' 	=> SITE_URL.'my-received-reviews',
						'status'		=> true,
						'message'   	=> REVIEW_RPLY_ADDED);
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
				'redirectLink'	=> SITE_URL.'my-received-reviews',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}

	public function getReplyForm($review_id=0){
		$final_content = "";
		if($review_id>0){
			$replace = array(
					'%ID%'=>$review_id
				);
			$final_content = get_view(DIR_TMPL .$this->module. "/reply_form-nct.tpl.php",$replace);
		}
		return $final_content;
	}
	public function getReviewReply($review_id=0){
		$final_content = "";
		if($review_id>0){

			$replyMsg=getTableValue("tbl_reviews","replyMsg",array("id"=>$review_id));
			$replace = array(
					'%REVIEW%'=>$replyMsg
				);
			if ($this->sessRequestType == 'app') {
				return $replyMsg;
			}
			$final_content = get_view(DIR_TMPL .$this->module. "/review_reply-nct.tpl.php",$replace);
		}
		return $final_content;
	}

	public function getReviewList(){

		$final_content = "";

		$serviceQry="SELECT r.*,u.firstName,u.lastName,u.profileImg,sr.unique_id FROM tbl_reviews as r LEFT JOIN tbl_users as u ON u.id=r.sender_id 
		LEFT JOIN tbl_service_requests AS sr ON sr.id = r.service_request_id 
			WHERE r.receiver_id = '".$this->sessUserId."' AND r.parent_id='0' ORDER BY r.id DESC";

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
					$reply_form="";
					$replyMsg="";
					$rating=renderStarRating($fetchRes['rating']);

					if($_SESSION['user_type'] == 'provider' || ($this->sessRequestType == 'app')) {
						if($fetchRes['replySend']=='y'){
							$reply_form=$replyMsg=$this->getReviewReply($fetchRes['id']);
						}else{
							$reply_form=$this->getReplyForm($fetchRes['id']);
						}
					}
					
					$user_name = filtering(ucwords($fetchRes['firstName'] . ' ' . $fetchRes['lastName']) , 'output' , 'string');
					$user_image = checkImage('profile/'.$fetchRes['sender_id'].'/th2_'.$fetchRes['profileImg']);
					$posted_date=time_elapsed_string($fetchRes['posted_date']);
					$replace = array(
							'%ID%'=>$fetchRes['id'],
							'%REVIEW%'=>$fetchRes['description'],
							'%RATING%'=>$rating,
							'%USER_NAME%'=>$user_name,
							'%USER_IMG%'=>$user_image,
							'%SERVICE_ID%'=>$fetchRes['unique_id'],
							'%POSTED_DATE%'=>$posted_date,
							'%REPLY_FORM%'=>$reply_form
						);
					$final_content .= get_view(DIR_TMPL .$this->module. "/service_row-nct.tpl.php",$replace);
					$review_list[$key]['id']            = $fetchRes['id'];
					$review_list[$key]['sender_id']   = $fetchRes['sender_id'];
					$review_list[$key]['review'] = $fetchRes['description'];
					$review_list[$key]['rating'] = $fetchRes['rating'];
					$review_list[$key]['user_name'] = $user_name;
					$review_list[$key]['user_image'] = $user_image;
					$review_list[$key]['service_request_id'] = $fetchRes['unique_id'];
					$review_list[$key]['posted_date'] = $posted_date;
					$review_list[$key]['replySend'] = $fetchRes['replySend'];
					$review_list[$key]['replyMsg'] = $replyMsg;
				}
				if ($this->sessRequestType == 'app') {
					$returnResponse = array(
						'status'     => true,
						'message'    => '',
						'data'    => array('pagination' => $pagination,"review_list" => $review_list));
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
						'message'    => NO_ANY_REC_REVIEWS,
						'data'    => array('pagination' => $pagination));
				} else {

					$retData['html']       ='<div class="text-center">' . NO_ANY_REC_REVIEWS . '</div>';
					$retData['pagination'] = $pagination;
					$returnResponse        = array(
						'status'  => false,
						'message' => NO_ANY_REC_REVIEWS,
						'retData' => $retData);
				}
			}
		}else{
			if ($this->sessRequestType == 'app') {
				$returnResponse = array(						
					'status'     => false,
					'message'    => NO_ANY_REC_REVIEWS,
					'data'    => array('pagination' => $pagination));
			} else {

				$retData['html']       = '<div class="text-center">' . NO_ANY_REC_REVIEWS . '</div>';
				$retData['pagination'] = "";
				$returnResponse        = array(
					'status'  => false,
					'message' => NO_ANY_REC_REVIEWS,
					'retData' => $retData);
			}
		}
		return $returnResponse;
	}
}
?>