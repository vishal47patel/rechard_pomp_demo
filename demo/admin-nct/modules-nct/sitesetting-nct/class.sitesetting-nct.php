<?php

class SiteSetting extends Home {

    function __construct()
    {
        parent::__construct();
        $this->table = 'tbl_site_settings';
    }

    public function _index()
    {
        /*data-target='#general'
        data-target='#api'
        data-target='#email'
        data-target='#footer'
        data-target='#payment'
        data-target='#other'
        data-target='#statistics'*/
        $generalH    = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4> General Settings</h4></div>";
		/* start vspl changes 12-10-2022 */
        $mobile_app    = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4> Mobile App</h4></div>";
        /* end vspl changes 12-10-2022 */
		$apiH        = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4> API Settings</h4></div>";
        $emailH      = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4> Email Settings</h4></div>";
        $footerH     = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4> Footer Settings</h4></div>";
        $paymentH    = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4> Payment Settings</h4></div>";
        $otherH      = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4> Other Settings</h4></div>";
        $statisticsH = "<div class='page-header /*pointer*/' data-toggle='collapse'><h4>Front Side Statistics</h4></div>";

        $general = $api = $email = $footer = $payment = $other = $statistics = $statistics_content = "";


        $sqlSetting = $this->db->pdoQuery("SELECT * FROM ".$this->table." WHERE isActive = 'y'")->results();
        foreach ($sqlSetting as $k => $setrow) {
            $content   = '';
            $required  = '';
            $mend_sign = '';

            if ($setrow["type"] == "fileBox" && $setrow["value"] == "" ) {
                $required = "required ";
                $mend_sign = MEND_SIGN;
            }
            if ($setrow["type"] == "fileBox" && !empty($setrow["value"])) {

                $extraAtt = ($setrow['id'] == '3') ? 'style="background-color: #305f9b;"' : "";
                $setrow["value"] = $this->img(array("onlyField" => true, "src" => "" . SITE_IMG . $setrow["value"] . "", "width" => "" . (($setrow["constant"] == "SITE_FAVICON") ? "20px" : "200px") . "" , "extraAtt" => $extraAtt));
            }
            if ($setrow["type"] == "radio") {
                $mend_sign = MEND_SIGN;
                if($setrow['constant'] == "STATISTICS"){
                    $values = array("l" => "Live Statistics","d" => "Dummy Statistics");
                    $lbl = $mend_sign . $setrow["label"];
                }else{
                    $values = array("y" => "Yes","n" => "No");
                    $lbl = $setrow["label"];
                }

                $content .= $this->radio(array(
                    "label"   => $lbl . " :",
                    "lblOnly" => $setrow["label"] . " :",
                    "class"   => "radioBtn-bg " . $setrow['class'],
                    "name"    => $setrow["id"],
                    "value"   => $setrow["value"],
                    "values"  => $values
                    ));
            } else if ($setrow["type"] == "selectBox") {
                $mend_sign = MEND_SIGN;
                $content.= $this->selectBox(array("label" => $mend_sign . $setrow["label"] . ":", "onlyField" => false, "allow_null" => true, "allow_null_value" => "", "class" => "required", "name" => $setrow["id"], "choices" => array(0 => "Select Location"), "value" => $setrow["value"], "defaultValue" => true, "multiple" => false, "optgroup" => false, "intoDB" => array("val" => true,
                        "table" => "tbl_locations",
                        "fields" => "*",
                        "where" => "status='1'",
                        "orderBy" => "location_name",
                        "valField" => "id",
                        "dispField" => "location_name")));
            } else {

                if ($setrow["required"] == 1) {
                    $required = "required ";
                    $mend_sign = MEND_SIGN;
                }
                $type = isset($setrow["type"])?trim($setrow["type"]):"textBox";

                if (($setrow["type"] == "filebox") && ($setrow['constant'] == 'SITE_LOGO')) {
					
					
					$content.=$this->$type(array("label" => $mend_sign . $setrow["label"] . ":", "value" => $setrow["value"], "class" => $required . $setrow["class"], "name" => $setrow["id"],'extraAtt' => 'accept="image/png,image/jpeg"'));
					
                    
                }
                else {	
					if($setrow['section'] == 'mobile_app_general' && $setrow['label'] == 'Logo'){
						$content.=$this->$type(array("label" => $mend_sign . $setrow["label"] . ":", "value" => $setrow["value"], "class" => $required . $setrow["class"], "name" => $setrow["id"], "extraAtt" => "onchange='Upload()'"));
					}
					else if($setrow['section'] == 'mobile_app_general' && $setrow['label'] == 'Image'){
						$content.=$this->$type(array("label" => $mend_sign . $setrow["label"] . ":", "value" => $setrow["value"], "class" => $required . $setrow["class"], "name" => $setrow["id"], "extraAtt" => "onchange='Upload2()'"));
					}
					else{
						$content.=$this->$type(array("label" => $mend_sign . $setrow["label"] . ":", "value" => $setrow["value"], "class" => $required . $setrow["class"], "name" => $setrow["id"]));
					}
						
					
                }
            }

            if (!empty($setrow['hint'])) {
                $content .= '<div class="form-group"><label class="control-label col-md-3">&nbsp;</label><div class="col-md-4"><p class="form-control-static hint">'.$setrow['hint'].'</p></div></div>';
            }
			
			

            if($setrow['section'] == 'general') {
                $general .= $content;
            }
			/* start vspl changes 12-10-2022 */
			if($setrow['section'] == 'mobile_app_general') {
                $mobile_app_content .= $content;
            }
			/* end vspl changes 12-10-2022 */
            else if($setrow['section'] == 'api') {
                $api .= $content;
            }
            else if($setrow['section'] == 'email') {
                $email .= $content;
            }
            else if($setrow['section'] == 'footer') {
                $footer .= $content;
            }
            else if($setrow['section'] == 'payment') {
                $payment .= $content;
            }
            else if($setrow['section'] == 'other') {
                $other .= $content;
            }
            else if($setrow['section'] == 'statistics') {
                $statistics .= $content;
            }
            else if($setrow['section'] == 'statistics_content') {
                $statistics_content .= $content;
            }
        }

// $mobile_app_content = 'vhhncfhtctcxt';

        $content = '';
        $content .= ($general != '') ? ($generalH .'<div id="general" class="collapse in">'. $general.'</div>') : '';
		/* start vspl changes 12-10-2022 */
        $content .= ($mobile_app_content != '') ? ($mobile_app .'<div id="mobile_app_content" class="collapse in">'. $mobile_app_content.'</div>') : '';
		/* end vspl changes 12-10-2022 */
        $content .= ($api != '') ? ($apiH .'<div id="api" class="collapse in">'. $api.'</div>') : '';
        $content .= ($email != '') ? ($emailH .'<div id="email" class="collapse in">'. $email.'</div>') : '';
        $content .= ($footer != '') ? ($footerH .'<div id="footer" class="collapse in">'. $footer.'</div>') : '';
        $content .= ($payment != '') ? ($paymentH .'<div id="payment" class="collapse in">'. $payment.'</div>') : '';
        $content .= ($other != '') ? ($otherH .'<div id="other" class="collapse in">'. $other.'</div>') : '';
        $statistics_content = '<div id="statistics_content_div">' . $statistics_content . '</div>';
        $content .= ($statistics != '') ? ($statisticsH .'<div id="statistics" class="collapse in">'. $statistics . $statistics_content.'</div>') : '';


        $content.=$this->buttonpanel_start() .
                $this->button(array("onlyField" => true, "name" => "submitSetForm", "type" => "submit", "class" => "green", "value" => "Submit", "extraAtt" => "")) .
                $this->button(array("onlyField" => true, "name" => "cn", "type" => "button", "class" => "btn-toggler", "value" => "Cancel", "extraAtt" => "onclick=\"location.href='" . SITE_ADM_MOD . "home-nct/'\""));

        $content.=$this->buttonpanel_end();
        return $content;
    }

