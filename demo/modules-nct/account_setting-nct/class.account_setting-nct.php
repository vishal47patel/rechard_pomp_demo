<?php
class AccountSetting {
	function __construct($contentArray = array()) {
		global $objHome,$sessUserId,$sessRequestType;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);
		$this->module = $module;
		$this->objHome = $objHome;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId = isset($userId) && $userId > 0 ? $userId : $sessUserId;
	}

	/*public function changeMizutechDetails($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$mizutech_name = isset($mizutech_name) ? strtolower($mizutech_name): '';
				$mizutech_pwd = isset($mizutech_pwd) ? strtolower($mizutech_pwd): '';

				if(($mizutech_name != "") && ($mizutech_pwd != "")) {

					$this->db->update('tbl_users', array("mizutech_name"=>$mizutech_name , "mizutech_pwd" => $mizutech_pwd), array('id' => $this->sessUserId));

					$returnResponse = array(
						'redirectLink' 	=> SITE_URL.'account-setting',
						'status'		=> true,
						'message'   	=> MIZU_DETAILS_SAVED_SUC);

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
				'redirectLink'	=> SITE_URL.'account-setting',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}*/

	public function submitPaypalEmail($request = array()){		
		try
		{
			if(!empty($request)){
				extract($request);

				$paypalEmail = isset($paypalEmail) ? strtolower($paypalEmail): '';

				// if($paypalEmail!=""){

					$this->db->update('tbl_users', array("paypalEmail"=>$paypalEmail), array('id' => $this->sessUserId));

					$returnResponse = array(
						'redirectLink' 	=> SITE_URL.'account-setting',
						'status'		=> true,
						'message'   	=> PAY_GATE_ID_UPDATED);

					return $returnResponse;
				// }else{
		    		// throw new Exception(MSG_FILL_ALL_VALUE);
		    	// }

			}else{
				throw new Exception(MSG_FILL_ALL_VALUE);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'account-setting',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}

	public function submitChangeEmail($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$new_email_id = isset($new_email_id) ? strtolower($new_email_id): '';

				if($new_email_id!=""){

					//$email_exist=getTableValue('tbl_users','id',array('email' => $new_email_id));
					$email_exist = $this->db->pdoQuery("SELECT id FROM tbl_users WHERE email = '".$new_email_id."' AND isActive != 'r'")->result();
					$email_exist = $email_exist['id'];

					if($email_exist>0){
						throw new Exception(MSG_EMAIL_EXISTS);
					}else{
						$acti_key=base64_encode(time());
						$objPost->emailVerifyCode=$acti_key;
						$this->db->update('tbl_users', array('emailVerifyCode' => $objPost->emailVerifyCode,"new_email_id"=>$new_email_id), array('id' => $this->sessUserId));

						$fetch = $this->db->select("tbl_users",array('email','firstName'),array('id'=>$this->sessUserId))->result();
						$to              = $new_email_id;
			            $greetings       = $fetch['firstName'];

			            $cont_array      = array(
			                "greetings" => $greetings,
			                "old_email" => $fetch['email'],
			                "new_email" => $to,
			                "verificationLink" => '<a href="' . SITE_URL . '?activationCode=' . $objPost->emailVerifyCode . '&id=' . $this->sessUserId . '&action=changeEmail" title="Please click here to verify your account">Please click here to verify email.</a>'
			            );

						$array = generateEmailTemplate('change_email_address',$cont_array);
						sendEmailAddress($to,$array['subject'],$array['message']);

						$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'account-setting',
							'status'		=> true,
							'message'   	=> PLE_CHECK_MAIL_CHANGE_MAIL);

						return $returnResponse;
					}
				}else{
		    		throw new Exception(MSG_FILL_ALL_VALUE);
		    	}

			}else{
				throw new Exception(MSG_FILL_ALL_VALUE);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'account-setting',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}

	public function submitChangePassword($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);
				$oldPwd = isset($oldPwd) ? filtering($oldPwd,'input'): '';
				$newPwd = isset($newPwd) ? filtering($newPwd,'input'): '';
				$cnfNewPwd = isset($cnfNewPwd) ? filtering($cnfNewPwd,'input'): '';

				if($oldPwd != '' && $newPwd != '' && $cnfNewPwd != ''){
					//echo isPasswordValid($this->sessUserId,$oldPwd);
					if(!isPasswordValid($this->sessUserId,$oldPwd)){
						throw new Exception(MSG_CURR_PASS_NOT_MATCH);
					}
					/*echo 'one';
					exit;*/

					if($newPwd != $cnfNewPwd){
						throw new Exception(MSG_PASS_EQUAL);
					}
					if($newPwd == $oldPwd){
						throw new Exception(MSG_PASS_SAME);
					}

					$updateArray = array(
						"password"		=> md5($newPwd)
						);

					$this->db->update('tbl_users',$updateArray,array('id'=>$this->sessUserId));

					$returnResponse = array(
						'redirectLink' 	=> SITE_URL.'account-setting',
						'status'		=> true,
						'message'   	=> MSG_PASS_CHANGE_SUC);
					//print_r($returnResponse);exit;
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
				'redirectLink'	=> SITE_URL.'account-setting',
				'status'		=> false,
				'message'   	=> $e->getMessage());
			return $returnResponse;
		}
	}

	public function submitEmailNotification($request = array()){
			try
			{
				if(!empty($request)){
					extract($request);
					$notification_type = isset($notification_type) ? filtering($notification_type,'input'): '';
					$check = isset($check) ? filtering($check,'input'): 'n';

					if($notification_type != '' && $check != ''){

							$updateArray = array(
								$notification_type		=> $check
							);
							//print_r($updateArray);exit;
							$this->db->update('tbl_email_notification_setting',$updateArray,array('userId'=>$this->sessUserId));
							//echo $tot;exit;
							$returnResponse = array(
								'redirectLink' 	=> SITE_URL.'account-setting',
								'status'		=> true,
								'message'   	=> MSG_NOTI_UPDATED_SUC);

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
					'redirectLink'	=> SITE_URL.'account-setting',
					'status'		=> false,
					'message'   	=> $e->getMessage());

				return $returnResponse;
			}
	}

	public function getEmailNotification() {

		$replaceArray = array(
			'%NOTIFICATION_LIST%' => $this->getEmailNotificationList()
		);

		return get_view(DIR_TMPL . "{$this->module}/email_notification-nct.tpl.php",$replaceArray);
	}

	public function getEmailNotificationList(){
		$dbName = DB_NAME;

		$user_type=getTableValue("tbl_users","user_type",array("id"=>$this->sessUserId));
		$where='';
		if($user_type=='provider'){
			$where=" AND (COLUMN_NAME='request_received' OR COLUMN_NAME='service_completed' OR COLUMN_NAME='service_cancelled') ";
		}else{
			$where=" AND (COLUMN_NAME='assigned_customer' OR COLUMN_NAME='service_completed' OR COLUMN_NAME='service_cancelled') ";
		}

		$qrySel = $this->db->pdoQuery("SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$dbName."' AND TABLE_NAME = 'tbl_email_notification_setting'".$where)->results();

		if(!empty($qrySel)){
			$notificatonData = '';
			foreach ($qrySel as $key => $data) {
				if($user_type=='provider'){
					if($data['COLUMN_NAME'] == 'request_received'){
						$title = WHEN_SER_REQ_REC;
					}else if($data['COLUMN_NAME'] == 'service_completed'){
						$title = WHEN_SER_COM;
					}else if($data['COLUMN_NAME'] == 'service_cancelled'){
						$title = WHEN_SER_CAN_BY_PRO;
					}
				}else{
					if($data['COLUMN_NAME'] == 'assigned_customer'){
						$title = WHEN_SER_ASSIGN_CUS;
					}else if($data['COLUMN_NAME'] == 'service_completed'){
						$title = WHEN_SER_COM;
					}else if($data['COLUMN_NAME'] == 'service_cancelled'){
						$title = WHEN_SER_CAN_BY_PRO;
					}
				}
				
				$value =  checkNotiEnable($this->sessUserId,$data['COLUMN_NAME']);
				$notiValue = null;
				$appValue = 'n';

				if($value == true){
					 $notiValue = 'checked';
					 $appValue = 'y';
				}
				$notiData[] = array("title"=>$title,"notification_type" => $data['COLUMN_NAME'] , "is_enable" => $appValue);

				$replaceArray = array(
					'%NO%'	=> $i,
					'%NOTIFICATION_TITLE%' => $title,
					'%NOTIFICATION_TYPE%' => $data['COLUMN_NAME'],
					'%SELECTED%' => $notiValue,
				);
				$notificatonData.=get_view(DIR_TMPL . "{$this->module}/notification_type-nct.tpl.php",$replaceArray);
			}
			if($this->sessRequestType == 'app'){
				$retArr =  array('status'=>true,
							 'message'=>'success',
							 'data'=>$notiData);
				return $retArr;
			}else{
				return $notificatonData;
			}
		}
	}

	public function getChangePassword() {
		return get_view(DIR_TMPL . "{$this->module}/change_password-nct.tpl.php");
	}

	public function getPageContent() {
		$menu_tab = $this->objHome->getMenuTab($this->module);

		$mizutechDetails = $this->db->pdoQuery("SELECT mizutech_name , mizutech_pwd FROM tbl_users WHERE id = ?" , array($this->sessUserId))->result();
		
		$paymentGetId = $this->db->select('tbl_users', array('paypalEmail'), array('id' => $this->sessUserId))->result();		
		$replaceArray = array(
			'%MENU_TAB%' => $menu_tab,
			'%NOTIFICATION_LIST%' => $this->getEmailNotificationList(),
			'%CHANGE_PWD_TAB%' => $this->getChangePassword(),
			'%MIZU_NAME%' => $mizutechDetails['mizutech_name'],
			'%MIZU_PWD%' => $mizutechDetails['mizutech_pwd'],
			'%PAYMENT_GATEWAY_ID%'=> $paymentGetId['paypalEmail'],
		);

		return get_view(DIR_TMPL . "{$this->module}/{$this->module}.tpl.php",$replaceArray);
	}

	public function deleteAccount(){
		try
			{
				if($this->sessUserId != "" && $this->sessUserId > 0){
					$rideComplete = $this->db->pdoQuery("SELECT * FROM tbl_rides WHERE driverId = ? AND isActive != 't' AND (status != 'p' AND status !='r')",array($this->sessUserId))->affectedRows();

					if($rideComplete > 0){
						/*$this->db->pdoQuery("DELETE FROM tbl_users WHERE id = ".$this->sessUserId);
						$this->db->pdoQuery("DELETE FROM tbl_user_notification WHERE senderId = ? OR receiverId = ? OR driverId = ? OR customerId = ?",array($this->sessUserId,$this->sessUserId,$this->sessUserId,$this->sessUserId));*/

						if($this->sessRequestType =='app'){
							$returnResponse = array(
								'redirectLink'	=> SITE_URL.'account-setting',
								'status'		=> true,
								'message'   	=> MSG_ACC_DELETED_SUC.' '.SITE_NM.'.',
								'data'  		=> array());

							return $returnResponse;

						}else{
							$_SESSION["msgType"] = disMessage(array('type'=>'suc','var'=>MSG_ACC_DELETED_SUC.' '.SITE_NM.'.'));
							unset($_SESSION["user_id"]);
							redirectPage(SITE_URL);
						}

					}else{
						throw new Exception(MSG_COMPLETE_RIDE_FIRST);
					}
				}else{
					throw new Exception(WENT_WRONG);
				}
			}
			catch(Exception $e){
				$returnResponse = array(
					'redirectLink'	=> SITE_URL.'account-setting',
					'status'		=> false,
					'message'   	=> $e->getMessage(),
					'data'  		=> array());

				return $returnResponse;
			}
	}
	public function getCompanyDetatil($request = array()){
		extract($request);
		$getMobileAppConfig = $this->db->pdoQuery("SELECT * FROM tbl_site_settings WHERE section = 'mobile_app_general'");
		$qryRes = $getMobileAppConfig->results();
		
		$data = [];
		$company_detail = [];
		if(count($qryRes) > 4){
			foreach ($qryRes as $key => $fetchRes) {			
				if($fetchRes['label'] == 'Logo' || $fetchRes['label'] == 'Image'){				
					$company_detail[str_replace(" ","_",strtolower($fetchRes['label']))] = SITE_IMG.$fetchRes['value'];
				}else{
					$company_detail[str_replace(" ","_",strtolower($fetchRes['label']))] = $fetchRes['value'];
				}
			}
			$data["company_detail"] = $company_detail;
			// $data["language_id"] = $language_id;
			$returnResponse = array(
							'status'     => true,
							'message'    => 'success',
							'data'    =>  $data);
		}else{
			$company_detail['logo'] = '';
			$company_detail['site_name'] = '';
			$company_detail['tag_line'] = '';
			$company_detail['image'] = '';
			$company_detail['description'] = '';
			
			$data["company_detatil"] = $company_detail;
			$returnResponse = array(
							'status'     => false,
							'message'    => NO_DATA_FOUND,
							'data'    =>  $data);
		}
		return $returnResponse;		
    }
	public function submitMobileAppConfig($request = array()){
		echo "here controller call";exit;
		foreach ($_POST as $k => $v) {
			if ((int) $k) {
					$v      = closetags($v);
					$sData  = array("value" => filtering($v, 'input'));
					$sWhere = array("id" => $k);
					// echo "sdata <pre>";
					// print_r($sData);
					// echo "sdata <pre>";
					// print_r($sWhere);exit;
					$db->update("tbl_site_settings", $sData, $sWhere);
					// if ($k == 2) {
						// $data  = array("uEmail" => $v);
						// $where = array("id" => "1", "adminType" => "s");
						// $db->update("tbl_admin", $data, $where);
					// }
			}
		}
    }
}

?>
