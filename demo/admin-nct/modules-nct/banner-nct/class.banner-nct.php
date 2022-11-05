<?php

class Banner extends Home {

    public $data = array();

    public function __construct($module, $id = 0, $objPost = NULL, $searchArray = array(), $type = '') {
        global $db, $fields, $sessCataId;
        $this->db = $db;
        $this->data['id'] = $this->id = $id;
        $this->fields = $fields;
        $this->module = $module;
        $this->table = 'tbl_banner';

        $this->type = ($this->id > 0 ? 'edit' : 'add');
        $this->searchArray = $searchArray;
        parent::__construct();
        if($this->id>0){
            $qrySel = $this->db->select($this->table, array("*"),array("id"=>$id))->result();
            $fetchRes = $qrySel;
            $this->data['title'] = $this->title = $fetchRes['title'];
            $this->data['file_type'] = $this->file_type = $fetchRes['file_type'];
            $this->data['detail'] = $this->detail = $fetchRes['detail'];
            $this->data['isActive'] = $this->isActive = $fetchRes['isActive'];
            $this->data['id'] = $this->id = $fetchRes['id'];
            $this->data['createdDate'] = $this->createdDate = $fetchRes['createdDate'];
            $this->data['file'] = $this->file = $fetchRes['file'];
            $this->file = checkImage('banner/'.$this->file);
            $this->ext = strtolower(getExt($this->file));

        }else{
            $this->data['title'] = $this->title = '';
            $this->data['file_type'] = $this->file_type = '';
            $this->data['detail'] = $this->detail = '';
            $this->data['file'] = $this->file = '';
            $this->data['ext'] = $this->ext = '';
            $this->data['isActive'] = $this->isActive = 1;
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

   public function viewForm(){
        $isActive = $this->isActive == 'y' ? "Active" : "Deactive";
         $file  = "";
        $content = /*$this->displayBox(array("label"=>"Title&nbsp;:","value"=>$this->title)).
        $this->displayBox(array("label"=>"Detail&nbsp;:","value"=>$this->detail)).*/
        '<div class="clearfix"></div>';
        if($this->file_type == 'image')
        {
            $file .='<img src="'.$this->file.'" width="300" alt="Image">';
        }
        else
        {
            $this->ext = strtolower(getExt($this->file));

            $file .= '<div class="embed-responsive embed-responsive-16by9">
                                        <video width="300" loop muted controls id="background">
                                            <source src="'.$this->file.'" type="video/'.$this->ext.'"/>
                                        </video>
                        </div>';
        }
        $content .=$this->displayBox(array("label"=>ucfirst($this->file_type)." :","value"=>$file)).
        '<div class="clearfix"></div>'.
        $this->displayBox(array("label"=>"Status&nbsp;:","value"=>$isActive));

        return $content;
    }

    public function getForm() {
        $content = '';

        /*new language code*/
        $qrySel = $this->db->select("tbl_language", array("id","languageName","created_date"),array("status"=>'a'))->results();
        $c_v_container = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/constant_value_container-nct.tpl.php");

        $c_v_container_content = $c_v_container->parse();
        $c_v_container_search = array("%MEND_SIGN%","%LANGUAGE_NAME%","%BANNER_VALUE%","%ID%","%TYPEVALUE%","%LBL_NM%","%BANNER_VAL_CLASS%");
        $c_v_container_content1 = "";

        /*for title*/
        foreach($qrySel as $fetchRes){
            if($this->type == 'edit'){
                $qrysel1 = $this->db->select($this->table, array("id","title_".$fetchRes["id"]),array('id'=>$this->id))->result();
                $fetchRow = $qrysel1;
                $this->constantValue = $fetchRow["title_".$fetchRes["id"]];

                $titleCont = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/text_box-nct.tpl.php");
                $titleCont_content = $titleCont->parse();
                $titleCont_search = array("%TYPEVALUE%","%CONSTANT_VALUE%","%ID%");
                $titleCont_replace = array('title',stripslashes($this->constantValue),$fetchRes['id']);
                $valueContainer = str_replace($titleCont_search,$titleCont_replace,$titleCont_content);

                $c_v_container_replace = array(MEND_SIGN,$fetchRes['languageName'],$valueContainer,$fetchRes['id'],"title","Title",'col-md-4');
            }else{

                $titleCont = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/text_box-nct.tpl.php");
                $titleCont_content = $titleCont->parse();
                $titleCont_search = array("%TYPEVALUE%","%CONSTANT_VALUE%","%ID%");
                $titleCont_replace = array('title','',$fetchRes['id']);
                $valueContainer = str_replace($titleCont_search,$titleCont_replace,$titleCont_content);

                $c_v_container_replace = array(MEND_SIGN,$fetchRes['languageName'],$valueContainer,$fetchRes['id'],"title","Title",'col-md-4');
            }
            $c_v_container_content1 .= str_replace($c_v_container_search,$c_v_container_replace,$c_v_container_content);
        }

        /*for detail*/
        foreach($qrySel as $fetchRes){
            if($this->type == 'edit'){
                $qrysel1 = $this->db->select($this->table, array("id","detail_".$fetchRes["id"]),array('id'=>$this->id))->result();
                $fetchRow = $qrysel1;
                $this->constantValue = $fetchRow["detail_".$fetchRes["id"]];

                $detailCont = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/text_area-nct.tpl.php");
                $detailCont_content = $detailCont->parse();
                $detailCont_search = array("%TYPEVALUE%","%DETAILVALUE%","%ID%");
                $detailCont_replace = array('detail',($this->constantValue),$fetchRes['id']);
                $valueContainer = str_replace($detailCont_search,$detailCont_replace,$detailCont_content);

                $c_v_container_replace = array(MEND_SIGN,$fetchRes['languageName'],$valueContainer,$fetchRes['id'],"detail","Detail",'col-md-9');
            }else{

                $detailCont = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/text_area-nct.tpl.php");
                $detailCont_content = $detailCont->parse();
                $detailCont_search = array("%TYPEVALUE%","%DETAILVALUE%","%ID%");
                $detailCont_replace = array('detail','',$fetchRes['id']);
                $valueContainer = str_replace($detailCont_search,$detailCont_replace,$detailCont_content);

                $c_v_container_replace = array(MEND_SIGN,$fetchRes['languageName'],$valueContainer,$fetchRes['id'],"detail","Detail",'col-md-9');
            }
            $c_v_container_content1 .= str_replace($c_v_container_search,$c_v_container_replace,$c_v_container_content);
        }

        $getSelectBoxOption = $this->getSelectBoxOption();
        $fields = array("%VALUE%", "%SELECTED%", "%DISPLAY_VALUE%");

        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/form-nct.tpl.php");
        $main_content = $main_content->parse();
        $static_a = ($this->isActive == 'y' ? 'checked' : '');
        $static_d = ($this->isActive != 'y' ? 'checked' : '');
        /*'.SITE_UPD.'profile/temp_dir/
        '.DIR_UPD.'profile/temp_dir/*/

        $file_content="";
        if($this->file_type == 'video'){
            $file_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/video_content-nct.tpl.php");
        }else{
            $file_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/image_content-nct.tpl.php");
        }
        $file_content = $file_content->parse();
        $file_fields = array("%FILE%","%EXT%");
        $file_fields_replace = array($this->file,$this->ext);
        $file_content = str_replace($file_fields, $file_fields_replace, $file_content);

        $fields = array(
            "%CONSTANT_VALUE_CONTENT%",
            "%MEND_SIGN%",
            "%TITLE%",
            "%DETAIL%",
            "%FILE%",
            "%FILE_CONTENT%",
            "%DEST_SITE_URL%",
            "%DEST_DIR_URL%",
            "%STATUS_A%",
            "%STATUS_D%",
            "%TYPE%",
            "%ID%"
        );

        $fields_replace = array(
            $c_v_container_content1,
            MEND_SIGN,
            $this->data['title'],
            $this->data['detail'],
            $this->data['file'],
            $file_content,
            SITE_UPD.'banner/temp_dir/',
            DIR_UPD.'banner/temp_dir/',
            $static_a,
            $static_d,
            $this->type,
            $this->id
        );

        $content = str_replace($fields, $fields_replace, $main_content);
        return filtering($content, 'output', 'text');
    }

    public function dataGrid() {
        $content = $operation = $whereCond = $totalRow = NULL;
        $result = $tmp_rows = $row_data = array();
        extract($this->searchArray);
        $chr = str_replace(array('_', '%'), array('\_', '\%'), $chr);
        //$whereCond = ' where  status!=\'a\'';



        $aWhere = array();
        if (isset($sort)) {
            $sorting = $sort . ' ' . $order;
        } else {
            $sorting = 'id DESC';
        }
        if( $chr != ""){
             $aWhere[] = "%$chr%";
            $aWhere[] = "%$chr%";
            $whereCond = " WHERE (b.title LIKE ? OR b.detail LIKE ?) ";
        }
        $query = "SELECT b.*
                    FROM tbl_banner b
                    " . $whereCond . " ORDER BY " . $sorting;

        $query_with_limit = $query . " LIMIT " . $offset . " ," . $rows . " ";

        $totalUsers = $this->db->pdoQuery($query,$aWhere)->results();

        $qrySel = $this->db->pdoQuery($query_with_limit,$aWhere)->results();
        $totalRow = count($totalUsers);

        foreach ($qrySel as $fetchRes) {
            $isActive = ($fetchRes['isActive'] == "y") ? "checked" : "";

            $switch = (in_array('status', $this->Permission)) ? $this->toggel_switch(array("action" => "ajax." . $this->module . ".php?id=" . $fetchRes['id'] . "", "check" => $isActive)) : '';
            $operation = '';

            $operation .= (in_array('edit', $this->Permission)) ? $this->operation(array("href" => "ajax." . $this->module . ".php?action=edit&id=" . $fetchRes['id'] . "", "class" => "btn default btn-xs black btnEdit", "value" => '<i class="fa fa-edit"></i>&nbsp;Edit')) : '';


            /*$operation .=(in_array('view', $this->Permission)) ? '&nbsp;&nbsp;' . $this->operation(array("href" => "ajax." . $this->module . ".php?action=view&id=" . $fetchRes['id'] . "", "class" => "btn default blue btn-xs btn-viewbtn", "value" => '<i class="fa fa-laptop"></i>&nbsp;View')) : '';*/

            $title = (isset($fetchRes["title_1"]) && $fetchRes["title_1"] != '') ? $fetchRes["title_1"] : 'N/A';
            $detail = (isset($fetchRes["detail_1"]) && $fetchRes["detail_1"] != '') ? $fetchRes["detail_1"] : 'N/A';
            $file_type = (isset($fetchRes["file_type"]) && $fetchRes["file_type"] != '') ? ucfirst($fetchRes["file_type"]) : 'N/A';
            if($fetchRes['file_type'] == 'video')
            {
                $file = SITE_UPD.'banner/'.$fetchRes['file'];

                $ext = strtolower(getExt($fetchRes['file']));
                $file = '<video width="300" controls>
                            <source src="'.$file.'" type="video/'.$ext.'">
                            </video>';
            }
            else
            {
                $file = '<img src="'.SITE_UPD.'banner/'.$fetchRes['file'].'" width="300" alt="Image">';
            }

            $final_array = array(
                filtering($fetchRes['id'], 'output', 'int'),
                //filtering($title),
                //filtering($detail),
                filtering($file_type),
                $file
            );
            /*if (in_array('status', $this->Permission)) {
                $final_array = array_merge($final_array, array($switch));
            }*/
            if (in_array('edit', $this->Permission) || in_array('delete', $this->Permission) || in_array('view', $this->Permission)) {
                $final_array = array_merge($final_array, array($operation));
            }
            //echo "<pre>";print_r($final_array);exit;
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

    public function getSelectBoxOption() {
        $content = '';
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/select_option-nct.tpl.php");
        $content.= $main_content->parse();
        return sanitize_output($content);
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

        $main_content_parsed = $final_result = $main_content->parse();

        $fields = array(
            "%VIEW_ALL_RECORDS_BTN%"
        );

        $view_all_records_btn = '';
        if (( isset($_GET['day']) && $_GET['day'] != '' ) || ( isset($_GET['month']) && $_GET['month'] != '' ) || ( isset($_GET['year']) && $_GET['year'] != '' )) {
            $view_all_records_btn = $this->getViewAllBtn();
        }

        $fields_replace = array(
            $view_all_records_btn
        );

        $final_result = str_replace($fields, $fields_replace, $main_content_parsed);

        return $final_result;
    }

}