    public function radio($chk)
    {
        $checkBoxes         = $sub_final_result = '';
        $chk['label']       = isset($chk['label']) ? $chk['label'] : ' ';
        $chk['lblOnly']     = isset($chk['lblOnly']) ? $chk['lblOnly'] : ' ';
        $chk['value']       = isset($chk['value']) ? $chk['value'] : '';
        $chk['name']        = isset($chk['name']) ? $chk['name'] : array();
        $chk['class']       = isset($chk['class']) ? $chk['class'] : '';
        $chk['extraAtt']    = isset($chk['extraAtt']) ? ' ' . $chk['extraAtt'] : '';
        $chk['onlyField']   = isset($chk['onlyField']) ? $chk['onlyField'] : false;
        $chk['text']        = isset($chk["text"]) ? $chk["text"] : "";
        $chk['noDiv']       = isset($chk['noDiv']) ? $chk['noDiv'] : true;
        $chk['label_class'] = isset($chk['label_class']) ? ' ' . $chk['label_class'] : '';

        $main_content_only_field = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/radio_onlyfield.tpl.php");

        $main_content_only_field = $main_content_only_field->parse();

        $fields = array(
            "%LABEL_CLASS%",
            "%CLASS%",
            "%NAME%",
            "%ID%",
            "%VALUE%",
            "%EXTRA%",
            "%DISPLAY_VALUE%",
            "%CHECKED%"
        );

        foreach ($chk['values'] as $k => $v) {
            $check          = ($k == $chk['value']) ? 'checked="checked"' : '';
            $fields_replace = array(
                $chk['label_class'],
                $chk['class'],
                $chk['name'],
                $k,
                $k,
                $chk['extraAtt'],
                $v,
                $check
            );
            $sub_final_result .= str_replace($fields, $fields_replace, $main_content_only_field);
        }
        if ($chk['onlyField'] == true) {
            return $sub_final_result;
        } else {

            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/radio.tpl.php");
            $main_content = $main_content->parse();

            $fields         = array(
                "%RADIO_LIST%",
                "%LABEL%",
                "%LABEL_ONLY%",
            );
            $fields_replace = array(
                $sub_final_result,
                $chk['label'],
                $chk['lblOnly']
            );
            return str_replace($fields, $fields_replace, $main_content);
        }
    }

