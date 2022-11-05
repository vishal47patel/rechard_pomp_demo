<?php
class PaymentHistory{
	function __construct($contentArray = array()) {

		global $sessUserId, $sessRequestType, $fields;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);
		
		$this->id = $id;

		$this->type     = $type;
		$this->module     = $module;
		$this->fields    = $fields;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId = isset($userId) && $userId > 0 ? $userId : $this->sessUserId;
		$this->pageNo     = isset($pageNo) ? $pageNo : 1;
		$this->action = $action;
	}
	public function getPageContent() {
		$final_content="";

		$historyList=$this->getPaymentHistory();

		$replace = array(			
			'%HEADER%' => $historyList['retData']['header'],
			'%HISTORY_LIST%' => $historyList['retData']['html'],
			'%HISTORY_PAGINATION%' => $historyList['retData']['pagination']
		);

		$final_content= get_view(DIR_TMPL . "{$this->module}/{$this->module}.tpl.php",$replace);
		return $final_content;

	}

	public function getPaymentHistory(){

		$final_content = "";

		$historyQry="SELECT  history.*, sr.unique_id , sr.provider_id , sr.customer_id 
				FROM tbl_payment_history AS history 
				LEFT JOIN tbl_service_requests AS sr ON sr.id = history.request_id 
				WHERE (sr.provider_id = ".$this->sessUserId." OR sr.customer_id = " . $this->sessUserId . ") ORDER BY history.id DESC" ;

		$affRows = $this->db->pdoQuery($historyQry)->affectedRows();

		$pageNo = isset($this->pageNo) ? $this->pageNo : 1;

		$pager = getPagerData($affRows, SCROLL_LIMIT, $pageNo);
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

			$qryQuery = $this->db->pdoQuery($historyQry . $limit_cond);
			$NoOfrows   = $qryQuery->affectedRows();

			if ($NoOfrows > 0) {
				$qryRes = $qryQuery->results();
				
				foreach ($qryRes as $key => $fetchRes) {
					if($fetchRes['customer_id'] == $this->sessUserId) {
						$userName = getTableValue("tbl_users" , "CONCAT(firstName , ' ' , lastName)" , array("id" => $fetchRes['customer_id']));
					}
					else {
						$userName = getTableValue("tbl_users" , "CONCAT(firstName , ' ' , lastName)" , array("id" => $fetchRes['provider_id']));
					}
					
					$replace = array(
							'%ID%' => $fetchRes['id'],
							'%USER_NAME%' => filtering($userName),
							'%TRANS_ID%' => $fetchRes['transactionId'],
							'%SERVICE_ID%' => $fetchRes['unique_id'],
							'%PAYMENT_METHOD%' => ucfirst($fetchRes['payment_method']),
							'%TRANS_DATE%' => date(PHP_DATE_FORMAT , strtotime($fetchRes['createdDate'])),
							'%AMOUNT%' => DEFAULT_CURRENCY_SIGN . $fetchRes['amount']
						);
					$final_content .= get_view(DIR_TMPL .$this->module. "/history_row-nct.tpl.php",$replace);

					$history_list[$key]['id'] = $fetchRes['id'];
					$history_list[$key]['user_name'] = filtering($userName);
					$history_list[$key]['transactionId'] = $fetchRes['transactionId'];
					$history_list[$key]['service_id'] = $fetchRes['unique_id'];
					$history_list[$key]['payment_method'] = ucfirst($fetchRes['payment_method']);
					$history_list[$key]['trans_date'] = date(PHP_DATE_FORMAT , strtotime($fetchRes['createdDate']));
					$history_list[$key]['amount'] = DEFAULT_CURRENCY_SIGN . $fetchRes['amount'];
					
				}
				if ($this->sessRequestType == 'app') {
					$returnResponse = array(
						'status'     => true,
						'message'    => '',
						'data'    => array('pagination' => $pagination,"history_list" => $history_list));
				} else {

					$retData['header']       = 'show';
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
						'message'    => NO_HISTORY_FOUND,
						'data'    => array('pagination' => $pagination));
				} else {
					$retData['header'] = "hide";
					$retData['html']       ='<div class="box-shadow-main p-3 text-center">'.NO_HISTORY_FOUND.'</div>';
					$retData['pagination'] = $pagination;
					$returnResponse        = array(
						'status'  => false,
						'message' => NO_HISTORY_FOUND,
						'retData' => $retData);
				}
			}
		}else{
			if ($this->sessRequestType == 'app') {
				$returnResponse = array(						
					'status'     => false,
					'message'    => NO_HISTORY_FOUND,
					'data'    => array('pagination' => $pagination));
			} else {
				$retData['header'] = "hide";
				$retData['html']       = '<div class="box-shadow-main p-3 text-center">'.NO_HISTORY_FOUND.'</div>';
				$retData['pagination'] = "";
				$returnResponse        = array(
					'status'  => false,
					'message' => NO_HISTORY_FOUND,
					'retData' => $retData);
			}
		}
		return $returnResponse;
	}
}
?>