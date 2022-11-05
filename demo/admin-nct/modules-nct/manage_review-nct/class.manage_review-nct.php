<?php 

class Review extends Home { 
	
	public $status;
    public $data = array();

    public function __construct($module, $id = 0, $objPost = NULL, $searchArray = array(), $type = '') {
        global $db, $fields, $sessCataId;
        $this->db = $db;
        $this->data['id'] = $this->id = $id;
        $this->fields = $fields;
        $this->module = $module;
        $this->table = 'tbl_reviews';

        $this->type = ($this->id > 0 ? 'edit' : 'add');
        $this->searchArray = $searchArray;
        parent::__construct();
        if ($this->id > 0) {
            $qrySel = $this->db->select('tbl_reviews', "*", array("id" => $id))->result();
            $fetchRes = $qrySel;
            $this->data['sender_id'] = $this->sender_id = filtering($fetchRes['sender_id']);
            $this->data['receiver_id'] = $this->receiver_id = filtering($fetchRes['receiver_id']);
            $this->data['rating'] = $this->rating = filtering($fetchRes['rating']);
            $this->data['description'] = $this->description = filtering($fetchRes['description']);
            $this->data['service_request_id'] = $this->service_request_id = filtering($fetchRes['service_request_id']);
            $this->data['status'] = $this->status = filtering($fetchRes['status']);
            $this->data['posted_date'] = $this->posted_date = filtering($fetchRes['posted_date']);

        } else {
            $this->data['sender_id'] = $this->sender_id = '';
            $this->data['receiver_id'] = $this->receiver_id = '';
            $this->data['rating'] = $this->rating = 'y';
            $this->data['description'] = $this->description = '';
            $this->data['service_request_id'] = $this->service_request_id = '';
            $this->data['status'] = $this->status = '';
            $this->data['posted_date'] = $this->posted_date = '';

        }
        switch ($type) {
            case 'add' : {
                    $this->data['content'] = (in_array('add', $this->Permission)) ? $this->getForm() : '';
                    break;
                }
            case 'edit' : {
                    $this->data['content'] = (in_array('edit', $this->Permission)) ? $this->getForm() : '';
                    break;
                }
            case 'view' : {
                    $this->data['content'] = (in_array('view', $this->Permission)) ? $this->viewForm() : '';
                    break;
                }
            case 'delete' : {
                    $this->data['content'] = (in_array('delete', $this->Permission)) ? json_encode($this->dataGrid()) : '';
                    break;
                }
            case 'datagrid' : {
                    $this->data['content'] = (in_array('module', $this->Permission)) ? json_encode($this->dataGrid()) : '';
                }
        }
    }
	