    public function button($btn)
    {
        $btn['value']     = isset($btn['value']) ? $btn['value'] : '';
        $btn['name']      = isset($btn['name']) ? $btn['name'] : '';
        $btn['class']     = isset($btn['class']) ? 'btn ' . $btn['class'] : 'btn';
        $btn['type']      = isset($btn['type']) ? $btn['type'] : '';
        $btn['src']       = isset($btn['src']) ? $btn['src'] : '';
        $btn['extraAtt']  = isset($btn['extraAtt']) ? ' ' . $btn['extraAtt'] : '';
        $btn['onlyField'] = isset($btn['onlyField']) ? $btn['onlyField'] : false;
        $btn["src"]       = ($btn["type"] == "image" && $btn["src"] != '') ? $btn["src"] : '';

        $main_content_only_field = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/button_onlyfield.tpl.php");
        $main_content_only_field = $main_content_only_field->parse();
        $fields = array("%TYPE%", "%NAME%", "%CLASS%", "%ID%", "%SRC%", "%EXTRA%", "%VALUE%");
        $fields_replace = array($btn["type"], $btn["name"], $btn["class"], $btn["name"], $btn["src"], $btn['extraAtt'], $btn["value"]);
        $sub_final_result_only_field = str_replace($fields, $fields_replace, $main_content_only_field);

        if ($btn['onlyField'] == true) {
            return $sub_final_result_only_field;
        } else {
            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/button.tpl.php");
            $main_content = $main_content->parse();
            $fields = array("%BUTTON%");
            $fields_replace = array($sub_final_result_only_field);
            return str_replace($fields, $fields_replace, $main_content);
        }
    }

    public function img($text)
    {
        $text['href']      = isset($text['href']) ? $text['href'] : '';
        $text['src']       = isset($text['src']) ? $text['src'] : 'Enter Image Path Here: ';
        $text['name']      = isset($text['name']) ? $text['name'] : '';
        $text['id']        = isset($text['id']) ? $text['id'] : '';
        $text['class']     = isset($text['class']) ? '' . trim($text['class']) : '';
        $text['height']    = isset($text['height']) ? '' . trim($text['height']) : '';
        $text['width']     = isset($text['width']) ? '' . trim($text['width']) : '';
        $text['extraAtt']  = isset($text['extraAtt']) ? $text['extraAtt'] : '';
        $text['onlyField'] = isset($text['onlyField']) ? $text['onlyField'] : '';

        if ($text['onlyField'] == true) {
            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/img_onlyfield.tpl.php");
            $main_content = $main_content->parse();
        } else {
            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/img.tpl.php");
            $main_content = $main_content->parse();
        }
        $fields = array("%HREF%", "%SRC%", "%CLASS%", "%ID%", "%ALT%", "%WIDTH%", "%HEIGHT%", "%EXTRA%");
        $fields_replace = array($text['href'], $text['src'], $text['class'], $text['id'], $text['name'], $text['width'], $text['height'], $text['extraAtt']);
        return str_replace($fields,$fields_replace,$main_content);
    }

