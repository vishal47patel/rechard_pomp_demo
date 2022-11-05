<?php

    global $langId;
    $langId = isset($_REQUEST['language_id']) ? $_REQUEST['language_id'] : 1;

	require_once("../includes-nct/config-nct.php");
	//require_once ("../modules-nct/search-nct/class.search-nct.php");

	$response = array();
	$response['status'] = false;
	$response['message'] = WENT_WRONG;
	extract($_REQUEST);
	/*$module ='search-nct';
	$pageNo = issetor($pageNo,1);
	$contentArray = array("module" =>$module,'userId'=>$user_id,'pageNo'=>$pageNo);
	$objsearch = new search($contentArray);*/
	$response['data'] = array();



	if ($_REQUEST['action'] == 'getAllLanguage') {

		$languagelist = $db->pdoQuery("SELECT * FROM tbl_language WHERE status =  ? ORDER BY languageName",array("a"))->results();
		$response['status'] = true;
        $response['message'] = 'success';
		foreach ($languagelist as $langData) {
			$response['data'][] = array(
				'id'				=> $langData['id'],
				'languageName'		=> $langData['languageName'],
				//'langflag'			=> $langData['langflag'],
				'default_lan'		=> $langData['default_lan'],
				'url_constant'		=> $langData['url_constant'],
			);
		}
	}
	else if ($_REQUEST['action'] == 'getConstans') {

		$languagelist = $db->pdoQuery("SELECT * FROM tbl_constant WHERE (status='a' OR status='b' OR status='w') ORDER BY id")->results();
		$response['status'] = true;
        $response['message'] = 'success';
		foreach ($languagelist as $langData) {
			$data[$langData['constantName']] = $langData['value_'.$langId];
		}
		$response['data'] = $data;

	}else if ($_REQUEST['action'] == 'changeLanguage') {

		$user_id 		= isset($_REQUEST['user_id']) 		? (int)$_REQUEST['user_id'] 	: 0;
		$langage_id 	= isset($_REQUEST['langage_id']) 	? (int)$_REQUEST['langage_id']  : 0;
		$checkLanguage  = getTableValue('tbl_language' , 'id' , array('status' => 'a' , 'id' => $langage_id));
		if($checkLanguage > 0 && $langage_id > 0 && $user_id > 0){
			$q = $db->pdoQuery("UPDATE tbl_users SET defLanguage = ? WHERE id = ?",array($langage_id,$user_id));
			if($q->affectedRows() > 0){
				$response['status'] = true;
	        	$response['message'] = LANGUAGE_CHANGED;
			}
		}
		else{
			$response['message'] = PLEASE_PROVIDE_VALID_DATA;
		}
	}

$response['language_id'] = $langId;

echo json_encode($response);
exit;