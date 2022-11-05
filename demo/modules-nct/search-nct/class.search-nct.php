<?php
class search {
	function __construct($moduledata) {
		extract($moduledata);
		global $sessUserId,$cCode;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		$this->module = $module;
		$this->sessUserId = isset($userId) && $userId ? $userId : $sessUserId;

		$this->pageNo = isset($pageNo)?$pageNo:1;

		/*$slider_minRadius = getTableValue('tbl_users' , 'MIN(totalPrice)' , array('isActive' => 'y'));
		$slider_maxRadius = getTableValue('tbl_users' , 'MAX(totalPrice)' , array('isActive' => 'y'));*/

		$this->slider_minRadius = 1;
		$this->slider_maxRadius = 100;
	}

	public function getPageContent($request = array()) {
		//$search_results = $this->getSearchResults($request);

		$service_type       = issetor($request['service_type']);
		$radius          = issetor($request['radius']);		
		$minRadius      = issetor($request['minRadius']);
		$maxRadius      = issetor($request['maxRadius']);	
		$radiusConsider = issetor($request['radiusConsider']);	
		$provider_name = issetor($request['provider_name']);	

		$this->slider_maxRadius = ($radius > $this->slider_maxRadius) ? $radius : $this->slider_maxRadius;
		$replaceArray = array(
			//"%SEARCH_RESULT_SECTION%" => $search_results['retData']['html'],			
			"%SERVICE_TYPE%"                => ($service_type != '') ? $service_type : '',
			"%RADIUS%"                  => ($radius != '') ? $radius : '',
			"%PROVIDER_NAME%"           => $provider_name,
			"%MIN_RADIUS%"              => ($minRadius != '') ? $minRadius : $this->slider_minRadius,
			"%MAX_RADIUS%"              => ($maxRadius != '') ? $maxRadius : $this->slider_maxRadius,
			"%SLIDER_MIN_RADIUS%"       => $this->slider_minRadius,
			"%SLIDER_MAX_RADIUS%"       => $this->slider_maxRadius,
			//"%PAGINATION%"            => $search_results['retData']['pagination'],
			"%RADIUS_CONSIDER%" => $radiusConsider,
			"%PAGE%"                  => $this->pageNo,
			"%MECH_SELECTED%" => ($service_type == 'mechanic') ? "selected='selected'" : "",
			"%TAXI_SELCTED%" => ($service_type == 'taxi') ? "selected='selected'" : "",
			);
		return get_view(DIR_TMPL . $this->module."/".$this->module.".tpl.php" , $replaceArray);
	}

