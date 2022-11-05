<?php

class request_management extends Home {

    public $category;
    public $status;
    public $data = array();

    public function __construct($module, $id = 0, $objPost = NULL, $searchArray = array(), $type = '') {
        global $db, $fields, $sessCataId;
        $this->db = $db;
        $this->data['id'] = $this->id = $id;
        $this->fields = $fields;
        $this->module = $module;
        $this->table = 'tbl_service_requests';

        $this->type = ($this->id > 0 ? 'edit' : 'add');
        $this->searchArray = $searchArray;
        parent::__construct();
        if ($this->id > 0) {
            /*$qrySel = $this->db->select('tbl_service_requests', "*", array("id" => $id))->result();
            $fetchRes = $qrySel;*/

        } else {
        }
        switch ($type) {
            case 'view' : {
                $this->data['content'] = (in_array('view', $this->Permission)) ? $this->viewForm() : '';
                break;
            }
            case 'datagrid' : {
                    $this->data['content'] = (in_array('module', $this->Permission)) ? json_encode($this->dataGrid()) : '';
                }
        }
    }

    public function viewForm() {
        $fetchRes = $this->db->pdoQuery("SELECT sr.*,CONCAT(cust.firstName,' ',cust.lastName) AS customer_name,CONCAT(prov.firstName,' ',prov.lastName) AS provider_name, IF(sr.service_type = 'mechanic' , service_date , start_date) AS consider_date FROM tbl_service_requests as sr
        LEFT JOIN tbl_users as cust ON cust.id=sr.customer_id 
        LEFT JOIN tbl_users as prov ON prov.id=sr.provider_id 
        WHERE sr.id = " . $this->id)->result();


        if($fetchRes['service_type']=='mechanic'){
            $dispStartDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['service_date']));
            
            $dispServiceDate = $dispStartDate . ' ' . ($fetchRes['service_time_slot'] - 1) . ":00" . ' - ' . ($fetchRes['service_time_slot']) . ":00";
        }
        else {
            $dispStartDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['start_date']));

            $dispEndDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['end_date']));

            $dispServiceDate = $dispStartDate . " - " . $dispEndDate;
        }

        $customerLink = '<a href="'.SITE_URL . "profile/" . $fetchRes['customer_id'] . '">'.$fetchRes['customer_name'].'</a>';

        $providerLink = '<a href="'.SITE_URL . "profile/" . $fetchRes['provider_id'] . '">'.$fetchRes['provider_name'].'</a>';

        $content = $this->displayBox(array("label" => "Service ID&nbsp;:", "value" => $fetchRes['unique_id']));

        $content .= $this->displayBox(array("label" => "Service Type&nbsp;:", "value" => ($fetchRes['service_type'] == 'mechanic') ? "Auto Service" : "Taxi Service"));

        $content .= $this->displayBox(array("label" => "Service Date&nbsp;:", "value" => $dispServiceDate));       

        $content .= $this->displayBox(array("label" => "Service Status&nbsp;:", "value" => ucfirst($fetchRes['service_status'])));

        $content .= $this->displayBox(array("label" => "Provider Name&nbsp;:", "value" => $providerLink));

        $content .= $this->displayBox(array("label" => "Customer Name&nbsp;:", "value" => $customerLink));

        return $content;
    }

    public function dataGrid() {

        $content = $operation = $totalRow = NULL;
        $result = $tmp_rows = $row_data = array();
        extract($this->searchArray);
        $chr = str_replace(array('_', '%'), array('\_', '\%'), $chr);

        $aWhere = array();
        $aWhere[] = "%$chr%";
        $aWhere[] = "%$chr%";
        $aWhere[] = "%$chr%";
        $aWhere[] = "%$chr%";
        $aWhere[] = "%$chr%";
        $aWhere[] = "%$chr%";

        if (isset($sort))
            $sorting = $sort . ' ' . $order;
        else
            $sorting = 'sr.id DESC';

        $qry = "SELECT sr.*,CONCAT(cust.firstName,' ',cust.lastName) AS customer_name,CONCAT(prov.firstName,' ',prov.lastName) AS provider_name, IF(sr.service_type = 'mechanic' , service_date , start_date) AS consider_date FROM tbl_service_requests as sr
        LEFT JOIN tbl_users as cust ON cust.id=sr.customer_id 
        LEFT JOIN tbl_users as prov ON prov.id=sr.provider_id 
        WHERE (CONCAT(cust.firstName,' ',cust.lastName) LIKE ? OR CONCAT(prov.firstName,' ',prov.lastName) LIKE ? OR unique_id LIKE ? OR DATE_FORMAT(start_date, '" . MYSQL_DATE_FORMAT . "') LIKE ? OR DATE_FORMAT(end_date, '" . MYSQL_DATE_FORMAT . "') LIKE ? OR DATE_FORMAT(service_date, '" . MYSQL_DATE_FORMAT . "') LIKE ?) order by " . $sorting;
        $totalRow = $this->db->pdoQuery($qry, $aWhere)->affectedRows();
        $qrySel = $this->db->pdoQuery($qry . " limit " . $offset . " ," . $rows . " ", $aWhere)->results();

        foreach ($qrySel as $fetchRes) {
            if($fetchRes['service_type']=='mechanic'){
                $dispStartDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['service_date']));
                
                $dispServiceDate = $dispStartDate . ' ' . ($fetchRes['service_time_slot'] - 1) . ":00" . ' - ' . ($fetchRes['service_time_slot']) . ":00";
            }
            else {
                $dispStartDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['start_date']));

                $dispEndDate = date(PHP_DATE_FORMAT , strtotime($fetchRes['end_date']));

                $dispServiceDate = $dispStartDate . " - " . $dispEndDate;
            }

            $operation = (in_array('view', $this->Permission)) ? $this->operation(array("href" => "ajax." . $this->module . ".php?action=view&id=" . $fetchRes['id'] . "", "class" => "btn default blue btn-xs btn-viewbtn", "value" => '<i class="fa fa-laptop"></i>&nbsp;View')) : '';

            $final_array = array(
                filtering($fetchRes['id'], 'output', 'int'),
                filtering($fetchRes["unique_id"]),
                $dispServiceDate,                
                filtering($fetchRes["customer_name"]),                
                filtering($fetchRes["provider_name"]),
            );

            if (in_array('view', $this->Permission)) {
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
