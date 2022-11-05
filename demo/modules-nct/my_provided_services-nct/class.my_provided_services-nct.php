<?php
class MyProvidedServices{
	function __construct($contentArray = array()) {

		global $sessUserId, $fields;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);
		
		$this->id = $id;

		$this->type     = $type;
		$this->module     = $module;
		$this->fields    = $fields;
		$this->sessUserId = isset($userId) && $userId > 0 ? $userId : $this->sessUserId;
		$this->pageNo     = isset($pageNo) ? $pageNo : 1;
		$this->action = $action;
	}
	public function getPageContent() {
		$final_content="";

		$redeemServiceList=$this->getServiceList();

		$replace = array(			
			'%SERVICE_LIST%' => $redeemServiceList['retData']['html'],
			'%SERVICE_PAGINATION%' => $redeemServiceList['retData']['pagination'],
			'%NO_RECORD_CLASS%' => ($redeemServiceList['retData']['html'] != '') ? 'd-none' : ''
		);

		$final_content= get_view(DIR_TMPL . "{$this->module}/{$this->module}.tpl.php",$replace);
		return $final_content;

	}

	public function submitAddService($request = array()){
		try
		{
			if(!empty($request)){
				extract($request);

				$service_name = isset($service_name) ? ($service_name): '';

				if($service_name!=""){

					$exist_ser=getTableValue("tbl_services","id",array("service_name"=>strtolower($service_name) , "provider_id" => $this->sessUserId));

					if($exist_ser==''){
						$insert_id=$this->db->insert('tbl_services',array("provider_id"=>$this->sessUserId,"service_name"=>$service_name,"createdDate"=>date('Y-m-d H:i:s')))->getLastInsertId();

						$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'my-provided-services',
							'status'		=> true,
							'message'   	=> NEW_SER_ADDED_SUC);

						return $returnResponse;
					}else{
						throw new Exception(SER_NAME_AL_EXIST);
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
				'redirectLink'	=> SITE_URL.'my-provided-services',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
			return $returnResponse;
		}
	}	

	public function getServiceList(){

		$final_content = "";

		$serviceQry="SELECT * FROM tbl_services WHERE provider_id = '".$this->sessUserId."' ORDER BY id DESC";

		$affRows = $this->db->pdoQuery($serviceQry)->affectedRows();

		$pageNo = isset($this->pageNo) ? $this->pageNo : 1;

		$pager = getPagerData($affRows, 9, $pageNo);
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

					$retData['html']       = '';
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

				$retData['html']       = '';
				$retData['pagination'] = "";
				$returnResponse        = array(
					'status'  => false,
					'message' => NO_ANY_SER_ADDED,
					'retData' => $retData);
			}
		}
		return $returnResponse;
	}
	
	public function deleteService($request = array(),$app=''){
		try
		{			
			if(!empty($request)){
				extract($request);
				$service_id = isset($service_id) ? ($service_id): '';
				$serviceQry="SELECT * FROM tbl_users where id=".$this->sessUserId;
				$qryQuery = $this->db->pdoQuery($serviceQry);
				$qryRes = $qryQuery->results();
				
				if(count($qryRes) > 0 && $qryRes[0]['user_type'] == 'provider' && $service_id!=""){

					$exist_ser=getTableValue("tbl_services","id",array("id"=>trim($service_id) , "provider_id" => $this->sessUserId));
					if($exist_ser!=''){
						
						$this->db->delete("tbl_services" , array(
								"provider_id" => $this->sessUserId,
								"id" => $service_id
						));

						$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'my-provided-services',
							'status'		=> true,
							'message'   	=> SER_DELETED_SUC);						
						
					}else{						
						$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'my-provided-services',
							'status'		=> false,
							'message'   	=> REC_NOT_FOUND);
					}
				}else{
		    		$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'my-provided-services',
							'status'		=> false,
							'message'   	=> SOMETHING_WRONG);
		    	}
				
				
			}else{
				$returnResponse = array(
							'redirectLink' 	=> SITE_URL.'my-provided-services',
							'status'		=> false,
							'message'   	=> MSG_FILL_ALL_VALUE);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'my-provided-services',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'data'  		=> array());
		}
		return $returnResponse;		
	}
}
?>