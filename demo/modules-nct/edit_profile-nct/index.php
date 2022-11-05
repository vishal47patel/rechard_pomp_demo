<?php
$reqAuth = true;
$module = 'edit_profile-nct';
require_once "../../includes-nct/config-nct.php";
require_once "class.edit_profile-nct.php";

extract($_REQUEST);

/*load script*/
$scripts = array(        	
        	array("cropper-master/dist/cropper.js",SITE_PLUGIN),
                array("bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js",SITE_PLUGIN),
        	array($module.".js", SITE_JS_MOD));
/*load script*/
$styles = array(		
                array("bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.css",SITE_PLUGIN),
		array("cropper-master/dist/cropper.css",SITE_PLUGIN));


$winTitle = EDIT_PROFILE.' - ' . SITE_NM;
$headTitle = EDIT_PROFILE;
$metaTag = getMetaTags(array("description" => $winTitle, "keywords" => $headTitle, "author" => AUTHOR));
$contentArray = array('module'=>$module);
$obj = new edit_profile($contentArray);

if(isset($_POST['method']) && $_POST['method'] == 'checkUniqueName') {
        if(checkUniqueName($_POST['firstName'],$_POST['lastName'],$sessUserId)){
                echo 'true';
        }else{
                echo 'false';
        }exit;
}

if(isset($_POST['method']) && $_POST['method'] == 'checkValidate' && isset($_POST['contactNo']) && $_POST['contactNo'] != '') {
        if(isExist($_POST['contactNo'],'contactNo',true,$sessUserId)){
                echo 'true';
        }else{
                echo 'false';
        }
        exit;
}

if(isset($_POST['method']) && $_POST['method'] == 'checkValidate' && isset($_POST['paypalEmail']) && $_POST['paypalEmail'] != '') {
        if(isExist($_POST['paypalEmail'],'paypalEmail',true,$sessUserId)){
                echo 'true';
        }else{
                echo 'false';
        }
        exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'checkProfileImg') {
        echo $obj->isUserProfileSet();
        exit;
}

if(isset($_FILES['cropped_image']) && $_FILES['cropped_image']['name'] != ''){

        $upload_dir=DIR_UPD.'profile/'.$sessUserId.'/';
        if(!file_exists($upload_dir))
        {
                mkdir($upload_dir,0777);
        }

        $newName = rand().time().'.png';
        /* Remove old profile pics of particular user */
        deletefile($upload_dir,array($newName));

        $destination = DIR_UPD."profile/".$sessUserId.'/'.$newName;
        $cropped = $_FILES["cropped_image"]["tmp_name"];

        $thumbnailArray = array();
        $thumbnailArray[0] = array('newWidth'=>100,'newHeight'=>100);
        $thumbnailArray[1] = array('newWidth'=>265,'newHeight'=>265);
        
        uploadImagewithResize($upload_dir,$destination,$cropped,$newName,$thumbnailArray);
        convertToWebP($upload_dir.'th1_'.$newName);
        convertToWebP($upload_dir.'th2_'.$newName);

        $dataArr = array("profileImg" => $newName);
        $dataWhere = array("id" => $sessUserId);
        $db->update('tbl_users', $dataArr, $dataWhere);
        echo json_encode((array('type'=>'success','text'=>PROFILE_PIC_UPDATED,"imageURL"=>checkImage('profile/'.$sessUserId.'/th2_'.$newName , "" , "mainImage") ,"smallImageURL"=>checkImage('profile/'.$sessUserId.'/th1_'.$newName , "" , "mainImage"))));
        exit;
}

if(isset($_POST['btnEditProfile'])){
	$response = $obj->submitUpdateProfile($_POST);
	$_SESSION["msgType"] = disMessage(array('type'=>$response['status'] == true ? 'suc' : 'err','var'=>$response['message']));
	redirectPage($response['redirectLink']);exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'setAvailabilityById'){
    
    $response = $obj->setAvailabilityById($_POST);    
    echo json_encode($response);
    exit;
}
if(isset($_POST['action']) && $_POST['action'] == 'setAvailability'){
    
    $response = $obj->setAvailability($_POST);    
    echo json_encode($response);
    exit;
}
if(isset($_POST['action']) && $_POST['action'] == 'setManualAvailability'){
    
    $response = $obj->setManualAvailability($_POST);    
    echo json_encode($response);
    exit;
}
if(isset($_POST['action']) && $_POST['action'] == 'setTaxiAvailability'){
    
    $response = $obj->setTaxiAvailability($_POST);    
    echo json_encode($response);
    exit;
}

$pageContent = $obj->getPageContent();
require_once DIR_TMPL . "parsing-nct.tpl.php";
?>