	public function viewForm() {
        $details = $this->db->pdoQuery("SELECT pr.*,pr.rating,pr.description,CONCAT(reviewer.firstName,' ',reviewer.lastName) AS reviewerName,CONCAT(seller.firstName,' ',seller.lastName) AS sellerName,p.unique_id,p.service_date , p.start_date , p.end_date FROM tbl_reviews as pr 
                                       LEFT JOIN tbl_service_requests as p  on pr.service_request_id=p.id  
                                       LEFT JOIN tbl_users as reviewer  on pr.sender_id=reviewer.id 
                                       LEFT JOIN tbl_users as seller on pr.receiver_id=seller.id WHERE pr.id = " . $this->id)->result();

        if($details['service_date'] == '0000-00-00') {
            $serviceDate = date(PHP_DATE_FORMAT,strtotime($details['start_date'])) ." " . date("H:i",strtotime($details['end_date']));
        }
        else {
            $serviceDate = date(PHP_DATE_FORMAT,strtotime($details['service_date']));
        }

        $content = '';
        $content .= $this->displayBox(array("label" => "Receiver Name&nbsp;:", "value" => $details['sellerName']));
        $content .= $this->displayBox(array("label" => "Sender Name&nbsp;:", "value" => $details['reviewerName']));
        $content .= $this->displayBox(array("label" => "Service ID&nbsp;:", "value" => $details['unique_id']));
        $content .= $this->displayBox(array("label" => "Service Date&nbsp;:", "value" => $serviceDate));
        $content .= $this->displayBox(array("label" => "Review Description&nbsp;:", "value" => $details['description']));
        $content .= $this->displayBox(array("label" => "Rating&nbsp;:", "value" => $details['rating']));
        $content .= $this->displayBox(array("label" => "Posted Date&nbsp;:", "value" => date(PHP_DATE_FORMAT,strtotime($details['posted_date']))));

        return $content;		
	}


	public function getForm() {	
		$content = '';

        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/form-nct.tpl.php");
        $main_content = $main_content->parse();

        $static_a = ($this->isActive == 'y' ? 'checked' : '');
        $static_d = ($this->isActive != 'y' ? 'checked' : '');

        $fields = array("%MEND_SIGN%", "%DESCRIPTION%", "%STATUS_A%", "%STATUS_D%", "%ID%",  "%TYPE%");

        $fields_replace = array(MEND_SIGN, $this->description, $static_a, $static_d, $this->id,$this->type);

        $content = str_replace($fields, $fields_replace, $main_content);
        return sanitize_output($content);
	}
	
	
	public function dataGrid() {
		$content = $operation = $whereCond = $totalRow = NULL;
        $result = $tmp_rows = $row_data = array();
        extract($this->searchArray);
        $chr = str_replace(array('_', '%'), array('\_', '\%'), $chr);
        $whereCond = '';
        $aWhere = array();
        if (isset($chr) && $chr != '') {
            $aWhere[] = "%$chr%";
            $aWhere[] = "%$chr%";
            $aWhere[] = "%$chr%";
            $aWhere[] = "%$chr%";
            $aWhere[] = "%$chr%";
            $aWhere[] = "%$chr%";
            $aWhere[] = "%$chr%";

            $whereCond .= " WHERE (pr.description LIKE ? OR pr.rating LIKE ? OR reviewer.firstName LIKE ? OR reviewer.lastName LIKE ? OR seller.firstName LIKE ? OR seller.lastName LIKE ? OR p.unique_id LIKE ?) ";
        }

        if (isset($sort))
            $sorting = $sort . ' ' . $order;
        else
            $sorting = 'id DESC';

        $qry = "SELECT pr.*,pr.rating,pr.description,reviewer.id AS reviewerId,CONCAT(reviewer.firstName,' ',reviewer.lastName) AS reviewerName,CONCAT(seller.firstName,' ',seller.lastName) AS sellerName,p.unique_id FROM tbl_reviews as pr 
									   LEFT JOIN tbl_service_requests as p  on pr.service_request_id=p.id  
									   LEFT JOIN tbl_users as reviewer  on pr.sender_id=reviewer.id 
                                       LEFT JOIN tbl_users as seller on pr.receiver_id=seller.id".$whereCond;
        $totalRow = $this->db->pdoQuery($qry, $aWhere)->affectedRows();
        $qrySel = $this->db->pdoQuery($qry . " order by " . $sorting . " limit " . $offset . " ," . $rows . " " , $aWhere)->results();
        
        foreach ($qrySel as $fetchRes) {  
            $status = ($fetchRes['status'] == "y") ? "checked" : "";

            $switch = (in_array('status', $this->Permission)) ? $this->toggel_switch(array("action" => "ajax." . $this->module . ".php?id=" . $fetchRes['id'] . "", "check" => $status)) : '';
            $operation = '';

            /*$operation .= (in_array('edit', $this->Permission)) ? $this->operation(array("href" => "ajax." . $this->module . ".php?action=edit&id=" . $fetchRes['id'] . "", "class" => "btn default btn-xs black btnEdit", "value" => '<i class="fa fa-edit"></i>&nbsp;Edit')) : '';
            $operation .=(in_array('delete', $this->Permission)) ? '&nbsp;&nbsp;' . $this->operation(array("href" => "ajax." . $this->module . ".php?action=delete&id=" . $fetchRes['id'] . "", "class" => "btn default btn-xs red btn-delete", "value" => '<i class="fa fa-trash-o"></i>&nbsp;Delete')) : '';*/

            $operation .=(in_array('view', $this->Permission)) ? '&nbsp;&nbsp;' . $this->operation(array("href" => "ajax." . $this->module . ".php?action=view&id=" . $fetchRes['id'] . "", "class" => "btn default blue btn-xs btn-viewbtn", "value" => '<i class="fa fa-laptop"></i>&nbsp;View')) : '';         
			

            $desc = $fetchRes['description'];
			if(strlen($desc) > 30) {
				$desc = substr($desc , 0 ,30) . '...';
			}

            $rating = '<div class="ratting" rating="'.$fetchRes["rating"].'"></div>';

			$final_array =  array($fetchRes['sellerName'],
                    $fetchRes['reviewerName'],
                    $fetchRes['unique_id'],
                    $desc,
                    $rating,
                    date(PHP_DATE_FORMAT,strtotime($fetchRes['posted_date']))
                );
			
		    if (in_array('status', $this->Permission)) {
                //$final_array = array_merge($final_array, array($switch));
            }
            if (in_array('edit', $this->Permission) || in_array('delete', $this->Permission) || in_array('view', $this->Permission)) {
                $final_array = array_merge($final_array, array($operation));
            }

			$row_data[] = $final_array;
        }

        $result["sEcho"] = $sEcho;
        $result["iTotalRecords"] = (int) $totalRow;
        $result["iTotalDisplayRecords"] = (int) $totalRow;
        $result["aaData"] = $row_data;
        return $result;	
	}

    public function displaybox($text) {

        $text['label'] = isset($text['label']) ? $text['label'] : 'Enter Text Here: ';
        $text['value'] = isset($text['value']) ? $text['value'] : '';
        $text['name'] = isset($text['name']) ? $text['name'] : '';
        $text['class'] = isset($text['class']) ? 'form-control-static ' . trim($text['class']) : 'form-control-static';
        $text['onlyField'] = isset($text['onlyField']) ? $text['onlyField'] : false;
        $text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';

        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/displaybox.tpl.php');
        $main_content = $main_content->parse();
        $fields = array("%LABEL%", "%CLASS%", "%VALUE%");
        $fields_replace = array($text['label'], $text['class'], $text['value']);
        return str_replace($fields, $fields_replace, $main_content);
    }

	public function toggel_switch($text) {
        $text['action'] = isset($text['action']) ? $text['action'] : 'Enter Action Here: ';
        $text['check'] = isset($text['check']) ? $text['check'] : '';
        $text['name'] = isset($text['name']) ? $text['name'] : '';
        $text['class'] = isset($text['class']) ? '' . trim($text['class']) : '';
        $text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';

        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/switch-nct.tpl.php');
        $main_content = $main_content->parse();
        $fields = array("%NAME%", "%CLASS%", "%ACTION%", "%EXTRA%", "%CHECK%");
        $fields_replace = array($text['name'], $text['class'], $text['action'], $text['extraAtt'], $text['check']);
        return str_replace($fields, $fields_replace, $main_content);
    }

    public function operation($text) {

        $text['href'] = isset($text['href']) ? $text['href'] : 'Enter Link Here: ';
        $text['value'] = isset($text['value']) ? $text['value'] : '';
        $text['name'] = isset($text['name']) ? $text['name'] : '';
        $text['class'] = isset($text['class']) ? '' . trim($text['class']) : '';
        $text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/operation-nct.tpl.php');
        $main_content = $main_content->parse();
        $fields = array("%HREF%", "%CLASS%", "%VALUE%", "%EXTRA%");
        $fields_replace = array($text['href'], $text['class'], $text['value'], $text['extraAtt']);
        return str_replace($fields, $fields_replace, $main_content);
    }

    public function getPageContent() {
        $final_result = NULL;
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/" . $this->module . ".tpl.php");
        $main_content->breadcrumb = $this->getBreadcrumb();
        $final_result = $main_content->parse();
        return $final_result;
    }
}