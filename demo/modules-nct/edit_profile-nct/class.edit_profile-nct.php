<?php
class edit_profile
{
	public function __construct($contentArray = array())
	{
		global $sessUserId, $sessRequestType, $objHome;

		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);
		$this->module          = $module;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId      = isset($userId) && $userId > 0 ? $userId : $sessUserId;
		$this->userCountryId   = 91;
		$this->objHome         = $objHome;
	}

	public function isUserProfileSet()
	{
		$profilePic = getTableValue('tbl_users', 'profileImg', array('id' => $this->sessUserId));

		if ($profilePic == '') {
			return 'false';
		} else {
			return 'true';
		}
	}
	
	public function setTaxiAvailability($request = array()){
		try
		{
			if(!empty($request)){

				$availability_status = isset($request['availability_status']) ? ($request['availability_status']): '';

				if($availability_status!=""){					
					
					$startDateTime = date("Y-m-d" , strtotime($request['cal_start_date']));
					$endDateTime = date("Y-m-d" , strtotime($request['cal_end_date']));

					$bookedServices = $this->db->pdoQuery("SELECT id FROM tbl_service_requests WHERE ( (start_date >= '".$startDateTime."' AND start_date <= '".$endDateTime."') ) AND provider_id = " . $this->sessUserId . " AND request_status = 'a' AND service_status != 'cancel'")->affectedRows();
					
					if(($bookedServices > 0) && ($availability_status == "no")) {
						$returnResponse = array(
				        'redirectLink'  => SITE_URL . 'edit-profile',
				        'status'        => false,
				        'message'       => NOT_UPDATE_BOOKED_TIME);

						return $returnResponse;
					}

					while($startDateTime < date("Y-m-d" , strtotime($request['cal_end_date']))) {
						$datePart = date("Y-m-d" , strtotime($startDateTime));
						$slot = $request['slot'];

						if($availability_status == 'yes') {
							$this->db->delete("tbl_provider_availability" , array(
								"provider_id" => $this->sessUserId,
								"start_date" => $datePart,
								"slot" => $slot
						));
						}
						else {
							$checkRecExist = getTableValue("tbl_provider_availability" , "id" , array(
									"provider_id" => $this->sessUserId,
									"start_date" => $datePart,
									"slot" => $slot
								));

							if($checkRecExist == "") {
								$this->db->insert("tbl_provider_availability" , array(
									"provider_id" => $this->sessUserId,
									"start_date" => $datePart,
									"slot" => $slot
								));
							}
						}						

						$time = strtotime($startDateTime) + (24 * 3600);
						$startDateTime = date("Y-m-d", $time);
					}

					$returnResponse = array(
				        'redirectLink'  => SITE_URL,
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

	public function setManualAvailability($request = array()){
		try
		{
			if(!empty($request)){

				$availability_status = isset($request['availability_status']) ? ($request['availability_status']): '';

				if($availability_status!=""){					
					
					$startDateTime = date("Y-m-d" , strtotime($request['cal_start_date']));
					$endDateTime = date("Y-m-d" , strtotime($request['cal_end_date']));

					if($request['slot'] == 0) {
						$bookedServices = $this->db->pdoQuery("SELECT id FROM tbl_service_requests WHERE ( (start_date >= '".$startDateTime."' AND start_date <= '".$endDateTime."') ) AND provider_id = " . $this->sessUserId . " AND request_status = 'a' AND service_status != 'cancel'")->affectedRows();
					}
					else {
						$bookedServices = $this->db->pdoQuery("SELECT id FROM tbl_service_requests WHERE ( (service_date >= '".$startDateTime."' AND service_date <= '".$endDateTime."') AND (service_time_slot = ".$request['slot'].")) AND provider_id = " . $this->sessUserId . " AND request_status = 'a' AND service_status != 'cancel'")->affectedRows();
					}

					if(($bookedServices > 0) && ($availability_status == "no")) {
						$returnResponse = array(
				        'redirectLink'  => SITE_URL . 'edit-profile',
				        'status'        => false,
				        'message'       => NOT_UPDATE_BOOKED_TIME);

						return $returnResponse;
					}

					while($startDateTime <= date("Y-m-d" , strtotime($request['cal_end_date']))) {
						$datePart = date("Y-m-d" , strtotime($startDateTime));
						$slot = $request['slot'];

						if($availability_status == 'yes') {
							$this->db->delete("tbl_provider_availability" , array(
								"provider_id" => $this->sessUserId,
								"start_date" => $datePart,
								"slot" => $slot
						));
						}
						else {
							$checkRecExist = getTableValue("tbl_provider_availability" , "id" , array(
									"provider_id" => $this->sessUserId,
									"start_date" => $datePart,
									"slot" => $slot
								));

							if($checkRecExist == "") {
								$this->db->insert("tbl_provider_availability" , array(
									"provider_id" => $this->sessUserId,
									"start_date" => $datePart,
									"slot" => $slot
								));
							}
						}						

						$time = strtotime($startDateTime) + (24 * 3600);
						$startDateTime = date("Y-m-d", $time);
					}

					$returnResponse = array(
				        'redirectLink'  => SITE_URL,
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

	public function setAvailabilityById($request = array()){
		try
		{
			if(!empty($request)){

				$availability_status = isset($request['availability_status']) ? ($request['availability_status']): '';
					
				$this->db->delete("tbl_provider_availability" , array(
						"id" => $request['availability_id']
				));
				

				$returnResponse = array(
			        'redirectLink'  => SITE_URL,
			        'status'        => true,
			        'message'       => AVAILABILITY_UPDATED_SUCCESSFULLY);

				return $returnResponse;					

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

	public function setAvailability($request = array()){
		try
		{
			if(!empty($request)){

				$availability_status = isset($request['availability_status']) ? ($request['availability_status']): '';

				if($availability_status!=""){					
					
					$startDateTime = date("Y-m-d" , strtotime($request['cal_start_date']));
					$endDateTime = date("Y-m-d" , strtotime($request['cal_end_date']));

					$start_slot = date("H" , strtotime($request['cal_start_date']));
					$start_slot += 1;

					$end_slot = date("H" , strtotime($request['cal_end_date']));
					$end_slot += 1;

					$bookedServices = $this->db->pdoQuery("SELECT id FROM tbl_service_requests WHERE ( (service_date >= '".$startDateTime."' AND service_time_slot >= ".$start_slot.") AND (service_date <= '".$endDateTime."' AND service_time_slot <= ".$end_slot.") ) AND provider_id = " . $this->sessUserId . " AND request_status = 'a' AND service_status != 'cancel'")->affectedRows();
					
					if(($bookedServices > 0) && ($availability_status == "no")) {
						$returnResponse = array(
				        'redirectLink'  => SITE_URL . 'edit-profile',
				        'status'        => false,
				        'message'       => NOT_UPDATE_BOOKED_TIME);

						return $returnResponse;
					}

					$startDateTime = $request['cal_start_date'];

					while($startDateTime < $request['cal_end_date']) {
						$datePart = date("Y-m-d" , strtotime($startDateTime));
						$slot = date("H" , strtotime($startDateTime));
						$slot += 1;

						if($availability_status == 'yes') {
							$this->db->delete("tbl_provider_availability" , array(
								"provider_id" => $this->sessUserId,
								"start_date" => $datePart,
								"slot" => $slot
						));
						}
						else {
							$checkRecExist = getTableValue("tbl_provider_availability" , "id" , array(
									"provider_id" => $this->sessUserId,
									"start_date" => $datePart,
									"slot" => $slot
								));

							if($checkRecExist == "") {
								$this->db->insert("tbl_provider_availability" , array(
									"provider_id" => $this->sessUserId,
									"start_date" => $datePart,
									"slot" => $slot
								));
							}
						}						

						$time = strtotime($startDateTime) + 3600;
						$startDateTime = date("Y-m-d H:i", $time);
					}

					$returnResponse = array(
				        'redirectLink'  => SITE_URL,
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
	
	public function submitUpdateAboutUs($request = array())
	{
		try {
			if (!empty($request)) {
				extract($request);
				// echo "this->sessUserId".$this->sessUserId;
				
				// print_r($request);exit;
				$objPost->business_details    = isset($about_us)?filtering($about_us,'input'):'';
				$this->db->update('tbl_users', (array) $objPost, array('id' => $this->sessUserId));	
				$returnResponse = array(
					'status'       => true,
					'message'      => MSG_ABOUT_US_UPDATE_SUC,
					'data'         => array());

				return $returnResponse;
			}
			
		} catch (Exception $e) {
			$returnResponse = array(
				'status'       => false,
				'message'      => $e->getMessage(),
				'data'         => array());

			return $returnResponse;
		}
	}
	public function submitUpdateProfile($request = array(),$FILES='')
	{
		try {
			if (!empty($request)) {
				extract($request);
				//print_r($request);exit;
				$objPost->firstName = isset($firstName) ? filtering($firstName, 'input') : '';
				$objPost->lastName  = isset($lastName) ? filtering($lastName, 'input') : '';
				$objPost->business_name    = isset($business_name)?filtering($business_name,'input'):'';
				$objPost->paypalEmail    = isset($paypalEmail)?filtering($paypalEmail,'input'):'';
				$objPost->business_details    = isset($business_details)?filtering($business_details,'input'):'';
				$objPost->contactNo   = isset($contactNo) ? filtering($contactNo, 'input') : '';
				$objPost->address   = isset($address) ? filtering($address, 'input') : '';
				$objPost->addLat   = isset($addLat) ? filtering($addLat, 'input') : '';
				$objPost->addLong   = isset($addLong) ? filtering($addLong, 'input') : '';
				$objPost->vehicle_type   = isset($vehicle_type) ? filtering($vehicle_type, 'input') : '';
				$objPost->vehi_brand = isset($vehi_brand) ? filtering($vehi_brand, 'input') : '';
				$objPost->vehi_model = isset($vehi_model) ? filtering($vehi_model, 'input') : '';
				$objPost->vehi_year = isset($vehi_year) ? filtering($vehi_year, 'input') : '';
				$objPost->vehi_engine = isset($vehi_engine) ? filtering($vehi_engine, 'input') : '';
				$objPost->vehi_mileage = isset($vehi_mileage) ? filtering($vehi_mileage, 'input') : '';
				
				if ($objPost->firstName != '' && $objPost->lastName != '' && $objPost->contactNo != '' ) {

					if (!isExist($contactNo, 'contactNo', true, $this->sessUserId)) {
						throw new Exception(MSG_CONTACT_EXISTS);
					}

					/*if (!isExist($paypalEmail, 'paypalEmail', true, $this->sessUserId)) {
						throw new Exception(MSG_PAYPAL_EXIST);
					}*/
					if ($this->sessRequestType == 'app') {
						if (isset($FILES['image']['name']) && $FILES['image']['error'] <= 0) {

							$upload_dir = DIR_UPD . 'profile/' . $this->sessUserId . '/';
							if (!file_exists($upload_dir)) {
								mkdir($upload_dir, 0777);
							}

							$newName = rand() . time() . '.png';
							/* Remove old profile pics of particular user */
							deletefile($upload_dir, array($newName));

							$destination = DIR_UPD . "profile/" . $this->sessUserId . '/' . $newName;
							$cropped     = $FILES["image"]["tmp_name"];

							$thumbnailArray    = array();
							$thumbnailArray[0] = array('newWidth' => 100, 'newHeight' => 100);
							$thumbnailArray[1] = array('newWidth' => 265, 'newHeight' => 265);
							
							uploadImagewithResize($upload_dir, $destination, $cropped, $newName, $thumbnailArray);
							convertToWebP($upload_dir.'th1_'.$newName);
        					convertToWebP($upload_dir.'th2_'.$newName);

							$objPost->profileImg = $newName;
						}
					}

					if ($this->sessRequestType == 'app') {
						foreach ($_FILES['uploadedImages']['tmp_name'] as $uploadedImages) {
							$hiddenImg = rand().time().'.png';
					        $upload_dir = DIR_UPD.'images/'.$this->sessUserId. '/';

					        if(!file_exists($upload_dir))
					        {
					            mkdir($upload_dir,0777);
					        }
					        
					        copy($uploadedImages, $upload_dir.$hiddenImg);
					        convertToWebP($upload_dir.$hiddenImg);

					        /*$thumbnailArray[0] = array('newWidth'=>360,'newHeight'=>127);
		                
			                uploadImagewithResize($upload_dir,$upload_dir.$hiddenImg,DIR_UPD.'images/temp_dir/'.$hiddenImg,$hiddenImg,$thumbnailArray);
			                convertToWebP($upload_dir.'th1_'.$hiddenImg);*/

					        $this->db->insert("tbl_user_images" , array("image_name" => $hiddenImg , "user_id" => $this->sessUserId));
					    }
					}
					else {
						if(!empty($request['uploadedImages'])) {

							foreach ($request['uploadedImages'] as $hiddenImg) {

						        $upload_dir = DIR_UPD.'images/'.$this->sessUserId. '/';

						        if(!file_exists($upload_dir))
						        {
						            mkdir($upload_dir,0777);
						        }
						        
						        copy(DIR_UPD.'images/temp_dir/'.$this->sessUserId.'/'.$hiddenImg, $upload_dir.$hiddenImg);
						        convertToWebP($upload_dir.$hiddenImg);

						        /*$thumbnailArray[0] = array('newWidth'=>360,'newHeight'=>127);
			                
				                uploadImagewithResize($upload_dir,$upload_dir.$hiddenImg,DIR_UPD.'images/temp_dir/'.$hiddenImg,$hiddenImg,$thumbnailArray);
				                convertToWebP($upload_dir.'th1_'.$hiddenImg);*/

						        $this->db->insert("tbl_user_images" , array("image_name" => $hiddenImg , "user_id" => $this->sessUserId));
						    }


						    $tempFile = glob(DIR_UPD."images/temp_dir/".$this->sessUserId."/*"); // get all file names
					        foreach($tempFile as $fileList)
					        { // iterate files
					            if(is_file($fileList))
					                unlink($fileList); // delete file
					        }

					        rmdir(DIR_UPD."images/temp_dir/".$this->sessUserId);
						}
					}

					foreach ($request['removeImages'] as $removeImage) {
						$imageName = getTableValue("tbl_user_images" , "image_name" , array("id" => $removeImage));
						$this->db->delete("tbl_user_images" , array("id" => $removeImage));
						unlink(DIR_UPD."images/".$this->sessUserId . "/" . $imageName);

						$pathInfo = pathinfo(SITE_UPD . "images/".$this->sessUserId . "/" . $imageName);
        				unlink(DIR_UPD."images/".$this->sessUserId . "/" . $pathInfo['filename'] . '.webp');
					}

					$this->db->update('tbl_users', (array) $objPost, array('id' => $this->sessUserId));

					$returnData = array(
						"profileImg" => checkImage('profile/' . $this->sessUserId . '/th2_' . $objPost->profileImg),
					);

					$returnResponse = array(
						'redirectLink' => SITE_URL . 'profile/' . $this->sessUserId,
						'status'       => true,
						'message'      => MSG_PROFILE_UPDATE_SUC,
						'data'         => array());

					return $returnResponse;
				} else {
					throw new Exception(MSG_FILL_ALL_VALUE);
				}
			} else {
				throw new Exception(MSG_FILL_ALL_VALUE);
			}
		} catch (Exception $e) {
			$returnResponse = array(
				'redirectLink' => SITE_URL . 'edit-profile',
				'status'       => false,
				'message'      => $e->getMessage(),
				'data'         => array());

			return $returnResponse;
		}
	}

	public function getPageContent()
	{

		$userData = $this->db->select('tbl_users', array('*'), array('id' => $this->sessUserId))->result();

		if (!empty($userData)) {

			$uploadedImages = '';

	        $images = $this->db->pdoQuery("SELECT id , image_name FROM tbl_user_images WHERE user_id = " . $this->sessUserId)->results();

	        foreach ($images as $image) {
	            $uploadedImages .= '<div class="col-6 col-sm-4 col-md-3 form-group"><div class="position-relative"><div class="img-preview-list">
	            
	            <picture>
                      <source class="w-100" srcset="'.checkImage('images/'.$this->sessUserId. '/'.$image['image_name']).'" type="image/webp">
                      <source class="w-100" srcset="'.checkImage('images/'.$this->sessUserId. '/'.$image['image_name'] , "" , "mainImage").'" type="image/jpg"> 
                      <img class="w-100" src="'.checkImage('images/'.$this->sessUserId. '/'.$image['image_name'] , "" , "mainImage").'" />
                    </picture>

	            </div><a href="javascript:void(0)" class="close-icon hardImgDelete" imageId="'.$image['id'].'"><i class="icon-trash"></i></a></div></div>';
	        }
			
			$replaceArray    = array(
				'%FIRST_NAME%' => filtering($userData['firstName'], 'output', 'string'),
				'%LAST_NAME%'  => filtering($userData['lastName'], 'output', 'string'),
				'%BUSINESS_NAME%'  => filtering($userData['business_name'], 'output', 'string'),
				'%CONTACT_NO%' => filtering($userData['contactNo'], 'output', 'string'),
				'%USER_IMAGE%' => checkImage('profile/' . $this->sessUserId . '/th2_' . $userData['profileImg'] , "" , "mainImage"),
				'%USER_IMAGE_HDN%' => $userData['profileImg'],
				"%ADDRESS%"    => filtering($userData['address'], 'output', 'string'),
				"%ADDRESS_LAT%" => $userData['addLat'],
				"%ADDRESS_LNG%" => $userData['addLong'],
				"%CAR_SELCTED%" => ($userData['vehicle_type'] == 'car') ? "selected='selected'" : "",
				"%BIKE_SELCTED%" => ($userData['vehicle_type'] == 'bike') ? "selected='selected'" : "",
				"%BOTH_SELCTED%" => ($userData['vehicle_type'] == 'both') ? "selected='selected'" : "",
				'%SESSUSERID%' => $this->sessUserId,
				"%USR_SERVICE_TYPE%" => $userData['service_type'],
				"%DEST_SITE_URL%" => SITE_UPD.'images/temp_dir/'.$this->sessUserId . "/",
				"%DEST_DIR_URL%" => DIR_UPD.'images/temp_dir/'.$this->sessUserId . "/",
				"%UPLOADED_IMAGES%" => $uploadedImages,
				'%VEHI_BRAND%'   =>  $userData['vehi_brand'],
				'%VEHI_MODEL%'   =>  $userData['vehi_model'],
				'%VEHI_YEAR%'   =>  $userData['vehi_year'],
				'%VEHI_ENGINE%'   =>  $userData['vehi_engine'],
				'%VEHI_MILEAGE%' => $userData['vehi_mileage'],
				'%PAYMENT_GATEWAY_ID%' => $userData['paypalEmail'],
				"%BUSINESS_DETAILS%" => $userData['business_details']
			);
		}

		if($userData['user_type'] == 'provider') {
			$replaceArray["%TIME_SLOTS%"] = prepare_time_slots();
		}

		$content = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php", $replaceArray);
		return $content;
	}

}
