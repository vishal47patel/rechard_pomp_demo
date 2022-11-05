<?php
class Home {
	function __construct($contentArray = array()) {
		global $sessUserId,$sessRequestType,$lId,$cId,$cCode;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);

		$this->module = $module;
		$this->lId = $lId;
		$this->cId = $cId;
		$this->cCode = $cCode;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId = (isset($userId) && $userId > 0 ? $userId : $sessUserId);
		//$this->userCountryId = getTableValue('tbl_users','countryCode',array('id'=>$this->sessUserId));

	}

	public function getNearByProviders($latitude = '', $longitude = '', $service_type = '', $vehicle_type = '' , $pageNo = 1, $mileage='') {
		$returnResponse = $retData = $retSearch = array();
		$html = '';
		
		$latitude = isset($latitude) ? filtering($latitude, 'input', 'string', '') : '';
		$longitude = isset($longitude) ? filtering($longitude, 'input', 'string', '') : '';
		$m = 1.609;
		$radius = ($mileage != '') ? ($mileage*$m) : NEARBY_RADIUS;
		
		if($latitude == '' || $longitude == '') {
			if($this->sessRequestType == 'app'){
				$retSearch['status'] = false;
				$retSearch['message'] = NO_NEARBY_PROVIDER_FOUND;
				$returnResponse = $retSearch;
			}else{
				$retData['html'] = NO_NEARBY_PROVIDER_FOUND;

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
			return $returnResponse;
		}
		
		$whereStr = "";
		if($service_type != "") {
			$whereStr = " AND user.service_type = '".$service_type."' ";
		}

		if($vehicle_type != "") {
			$whereStr .= " AND (user.vehicle_type = 'both' OR user.vehicle_type = '".$vehicle_type."') ";
		}

		$distanceFrom .= "((ACOS(SIN($latitude * PI() / 180) * SIN(user.addLat*PI()/180)+COS($latitude*PI()/180)*COS(user.addLat*PI()/180)*COS(($longitude-user.addLong)*PI()/180))*180 / PI()) * 60 * 1.1515* 1.609344)";

		$allProviderDetailsQry = "SELECT user.*, ROUND(AVG(review.rating),1) as averageRating , ".$distanceFrom." AS distance  
				FROM tbl_users as user 
				LEFT JOIN tbl_reviews as review ON review.receiver_id=user.id AND review.status='y' 
				WHERE user.user_type = 'provider' AND user.isActive='y' AND user.isEmailVerify = 'y' AND " . $distanceFrom . " <= " . $radius . $whereStr . " GROUP BY user.id ORDER BY user.isAvailability ASC , user.id DESC";
		// echo $allProviderDetailsQry;exit;
		$affRows = $this->db->pdoQuery($allProviderDetailsQry)->affectedRows();		
	    $retSearch = array();

	    if($this->sessRequestType == 'app'){
	    	$affRows = $this->db->pdoQuery($allProviderDetailsQry)->affectedRows();	    	
        	$pager = getPagerData($affRows, SCROLL_LIMIT, $pageNo);

        	$pagination['current_page'] = issetor($pager ->page,0);
			$pagination['total_pages'] = issetor($pager ->numPages,0);
			$pagination['total'] = issetor($affRows,0);

	        $retSearch['provider'] = array();
	        $retSearch['pagination'] = $pagination;

	        $offset = $pager->offset;
            if ($offset < 0) {
                $offset = 0;
            }

            $limit = $pager->limit;
            $page = $pager->page;

            $limit_cond = " LIMIT $offset, $limit";

            $allProviderDetails = $this->db->pdoQuery($allProviderDetailsQry . $limit_cond)->results();
	    }
	    else {
	    	$allProviderDetails = $this->db->pdoQuery($allProviderDetailsQry)->results();
	    }

        if (count($allProviderDetails) > 0) {

			foreach ($allProviderDetails as $key => $providerDetail) {
								
				
				$serviceQry="SELECT * FROM tbl_services WHERE provider_id = '".$providerDetail['id']."' ORDER BY id DESC";
				 $qryQuery = $this->db->pdoQuery($serviceQry);
				 $qryRes = $qryQuery->results();
				 $service_list = '';
				foreach ($qryRes as $key1 => $fetchRes) {	
					if($service_list != ''){
						$service_list .= ',';
					}
					$service_list .= $fetchRes['service_name'];				

				}
				
				// $serviceQry="SELECT id, service_name FROM tbl_services WHERE provider_id = '".$providerDetail['id']."' ORDER BY id DESC";
				// $qryQuery = $this->db->pdoQuery($serviceQry);
				// $qryRes = $qryQuery->results();
				// $service_list = $qryRes;
				
				$user_image = checkImage('profile/'.$providerDetail['id'].'/th2_'.$providerDetail['profileImg']);
				$user_image_main = checkImage('profile/'.$providerDetail['id'].'/th2_'.$providerDetail['profileImg'] , "", "mainImage");
				$provider_name = filtering($providerDetail['firstName'] . ' ' . $providerDetail['lastName'] , 'output' , 'string');
				$address = filtering($providerDetail['address'] , 'output' , 'string');
				$contactNo = filtering($providerDetail['contactNo'] , 'output' , 'string');
				$provider_id = $providerDetail['id'];
				$email = $providerDetail['email'];
				$averageRating = ($providerDetail['averageRating'] > 0) ? $providerDetail['averageRating'] : '0';
				$distance = number_format($providerDetail['distance'] , 2);
				$ratingHtml = renderStarRating($averageRating);
				
				$facebook_link=getSocialLinks($provider_id,'f');
				$google_link=getSocialLinks($provider_id,'g');
				$twitter_link=getSocialLinks($provider_id,'t');

				$availability = ($providerDetail['isAvailability'] == 'y' ? IMEDIATE_AVAILABLE : OPEN);

				// $retSearch['provider'][$key]['timezone'] = date_default_timezone_get();
				$retSearch['provider'][$key]['email'] = $email;
				$retSearch['provider'][$key]['provider_id'] = $provider_id;
				$retSearch['provider'][$key]['user_image'] = $user_image;
				$retSearch['provider'][$key]['provider_name'] = $provider_name;
				$retSearch['provider'][$key]['address'] = $address;
				$retSearch['provider'][$key]['contactNo'] = $contactNo;
				$retSearch['provider'][$key]['averageRating'] = $averageRating;
				$retSearch['provider'][$key]['distance'] = $distance;
				$retSearch['provider'][$key]['facebook_link'] = $facebook_link;
				$retSearch['provider'][$key]['google_link'] = $google_link;
				$retSearch['provider'][$key]['twitter_link'] = $twitter_link;
				$retSearch['provider'][$key]['availability'] = $availability;
				$retSearch['provider'][$key]['services'] = $service_list;

				$replaceArray = array(
						'%USER_IMAGE%' => $user_image,
						"%USER_IMAGE_MAIN%" => $user_image_main,
						"%PROVIDER_NAME%" => $driver_name,
						"%ADDRESS%" => $address,
						"%PROVIDER_ID%" => $provider_id,
						"%AVG_RATING%" => $ratingHtml,
						"%DISTANCE%" => $distance,
						"%EMAIL%" => $email,
						"%CONTACT_NO%" => $contactNo,
						"%FB_LINK%" => $facebook_link,
						"%GOOGLE_LINK%" => $google_link,
						"%TWITTER_LINK%" => $twitter_link,
						"%ITEM_CLASS%" => ($service_type == 'mechanic') ? 'nearby-provider-items' : 'nearby-taxi-items',
						"%AVAILABILITY%" => $availability
					);

				$html .= get_view(DIR_TMPL . $this->module."/nearByProvider-nct.tpl.php" , $replaceArray);
			}
			if($this->sessRequestType == 'app'){

				$returnResponse = array(
					'status'		=> true,
					'message'  	 	=> 'success',
					'data' => $retSearch);
			}else{
				$retData['html'] = $html;

				$returnResponse = array(
					'status'		=> true,
					'message'  	 	=> '',
					'retData' => $retData);
			}
		}else{
			if($this->sessRequestType == 'app'){
				$retSearch['status'] = false;
				$retSearch['message'] = NO_NEARBY_PROVIDER_FOUND;
				$returnResponse = $retSearch;
			}else{
				$retData['html'] = NO_NEARBY_PROVIDER_FOUND;

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
		}

		return $returnResponse;
	}

	public function getHeaderContent() {
		if($_GET['viewType'] == 'app') {
			return "";
		}
		$menu = NULL;
		if(isset($this->sessUserId) && $this->sessUserId > 0){

			$userName = getTableValue('tbl_users','CONCAT(firstName , " " , lastName)',array('id'=>$this->sessUserId));

			$msg_noti_unread_count = getTableValue('tbl_messages' , 'COUNT(id)' , array('readStatus' => 'n' , 'receiverId' => $this->sessUserId,'receiverDelete'=>'n'));

			$msg_notification_class = '';
			if($msg_noti_unread_count <= 0) {
				$msg_notification_class = 'd-none';
			}

			$replace = array(
				'%USER_NAME%'  => $userName,
				'%SESSUSERID%' => $this->sessUserId,
				'%USER_IMAGE%' => checkImage('profile/'.$this->sessUserId.'/th1_'.fetchUserImage($this->sessUserId)),
				'%USER_IMAGE_MAIN%' => checkImage('profile/'.$this->sessUserId.'/th1_'.fetchUserImage($this->sessUserId) , "" , "mainImage")
				);

			$menu = get_view(DIR_TMPL . $this->module . "/" . "after-login-menu-nct.tpl.php",$replace);
		}else{
			$msg_noti_unread_count = '';
			$signup_class = $login_class = '';
			if(strpos($_SERVER['REQUEST_URI'] , 'login') !== false) {
				$login_class = 'loginBtn d-none';
			}

			if(strpos($_SERVER['REQUEST_URI'] , 'sign-up') !== false) {
				$signup_class = 'signupBtn d-none';
			}
			$replaceHeader = array(
					'%SIGNUP_CLASS%' => $signup_class,
					'%LOGIN_CLASS%' => $login_class
					);
			$menu = get_view(DIR_TMPL . $this->module . "/" . "before-login-menu-nct.tpl.php",$replaceHeader);
		}
		$header_class = "";

		$html = null;

		$showLoad = isset($_GET['showLoad']) ? $_GET['showLoad'] : '';

		$replace = array(
			'%MENU%'=>$menu,
			'%INNER_HEADER_CLASS%' => ($this->module == 'home-nct' ? '' : 'inner-header'),
			'%LOADER_CLASS%' => ($showLoad == 'show_loading' ? 'd-none' : 'd-none'),
			'%LANGUAGE_LIST%' => $this->get_lang_item(),
			'%LANG_ID%'=>$_SESSION['lId'],
			"%MESSAGE_NOTIFICATION_CLASS%" => $msg_notification_class,
			'%MESSAGE_COUNT%' => $msg_noti_unread_count,
		);
		$html .= get_view(DIR_TMPL . "header-nct.tpl.php",$replace);
		return $html;
	}

	public function getFooterContent($currentModule = 'home-nct') {
				
		$userMizutechName = $userMizutechPwd = '';
		if($this->sessUserId > 0) {
			$response = $this->db->pdoQuery("SELECT mizutech_name , mizutech_pwd FROM tbl_users WHERE id = " . $this->sessUserId)->result();

            //pooja:comment this code
			$userMizutechName = $response['mizutech_name'];
			$userMizutechPwd = $response['mizutech_pwd'];
			/*$userMizutechName = "1004";
			$userMizutechPwd = "vin@659";*/
			
		}

		$html = null;
		$replace = array(
			'%LANG_ID%'=>$_SESSION['lId'],
			'%CURRENT_MODULE%' => $currentModule,
			'%SESS_USER_ID%' => $this->sessUserId,
			'%FOOTER%' => $this->getCMSPages(),
			'%FOOTER_LOGO%' => get_view(DIR_TMPL . "/footer-nct-logo-nct.tpl.php"),
			'%USR_MIZUTECH_NAME%' => $userMizutechName,
			'%USR_MIZUTECH_PWD%' => $userMizutechPwd
			);
		$html .= get_view(DIR_TMPL . "footer-nct.tpl.php",$replace);
		return $html;
	}


	/*
		this will return footer language drop down on every page
	*/
	public function get_lang_item(){
		$language_item ="";
		$languagelist = $this->db->select("tbl_language",array('*'),array("status"=>'a'))->results();
		$lang_item = "";

		foreach ($languagelist as $langData) {
			$replace = array(
					'%OPT_VALUE%'=>$langData['id'],
					'%OPT_TEXT%'=>$langData['languageName'],
					'%EXTRA%'=>'',
					'%SELECTED%'=>($langData['id'] == $this->lId) ? 'selected' : NULL,
				);
			$lang_item .= get_view(DIR_TMPL . "option-nct.tpl.php",$replace);
		}
		return $lang_item;
	}
	
	public function getCMSPages($request_data = array()){
		$content="";
		extract($request_data);

		$returnResponse =array();

		if($this->sessRequestType == 'app'){
			$lId=$langId;
		}else{
			$lId=$this->lId;
		}

		try{
			$selQuery = $this->db->pdoQuery("SELECT * FROM tbl_content WHERE pId != 6 AND isActive = 'y' order by pId ASC");

			if ($selQuery->affectedRows() >= 1) {
				$qryRes = $selQuery->results();

				foreach ($qryRes as $fetchRes) {
					$url=SITE_URL.'content/'.$fetchRes['page_slug'];
					$array=array('%PAGE_SLUG%'=>$fetchRes['page_slug'],'%LI_VALUE%'=>$fetchRes["pageTitle_".$lId],'%LI_URL%'=>$url);
					$content .= get_view(DIR_TMPL . "/footer-menu-li-nct.tpl.php",$array);

					$arrData[]=array("page_slug"=>$fetchRes['page_slug'],"pageTitle"=>$fetchRes["pageTitle_".$lId],"pageUrl"=>$url);
				}

				if($this->sessRequestType == 'app'){

					$returnResponse = array(
										'redirectLink'	=> SITE_URL,
										'status'		=> true,
										'message'		=> '',
										'data'			=> $arrData);

					return $returnResponse;
				}else{
					return $content;
				}
			} else {
				if($this->sessRequestType == 'app'){

					throw new Exception(MSG_NO_PAGE_FOUND);
				}else{
					return $content;
				}
				
			}
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> $redirectLink,
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function get_social_link(){
		$socialLink ="";

		$socialLink .= get_view(DIR_TMPL . "/footer-link-nct.tpl.php",array('%LINK%' => FB_LINK,'%A_CLASS%'=>'fb-link','%FA_CLASS%'=>'facebook-f','%TITLE%'=>''));

		$socialLink .= get_view(DIR_TMPL . "/footer-link-nct.tpl.php",array('%LINK%' => TWIITER_LINK,'%A_CLASS%'=>'twitter-link','%FA_CLASS%'=>'twitter','%TITLE%'=>''));

		$socialLink .= get_view(DIR_TMPL . "/footer-link-nct.tpl.php",array('%LINK%' => GPLUS_LINK,'%A_CLASS%'=>'google-link','%FA_CLASS%'=>'google-plus-g','%TITLE%'=>''));

		return $socialLink;
	}

	public function getHomeBanner() {
		$html = null;

		$banner_type = $this->db->pdoQuery("select file from tbl_banner")->result();
		
		$banner = DIR_UPD . 'banner/' . $banner_type['file'];
		if(!is_file($banner)) {
			$banner = SITE_IMG . 'slider-1.jpg';
		}
		else {
			$banner = SITE_UPD . 'banner/' . $banner_type['file'];
		}
		$html .= get_view(DIR_TMPL . $this->module. "/home-banner-nct" . ".tpl.php",array("%BANNER%"=>$banner));
		
		return $html;
	}

	public function subscribeNewsletter($request = array()){
		try{
			if(isset($request['email_sub']) && $request['email_sub'] != '')
			{
				extract($request);
				$createdDate = date('Y-m-d H:i:s');

				$check_already_exist = getTableValue('tbl_subscribers','id',array('email'=>$email_sub));

				if($check_already_exist > 0)
				{
					throw new Exception(MSG_ALREADY_SUB);
				}
				else
				{
					$valArray = array('email'=>$email_sub,'isActive'=>'y',"createdDate"=>$createdDate,'ipAddress'=>get_ip_address());
					$this->db->insert("tbl_subscribers", $valArray);

					$returnResponse = array(
						'redirectLink' 	=> SITE_URL,
						'status'		=> true,
						'message'   	=> MSG_SUBSCRIBE_SUC,
						'data'  		=> array());
					return $returnResponse;
				}
			}
			else
			{
				throw new Exception(MSG_VALID_EMAIL);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink' 	=> SITE_URL,
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}

	public function postConctactUs($request = array()){
		global $sessFirstName,$sessLastName,$objPost;
		try{
			extract($request);
			$objPost->firstName = isset($firstName) ? filtering($firstName,'input', 'string') : "";
			$objPost->lastName = isset($lastName) ? filtering($lastName,'input', 'string') : "";

			$objPost->email = isset($email) ? filtering($email,'input', 'string') : "";
			$objPost->subject = isset($subject) ? filtering($subject,'input', 'number') : "";

			$objPost->message = isset($message) ? filtering($message,'input', 'text') : "";
			$objPost->contactNo = isset($contactNo) ? filtering($contactNo,'input', 'text') : "";
			
			$objPost->createdDate = date('Y-m-d H:i:s');
			$objPost->ipAddress = get_ip_address();
			if($objPost->message!= "" && $objPost->email!= "" && $objPost->firstName!= "" && $objPost->lastName!= "" && $objPost->subject!= "" ){
				$lastId = $this->db->insert("tbl_contact_us",(array)$objPost)->getLastInsertId();

				if($lastId > 0){

						/*add admin notifications*/
						$adminNoti = array('entity_id'=>0,
											'type'=>'contact_us');

						addAdminNotification($adminNoti);
						/*add admin notifications*/
					$arrayCont = array('email'=>$email,'username'=>$firstName,'message'=>$message);
					$array     = generateEmailTemplate('user_contactus',$arrayCont);

					sendEmailAddress(ADMIN_EMAIL,$array['subject'],$array['message']);
					$returnResponse = array(
					'redirectLink' 	=> ($_SESSION['user_type'] == 'provider') ? SITE_URL . 'profile/' . $this->sessUserId : SITE_URL,
					'status'		=> true,
					'message'   	=> MSG_CONTACT_US_SUC);
					return $returnResponse;
				}else{
					throw new Exception(WENT_WRONG);
				}
			}else{
				throw new Exception(MSG_FILL_ALL_VALUE);
			}

		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink' 	=> SITE_URL,
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}

	public function getPageContent() {
		$html = null;
		$areYouProviderContent = getTableValue("tbl_content" , "pageDesc_" . $this->lId , array("page_slug" => "are-you-provider"));
		$customerQry = $this->db->pdoQuery("SELECT * FROM tbl_content WHERE page_slug = 'are-you-provider'")->results();
		
		$hide = 'style="display:none"';
		if($customerQry && $customerQry[0]['isActive'] == 'y'){
			$hide = '';
		}
		$replace = array(			
			'%HOME_BANNER_SECTION%' => $this->getHomeBanner(),
			"%PROVIDER_CONTENT%" => $areYouProviderContent,
			"%HIDE%" => $hide
			);
		$html .= get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php",$replace);
		// return $hide;
		return $html;
	}

	public function getMenuTab($module=""){
		$html = null;
		$replace = array(
			'%BOOK_ACTIVE%' => ($module == "my_booking-nct" ? "active" : ""),
			'%RES_ACTIVE%' => ($module == "my_reservation-nct" ? "active" : ""),
			'%FIN_ACTIVE%'=> ($module == "financial_dashboard-nct" ? "active" : ""),
			'%ACC_ACTIVE%' => ($module == "account_setting-nct" ? "active" : ""),
		);
		$html .= get_view(DIR_TMPL ."/menu-tab-nct.tpl.php",$replace);
		return $html;
	}

	public function getCountryCode(){
		$content = NULL;
		$arrData = array();
		$cList = $this->db->pdoQuery("SELECT DISTINCT (phonecode),id,countryName FROM tbl_country WHERE isActive = ? GROUP BY phonecode ORDER BY FIELD(id,1) DESC,cast(phonecode as unsigned) ",array('y'))->results();

		foreach ($cList as $key => $value) {
			$selected = '';
			$isSelected = 'n';
			if($value['id'] == $this->userCountryId){
				$selected = 'selected';
				$isSelected = 'y';
			}
			$array=array('%ID%'=>$value['id'],'%VALUE%'=>$value['phonecode'],'%SELECTED%'=>$selected);
			$content .= get_view(DIR_TMPL . "/option-country-code-nct.tpl.php",$array);
			$arrData['countryCode'][$key]['id'] = $value['id'];
			$arrData['countryCode'][$key]['phonecode'] = $value['phonecode'];
			$arrData['countryCode'][$key]['selected'] = $isSelected;
			$arrData['countryCode'][$key]['countryName'] = $value['countryName'];
		}
		if($this->sessRequestType == 'app'){
			$returnResponse = array(
								'redirectLink'	=> SITE_URL,
								'status'		=> true,
								'message'		=> '',
								'data'			=> $arrData);

			return $returnResponse;
		}else{
			return $content;
		}
	}

	public function changeLanguage($arr =array())
	{
		if($this->sessUserId > 0){
			$this->db->pdoQuery("UPDATE tbl_users SET defLanguage = ? WHERE id = ?",array($arr['language'],$this->sessUserId));
		}
		$_SESSION["lId"] = $arr["language"];
		return true;
	}
}

?>
