<?php

class Login extends Home {

    function __construct() {
        parent::__construct();
    }

    public function loginSubmit() {
        $uName = $this->objPost->uName;
        $uPass = $this->objPost->uPass;

        $qrysel = $this->db->select("tbl_admin", array("id" , "adminType" , "uPass", "isActive"), array("uName" => $uName))->result();

        if (!empty($qrysel) > 0 && ($qrysel['isActive'] != 'd' && $qrysel['isActive'] != 't')) {
            $fetchUser = $qrysel;
            $adm_id = $fetchUser['id'];
            if ($fetchUser["uPass"] == md5($uPass)) {
                extract($fetchUser);
                $_SESSION["adminNctBlaUserId"] = (int) $fetchUser["id"];
                $_SESSION["uName"] = $uName;
                $_SESSION["adminType"] = $fetchUser['adminType'];
                $sess_id = session_id();

                if (isset($_SESSION['req_uri_adm']) && $_SESSION['req_uri_adm'] != '') {
                    $url = $_SESSION['req_uri_adm'];
                    unset($_SESSION['req_uri_adm']);
                    unset($_SESSION['loginDisplayed_adm']);
                    redirectPage($url);
                } else {
                    redirectPage(SITE_ADM_MOD . 'home-nct/');
                }
            } else {
                return 'invaildUsers';
            }
        } else if ($qrysel['isActive'] == 'd') {
            $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'unapprovedUser'));
            redirectPage(SITE_ADM_MOD . 'login-nct/');
        } else {
            $_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'invaildUsers'));
            redirectPage(SITE_ADM_MOD . 'login-nct/');
        }
    }

    public function forgotProdedure() {

        $uEmail = isset($this->objPost->uEmail) ? $this->objPost->uEmail : '';
        $uName = isset($this->objPost->uName) ? $this->objPost->uName : '';
        $value = new stdClass();
        $qrysel = $this->db->select("tbl_admin", array("id,uEmail,uName,uPass"), array("uEmail" => $uEmail))->result();
        if (!empty($qrysel) > 0) {
            $fetchUser    = $qrysel;
            $to           = $fetchUser["uEmail"];
            $uName        = $fetchUser["uName"];
            $id           = (int) $fetchUser["id"];
            $subject      = "Forgot Password";
            $value->uPass = genrateRandom();

            $this->db->update("tbl_admin", array("uPass" => md5($value->uPass)), array("id" => $id));

            $arrayCont = array();
            $arrayCont['new_password'] = $value->uPass;
            $arrayCont['greetings']          = $uName;

            $array = generateEmailTemplate('admin_forgot_password',$arrayCont);
            sendEmailAddress($to,$array['subject'],$array['message']);

            return 'New password sent successfully. Please check your mail.';
        } else {
            return 'wrongUsername';
        }
    }

    public function changePasswordProcedure() {

        global $adminUserId;
        $opasswd = isset($this->objPost->opasswd) ? $this->objPost->opasswd : '';
        $passwd = isset($this->objPost->passwd) ? $this->objPost->passwd : '';
        $cpasswd = isset($this->objPost->cpasswd) ? $this->objPost->cpasswd : '';

        $qrysel = $this->db->select("adminuser", "password", "id=" . $adminUserId . "");
        $fetchUser = mysql_fetch_array($qrysel);
        if ($fetchUser["password"] != $opasswd) {
            return 'wrongPass';
        } else if ($passwd != $cpasswd) {
            return 'passNotmatch';
        } else {
            $value = new stdClass();
            $value->password = $cpasswd;
            $value->isForgot = 'n';
            $qryUpd = $this->db->update("adminuser", $value, "id=" . $adminUserId . "", '');
            return 'succChangePass';
        }
    }

    public function getPageContent() {
        $final_result = NULL;
        $main_content = new MainTemplater(DIR_ADMIN_TMPL . $this->module . "/" . $this->module . ".tpl.php");
        $main_content->breadcrumb = $this->getBreadcrumb();
        $final_result = $main_content->parse();
        return $final_result;
    }

}

?>