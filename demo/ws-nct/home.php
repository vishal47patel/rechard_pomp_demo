<?php

global $langId;
$langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

require_once("../includes-nct/config-nct.php");
require_once ("../modules-nct/home-nct/class.home-nct.php");

$response = array();
$response['status'] = false;
$response['message'] = WENT_WRONG;
extract($_REQUEST);
$module ='home-nct';

$contentArray = array("module" =>$module,'userId'=>$user_id);
$objHome = new Home($contentArray);

if ($_REQUEST['action'] == 'contactUs') {
    $response = $objHome->postConctactUs($_REQUEST);
}else if($_REQUEST['action'] == 'postFeedback'){
    if($user_id > 0){
        $response = $objHome->postFeedback($_REQUEST);
    }else{
        $response['message'] = PLEASE_PROVIDE_VALID_DATA;
    }
}else if($_REQUEST['action'] == 'getCountryCode'){
    $response = $objHome->getCountryCode($_REQUEST);
}else if($_REQUEST['action'] == 'getCMSPages'){
    $_REQUEST['langId']=$langId;
    $response = $objHome->getCMSPages($_REQUEST);
}else if($_REQUEST['action'] == 'getBannerImg'){
    $_REQUEST['langId']=$langId;
    $banner_type = $db->pdoQuery("select file from tbl_banner")->result();
    
    $banner = DIR_UPD . 'banner/' . $banner_type['file'];
    if(!is_file($banner)) {
        $banner = SITE_IMG . 'slider-1.jpg';
    }
    else {
        $banner = SITE_UPD . 'banner/' . $banner_type['file'];
    }
    $arrData=array("banner_link"=>$banner);
    $response = array(
            'redirectLink'  => SITE_URL,
            'status'        => true,
            'message'       => '',
            'data'          => $arrData);
}
else if($action  == 'getNearByProviders'){
	// echo "here";exit;
    if($latitude != '' && $longitude != ''){
		
		if(isset($mileage)){
			$mileage = $mileage;
		}else{
			$mileage = '';
		}
		// echo $mileage;exit;
        $response = $objHome->getNearByProviders($latitude , $longitude , $service_type , $vehicle_type , $pageNo, $mileage);
    }else{
        $response['status'] = false;
        $response['message'] = PLEASE_PROVIDE_VALID_DATA;
    }
}
$response['language_id'] = $langId;
echo json_encode($response);
exit;