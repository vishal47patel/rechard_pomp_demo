<?php
class ForgotPassword {
	function __construct($module = "", $id = 0, $token = "",$reffToken="",$objCookie=array()) {
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;

		}
		$this->module = $module;
		$this->id = $id;
		$this->objCookie = new stdClass();
		$this->objCookie->email = isset($_COOKIE["email"]) ? $_COOKIE["email"] : '';
		$this->objCookie->password = isset($_COOKIE["password"]) ? ($_COOKIE["password"])	 : '';
		$this->objCookie->remember = isset($_COOKIE["remember"]) ? $_COOKIE["remember"] : 0;

	}
	public function getPageContent() {

		$chk = (isset($this->objCookie->remember) && $this->objCookie->remember == '1') ? 'checked="checked"' : NULL;
		$email = (isset($this->objCookie->email) && $this->objCookie->email != "") ? $this->objCookie->email : NULL;
		$tplUrl = DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php";
		$replaceArr = array("%EMAIL%"=>$email,"%PASSWORD%"=>$this->objCookie->password,"%REMEMBER_ME%"=>$chk);
		$content = get_view($tplUrl,$replaceArr);
		return $content;
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
}

?>
