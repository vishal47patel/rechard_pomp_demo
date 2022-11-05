<?php
class Content extends Home{
	public $page_name;
	public $page_title;
	public $meta_keyword;
	public $meta_desc;
	public $page_desc;
	public $isActive;
	public $data = array();
	public function __construct($module, $id=0, $objPost=NULL, $searchArray=array(), $type=''){
		global $db, $fields, $sessCataId;
		$this->db = $db;
		$this->data['id'] = $this->id = $id;
		$this->fields = $fields;
		$this->module = $module;
		$this->table = 'tbl_content';
		$this->type = ($this->id > 0 ? 'edit' : 'add');
		$this->searchArray = $searchArray;
		parent::__construct();
		if($this->id>0){
			$qrySel = $this->db->select($this->table, array("*"),array("pId"=>$id))->result();
			$fetchRes = $qrySel;

			$this->data['pageTitle']    = $this->pageTitle = $fetchRes['pageTitle'];
			$this->data['metaKeyword']  = $this->metaKeyword = $fetchRes['metaKeyword'];
			$this->data['metaDesc']     = $this->metaDesc = $fetchRes['metaDesc'];
			$this->data['linkType']     = $this->linkType = $fetchRes['linkType'];
			$this->data['url']          = $this->url = $fetchRes['url'];
			$this->data['pageDesc']     = $this->pageDesc = $fetchRes['pageDesc'];
			$this->data['isActive']     = $this->isActive = $fetchRes['isActive'];
		}else{
			$this->data['pageTitle']    = $this->pageTitle = '';
			$this->data['metaKeyword']  = $this->metaKeyword = '';
			$this->data['metaDesc']     = $this->metaDesc = '';
			$this->data['linkType']     = $this->linkType = "";
			$this->data['url']          = $this->url = "";
			$this->data['pageDesc']     = $this->pageDesc = '';
			$this->data['isActive']     = $this->isActive = 'a';
		}
		switch($type){
			case 'add' : {
				$this->data['content'] =  $this->getForm();
				break;
			}case 'edit' : {
				$this->data['content'] =  $this->getForm();
				break;
			}case 'view' : {
				$this->data['content'] =  $this->viewForm();
				break;
			}case 'delete' : {
				$this->data['content'] =  json_encode($this->dataGrid());
				break;
			}case 'datagrid' : {
				$this->data['content'] =  json_encode($this->dataGrid());
			}
		}
	}
	public function viewForm(){
		//$content_type = getTableValue("tbl_content_type",'type',array('id'=>$this->content_type));
		//$content = $this->displayBox(array("label"=>"Page Name&nbsp;:","value"=>$this->pageName)).
		$content = $this->displayBox(array("label"=>"Page Title&nbsp;:","value"=>$this->pageTitle)).
		$this->displayBox(array("label"=>"Meta Keyword&nbsp;:","value"=>$this->metaKeyword)).
		$this->displayBox(array("label"=>"Meta Description&nbsp;:","value"=>$this->metaDesc)).
		$this->displayBox(array("label"=>"Page Description&nbsp;:","value"=>$this->pageDesc , "value_class" => "ckeditor-content"));
		return $content;
	}
	public function getForm(){
		$content = '';


		$qrySel = $this->db->select("tbl_language", array("id","languageName","created_date"),array("status"=>'a'))->results();
		$constant_value = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/constant_value-nct.tpl.php");
		$constant_value_content = $constant_value->parse();
		$constant_value_search = array("%MEND_SIGN%","%LANGUAGE_NAME%","%CONSTANT_VALUE%","%ID%","%TYPEVALUE%","%LBL_NM%");
		$constant_value_content2="";
		foreach($qrySel as $fetchRes){
			if($this->type == 'edit'){
				$qrysel1 = $this->db->select($this->table, array("pId","pageTitle_".$fetchRes["id"]),array('pId'=>$this->id))->result();
				$fetchRow = $qrysel1;
				$this->constantValue = ($this->type == 'edit') ? $fetchRow["pageTitle_".$fetchRes["id"]] : '';
				$constant_value_replace = array(MEND_SIGN,$fetchRes['languageName'],stripslashes($this->constantValue),$fetchRes['id'],"pageTitleValue","Page Title");
			}else{
				$constant_value_replace = array(MEND_SIGN,$fetchRes['languageName'],'',$fetchRes['id'],"pageTitleValue","Page Title");
			}
			$constant_value_content2 .= str_replace($constant_value_search,$constant_value_replace,$constant_value_content);
		}
		//metaKeyword

		$qrySel = $this->db->select("tbl_language", array("id","languageName","created_date"),array("status"=>'a'))->results();
		$constant_value = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/constant_value_txt-nct.tpl.php");
		$constant_value_content = $constant_value->parse();
		$constant_value_search = array("%MEND_SIGN%","%LANGUAGE_NAME%","%CLASS_NAME%","%CONSTANT_VALUE%","%ID%","%TYPEVALUE%","%LBL_NM%");
		$constant_value_content3 = "";
		foreach($qrySel as $fetchRes){
			if($this->type == 'edit'){
				$qrysel1 = $this->db->select($this->table, array("pId","metaKeyword_".$fetchRes["id"]),array('pId'=>$this->id))->result();
				$fetchRow = $qrysel1;
				$this->constantValue = ($this->type == 'edit') ? $fetchRow["metaKeyword_".$fetchRes["id"]] : '';
				$constant_value_replace = array('',$fetchRes['languageName'],"metaKeyword",stripslashes($this->constantValue),$fetchRes['id'],"metaKeywordValue","Meta Keyword");
			}else{
				$constant_value_replace = array('',$fetchRes['languageName'],"metaKeyword",'',$fetchRes['id'],"metaKeywordValue","Meta Keyword");
			}
			$constant_value_content3 .= str_replace($constant_value_search,$constant_value_replace,$constant_value_content);
		}
		//metaDesc

		$qrySel = $this->db->select("tbl_language", array("id","languageName","created_date"),array("status"=>'a'))->results();
		$constant_value = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/constant_value_txt-nct.tpl.php");
		$constant_value_content = $constant_value->parse();
		$constant_value_search = array("%MEND_SIGN%","%LANGUAGE_NAME%","%CLASS_NAME%","%CONSTANT_VALUE%","%ID%","%TYPEVALUE%","%LBL_NM%");
		$constant_value_content4 = "";

		foreach($qrySel as $fetchRes){
			if($this->type == 'edit'){
				$qrysel1 = $this->db->select($this->table, array("pId","metaDesc_".$fetchRes["id"]),array('pId'=>$this->id))->result();
				$fetchRow = $qrysel1;
				$this->constantValue = ($this->type == 'edit') ? $fetchRow["metaDesc_".$fetchRes["id"]] : '';
				$constant_value_replace = array('',$fetchRes['languageName'],"metaDescription",stripslashes($this->constantValue),$fetchRes['id'],"metaDescValue","Meta Description");
			}else{
				$constant_value_replace = array('',$fetchRes['languageName'],"metaDescription",'',$fetchRes['id'],"metaDescValue","Meta Description");
			}
			$constant_value_content4 .= str_replace($constant_value_search,$constant_value_replace,$constant_value_content);
		}
		//pageDesc

		$qrySel = $this->db->select("tbl_language", array("id","languageName","created_date"),array("status"=>'a'))->results();
		$constant_value = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/constant_value_ck-nct.tpl.php");
		$constant_value_content = $constant_value->parse();
		$constant_value_search = array("%MEND_SIGN%","%LANGUAGE_NAME%","%CONSTANT_VALUE%","%ID%","%TYPEVALUE%","%LBL_NM%");
		$constant_value_content5 = "";

		foreach($qrySel as $fetchRes){
			if($this->type == 'edit'){
				$qrysel1 = $this->db->select($this->table, array("pId","pageDesc_".$fetchRes["id"]),array('pId'=>$this->id))->result();
				$fetchRow = $qrysel1;
				$this->constantValue = ($this->type == 'edit') ? $fetchRow["pageDesc_".$fetchRes["id"]] : '';
				$constant_value_replace = array(MEND_SIGN,$fetchRes['languageName'],stripslashes($this->constantValue),$fetchRes['id'],"pageDescValue","Page Description");
			}else{
				$constant_value_replace = array(MEND_SIGN,$fetchRes['languageName'],'',$fetchRes['id'],"pageDescValue","Page Description");
			}
			$constant_value_content5 .= str_replace($constant_value_search,$constant_value_replace,$constant_value_content);
		}
		$getSelectBoxOption = $this->getSelectBoxOption();
		$fields = array("%VALUE%","%SELECTED%","%DISPLAY_VALUE%");
		//content type drop down

		$main_content = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/form-nct.tpl.php");
		$main_content = $main_content->parse();
		$static_a = ($this->isActive == 'y' ? 'checked':'');
		$static_d = ($this->isActive != 'y' ? 'checked':'');
		$linktype_url = ($this->linkType == 'url' ? ' checked="checked" ': '');
		$linktype_page = ($this->linkType != 'url' ? ' checked="checked" ': '');

		$fields = array(
			"%LINK_URL%",
			"%LINK_PAGE%",
			"%URL%",
			"%MEND_SIGN%",
			"%PAGE_TITLE%",
			"%META_KEYWORD%",
			"%META_DESCRIPTION%",
			"%PAGE_DESCRIPTION%",
			"%STATIC_A%",
			"%STATIC_D%",
			"%TYPE%",
			"%ID%",
			"%CONSTANT_VALUE1%",
			"%CONSTANT_VALUE2%",
			"%CONSTANT_VALUE3%",
			"%CONSTANT_VALUE4%");
		$fields_replace = array(
			$linktype_url,
			$linktype_page,
			$this->data['url'],
			MEND_SIGN,
			$this->data['pageTitle'],
			$this->data['metaKeyword'],
			$this->data['metaDesc'],
			$this->data['pageDesc'],
			$static_a,
			$static_d,
			$this->type,
			$this->id,
			$constant_value_content2,
			$constant_value_content3,
			$constant_value_content4,
			$constant_value_content5
		);
		$content = str_replace($fields,$fields_replace,$main_content);
		return sanitize_output($content);
	}
	public function dataGrid(){
		$content = $operation = $whereCond = $totalRow = NULL;
		$result = $tmp_rows = $row_data = array();
		extract($this->searchArray);
		$chr = str_replace(array('_', '%'), array('\_', '\%'),$chr );
		$whereCond = array("isActive !="=>'t');
		if(isset($chr) && $chr != '') {
			//$whereCond = array("pageName LIKE"=> "%$chr%");
			$whereCond = array_merge($whereCond,array("AND pageTitle_1 LIKE"=> "%$chr%"));
			$whereCond = array_merge($whereCond,array("OR pageDesc_1 LIKE"=> "%$chr%"));
		}
		if(isset($sort))
			if($sort == 'pId'){
				$sorting = 'pId DESC';
			}else{
				$sorting = $sort.' '. $order;
			}
		else
			$sorting = 'pId DESC';
		$totalRow = $this->db->count($this->table, $whereCond);
		$qrySel = $this->db->select("tbl_content",array("pId","pageTitle_1","metaKeyword","metaDesc","pageDesc","isActive","createdDate"), $whereCond, " ORDER BY $sorting limit $offset , $rows" )->results();
		foreach($qrySel as $fetchRes) {
			$status = ($fetchRes['isActive']=="y") ? "checked" : "";
			$switch  =(in_array('status',$this->Permission))?$this->toggel_switch(array("action"=>"ajax.".$this->module.".php?id=".$fetchRes['pId']."","check"=>$status)):'';
			$operation='';
			$operation .= (in_array('edit',$this->Permission))?$this->operation(array("href"=>"ajax.".$this->module.".php?action=edit&id=".$fetchRes['pId']."","class"=>"btn default btn-xs black btnEdit","value"=>'<i class="fa fa-edit"></i>&nbsp;Edit')):'';
			$operation .=(in_array('delete',$this->Permission))?'&nbsp;&nbsp;'.$this->operation(array("href"=>"ajax.".$this->module.".php?action=delete&id=".$fetchRes['pId']."","class"=>"btn default btn-xs red btn-delete","value"=>'<i class="fa fa-trash-o"></i>&nbsp;Delete')):'';
			$operation .=(in_array('view',$this->Permission))?'&nbsp;&nbsp;'.$this->operation(array("href"=>"ajax.".$this->module.".php?action=view&id=".$fetchRes['pId']."","class"=>"btn default blue btn-xs btn-viewbtn","value"=>'<i class="fa fa-laptop"></i>&nbsp;View')):'';
			$final_array =  array($fetchRes['pId'],$fetchRes["pageTitle_1"]);
			if(in_array('status',$this->Permission)){
				$final_array =  array_merge($final_array, array($switch));
			}
			if(in_array('edit',$this->Permission) || in_array('delete',$this->Permission) || in_array('view',$this->Permission) ){
				$final_array =  array_merge($final_array, array($operation));
			}
			$row_data[] = $final_array;
		}
		$result["sEcho"]=$sEcho;
		$result["iTotalRecords"] = (int)$totalRow;
		$result["iTotalDisplayRecords"] = (int)$totalRow;
		$result["aaData"] = $row_data;
		return $result;
	}
	public function toggel_switch($text){
		$text['action']   = isset($text['action']) ? $text['action'] : 'Enter Action Here: ';
		$text['check']    = isset($text['check']) ? $text['check'] : '';
		$text['name']     = isset($text['name']) ? $text['name'] : '';
		$text['class']    = isset($text['class']) ? ''.trim($text['class']) : '';
		$text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';
		$main_content     = new MainTemplater(DIR_ADMIN_TMPL.$this->module.'/switch-nct.tpl.php');
		$main_content     =$main_content->parse();
		$fields           = array("%NAME%","%CLASS%","%ACTION%","%EXTRA%","%CHECK%");
		$fields_replace   = array($text['name'],$text['class'],$text['action'],$text['extraAtt'],$text['check']);
		return str_replace($fields,$fields_replace,$main_content);
	}
	public function operation($text){
		$text['href']     = isset($text['href']) ? $text['href'] : 'Enter Link Here: ';
		$text['value']    = isset($text['value']) ? $text['value'] : '';
		$text['name']     = isset($text['name']) ? $text['name'] : '';
		$text['class']    = isset($text['class']) ? ''.trim($text['class']) : '';
		$text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';
		$main_content     = new MainTemplater(DIR_ADMIN_TMPL.$this->module.'/operation-nct.tpl.php');
		$main_content     =$main_content->parse();
		$fields           = array("%HREF%","%CLASS%","%VALUE%","%EXTRA%");
		$fields_replace   = array($text['href'],$text['class'],$text['value'],$text['extraAtt']);
		return str_replace($fields,$fields_replace,$main_content);
	}
	public function displaybox($text){
		$text['label']     = isset($text['label']) ? $text['label'] : 'Enter Text Here: ';
		$text['value']     = isset($text['value']) ? $text['value'] : '';
		$text['name']      = isset($text['name']) ? $text['name'] : '';
		$text['class']     = isset($text['class']) ? 'form-control-static '.trim($text['class']) : 'form-control-static';
		$text['onlyField'] = isset($text['onlyField']) ? $text['onlyField'] : false;
		$text['extraAtt']  = isset($text['extraAtt']) ? $text['extraAtt'] : '';
		$text['value_class']  = isset($text['value_class']) ? $text['value_class'] : '';
		$main_content      = new MainTemplater(DIR_ADMIN_TMPL.$this->module.'/displaybox.tpl.php');
		$main_content      =$main_content->parse();
		$fields            = array("%LABEL%","%CLASS%","%VALUE%","%VALUE_CLASS%");
		$fields_replace    = array($text['label'],$text['class'],$text['value'],$text['value_class']);
		return str_replace($fields,$fields_replace,$main_content);
	}
	public function getSelectBoxOption(){
		$content = '';
		$main_content = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/select_option-nct.tpl.php");
		$content.= $main_content->parse();
		return sanitize_output($content);
	}
	public function getPageContent(){
		$final_result             = NULL;
		$main_content             = new MainTemplater(DIR_ADMIN_TMPL.$this->module."/".$this->module.".tpl.php");
		$main_content->breadcrumb = $this->getBreadcrumb();
		$final_result             = $main_content->parse();
		return $final_result;
	}
}