    public function buttonpanel_start()
    {
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/buttonpanel_start.tpl.php");
        $main_content = $main_content->parse();

        return $main_content;
    }

    public function buttonpanel_end()
    {
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/buttonpanel_end.tpl.php");
        $main_content = $main_content->parse();
        return $main_content;
    }

    public function form_start($text)
    {
        $text['action']   = isset($text['action']) ? $text['action'] : '';
        $text['method']   = isset($text['method']) ? $text['method'] : 'post';
        $text['name']     = isset($text['name']) ? $text['name'] : '';
        $text['id']       = isset($text['id']) ? $text['id'] : '';
        $text['class']    = isset($text['class']) ? '' . trim($text['class']) : 'form-horizontal';
        $text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';

        $main_content     = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/form_start.tpl.php");
        $main_content     = $main_content->parse();
        $fields           = array("%ACTION%", "%METHOD%", "%NAME%", "%ID%", "%CLASS%", "%EXTRA%");
        $fields_replace   = array($text['action'], $text['method'], $text['name'], $text['name'], $text['class'], $text['extraAtt']);
        return str_replace($fields, $fields_replace, $main_content);
    }

    public function form_end()
    {
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/form_end.tpl.php");
        $main_content = $main_content->parse();
        return $main_content;
    }

    public function displayBox($text)
    {

        $text['label']     = isset($text['label']) ? $text['label'] : 'Enter Text Here: ';
        $text['value']     = isset($text['value']) ? $text['value'] : '';
        $text['name']      = isset($text['name']) ? $text['name'] : '';
        $text['class']     = isset($text['class']) ? 'form-control-static ' . trim($text['class']) : 'form-control-static';
        $text['onlyField'] = isset($text['onlyField']) ? $text['onlyField'] : false;
        $text['extraAtt']  = isset($text['extraAtt']) ? $text['extraAtt'] : '';

        $main_content      = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/displaybox.tpl.php");
        $main_content      = $main_content->parse();
        $fields            = array("%LABEL%", "%CLASS%", "%VALUE%");
        $fields_replace    = array($text['label'], $text['class'], $text['value']);
        return str_replace($fields, $fields_replace, $main_content);
    }

    public function textbox($text)
    {

        $text['label']    = isset($text['label']) ? $text['label'] : 'Enter Text Here: ';
        $text['value']    = isset($text['value']) ? $text['value'] : '';
        $text['name']     = isset($text['name']) ? $text['name'] : '';
        $text['class']    = isset($text['class']) ? 'form-control ' . trim($text['class']) : 'form-control';
        $text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';

        $content          = NULL;
        $main_content     = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/textbox-nct.tpl.php");
        $main_content     = $main_content->parse();

        $fields           = array("%CLASS%", "%NAME%", "%ID%", "%VALUE%", "%EXTRA%", "%LABEL%");
        $fields_replace   = array($text['class'], $text['name'], $text['name'], $text['value'], $text['extraAtt'], $text['label']);
        $content          = str_replace($fields, $fields_replace, $main_content);
        return $content;
    }

