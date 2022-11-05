<?php
class ResetPassword extends Home{
	public function __construct($moduleData){
		extract($moduleData);
		foreach($GLOBALS as $key=>$values){
			$this->$key = $values;
		}
		$this->module = $module;
		$this->id = $id;
	}
	public function getPageContent() {		
		$content = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php",array('%USERID%'=>$this->id));
		return $content;
	}

	public function resetPassword($requestData = array()) {
		extract($requestData);
	    try{
		    $activationCode = isset($activationCode) ? $activationCode : NULL;

		    if ($activationCode != NULL) {
		        $selUser = $this->db-> pdoQuery('SELECT id,hash FROM tbl_users WHERE hash = ? AND id = ?', array($activationCode , base64_decode($userId)));

		        if ($selUser -> affectedRows() > 0) {
	                $returnResponse = array(
						'redirectLink' 	=> SITE_URL.'reset_password',
						'status'		=> true,
						'message'  	 	=> '',
						'data'  		=> array());

					return $returnResponse;		           
		        }
		        else {
		            throw new Exception(INVALID_RESET_LINK);
		        }
		    }else{
		    	throw new Exception(PROVIDE_CODE);
		    }
		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink' 	=> SITE_URL.'login/',
				'status'		=> false,
				'message'  	 	=> $e->getMessage(),
				'data'  		=> array());

			return $returnResponse;
		}
	}

	public function submitResetPassword($request = array()){
			try
			{
				if(!empty($request)){
					extract($request);					
					$newPwd = isset($newPwd) ? filtering($newPwd,'input'): '';
					$cnfNewPwd = isset($cnfNewPwd) ? filtering($cnfNewPwd,'input'): '';

					if($newPwd != '' && $cnfNewPwd != ''){				

							if($newPwd != $cnfNewPwd){
								throw new Exception(NEW_CNFM_PASS_MATCH);
							}

							$updateArray = array(
								"password" => md5($newPwd),
								"hash" => ''
								);

							$this->db->update('tbl_users',$updateArray,array('id'=>$userId));

							$returnResponse = array(
								'redirectLink' 	=> SITE_URL.'login/',
								'status'		=> true,
								'message'   	=> PWD_RESET_SUCC,
								'data'  		=> array());

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
					'redirectLink'	=> SITE_URL.'login/',
					'status'		=> false,
					'message'   	=> $e->getMessage(),
					'data'  		=> array());

				return $returnResponse;
			}
	}
}