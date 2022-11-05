<?php
$reqAuth = false;
$module = 'profile-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.profile-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(
		array("nct-js.js",SITE_JS),
		array($module.".js", SITE_JS_MOD),
		array("owl.carousel.min.js",SITE_JS),
    );
/*load script*/
$styles = array(
		array("owl.carousel.min.css",SITE_CSS),
);


$winTitle = MY_PROFILE.' - ' . SITE_NM;
$headTitle = MY_PROFILE;

$uId = issetor($userId,0);

$userData = $db->pdoQuery("SELECT u.* FROM tbl_users as u 		
		WHERE u.id = ?",array($uId))->result();

$firstName = filtering($userData['firstName'],'output','string');
$lastName = filtering($userData['lastName'],'output','string');
$business_details = filtering($userData['business_details'],'output','string');
$userImage = checkImage('profile/'.$uId.'/th2_',$userData['profileImg'], "mainImage");

$metaTag = getMetaTags(array("description" => $winTitle, 
	"keywords" => $headTitle, 
	"author" => AUTHOR,
	"og:title" => $firstName . ' ' . $lastName,
	"og:description" => $business_details,
	"og:image" => $userImage
));

$requestArr = array('module'=>$module,'userId'=>$uId);
$obj = new profile($requestArr);

$userId = $sessUserId;

if(isset($_GET['userId']) && $_GET['userId'] != ''){

	if(!isUserExist($_GET['userId'])){
		$_SESSION["msgType"] = disMessage(array('type'=>'error','var'=>NO_USER_FOUND));
		redirectPage(SITE_URL);
	}

	$userId = $_GET['userId'];
}

if(isset($_POST['action']) && $_POST['action'] == 'changeAvailability'){
    extract($_POST);

    $response = $obj->changeAvailability($_POST);
    $_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
    redirectPage($response['redirectLink']);
}

if(isset($_POST['action']) && $_POST['action'] == 'add_status'){
    extract($_POST);

    $response = $obj->addStatus($_POST);    
    echo json_encode($response);
    exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'add_opening_hours'){
    extract($_POST);

    $response = $obj->addOpeningHours($_POST);    
    echo json_encode($response);
    exit;
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ajaxPagination'){
	$response = $obj->getReviewList();
	$content = $response['retData']['html'];
	$pageContent = $response['retData']['pagination'];
	echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'pageContent'=>$pageContent,'success'=>true ));
	exit;
}
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'serviceAjaxPagination'){
	$response = $obj->getServiceList();
	$content = $response['retData']['html'];
	$pageContent = $response['retData']['pagination'];
	echo json_encode(array('type'=>$response['status']==true ? 'success' : 'error','content'=>$content,'pageContent'=>$pageContent,'success'=>true ));
	exit;
}

$pageContent = $obj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>