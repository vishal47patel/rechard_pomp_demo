<?php
class Login {
	function __construct($contentArray=array(),$objCookie=array()) {
		global $sessRequestType;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;

		}

		extract($contentArray);
		$this->module = $module;
		$this->sessRequestType = $sessRequestType;
		$this->id = issetor($id);
		$this->objCookie = new stdClass();
		$this->objCookie->email = isset($_COOKIE["email"]) ? $_COOKIE["email"] : '';
		$this->objCookie->password = isset($_COOKIE["password"]) ? ($_COOKIE["password"])	 : '';
		$this->objCookie->remember = isset($_COOKIE["remember"]) ? $_COOKIE["remember"] : 0;
	}

	public function getPageContent() {

		$chk = (isset($this->objCookie->remember) && $this->objCookie->remember == '1') ? 'checked="checked"' : NULL;
		$email = (isset($this->objCookie->email) && $this->objCookie->email != "") ? $this->objCookie->email : NULL;

		$content = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php",array("%EMAIL%"=>$email,"%PASSWORD%"=>$this->objCookie->password,"%REMEMBER_ME%"=>$chk));
		return $content;
	}

	public function submitLogin($request = array()){
		$redirectLink = SITE_URL.'login';

		try{
			if(!empty($request)){
				extract($request);
				if (isset($email) && isset($password)) {
					$selQuery = $this->db->pdoQuery("SELECT * FROM tbl_users WHERE email = '".$email."' OR contactNo = '".$email."'");

					if ($selQuery->affectedRows() >= 1) {
						$result = $selQuery->result();

						$selQuery1 = $this->db->pdoQuery("SELECT * FROM tbl_users WHERE (email = '".$email."' OR contactNo = '".$email."') AND password = ?" , array(md5($password)));

						$result = $selQuery1->result();

						if ($selQuery1->affectedRows() >= 1) {
							if ($result['isActive'] == "r") {
								$selQuery2 = $this->db->pdoQuery("SELECT * FROM tbl_users WHERE isActive != 'r' AND (email = '".$email."' OR contactNo = '".$email."') AND password = ?" , array(md5($password)))->affectedRows();
								
								if($selQuery2 == 0) {
									throw new Exception(ADMIN_DELETED_ACCT);
								}
								else {
									$result = $this->db->pdoQuery("SELECT * FROM tbl_users WHERE isActive != 'r' AND (email = '".$email."' OR contactNo = '".$email."') AND password = ?" , array(md5($password)))->result();
								}								
							} 

							extract($result);
							if (isset($isRemember) && $isRemember == 'y') {
								setcookie('email', $request['email'], time() + 3600 * 24 * 30, '/');
								setcookie('password', ($request['password']), time() + 3600 * 24 * 30, '/');
								setcookie('remember', '1', time() + 3600 * 24 * 30, '/');
							} else {
								setcookie('email', '', time() - 3600, '/');
								setcookie('password', '', time() - 3600, '/');
								setcookie('remember', '', time() - 3600, '/');
							}
							if ($isEmailVerify == "n") {
								throw new Exception(MSG_ACTIVATE_ACC);
							}else if ($isActive == "n") {
								throw new Exception(MSG_ACCT_DEACTIVED);
							}
							else {
								if($this->sessRequestType != 'app'){
									$_SESSION["user_id"] = $id;
									$_SESSION["first_name"] = $firstName;
									$_SESSION["last_name"] = $lastName;
									$_SESSION["user_type"] = $user_type;
									$_SESSION["service_type"] = $service_type;
									$_SESSION["login_time"] = time();
								}
								$result['profileUrl'] =checkImage('profile/'.$id.'/th2_'.$profileImg);
								
								$result['isProfileCompleted'] = $second_step_complete;
								if($_SESSION['req_uri'] != ""){
									$redirectLink = $_SESSION['req_uri'];
									unset($_SESSION['req_uri']);
								}else{

									if($second_step_complete == 'y') {
										if($user_type == 'provider') {
											$redirectLink = SITE_URL . 'profile/' . $id;
										}
										else {
											$redirectLink = SITE_URL;
										}
									}
									else {
										$redirectLink = SITE_URL . 'second-step';
									}
								}
								$result['voip_server_address'] = VOIP_SERVER_ADDRESS;
								
								if($creUpdated=='n'){
									$data=array("u_username"=>$mizutech_name,"u_password"=>$mizutech_pwd,"u_name"=>$firstName,"u_email"=>$email,"u_phone"=>$contactNo);

									$mizu_response=createMizutechUserAcc($data);
									if($mizu_response){
										$this->db->query("UPDATE tbl_users SET creUpdated = 'y' WHERE id = '".$id."' ");
									}
								}
								
								$returnResponse = array(
									'redirectLink' 	=> $redirectLink,
									'status'		=> true,
									'message'   	=> MSG_LOGIN_SUC.' '.SITE_NM,
									'data'  		=> mapArray($result));

								return $returnResponse;

							}
						} else {
							throw new Exception(MSG_INVALID_PASSWORD);
						}
					} else {
						throw new Exception(MSG_INVALID_EMAIL_NO);
					}
				} else {
					throw new Exception(FILL_VALUES);
				}
			}else{
				throw new Exception(FILL_VALUES);
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

	public function activateAccount($request = array()){
	    extract($request);
	    try{
		    $emailVerifyCode = isset($emailVerifyCode) ? $emailVerifyCode : NULL;

		    if ($emailVerifyCode != NULL) {
		        $selUser = $this->db-> pdoQuery('SELECT id,isEmailVerify,isActive,emailVerifyCode FROM tbl_users WHERE emailVerifyCode = ? LIMIT 1', array($emailVerifyCode));

		        if ($selUser -> affectedRows() > 0) {
		            $fetchUser = $selUser -> result();
		            if ($fetchUser['isEmailVerify'] == 'y') {

		                if ($fetchUser['isActive'] == 'd') {
		                	throw new Exception(MSG_ACCT_DEACTIVED);
		                }
		                else {
		                    throw new Exception(MSG_ACCOUNT_ACTIVATED);
		                }
		            }
		            else {

		                $id = $fetchUser['id'];

		                $this->db-> update('tbl_users', array(
		                    'isEmailVerify' 	=> 'y',
		                    'emailVerifyCode'	=> '',
		                    'isActive' => 'y'
		                ), array("id" => $id));

		                $returnResponse = array(
							'redirectLink' 	=> SITE_URL.'login',
							'status'		=> true,
							'message'  	 	=> MSG_ACCOUNT_SUC_ACTIVATED,
							'data'  		=> array());

						return $returnResponse;
		            }
		        }
		        else {
		            throw new Exception(MSG_INVALID_VERI_CODE);
		        }
		    }else{
		    	throw new Exception(MSG_INVALID_VERI_CODE);
		    }
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL.'login',
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function forgotPassword($request_data = array()){
		extract($request_data);

		$returnResponse = array();
		try{
			$email = (isset($email)) ? filtering($email, 'input', 'string', '') : '';
			$check_email =$this->db-> pdoQuery('SELECT email FROM tbl_users WHERE email = ? AND isActive != "r"', array($email))->affectedRows();

			if($check_email>0){
				$fetchRes = $this->db-> pdoQuery('SELECT * FROM tbl_users WHERE email = ? AND isActive != "r"', array($email))->result();

				$uId = (isset($fetchRes['id']))?$fetchRes['id']:'';
				$active = (isset($fetchRes['isActive']))?$fetchRes['isActive']:'n';
				$isEmailVerify = (isset($fetchRes['isEmailVerify']))?$fetchRes['isEmailVerify']:'n';
				$firstName = (isset($fetchRes['firstName']))?$fetchRes['firstName']:'';
				$lastName = (isset($fetchRes['lastName']))?$fetchRes['lastName']:'';

				if($isEmailVerify == 'y'){
					if($active == 'y'){
						$hash = base64_encode(time());
						$valArray = array('hash'=>$hash);
						$this->db->update('tbl_users',$valArray,array('email'=>$email));

						$to = $email;
						$arrayCont = array('greetings'=>$firstName,'passLink'=>'<a href="'.SITE_URL.'reset_password/'.base64_encode($uId).'/'.$hash.'">Click Here</a>');

						$array = generateEmailTemplate('user_forgot_password',$arrayCont);
						
						sendEmailAddress($to,$array['subject'],$array['message']);

						$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'login',
							'status'		=> true,
							'message'  	 	=> MSG_RESET_PASSWORD_MAIL_SEND,
							'data'  		=> array());

						return $returnResponse;
					}
					else {
						throw new Exception(MSG_ACCT_DEACTIVED);	
					}
				}else{
					throw new Exception(MSG_ACTIVATE_ACC);
				}
			}else{
				$check_email1 =$this->db-> pdoQuery('SELECT email FROM tbl_users WHERE email = ? AND isActive = "r"', array($email))->affectedRows();

				if($check_email1 > 0) {
					throw new Exception(ADMIN_DELETED_ACCT);
				}
				else {
					throw new Exception(MSG_EMAIL_NOT_EXIST);
				}
			}
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL.'login',
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function resendVerificationMail($request_data = array()) {
		extract($request_data);

		$returnResponse = array();
		try{
			$email = (isset($email)) ? filtering($email, 'input', 'string', '') : '';
			$userData =$this->db-> pdoQuery('SELECT * FROM tbl_users WHERE email = ? AND isActive != "r"', array($email));
			$check_email = $userData->affectedRows();

			if($check_email>0){
				$fetchRes = $userData->result();

				$uId = (isset($fetchRes['id']))?$fetchRes['id']:'';
				$active = (isset($fetchRes['isActive']))?$fetchRes['isActive']:'n';
				$isEmailVerify = (isset($fetchRes['isEmailVerify']))?$fetchRes['isEmailVerify']:'n';
				$firstName = (isset($fetchRes['firstName']))?$fetchRes['firstName']:'';
				$lastName = (isset($fetchRes['lastName']))?$fetchRes['lastName']:'';

				if($isEmailVerify == 'n'){
					$activationCode = md5(time());

					$valArray = array('emailVerifyCode'=>$activationCode);
					$this->db->update('tbl_users',$valArray,array('email'=>$email));

					$activationLink = '<a href="'.SITE_URL . 'activate-account/' . $activationCode.'">Activate Now</a>';

					$to = $email;

					$arrayCont = array('greetings'=>$firstName . " " . $lastName,'activationLink'=>$activationLink);

					$array = generateEmailTemplate('resend_verification',$arrayCont);
					sendEmailAddress($to,$array['subject'],$array['message']);

					$returnResponse = array(
						'redirectLink' 	=> SITE_URL.'login',
						'status'		=> true,
						'message'  	 	=> MSG_ACTIVATION_MAIL_SENT,
						'data'  		=> array());

					return $returnResponse;
				}else{
					throw new Exception(MSG_ACCOUNT_ACTIVATED);
				}
			}else{
				$check_email1 =$this->db-> pdoQuery('SELECT email FROM tbl_users WHERE email = ? AND isActive = "r"', array($email))->affectedRows();

				if($check_email1 > 0) {
					throw new Exception(ADMIN_DELETED_ACCT);
				}
				else {
					throw new Exception(MSG_EMAIL_NOT_EXIST);
				}
			}
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL.'login',
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}
}

?>
