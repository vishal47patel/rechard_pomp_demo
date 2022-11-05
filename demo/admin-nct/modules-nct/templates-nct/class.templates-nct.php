<?php

class Templates extends Home {

    public $category;
    public $status;
    public $data = array();

    public function __construct($module, $id = 0, $objPost = NULL, $searchArray = array(), $type = '') {
        global $db, $fields, $sessCataId;
        $this->db = $db;
        $this->data['id'] = $this->id = $id;
        $this->fields = $fields;
        $this->module = $module;
        $this->table = 'tbl_email_templates';

        $this->type = ($this->id > 0 ? 'edit' : 'add');
        $this->searchArray = $searchArray;
        parent::__construct();
        if ($this->id > 0) {
            $qrySel = $this->db->select($this->table, "*", array("id" => $id))->result();
            $fetchRes = $qrySel;
            $this->data['subject'] = $this->subject = filtering($fetchRes['subject']);
            $this->data['types'] = $this->types = filtering($fetchRes['types']);
            $this->data['templates'] = $this->templates = filtering($fetchRes['templates'], 'output', 'text');
            $this->data['description'] = $this->description = filtering($fetchRes['description']);
            $this->data['isActive'] = $this->isActive = filtering($fetchRes['isActive']);
        } else {
            $this->data['subject'] = $this->subject = '';
            $this->data['types'] = $this->types = '';
            $this->data['templates'] = $this->templates = '';
            $this->data['description'] = $this->description = '';
            $this->data['isActive'] = $this->isActive = 'y';
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
        $content = 
        $this->displayBox(array("label" => "Type&nbsp;:", "value" => $this->types)) .
        $this->displayBox(array("label" => "Subject&nbsp;:", "value" => $this->subject)) .
        $this->displayBox(array("label" => "Description&nbsp;:", "value" => $this->description)) .
                $content = $this->displayBox(array("label" => "Templates&nbsp;:", "value" => $this->templates));
        return $content;
    }

    public function getForm() {
        $content = '';
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/form-nct.tpl.php");
        $main_content = $main_content->parse();
        $fields = array("%ONLY_ADD_DATA%","%TYPES%","%MEND_SIGN%", "%SUBJECT%", "%DESCRIPTION%", "%TEMPLATES%", "%TYPE%", "%ID%");
        if($this->type == 'add'){
            $add_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/only_add_fields-nct.tpl.php");
            $add_content = $add_content->parse();
        }else{
            $add_content = "";
        }

        $fields_replace = array($add_content,$this->types,MEND_SIGN, $this->subject, $this->description, htmlentities($this->templates), $this->type, $this->id);
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

            $whereCond .= " WHERE constant LIKE ? OR types LIKE ? OR types LIKE ? ";
        }

        if (isset($sort))
            $sorting = $sort . ' ' . $order;
        else
            $sorting = 'id DESC';

        $qry = "SELECT  id, types, constant, subject, templates, description, updateDate,isActive
                FROM tbl_email_templates " . $whereCond;

        $totalRow = $this->db->pdoQuery($qry , $aWhere)->affectedRows();

        $qrySel = $this->db->pdoQuery($qry . " order by " . $sorting . " limit " . $offset . " ," . $rows . " " , $aWhere)->results();
        
        foreach ($qrySel as $fetchRes) {
            $id = $fetchRes['id'];
            $isActive = ($fetchRes['isActive'] == "y") ? "checked" : "";
            $switch = (in_array('status', $this->Permission)) ? $this->toggel_switch(array("action" => "ajax." . $this->module . ".php?id=" . $fetchRes['id'] . "", "check" => $isActive)) : '';
            $operation = '';
            $operation .= (in_array('edit', $this->Permission)) ? $this->operation(array("href" => "ajax." . $this->module . ".php?action=edit&id=" . $fetchRes['id'] . "", "class" => "btn default btn-xs black btnEdit", "value" => '<i class="fa fa-edit"></i>&nbsp;Edit')) : '';
            $operation .=(in_array('view', $this->Permission)) ? '&nbsp;&nbsp;' . $this->operation(array("href" => "ajax." . $this->module . ".php?action=view&id=" . $fetchRes['id'] . "", "class" => "btn default blue btn-xs btn-viewbtn", "value" => '<i class="fa fa-laptop"></i>&nbsp;View')) : '';

            $final_array = array(
                filtering($fetchRes["id"]),
                filtering($fetchRes["constant"]),
                filtering($fetchRes["types"]),
                filtering($fetchRes["description"])
            );

            if (in_array('status', $this->Permission)) {
                $final_array = array_merge($final_array, array($switch));
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
    
    public function getPageContent() {
        $final_result = NULL;
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/" . $this->module . ".tpl.php");
        $main_content->breadcrumb = $this->getBreadcrumb();
        $final_result = $main_content->parse();
        return $final_result;
    }

}
