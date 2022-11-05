<?php
class Registration {
	function __construct($contentArray = array()) {
		global $sessRequestType,$objHome;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;

		}
		extract($contentArray);
		$this->module = $module;
		$this->sessRequestType = $sessRequestType;
		$this->objHome = $objHome;
		$this->regiUserType = $regiUserType;
	}

	public function submitRegistration($request = array()){
		try{
			if(!empty($request)){
				extract($request);
				$businessName  = isset($businessName) ? filtering($businessName,'input'): '';
				$firstName  = isset($firstName) ? filtering($firstName,'input'): '';
				$lastName   = isset($lastName) ? filtering($lastName,'input') : '';
				$email      = isset($email)?filtering($email,'input'):'';
				$contactNo  = isset($contactNo) ? filtering($contactNo,'input') : '';
				$password   = isset($password)?filtering($password,'input'):'';
				$c_password = isset($c_password)?filtering($c_password,'input'):'';
				$user_type     = isset($user_type)?filtering($user_type,'input'):'customer';
				$service_type     = isset($service_type)?filtering($service_type,'input'):'mechanic';
				$vehicle_type     = isset($vehicle_type)?filtering($vehicle_type,'input'):'both';
				
				/* vspl changes start for sign up form  26-09-2022*/
				
				$line1   = isset($line1) ? filtering($line1, 'input') : '';
				$line2   = isset($line2) ? filtering($line2, 'input') : '';
				$city   = isset($city) ? filtering($city, 'input') : '';
				$postcode   = isset($postcode) ? filtering($postcode, 'input') : '';
				$country   = isset($country) ? filtering($country, 'input') : '';
				
				// $address   = $line1.', '.$line2.', '.$city.', '.$postcode.', '.$country;
				$address = '';
				$address .= $line1;
				$address .= (strlen(trim($line1))>0) ? ', ': '';
				$address .= $line2;
				$address .= (strlen(trim($line2))>0) ? ', ': '';
				$address .= $city;
				$address .= (strlen(trim($city))>0) ? ', ': '';
				$address .= $postcode;
				$address .= (strlen(trim($postcode))>0) ? ', ': '';
				$address .= $country;
				
				
				// $address   = isset($address) ? filtering($address, 'input') : '';
				/* vspl changes end for sign up form  26-09-2022*/
				
				$addLat   = isset($addLat) ? filtering($addLat, 'input') : '';
				$addLong   = isset($addLong) ? filtering($addLong, 'input') : '';
				$date       = date('Y-m-d H:i:s');
				$ip         = get_ip_address();

				if(($firstName != '' || $lastName != '' || $businessName != '')  && $contactNo != '' && $email != '' && $password != '' && $c_password != ''&& $user_type != ''){


						if(!isExist($email,'email',false,$this->sessUserId)){
							throw new Exception(MSG_EMAIL_EXISTS);
						}

						if($password != $c_password){
							throw new Exception(MSG_PASS_CONF_NOT_MATCH);
						}

						if(!isExist($contactNo,'contactNo',false,$this->sessUserId)){
							throw new Exception(MSG_CONTACT_EXISTS);
						}

						$activationCode = md5(time());
						$activationLink = '<a href="'.SITE_URL . 'activate-account/' . $activationCode.'">'.ACTIVATE_NOW.'</a>';
						
						$mizutech_name=mizutechUsername();
						$mizutech_pwd=strtolower(genrateRandom(10));

						$insertarray = array(
							"hash"            => '',
							"new_email_id"    => '',
							"business_name"   => $businessName,
							"firstName"       =>$firstName,
							"lastName"        =>$lastName,
							"contactNo"       =>$contactNo,
							"emailVerifyCode" => $activationCode,
							"email"           =>$email,
							"password"        =>md5($password),
							"user_type"       =>$user_type,
							"service_type"    =>$service_type,
							"vehicle_type"    => $vehicle_type,
							"isActive"        =>'n',
							"address"         => $address,
							"addLat"          => $addLat,
							"addLong"         => $addLong,
							"mizutech_name"=>$mizutech_name,
							"mizutech_pwd"=>$mizutech_pwd,
							"ipAddress"       =>$ip,
							"createdDate"     =>$date );

						if($user_type == 'customer') {
							$insertarray['isEmailVerify'] = 'y';
							$insertarray['emailVerifyCode'] = '';
							$insertarray['isActive'] = 'y';
						}
						
						$insert_id=$this->db->insert('tbl_users',$insertarray)->getLastInsertId();
						
						
						$this->db->insert('tbl_email_notification_setting',array('userId'=>$insert_id));

						if($user_type == 'provider') {
							$to = $email;

							$arrayCont = array('greetings'=>"There!",'activationLink'=>$activationLink);

							$array = generateEmailTemplate('user_register',$arrayCont);
							sendEmailAddress($to,$array['subject'],$array['message']);

							$suc_message = MSG_REGISTERED_SUC;
						}
						else {
							$suc_message = MSG_REGISTERED_SUC_CUST;
						}
						
						$data=array("u_username"=>$mizutech_name,"u_password"=>$mizutech_pwd,"u_name"=>$firstName,"u_email"=>$email,"u_phone"=>$contactNo);

						$mizu_response=createMizutechUserAcc($data);
						if($mizu_response){
							$this->db->query("UPDATE tbl_users SET creUpdated = 'y' WHERE id = '".$insert_id."' ");
						}
												
						$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'login',
							'status'		=> true,
							'message'   	=> $suc_message,
							'data'  		=> array("user_id" => $insert_id));

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
				'redirectLink'	=> SITE_URL.'sign-up',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function getPageContent() {

		if($this->regiUserType != "") {
			$array=array(
					"%USER_TYPE%" => $this->regiUserType,
					"%PROV_CLASS%" => ($this->regiUserType == 'provider') ? "" : "d-none"
				);
			$returnResponse = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php",$array);
		}
		else {
			$returnResponse = get_view(DIR_TMPL . $this->module . "/user_selection-nct.tpl.php",array());
		}
		return $returnResponse;
	}
}

?>
