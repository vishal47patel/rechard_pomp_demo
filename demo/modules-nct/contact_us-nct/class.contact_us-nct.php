<?php
class contact_us
{
    public function __construct($contentArray = array(), $objCookie = array())
    {
        global $sessRequestType;
        foreach ($GLOBALS as $key => $values) {
            $this->$key = $values;
        }
        extract($contentArray);
        $this->module          = $module;
        $this->sessRequestType = $sessRequestType;
    }
    public function getPageContent()
    {
        $content = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php");
        return $content;
    }
}
