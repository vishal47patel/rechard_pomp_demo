<?php
$reqAuth = false;
$module = 'registration-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.registration-nct.php";
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
	redirectPage(SITE_URL);
}
extract($_REQUEST);


/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),
		array('api.js','https://www.google.com/recaptcha/'));

/*load script*/


$winTitle = SIGNUP.' - ' . SITE_NM;

$headTitle = SIGNUP.'' . SITE_NM;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));

$regiUserType = (isset($_GET['user_type']) && ($_GET['user_type'] != "")) ? $_GET['user_type'] : "";

$contentArray = array("module"=>$module,"id"=>0,"token"=>issetor($token), "regiUserType" => $regiUserType);
$obj = new Registration($contentArray);

if(isset($_POST['method']) && $_POST['method'] == 'checkUniqueName') {
        if(checkUniqueName($_POST['firstName'],$_POST['lastName'])){
                echo 'true';
        }else{
                echo 'false';
        }exit;
}

if(isset($_POST['method']) && $_POST['method'] == 'checkValidate' && isset($_POST['email']) && $_POST['email'] != '')
{
	if(isExist($_POST['email'],'email',false,$sessUserId)){
                echo 'true';
        }else{
                echo 'false';
        }
        exit;
}

if(isset($_POST['method']) && $_POST['method'] == 'checkValidate' && isset($_POST['contactNo']) && $_POST['contactNo'] != '')
{
        if(isExist($_POST['contactNo'],'contactNo',false,$sessUserId)){
                echo 'true';
        }else{
                echo 'false';
        }
        exit;
}

if(isset($_POST['btnSignUpSubmit'])){
	$response = $obj->submitRegistration($_POST);
	// echo "here";
	// echo "<pre>";
	// print_r($response);exit;
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
}

$pageContent = $obj->getPageContent();

require_once DIR_TMPL . "parsing-nct.tpl.php";
?>