<?php
class profile {
	function __construct($requestArr = array()) {
		global $sessUserId,$sessRequestType,$lId;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($requestArr);
		if($sessRequestType == 'app'){
			$this->sessUserId = isset($userId) && $userId > 0 ? $userId  : $sessUserId;
			$this->userId = (isset($otherUserId) && $otherUserId > 0 ? $otherUserId : 0);
		}else{
			$this->sessUserId = (isset($sessUserId) && $sessUserId > 0 ? $sessUserId : 0);
			$this->userId = (isset($userId) && $userId > 0 ? $userId : 0);

		}
		$this->module = $module;
		$this->lId = $lId;
		$this->sessRequestType = $sessRequestType;
	}
	public function changeAvailability($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$isAvailability = isset($isAvailability) ? ($isAvailability): '';
				$userId = isset($userId) ? ($userId): (isset($user_id) ? $user_id : '' );

				if($isAvailability!=""){

					
					$this->db->query("UPDATE tbl_users SET isAvailability = '".$isAvailability."' WHERE id = '".$userId."'");

					$returnResponse = array(
				        'redirectLink'  => SITE_URL."profile/".$userId,
				        'status'        => true,
				        'message'       => AVAILABILITY_UPDATED_SUCCESSFULLY);

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
				'redirectLink'	=> SITE_URL.'my-provided-services',
				'status'		=> false,
				'message'   	=> $e->getMessage());
			return $returnResponse;
		}
	}
	public function addStatus($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$addStatus = isset($addStatus) ? ($addStatus): '';
				$userId = isset($userId) ? ($userId): (isset($user_id) ? $user_id : '' );

				if($addStatus!=""){					
					$this->db->query("UPDATE tbl_users SET user_status = '".$addStatus."' WHERE id = '".$userId."'");

					$returnResponse = array(
				        'redirectLink'  => SITE_URL."profile/".$userId,
				        'status'        => true,
				        'message'       => SUC_STATUS_ADDED);

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
				'redirectLink'	=> SITE_URL,
				'status'		=> false,
				'message'   	=> $e->getMessage());
			return $returnResponse;
		}
	}
	public function addOpeningHours($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$openingHrs = isset($openingHrs) ? ($openingHrs): '';
				$userId = isset($userId) ? ($userId): (isset($user_id) ? $user_id : '' );

				if($openingHrs!=""){					
					$this->db->query("UPDATE tbl_users SET opening_hours = '".$openingHrs."' WHERE id = '".$userId."'");

					$returnResponse = array(
				        'redirectLink'  => SITE_URL."profile/".$userId,
				        'status'        => true,
				        'message'       => SUC_HOURS_ADDED);

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
				'redirectLink'	=> SITE_URL,
				'status'		=> false,
				'message'   	=> $e->getMessage());
			return $returnResponse;
		}
	}
	public function getProviderDetails(){		
		$services = [];		
		$final_result=$showIt=$availibilityBtn=$add_status=$addOpeningHrs=$user_images="";

		$userData = $this->db->pdoQuery("SELECT u.*,ROUND(AVG(review.rating),1) as averageRating FROM tbl_users as u
		LEFT JOIN tbl_reviews as review ON review.receiver_id=u.id AND review.status='y'
		WHERE u.id = ?",array($this->userId))->result();

		if(!empty($userData)){
			$firstName = filtering($userData['firstName'],'output','string');
			$lastName = filtering($userData['lastName'],'output','string');
			$business_name = filtering($userData['business_name'],'output','string');
			$paypalEmail = filtering($userData['paypalEmail'],'output','string');
			$email = filtering($userData['email'],'output','string');
			$user_type = filtering($userData['user_type'],'output','string');
			$service_type = filtering($userData['service_type'],'output','string');
			$contactNo = $userData['contactNo'] != '' ? filtering($userData['contactNo'],'output','string') : 'N/A';
			$address = $userData['address'] != '' ? filtering($userData['address'],'output','string') : 'N/A';
			$paypalEmail = $userData['paypalEmail'] != '' ? filtering($userData['paypalEmail'],'output','string') : 'N/A';
			$userImage = checkImage('profile/'.$this->userId.'/th2_',$userData['profileImg']);
			$userImage_main = checkImage('profile/'.$this->userId.'/th2_',$userData['profileImg'] , "mainImage");
			$user_status = filtering($userData['user_status'],'output','string');
			$opening_hours = filtering($userData['opening_hours'],'output','string');
			$business_details = filtering($userData['business_details'],'output','string');
			$contactNo = $contactNo;
			
			$dispAvailability = '';
			if($userData['id'] == $this->sessUserId ){
				$showIt = get_view(DIR_TMPL . $this->module."/show_edit_profile-nct.tpl.php");
				$availibilityBtn = get_view(DIR_TMPL . $this->module."/availibility-btn-nct.tpl.php");
				$add_status='<a href="javascript:void(0);" id="openStatusModal" class="btn-main btn-main-red">'.(($user_status == "") ? ADD_STATUS : EDIT_STATUS).'</a>';
				$addOpeningHrs = '<a href="javascript:void(0);" id="openOpeningHrsModal" class="btn-main btn-main-red">'.(($opening_hours == "") ? ADD_OPENING_HOURS : EDIT_OPENING_HOURS).'</a>';
			}
			else {
				$dispAvailability = '<div class="row">
			        		<div class="col-md-12">
			        		    <div class="avail-label">'.LBL_AVAILABILITY	.' : '.(($userData['isAvailability'] == 'y' ? IMEDIATE_AVAILABLE : OPEN)).'</div>
			        		</div>
			        	</div>';
			}
			
			if($service_type=='mechanic'){
				$service_type=MECHANIC_SERVICE;
				
				$getServiceList = $this->getServiceList();
				if($getServiceList && $getServiceList["data"] && $getServiceList["data"]["service_list"]){
					$services = $getServiceList["data"]["service_list"];					
				}		
				
			}else{
				$service_type=TAXI_SERVICE;
			}
			$availability="";
			if($userData['isAvailability']=='y'){
				$availability="checked='checked'";
			}

			if($userImage != "") {
				//$user_images.='<div class="item"><img src="'.$userImage.'"></div>';

				$user_images.='<div class="item"><picture>
                      <source srcset="'.$userImage.'" type="image/webp">
                      <source srcset="'.$userImage_main.'" type="image/jpg"> 
                      <img src="'.$userImage_main.'" />
                    </picture></div>';
			}

			$totPhotos = $this->db->pdoQuery("SELECT * FROM tbl_user_images WHERE user_id = ?",array($this->userId))->affectedRows();
			$usr_imgs_app=array();
			if($totPhotos>0){

				$userPhotos = $this->db->pdoQuery("SELECT * FROM tbl_user_images WHERE user_id = ?",array($this->userId))->results();

				foreach($userPhotos as $fetchRes){

					$img = checkImage('images/'.$this->userId.'/',$fetchRes['image_name']);
					$img_main = checkImage('images/'.$this->userId.'/',$fetchRes['image_name'] , "mainImage");
					//$user_images.='<div class="item"><img src="'.$img.'"></div>';
					$user_images.='<div class="item">
					<picture>
                      <source srcset="'.$img.'" type="image/webp">
                      <source srcset="'.$img_main.'" type="image/jpg"> 
                      <img src="'.$img_main.'" />
                    </picture>
					</div>';

					$imgArr = array();
					$imgArr["id"] = $fetchRes['id'];
					$imgArr["url"] = $img;

					$usr_imgs_app[]=$imgArr;
				}
			}

			if($user_images != "") {
				$user_images_section = get_view(DIR_TMPL . $this->module."/user_images-nct.tpl.php", array(
						'%USER_ID%'		=> $userData['id'],
						'%FIRST_NAME%'	=>	$firstName,
						'%LAST_NAME%' 	=>	$lastName,
						'%BUSINESS_NAME%' => $business_name,
						"%USER_IMGS%" => $user_images,
						"%SERVICE_TYPE%" => $service_type,
						"%AVG_RATING%"=>renderStarRating($userData['averageRating']),
						'%EMAIL%'		=> 	$email,
						'%CONTACT_NO%'	=>  $contactNo,
						'%LOCATION%'	=>  $address,
					)
					);
			}

			if($this->sessRequestType != 'app'){
				$serviceList=$this->getServiceList();
				$reviewReceivedList=$this->getReviewList();

				$replaceArray = array(
					'%USER_ID%'		=> $userData['id'],
					'%SHOW_IT%'     =>  $showIt,
					'%AVIALIBILITY_BTN%'     =>  $availibilityBtn,
					'%ADD_STATUS%'     =>  $add_status,
					"%ADD_OPENING_HOURS%" => $addOpeningHrs,
					'%USER_IMAGE%'	=>  $userImage,
					
					"%CHECKED_AVILABILITY%"=>$availability,
					'%USER_IMGS_SECTION%'     =>  $user_images_section,
					"%USR_SERVICE_TYPE%" => $userData['service_type'],
					"%USER_STATUS%" => $user_status,
					"%USER_OPENING_HOURS%" => $opening_hours,
					"%BUSINESS_DETAILS%" => $business_details,
					'%SERVICE_LIST%' => $serviceList['retData']['html'],
					'%SERVICE_PAGINATION%' => $serviceList['retData']['pagination'],
					'%REVIEW_LIST%' => $reviewReceivedList['retData']['html'],
					'%REVIEW_PAGINATION%' => $reviewReceivedList['retData']['pagination'],
					"%DISP_AVAILABILITY%" => $dispAvailability
				);
			}

			if($this->sessRequestType == 'app'){
				$user['profileData']['id'] = $userData['id'];
				$user['profileData']['user_type'] = $userData['user_type'];
				$user['profileData']['service_type'] = $userData['service_type'];
				$user['profileData']['vehicle_type'] = $userData['vehicle_type'];
				$user['profileData']['firstName'] = $firstName;
				$user['profileData']['lastName'] = $lastName;
				$user['profileData']['email'] = $email;
				$user['profileData']['contactNo'] = $contactNo;
				$user['profileData']['address'] = $address;
				$user['profileData']['addLat'] = $userData['addLat'];
				$user['profileData']['addLong'] = $userData['addLong'];
				$user['profileData']['profileUrl'] = $userImage;
				$user['profileData']['averageRating'] = $userData['averageRating'];
				$user['profileData']['availability'] = $userData['isAvailability'];
				$user['profileData']['user_images'] = $usr_imgs_app;
				$user['profileData']['user_status'] = $user_status;
				$user['profileData']['opening_hours'] = $opening_hours;
				$user['profileData']['business_details'] = $business_details;
				$user['profileData']['business_name'] = $business_name;
				$user['profileData']['paypalEmail'] = $paypalEmail;
				if($userData['service_type']=='mechanic'){
					$user['profileData']['services'] = $services;					
				}
				return $user;
			}else{
				return get_view(DIR_TMPL . $this->module."/provider-user-nct.tpl.php",$replaceArray);	
			}
			
		}

		return $final_result;
	}

	public function getCustomerDetails(){
		$final_result=$user_images="";

		$userData = $this->db->pdoQuery("SELECT u.*,ROUND(AVG(review.rating),1) as averageRating FROM tbl_users as u
		LEFT JOIN tbl_reviews as review ON review.receiver_id=u.id AND review.status='y'
		WHERE u.id = ?",array($this->userId))->result();

		if(!empty($userData)){

			$firstName = filtering($userData['firstName'],'output','string');
			$lastName = filtering($userData['lastName'],'output','string');
			$email = filtering($userData['email'],'output','string');
			$contactNo = $userData['contactNo'] != '' ? filtering($userData['contactNo'],'output','string') : 'N/A';
			$vehi_brand = $userData['vehi_brand'] != '' ? filtering($userData['vehi_brand'],'output','string') : '-';
			$vehi_model = $userData['vehi_model'] != '' ? filtering($userData['vehi_model'],'output','string') : '-';
			$vehi_year = $userData['vehi_year'] != '' ? filtering($userData['vehi_year'],'output','string') : '-';
			$vehi_engine = $userData['vehi_engine'] != '' ? filtering($userData['vehi_engine'],'output','string') : '-';
			$vehi_mileage = $userData['vehi_mileage'] != '' ? filtering($userData['vehi_mileage'],'output','string') : '-';
			$userImage = checkImage('profile/'.$this->userId.'/th2_',$userData['profileImg']);
			$userImage_main = checkImage('profile/'.$this->userId.'/th2_',$userData['profileImg'] , "mainImage");
			$contactNo = $contactNo;

			if($userData['id'] == $this->sessUserId ){
				$showIt = get_view(DIR_TMPL . $this->module."/show_edit_profile-nct.tpl.php",$replaceArray);
			}

			if($userImage != "") {
				//$user_images.='<div class="item"><img src="'.$userImage.'"></div>';
				$user_images.='<div class="item"><picture>
                      <source srcset="'.$userImage.'" type="image/webp">
                      <source srcset="'.$userImage_main.'" type="image/jpg"> 
                      <img src="'.$userImage_main.'" />
                    </picture></div>';
			}

			$totPhotos = $this->db->pdoQuery("SELECT * FROM tbl_user_images WHERE user_id = ?",array($this->userId))->affectedRows();
			$usr_imgs_app=array();
			if($totPhotos>0){

				$userPhotos = $this->db->pdoQuery("SELECT * FROM tbl_user_images WHERE user_id = ?",array($this->userId))->results();

				foreach($userPhotos as $fetchRes){

					$img = checkImage('images/'.$this->userId.'/',$fetchRes['image_name']);
					$img_main = checkImage('images/'.$this->userId.'/',$fetchRes['image_name'] , "mainImage");
					//$user_images.='<div class="item"><img src="'.$img.'"></div>';
					$user_images.='<div class="item">
					<picture>
                      <source srcset="'.$img.'" type="image/webp">
                      <source srcset="'.$img_main.'" type="image/jpg"> 
                      <img src="'.$img_main.'" />
                    </picture>
					</div>';

					$imgArr = array();
					$imgArr["id"] = $fetchRes['id'];
					$imgArr["url"] = $img;

					$usr_imgs_app[]=$imgArr;
				}
			}

			if($user_images != "") {
				$user_images_section = get_view(DIR_TMPL . $this->module."/user_images_cust-nct.tpl.php", array("%USER_IMGS%" => $user_images));
			}
			
			//$reviewReceivedList=$this->getReviewList();
			
			$replaceArray = array(
				'%USER_ID%'		=> $userData['id'],
				'%FIRST_NAME%'	=>	$firstName,
				'%LAST_NAME%' 	=>	$lastName,
				'%EMAIL%'		=> 	$email,
				'%CONTACT_NO%'	=>  $contactNo,
				'%USER_IMAGE%'	=>  $userImage,
				"%AVG_RATING%"  =>  renderStarRating($userData['averageRating']),
				'%SHOW_IT%'     =>  $showIt,
				'%USER_IMGS_SECTION%'   =>  $user_images_section,
				'%VEHI_BRAND%'   =>  $vehi_brand,
				'%VEHI_MODEL%'   =>  $vehi_model,
				'%VEHI_YEAR%'   =>  $vehi_year,
				'%VEHI_ENGINE%'   =>  $vehi_engine,
				'%VEHI_MILEAGE%' => $vehi_mileage,
				'%REVIEW_LIST%' => $reviewReceivedList['retData']['html'],
				'%REVIEW_PAGINATION%' => $reviewReceivedList['retData']['pagination']
			);

			if($this->sessRequestType == 'app'){
				$user['profileData']['id'] = $userData['id'];
				$user['profileData']['user_type'] = $userData['user_type'];
				$user['profileData']['firstName'] = $firstName;
				$user['profileData']['lastName'] = $lastName;
				$user['profileData']['email'] = $email;
				$user['profileData']['contactNo'] = $contactNo;
				$user['profileData']['profileUrl'] = $userImage;
				$user['profileData']['user_images'] = $usr_imgs_app;
				$user['profileData']['vehi_brand'] = $vehi_brand;
				$user['profileData']['vehi_model'] = $vehi_model;
				$user['profileData']['vehi_year'] = $vehi_year;
				$user['profileData']['vehi_engine'] = $vehi_engine;
				$user['profileData']['vehi_mileage'] = $vehi_mileage;
				$user['profileData']['averageRating'] = $userData['averageRating'];
				$user['profileData']['paypalEmail'] = "";
				return $user;
			}else{
				return get_view(DIR_TMPL . $this->module."/customer-user-nct.tpl.php",$replaceArray);	
			}
		}
	}

	public function getPageContent() {

		$final_result="";
		$user_type = getTableValue("tbl_users","user_type",array("id"=>$this->userId));
		$replaceArray = array();

		if($user_type=='provider'){
			$replaceArray = array(
				'%USER_PROFILE_DETAILS%'=> $this->getProviderDetails()
			);
		}else{
			$replaceArray = array(
				'%USER_PROFILE_DETAILS%'=> $this->getCustomerDetails()
			);
		}

		if($this->userId == $this->sessUserId) {
			$replaceArray["%PROFILE_LABEL%"] = MY_PROFILE;
		}
		else {
			if($user_type=='provider'){
				$replaceArray["%PROFILE_LABEL%"] = filtering(PROVIDER_PROFILE);
			}
			else {
				$replaceArray["%PROFILE_LABEL%"] = filtering(CUSTOMER_PROFILE);
			}
		}

		return get_view(DIR_TMPL . $this->module."/".$this->module.".tpl.php",$replaceArray);
	}

	public function getServiceList(){

		$final_content = "";

		$serviceQry="SELECT * FROM tbl_services WHERE provider_id = '".$this->userId."' ORDER BY id DESC";

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
					$replace = array(
							'%ID%'=>$fetchRes['id'],
							'%SERVICE_NAME%'=>$fetchRes['service_name']
						);
					$final_content .= get_view(DIR_TMPL .$this->module. "/service_row-nct.tpl.php",$replace);
					$service_list[$key]['id']            = $fetchRes['id'];
					$service_list[$key]['service_name'] = $fetchRes['service_name'];
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
						'message'    => NO_ANY_SER_ADDED,
						'data'    => array('pagination' => $pagination));
				} else {

					$retData['html']       = '<div class="box-shadow-main p-3 text-center">'.NO_ANY_SER_ADDED.'</div>';
					$retData['pagination'] = $pagination;
					$returnResponse        = array(
						'status'  => false,
						'message' => NO_ANY_SER_ADDED,
						'retData' => $retData);
				}
			}
		}else{
			if ($this->sessRequestType == 'app') {
				$returnResponse = array(						
					'status'     => false,
					'message'    => NO_ANY_SER_ADDED,
					'data'    => array('pagination' => $pagination));
			} else {

				$retData['html']       = '<div class="box-shadow-main p-3 text-center">'.NO_ANY_SER_ADDED.'</div>';
				$retData['pagination'] = "";
				$returnResponse        = array(
					'status'  => false,
					'message' => NO_ANY_SER_ADDED,
					'retData' => $retData);
			}
		}
		return $returnResponse;
	}

	public function getReviewList(){

		$final_content = "";

		$serviceQry="SELECT r.*,u.firstName,u.lastName,u.profileImg,sr.unique_id FROM tbl_reviews as r LEFT JOIN tbl_users as u ON u.id=r.sender_id 
		LEFT JOIN tbl_service_requests AS sr ON sr.id = r.service_request_id 
			WHERE r.receiver_id = '".$this->userId."' AND r.parent_id='0' ORDER BY r.id DESC";

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
					$replyMsg=array();
					$rating=renderStarRating($fetchRes['rating']);

					if($fetchRes['replySend']=='y'){
						//$reply_form=$replyMsg=$this->getReviewReply($fetchRes['id']);
					}else{
						//$reply_form=$this->getReplyForm($fetchRes['id']);
					}
					
					$user_name = filtering(ucwords($fetchRes['firstName'] . ' ' . $fetchRes['lastName']) , 'output' , 'string');
					$user_image = checkImage('profile/'.$fetchRes['sender_id'].'/th2_'.$fetchRes['profileImg']);
					$user_image_main = checkImage('profile/'.$fetchRes['sender_id'].'/th2_'.$fetchRes['profileImg'] , "" , "mainImage");
					$posted_date=time_elapsed_string($fetchRes['posted_date']);
					$replace = array(
							'%ID%'=>$fetchRes['id'],
							'%REVIEW%'=>$fetchRes['description'],
							'%RATING%'=>$rating,
							'%USER_NAME%'=>$user_name,
							'%USER_IMG%'=>$user_image,
							'%USER_IMG_MAIN%' => $user_image_main,
							'%SERVICE_ID%'=>$fetchRes['unique_id'],
							'%POSTED_DATE%'=>$posted_date,
							'%REPLY_FORM%'=>$reply_form
						);
					$final_content .= get_view(DIR_TMPL .$this->module. "/review_row-nct.tpl.php",$replace);
					$review_list[$key]['id']            = $fetchRes['id'];
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

					$retData['html']       ='<div class="box-shadow-main p-3 text-center">' . NO_ANY_REC_REVIEWS . '</div>';
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

				$retData['html']       = '<div class="box-shadow-main p-3 text-center">' . NO_ANY_REC_REVIEWS . '</div>';
				$retData['pagination'] = "";
				$returnResponse        = array(
					'status'  => false,
					'message' => NO_ANY_REC_REVIEWS,
					'retData' => $retData);
			}
		}
		return $returnResponse;
	}
	public function setUpdateService($request = array())
	{
		try {
			if (!empty($request)) {
				extract($request);
				// echo "this->sessUserId".$this->sessUserId;
				
				// print_r($request);exit;
				$objPost->service_name    = isset($service_name)?filtering($service_name,'input'):'';
				$this->db->update('tbl_services', (array) $objPost, array('id' => $service_id));	
				$response = array(
					'status'       => true,
					'message'      => MSG_SERVICE_UPDATE_SUC,
					// 'message'      => MSG_SERVICE_STARTED_SUC,
					'data'         => array());

				return $response;
			}
			
		} catch (Exception $e) {
			$response = array(
				'status'       => false,
				'message'      => $e->getMessage(),
				'data'         => array());

			return $response;
		}
	}
}

?>
