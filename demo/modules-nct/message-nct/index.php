<?php
$reqAuth = true;
$module = 'message-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.message-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(
		array("scroll/jquery.mCustomScrollbar.concat.min.js",SITE_JS),
		//array("nct-js.js",SITE_JS),
		/*array("jquery.easing-1.3.pack.js",SITE_JS),*/
		/*array("jquery.fancybox-1.3.4_patch.js",SITE_JS),*/
		array("jquery.fancybox.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),

	);
/*load script*/

/*load style*/
$styles = array(array("scroll/jquery.mCustomScrollbar.css", SITE_CSS),
				/*array("jquery.fancybox-1.3.4.css", SITE_CSS),*/
				array("jquery.fancybox.css", SITE_CSS)
			);
/*load style*/
/*pri($_REQUEST);*/
$winTitle = INBOX.' - ' . SITE_NM;

$headTitle = INBOX.'' . SITE_NM;

$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));
$pageNo = issetor($pageNo,1);
$searchName = issetor($searchName);
$receiverId = issetor($receiverId,0);

if($_GET['senderType'] == 'mizutech') {
	$receiverId = getTableValue("tbl_users" , "id" , array("mizutech_name" => $_GET['sendername']));
}
$requestArr = array("module"=>$module,'pageNo'=>$pageNo,'searchName'=>$searchName,'receiverId'=>$receiverId);

$objMessage = new Message($requestArr);

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'sendMessage'){

	$response = $objMessage->sendMessage($_POST);
	echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$response['retData'], 'message'=>$response['message'],'callBackUrl' => $response['redirectLink'],'plainMsg'=>$response['plainMsg'],'leftPanel'=>$response['leftPanel']));
	exit;
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getUserList'){
	$response = $objMessage->getLeftPanel($_REQUEST['type']);
	echo json_encode($response);
	exit;
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'deleteMessage'){
	$response = $objMessage->deleteMessage();
	echo json_encode($response);
	exit;
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getRightPanel'){
	$response = $objMessage->getRightPanel();
	echo json_encode($response);
	// redirectPage('https://vishal.vindaloosofttech.com/demo/');
	
	
	exit;
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getMessages'){
	$tab = ($tabType == 'index' ? 'i' : 't');
	$response = $objMessage->getMessages($tab);
	echo json_encode($response);
	exit;
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'readMessages'){
	$response = $objMessage->readMessages();
	echo json_encode($response);
	exit;
}
$pageContent = $objMessage->getPageContent();

require_once DIR_TMPL . "parsing-nct.tpl.php";
?>