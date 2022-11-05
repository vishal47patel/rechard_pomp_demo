<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

    require_once("../includes-nct/config-nct.php");

    $response = array();
    $response['status'] = false;
    $response['message'] = WENT_WRONG;
    extract($_REQUEST);
    if ($_REQUEST['action'] == 'checkDevice') {
        if($device_id != '' && $user_id > 0){
            manageDeviceId($user_id,$device_id);
            $response['status'] = true;
            $response['message'] = DEVICE_REGI_SUC;
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }else if($action == 'cms'){

        $SqlPage = $db->pdoQuery("SELECT * FROM tbl_content WHERE pId != 6 AND isActive = ?",array('y'));
        $Pageres = $SqlPage->affectedRows();
        $pages = $SqlPage->results();
        $response['status'] = true;
        $response['message'] = 'successs';
        $response['pages'][] = "";
        foreach($pages as $key=>$page){
            $response['pages'][$key]['page_id'] = $page['pId'];
            $response['pages'][$key]['pageTitle'] =$page['pageTitle_1'];
            $response['pages'][$key]['page_or_url'] = (($page['linkType']=='url') ? 'u' : 'p');
            $response['pages'][$key]['pageContent'] = (($page['linkType']=='url') ?  $page['url'] : $page["pageDesc_1"]);
        }

    }
    else if ($_REQUEST['action'] == 'getSearchRadius') {

        $response['status'] = true;
        $response['message'] = 'success';        
        $response['data'] = array("search_radius" => NEARBY_RADIUS);

    }
    else if ($_REQUEST['action'] == 'getMizutechDetails') {
        if($user_id > 0){
            $response['status'] = true;
            $response['message'] = 'success';       

            global $db;
            $mizutechDetails =  $db->pdoQuery("SELECT mizutech_name , mizutech_pwd FROM tbl_users WHERE id = ?" , array($user_id))->result();

            $response['data'] = array("mizutech_name" => $mizutechDetails['mizutech_name'] , "mizutech_pwd" => $mizutechDetails['mizutech_pwd']);
        }else{
            $response['status'] = false;
            $response['message'] = PLEASE_PROVIDE_VALID_DATA;
        }
    }
    else if ($_REQUEST['action'] == 'checkUniqueName') {
        if(checkUniqueName($_REQUEST['firstName'],$_REQUEST['lastName'],$_REQUEST['user_id'])){
                $response['status'] = false;
        }else{
                $response['status'] = true;
        }
        $response['message'] = "";        
    }
$response['data']['language_id'] = $langId;
echo json_encode($response);
exit;