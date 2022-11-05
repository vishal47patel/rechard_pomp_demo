<?php

class Transaction_history extends Home {

    public $category;
    public $status;
    public $data = array();

    public function __construct($module, $id = 0, $objPost = NULL, $searchArray = array(), $type = '') {
        global $db, $fields, $sessCataId;
        $this->db = $db;
        $this->data['id'] = $this->id = $id;
        $this->fields = $fields;
        $this->module = $module;
        $this->table = 'tbl_payment_history';

        $this->type = ($this->id > 0 ? 'edit' : 'add');
        $this->searchArray = $searchArray;
        parent::__construct();
        if ($this->id > 0) {
            $qrySel = $this->db->select('tbl_payment_history', "*", array("id" => $id))->result();
            $fetchRes = $qrySel;

        } else {
        }
        switch ($type) {
            case 'datagrid' : {
                    $this->data['content'] = (in_array('module', $this->Permission)) ? json_encode($this->dataGrid()) : '';
                }
        }
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
            $sorting = 'history.id DESC';

        $qry = "SELECT  history.*,CONCAT(firstName,' ',lastName) AS userName, sr.unique_id FROM tbl_payment_history AS history LEFT JOIN tbl_users AS usr ON usr.id=history.userId LEFT JOIN tbl_service_requests AS sr ON sr.id = history.request_id 
            WHERE (CONCAT(firstName,' ',lastName) LIKE ? OR transactionId LIKE ? OR unique_id LIKE ? OR history.payment_method LIKE ? OR amount LIKE ? OR DATE_FORMAT(history.createdDate, '" . MYSQL_DATE_FORMAT . "') LIKE ?) order by " . $sorting;
        $totalRow = $this->db->pdoQuery($qry, $aWhere)->affectedRows();
        $qrySel = $this->db->pdoQuery($qry . " limit " . $offset . " ," . $rows . " ", $aWhere)->results();

        foreach ($qrySel as $fetchRes) {
            
            $final_array = array(
                filtering($fetchRes["userName"]),
                ucfirst($fetchRes["payment_method"]),
                DEFAULT_CURRENCY_SIGN . filtering($fetchRes["amount"]),
                ($fetchRes["unique_id"]),
                filtering($fetchRes["transactionId"]),                
                filtering(date(PHP_DATE_FORMAT , strtotime($fetchRes['createdDate']))),
            );

            $row_data[] = $final_array;
        }

        $result["sEcho"] = $sEcho;
        $result["iTotalRecords"] = (int) $totalRow;
        $result["iTotalDisplayRecords"] = (int) $totalRow;
        $result["aaData"] = $row_data;
        return $result;
    }

    public function getPageContent() {
        $final_result = NULL;
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/" . $this->module . ".tpl.php");
        $main_content->breadcrumb = $this->getBreadcrumb();
        $final_result = $main_content->parse();
        return $final_result;
    }

}
