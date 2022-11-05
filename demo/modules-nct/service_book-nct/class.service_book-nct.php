<?php
class ServiceBook {
	function __construct($moduledata) {
		extract($moduledata);
		global $sessUserId,$cCode;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		$this->module = $module;
		$this->sessUserId = isset($userId) && $userId ? $userId : $sessUserId;

		$this->pageNo = isset($pageNo)?$pageNo:1;
	}

	public function getPageContent($request = array()) {
		
		$replaceArray = array(
			"%PAGE%"                  => $this->pageNo,
			);
		return get_view(DIR_TMPL . $this->module."/".$this->module.".tpl.php" , $replaceArray);
	}

	public function getVINDetails($request = array()) {

		$returnResponse = $retData = $retSearch = array();
		$html = '';

		$vin_number = isset($request['vin_number']) ? filtering($request['vin_number'], 'input', 'string', '') : '';
		
		if($vin_number == '') {
			if($this->sessRequestType == 'app'){
				$retSearch['status'] = false;
				$retSearch['message'] = NO_DETAILS_FOUND;
				$returnResponse = $retSearch;
			}else{
				$retData['html'] = '<div class="no-proivder-section no-data-block">' . NO_DETAILS_FOUND . '</div>';
				$retData['pagination'] = "";

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
			return $returnResponse;
		}        
		
		$serviceDetails = $this->getSearchResults($request);

		$apiPrefix = "https://api.vindecoder.eu/3.1";
		$apikey = VIN_API_KEY;   // Your API key
		$secretkey = VIN_SECRET_KEY;  // Your secret key
		$id = "decode";
		$vin = mb_strtoupper($vin_number); //XXXDEF1GH23456789

		$controlsum = substr(sha1("{$vin}|{$id}|{$apikey}|{$secretkey}"), 0, 10);

		$data = file_get_contents("{$apiPrefix}/{$apikey}/{$controlsum}/decode/{$vin}.json", false);
		$result = (array)json_decode($data);
		
		if($result['error'] == '1') {
			if($this->sessRequestType == 'app'){
				$retSearch['status'] = false;
				$retSearch['message'] = NO_DETAILS_FOUND;
				$returnResponse = $retSearch;
			}else{
				$retData['html'] = '<div class="no-proivder-section no-data-block">' . NO_DETAILS_FOUND . '</div>';
				$retData['pagination'] = "";

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
			return $returnResponse;
		}        

		$vehicleMake = '';
		$vehicleModel = '';
		$vehicleYear = '';
		$vehicleEngine = '';
		$enginePower = '';

		foreach ($result['decode'] as $data) {
			$details = (array)$data;

			if($details['label'] == 'Make') {
				$vehicleMake = ($details['value'] != "") ? $details['value'] : "-";
			}
			else if($details['label'] == 'Model') {
				$vehicleModel = ($details['value'] != "") ? $details['value'] : "-";
			}
			else if($details['label'] == 'Model Year') {
				$vehicleYear = ($details['value'] != "") ? $details['value'] : "-";
			}
			else if($details['label'] == 'Engine (full)') {
				$vehicleEngine = ($details['value'] != "") ? $details['value'] : "-";
			}
			else if($details['label'] == 'Engine Power (kW)') {
				$enginePower = ($details['value'] != "") ? $details['value'] : "-";
			} 
		}
		
		$retSearch['VIN_details']['VIN_number'] = $vin_number;
		$retSearch['VIN_details']['vehicle_make'] = $vehicleMake;
		$retSearch['VIN_details']['vehicle_model'] = $vehicleModel;
		$retSearch['VIN_details']['vehcile_year'] = $vehicleYear;
		$retSearch['VIN_details']['vehicle_engine'] = $vehicleEngine;
		$retSearch['VIN_details']['engine_power'] = $enginePower;

		$replaceArray = array(
			"%VIN_NUMBER%" => $vin_number,
			"%VEHICLE_MAKE%" => $vehicleMake,
			"%VEHICLE_MODEL%" => $vehicleModel,
			"%VEHICLE_YEAR%" => $vehicleYear,
			"%VEHICLE_ENGINE%" => $vehicleEngine,
			"%ENGINE_POWER%" => $enginePower,
			"%SERVICE_DETAILS%" => $serviceDetails['retData']['html'],
			"%PAGINATION%"      => $serviceDetails['retData']['pagination'],
		);

		$html .= get_view(DIR_TMPL . $this->module."/vin_details-nct.tpl.php" , $replaceArray);
		
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

		return $returnResponse;
	}

	public function getSearchResults($request = array()) {

		$returnResponse = $retData = $retSearch = array();
		$html = '';

		$vin_number = isset($request['vin_number']) ? filtering($request['vin_number'], 'input', 'string', '') : '';
		
		if($vin_number == '') {
			if($this->sessRequestType == 'app'){
				$retSearch['status'] = false;
				$retSearch['message'] = NO_DETAILS_FOUND;
				$returnResponse = $retSearch;
			}else{
				$retData['html'] = '<div class="no-proivder-section no-data-block">' . NO_DETAILS_FOUND . '</div>';
				$retData['pagination'] = "";

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
			return $returnResponse;
		}
		
		$allproviderDetailsQry = "SELECT sbr.*, user.business_name , user.profileImg 
				FROM tbl_service_book_record AS sbr 
				LEFT JOIN tbl_users as user ON user.id = sbr.provider_id  	
				WHERE vin_number='".$vin_number."' 			
				ORDER BY sbr.id DESC";
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
				
				$user_image = checkImage('profile/'.$providerDetail['provider_id'].'/th2_'.$providerDetail['profileImg']);
				$business_name = filtering($providerDetail['business_name'] , 'output' , 'string');
				$service_date = date("d-m-Y", strtotime($providerDetail['service_date']));
				$amount = filtering($providerDetail['amount'] , 'output' , 'string');
				$description = filtering($providerDetail['description'] , 'output' , 'string');

				$retSearch['provider'][$key]['provider_id'] = $providerDetail['provider_id'];
				$retSearch['provider'][$key]['user_image'] = $user_image;
				$retSearch['provider'][$key]['business_name'] = $business_name;
				$retSearch['provider'][$key]['service_date'] = $service_date;
				$retSearch['provider'][$key]['amount'] = DEFAULT_CURRENCY_SIGN . $amount;
				$retSearch['provider'][$key]['description'] = $description;

				$replaceArray = array(
						"%PROVIDER_ID%" => $providerDetail['provider_id'],
						"%USER_IMG%" => $user_image,
						"%BUSINESS_NAME%" => $business_name,
						"%SERVICE_DATE%" => $service_date,
						"%AMOUNT%" => DEFAULT_CURRENCY_SIGN . $amount,
						"%DESC%" => $description
					);

				$html .= get_view(DIR_TMPL . $this->module."/provider-nct.tpl.php" , $replaceArray);
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
				$retSearch['message'] = NO_DETAILS_FOUND;
				$returnResponse = $retSearch;
			}else{
				$retData['html'] = '<div class="no-proivder-section no-data-block">' . NO_DETAILS_FOUND . '</div>';
				$retData['pagination'] = "";

					$returnResponse = array(
						'status'		=> true,
						'message'  	 	=> '',
						'retData' => $retData);
			}
		}

		return $returnResponse;
	}

	public function addServiceRecord($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$description  = isset($description) ? filtering($description,'input'): '';
				$vin_number   = isset($vin_number) ? filtering($vin_number,'input') : '';
				$amount      = isset($amount)?filtering($amount,'input'):0;
				$service_date = isset($service_date) ? date("Y-m-d" , strtotime($service_date)) : '';

				if($description!="" && $vin_number!="" && $amount!="" && $service_date!=""){

						$insert_id=$this->db->insert('tbl_service_book_record',array("provider_id"=>$this->sessUserId,"description"=>$description,"vin_number" => $vin_number , "amount" => $amount , "service_date" => $service_date))->getLastInsertId();

						$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'service-book',
							'status'		=> true,
							'message'   	=> SER_REC_ADDED_SUC);

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
				'redirectLink'	=> SITE_URL.'service-book',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}
}

?>
