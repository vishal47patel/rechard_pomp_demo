<?php
$reqAuth = false;
$module = 'home-nct';
require_once "../../includes-nct/config-nct.php";

extract($_REQUEST);
/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array("owl.carousel.min.js",SITE_JS),
		array($module.".js", SITE_JS_MOD));
/*load script*/

$styles = array(
        array("owl.carousel.min.css",SITE_CSS),
        );

$winTitle = HOME.' - ' . SITE_NM;
$headTitle = HOME.'' . SITE_NM;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));
$pageContent = $objHome->getPageContent();



/*$apiPrefix = "https://api.vindecoder.eu/3.1";
$apikey = "5de0829f05e3";   // Your API key
$secretkey = "5baece36b5";  // Your secret key
$id = "decode";
$vin = mb_strtoupper("XXXDEF1GH23456789");

$controlsum = substr(sha1("{$vin}|{$id}|{$apikey}|{$secretkey}"), 0, 10);

$data = file_get_contents("{$apiPrefix}/{$apikey}/{$controlsum}/decode/{$vin}.json", false);
$result = json_decode($data);
echo "<pre>";
print_r($result);
echo "</pre>";
exit;*/


if(isset($_GET['action']) && $_GET['action'] == 'changeEmail'){
	extract($_GET);

	$emailVerifyCode=getTableValue("tbl_users","emailVerifyCode",array("id"=>$id));
	
	if($emailVerifyCode==$activationCode){
		
		if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
			unset($_SESSION["user_id"]);
			unset($_SESSION["user_type"]);
		}

		$acti_key=base64_encode(time());
		$emailVerifyCode=$acti_key;
		$new_email_id=getTableValue("tbl_users","new_email_id",array("id"=>$id));
		
		$db->update("tbl_users", array('emailVerifyCode'=>$emailVerifyCode,"email"=>$new_email_id,"new_email_id"=>"","new_email_status"=>"n"), array("id"=>$id));
		$msgType = $_SESSION["msgType"] = disMessage(array('type'=>'suc','var'=>'Your new email id has been changed.'));
	}
	else{
		$msgType = $_SESSION["msgType"] = disMessage(array('type'=>'err','var'=>'The link has been expired.'));
	}
	redirectPage(SITE_URL);
	exit;	
}


if(isset($_POST['action']) && $_POST['action'] == 'newsletterSubscribe'){
	$response = $objHome->subscribeNewsletter($_POST);
	echo json_encode((array('type'=>$response['status']==true ? 'success' : 'error','message'=>$response['message'])));
	exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'postConctactUs'){

	$response = $objHome->postConctactUs($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);
	exit;
}

if(isset($_POST["language"])&& $_POST["language"]>0){
	$response = $objHome->changeLanguage($_POST);
	exit;
}
if(isset($_POST["currency"])&& $_POST["currency"]>0){
	$response = $objHome->changeCurrency($_POST);
	exit;
}

if(isset($_POST['action']) && ($_POST['action'] == 'getNearByProviders')) {
    $response = array();
    $response = $objHome->getNearByProviders($_POST['latitude'] , $_POST['longitude']);
    $content = $response['retData']['html'];
    echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content ));
    exit;
}
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>