	public function getSearchResults($request = array()) {

		$returnResponse = $retData = $retSearch = array();
		$html = '';

		$latitude = isset($request['latitude']) ? filtering($request['latitude'], 'input', 'string', '') : '';
		$longitude = isset($request['longitude']) ? filtering($request['longitude'], 'input', 'string', '') : '';
		$service_type = isset($request['service_type']) ? filtering($request['service_type'], 'input', 'string', '') : '';
		$radius   = isset($request['radius']) ? filtering($request['radius'], 'input', 'string', '') : '';
		$minRadius = isset($request['minRadius']) ? filtering($request['minRadius'], 'input', 'int', '') : '';
		$maxRadius = isset($request['maxRadius']) ? filtering($request['maxRadius'], 'input', 'int', '') : '';
		$provider_name   = isset($request['provider_name']) ? filtering($request['provider_name'], 'input', 'string', '') : '';

		if($latitude == '' || $longitude == '') {
			if($this->sessRequestType == 'app'){
				$retSearch['status'] = false;
				$retSearch['message'] = NO_NEARBY_PROVIDER_FOUND;
				$returnResponse = $retSearch;
			}else{
				$retData['html'] = '<div class="no-proivder-section no-data-block">' . NO_NEARBY_PROVIDER_FOUND . '</div>';
				$retData['pagination'] = "";

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
			return $returnResponse;
		}

		$distanceFrom .= "((ACOS(SIN($latitude * PI() / 180) * SIN(user.addLat*PI()/180)+COS($latitude*PI()/180)*COS(user.addLat*PI()/180)*COS(($longitude-user.addLong)*PI()/180))*180 / PI()) * 60 * 1.1515* 1.609344)";

		$whereStr = '';		

		if($request['radiusConsider'] == 'single') {
			$whereStr .= " AND " . $distanceFrom . " <= " . $request['radius'];
		}
		else if($request['radiusConsider'] == 'double') {
			$whereStr .= " AND (" . $distanceFrom . " >= " . $request['minRadius'] . " AND " . $distanceFrom . " <= " . $request['maxRadius'] . ")";
		}
		
		if($request['service_type'] != '') {
			$whereStr .= " AND user.service_type = '" . $request['service_type'] . "'";
		}

		if($request['provider_name'] != '') {
			$whereStr .= " AND ( (user.firstName LIKE '%" . $request['provider_name'] . "%') OR (user.lastName LIKE '%" . $request['provider_name'] . "%') )";
		}

		$allproviderDetailsQry = "SELECT user.*, ROUND(AVG(review.rating),1) as averageRating , ".$distanceFrom." AS distance  
				FROM tbl_users as user 
				LEFT JOIN tbl_reviews as review ON review.receiver_id=user.id AND review.status='y' 
				WHERE user.user_type = 'provider' AND user.isActive='y' AND user.isEmailVerify = 'y' " . $whereStr . " GROUP BY user.id ORDER BY user.isAvailability ASC, user.id DESC";
		//echo $allproviderDetailsQry;exit;
		$affRows = $this->db->pdoQuery($allproviderDetailsQry)->affectedRows();
		$pageNo = isset($this->pageNo) ? $this->pageNo : 1;
        $pager = getPagerData($affRows, SCROLL_LIMIT, $pageNo);
	        $retSearch = array();

 		if($this->sessRequestType == 'app'){
			$pagination['current_page'] = issetor($pager ->page,0);
			$pagination['total_pages'] = issetor($pager ->numPages,0);
			$pagination['total'] = issetor($affRows,0);

	        $retSearch['provider'] = array();
	        $retSearch['pagination'] = $pagination;
	        $retSearch['defaultMinRadius'] = $this->slider_minRadius;
	        $retSearch['defaultMaxRadius'] = ($radius > $this->slider_maxRadius) ? $radius : $this->slider_maxRadius;
		}else{
			$pagination = pagination($pager, $this->pageNo, $affRows);
		}
        if ($pageNo <= $pager->numPages) {
            $offset = $pager->offset;
            if ($offset < 0) {
                $offset = 0;
            }

            $limit = $pager->limit;
            $page = $pager->page;

            $limit_cond = " LIMIT $offset, $limit";

			$allproviderDetails = $this->db->pdoQuery($allproviderDetailsQry . $limit_cond)->results();

			foreach ($allproviderDetails as $key => $providerDetail) {
				$user_image = checkImage('profile/'.$providerDetail['id'].'/th2_'.$providerDetail['profileImg']);
				$user_image_mian = checkImage('profile/'.$providerDetail['id'].'/th2_'.$providerDetail['profileImg'] , "" , "mainImage");
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

				$replaceArray = array(
						'%USER_IMAGE%' => $user_image,
						"%USER_IMAGE_MAIN%" => $user_image_mian,
						"%PROVIDER_NAME%" => $provider_name,
						"%ADDRESS%" => $address,
						"%PROVIDER_ID%" => $provider_id,
						"%AVG_RATING%" => $ratingHtml,
						"%DISTANCE%" => $distance,
						"%EMAIL%" => $email,
						"%CONTACT_NO%" => $contactNo,
						"%FB_LINK%" => $facebook_link,
						"%GOOGLE_LINK%" => $google_link,
						"%TWITTER_LINK%" => $twitter_link
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
				$retData['pagination'] = $pagination;

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
				$retData['html'] = '<div class="no-proivder-section no-data-block">' . NO_NEARBY_PROVIDER_FOUND . '</div>';
				$retData['pagination'] = "";

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
		}

		return $returnResponse;
	}
}

?>
