<?php
$reqAuth = false;
$module = 'forgot_pass-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.forgot_pass-nct.php";
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
	redirectPage(SITE_URL);
}
extract($_REQUEST);


/*load script*/
$scripts = array(array($module.".js", SITE_JS_MOD));
/*load script*/

/*$qryRes=$db->pdoQuery("SELECT * FROM tbl_users where creUpdated='n'")->results();
foreach($qryRes as $fetchRes){
	extract($fetchRes);
	$data=array("u_username"=>$mizutech_name,"u_password"=>$mizutech_pwd,"u_name"=>$firstName,"u_email"=>$email,"u_phone"=>$contactNo);

	$test=createMizutechUserAcc($data);
	if($test){
		$db->query("UPDATE tbl_users SET creUpdated = 'y' WHERE id = '".$id."' ");	
	}
}*/

$winTitle = 'Forgot Password - ' . SITE_NM;

$headTitle = 'Forgot Password' . SITE_NM;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));
$obj = new ForgotPassword($module, 0, issetor($token));


try{
	if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['action']) && $_POST['action'] == 'forgot_password' && isset($_POST['reset_pwd'])) {

		$response = $obj->forgotPassword($_POST);

		$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
		redirectPage($response['redirectLink']);
	}
}
catch(Exception $e){

	$msgType = $_SESSION["msgType"] = disMessage(array(
		'type' => 'err',
		'var' => $e->getMessage()
	));
	redirectPage(SITE_URL);
}


$pageContent = $obj->getPageContent();

require_once DIR_TMPL . "parsing-nct.tpl.php";
?>