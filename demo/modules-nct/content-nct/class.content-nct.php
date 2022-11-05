<?php
class Content{
	function __construct($module = "", $id = 0) {
		global $fields,$memberId;
		$this->fields = $fields;
		$this->memberId = $memberId;

		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		$this->module = $module;
		$this->id = $id;
	}
	public function getPageContent() {
		$final_content="";

		$data=$this->getContentDesc();
		$final_content= get_view(DIR_TMPL . "{$this->module}/{$this->module}.tpl.php",array("%pageTitle%"=>$data['pageTitle'],"%pageDesc%"=>$data['pageDesc']));
		return $final_content;

	}

	public function getContentDesc($request_data = array()){
		$final_content="";
		extract($request_data);
		//print_r($request_data);exit;
		$returnResponse = $response=array();
		$response['status']=false;
        $response['msg']=MSG_NO_PAGE_FOUND;
		if($this->sessRequestType == 'app'){
			$result = $this->db->select("tbl_content", array("*"), array("page_slug" => $slug))->result();
			$pId=$result['pId'];
			$lId=$langId;
		}else{
			$pId=$this->id;
			$lId=$this->lId;
		}

		$fetchRes = $this->db->select("tbl_content",array("*"),array("pId" =>$pId,"isactive"=>'y' ))->result();

		if(!empty($fetchRes))
		{
			$arrData['pageTitle']  = $fetchRes["pageTitle_".$lId];
			$arrData['pageDesc'] = $fetchRes["pageDesc_".$lId];
			$response['status']=true;
        	$response['msg']='';
		}
		if($this->sessRequestType == 'app'){
			$returnResponse = array(
								'redirectLink'	=> SITE_URL,
								'status'		=> $response['status'],
								'message'		=> $response['msg'],
								'data'			=> $arrData);

			return $returnResponse;
		}else{
			return $arrData;
		}
		
	}

}
?>