    public function password($text)
    {
        $text['label']     = isset($text['label']) ? $text['label'] : 'Enter Text Here: ';
        $text['value']     = isset($text['value']) ? $text['value'] : '';
        $text['name']      = isset($text['name']) ? $text['name'] : '';
        $text['class']     = isset($text['class']) ? 'form-control ' . trim($text['class']) : 'form-control';
        $text['onlyField'] = isset($text['onlyField']) ? $text['onlyField'] : false;
        $text['extraAtt']  = isset($text['extraAtt']) ? $text['extraAtt'] : '';

        if ($text["onlyField"] == true) {
            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/password_onlyfield.tpl.php');
        } else {
            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/password.tpl.php');
        }
        $main_content = $main_content->parse();
        $fields = array("%CLASS%", "%NAME%", "%ID%", "%VALUE%", "%EXTRA%", "%LABEL%");
        $fields_replace = array($text['class'], $text['name'], $text['name'], $text['value'], $text['extraAtt'], $text['label']);
        return str_replace($fields, $fields_replace, $main_content);
    }

    public function filebox($text)
    {

        $text['label']    = isset($text['label']) ? $text['label'] : 'Enter Text Here: ';
        $text['value']    = isset($text['value']) ? $text['value'] : '';
        $text['name']     = isset($text['name']) ? $text['name'] : '';
        $text['class']    = isset($text['class']) ? 'form-control ' . trim($text['class']) : 'form-control';
        $text['extraAtt'] = isset($text['extraAtt']) ? $text['extraAtt'] : '';
        $text["help"]     = isset($text["help"]) ? $text["help"] : "";
        $text["helptext"] = ($text["help"] != "") ? '<p class="help-block">' . $text["help"] . '</p>' : "";

        $content          = NULL;
        $main_content     = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/filebox-nct.tpl.php");
        $main_content     = $main_content->parse();

        $fields           = array("%CLASS%", "%NAME%", "%ID%", "%VALUE%", "%EXTRA%", "%LABEL%", "%HELPTEXT%");
        $fields_replace   = array($text['class'], $text['name'], $text['name'], $text['value'], $text['extraAtt'], $text['label'], $text["helptext"]);

        $content          = str_replace($fields, $fields_replace, $main_content);
        return $content;
    }

    public function textArea($text)
    {
        $text['label']     = isset($text['label']) ? $text['label'] : 'Enter Password Here: ';
        $text['value']     = isset($text['value']) ? $text['value'] : '';
        $text['name']      = isset($text['name']) ? $text['name'] : '';
        $text['class']     = isset($text['class']) ? "form-control " . $text['class'] : 'form-control';
        $text['extraAtt']  = isset($text['extraAtt']) ? ' ' . $text['extraAtt'] : '';
        $text['onlyField'] = isset($text['onlyField']) ? $text['onlyField'] : false;

        if ($text["onlyField"] == true) {
            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/textarea_onlyfield.tpl.php');
        } else {
            $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/textarea.tpl.php');
        }
        $main_content = $main_content->parse();
        $fields = array("%CLASS%", "%NAME%", "%ID%", "%VALUE%", "%EXTRA%", "%LABEL%");
        $fields_replace = array($text['class'], $text['name'], $text['name'], $text['value'], $text['extraAtt'], $text['label']);
        return str_replace($fields, $fields_replace, $main_content);
    }

    public function textAreaEditor($text)
    {
        $text['label']     = isset($text['label']) ? $text['label'] : 'Enter Password Here: ';
        $text['value']     = isset($text['value']) ? $text['value'] : '';
        $text['name']      = isset($text['name']) ? $text['name'] : '';
        $text['class']     = isset($text['class']) ? 'ckeditor form-control ' . $text['class'] : 'ckeditor form-control';
        $text['extraAtt']  = isset($text['extraAtt']) ? ' ' . $text['extraAtt'] : '';
        $text['onlyField'] = isset($text['onlyField']) ? $text['onlyField'] : false;

        $main_content      = new MainTemplater(DIR_ADMIN_TMPL . $this->module . '/textarea_editor.tpl.php');
        $main_content      = $main_content->parse();
        $fields            = array("%CLASS%", "%NAME%", "%ID%", "%VALUE%", "%EXTRA%", "%LABEL%");
        $fields_replace    = array($text['class'], $text['name'], $text['name'], htmlentities($text['value']), $text['extraAtt'], $text['label']);
        return str_replace($fields, $fields_replace, $main_content);
    }

    public function getPageContent()
    {
        $final_result = NULL;

        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/" . $this->module . ".tpl.php");
        $main_content->breadcrumb = $this->getBreadcrumb();
        $main_content->getForm = $this->_index();

        $final_result = $main_content->parse();
        return $final_result;
    }

}

?>