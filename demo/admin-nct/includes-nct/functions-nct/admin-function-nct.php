<?php
function getLoggedinName() {
	global $db, $adminUserId;
	$qrysel = $db->select("uName","id=".$adminUserId."");
	$fetchUser = mysql_fetch_object($qrysel);
	return trim(addslashes(ucwords($fetchUser->uName)));
}

//check Admin Permission
function chkPermission($module){
	global $db, $adminUserId;
	//"permissions",
	$admSl = $db->select("tbl_admin", array("adminType"), array("id ="=>(int)$adminUserId))->result();
	if(!empty($admSl)){
		$adm = $admSl;
		//echo $adm['adminType']; exit;
		if($adm['adminType'] == 'g'){
			$moduleId = $db->select("tbl_adminrole", array("id"), array("pagenm ="=>(string)$module))->result();
			$chkPermssion = $db->select("tbl_admin_permission", array("permission"), array("admin_id"=>(int)$adminUserId,"page_id"=>$moduleId['id'])," AND FIND_IN_SET('1',permission)")->result();
			if(empty($chkPermssion['permission'])){
				$toastr_message = $_SESSION["toastr_message"] = disMessage(array('type'=>'err','var'=>'NoPermission'));
				redirectPage(SITE_ADM_MOD.'home-nct/');
			}
		}
	}
}

function add_admin_activity($activity_array=array()){
	global $db,$adminUserId;
	$admSl = $db->select("tbl_admin", array("adminType"), array("id ="=>(int)$adminUserId))->result();
	if($admSl['adminType'] == 'g'){


		//mail to super admin
		$to =  SUPER_ADMIN_EMAIL; //"purvi.pandya@ncrypted.com";
		$greetings = SUPER_ADMIN;
		$subject = 'Subadmin activity in '.SITE_NM;

		$information = "Module : ".$activity_array['module']."<br/>";
		$information .= "Activity : ".$activity_array['activity']."<br/>";
		$information .= "Id : ".$activity_array['id']."<br/>";

		$arrayCont = array(
		    'greetings' => $greetings,
		    'ADMIN_NM' => $_SESSION["uName"],
		    'INFORMATION' => $information
		);

		$array = generateEmailTemplate('subadmin_activity', $arrayCont);
		//sendEmailAddress($to, $array['subject'], $array['message']);

		$activity_array['id'] = (isset($activity_array['id']))?$activity_array['id']:0;
		$activity_array['module'] = (isset($activity_array['module']))?getTableValue('tbl_adminrole','id',array("pagenm"=>$activity_array['module'])):0;
		$activity_array['activity'] = (isset($activity_array['activity']))?getTableValue('tbl_subadmin_action','id',array("constant"=>$activity_array['activity'])):0;
		$activity_array['action'] = (isset($activity_array['action']))?$activity_array['action']:'';
		$activity_array['created_date'] = date('Y-m-d H:i:s');
		$activity_array['updated_date'] = date('Y-m-d H:i:s');


		$val_array = array("activity_type"=>$activity_array['activity'],"page_id"=>$activity_array['module'],"admin_id"=>$adminUserId,"entity_id"=>$activity_array['id'],"entity_action"=>$activity_array['action'],"created_date"=>$activity_array['created_date'],"updated_date"=>$activity_array['updated_date']);
		$db->insert('tbl_admin_activity',$val_array);
	}
}


function chkModulePermission($module){
	global $db, $adminUserId;
	//"permissions",
	$permissions = array();
	$admSl = $db->select("tbl_admin", array("adminType"), array("id ="=>(int)$adminUserId))->result();

	if(!empty($admSl)){
		$adm = $admSl;
		//echo $adm['adminType']; exit;
		if($adm['adminType'] == 'g'){
			$moduleId = $db->select("tbl_adminrole", array("id"), array("pagenm ="=>(string)$module))->result();
			$chkPermssion = $db->select("tbl_admin_permission", array("permission"), array("admin_id"=>(int)$adminUserId,"page_id"=>$moduleId['id'],"and permission !="=>""))->result();
			if(!empty($chkPermssion['permission'])){
				$qryRes = $db->pdoQuery("select id,constant from tbl_subadmin_action where id in (".$chkPermssion['permission'].")")->results();
				foreach($qryRes as $fetchRes){
					$permissions[] = $fetchRes["constant"];
				}
			}
		}else{
			$qryRes = $db->select("tbl_subadmin_action", array("id,constant"), array())->results();
			foreach($qryRes as $fetchRes){
				$permissions[] = $fetchRes["constant"];
			}
		}
	}
	return $permissions;
}


// Get Section wise Role Array
function getSectionRoleArray($flag=false) {
	global $db, $adminUserId;
	$arr[]=array();
	$type = '';
	$res1=$db->select('tbl_admin','id,adminType,permissions','id='.$adminUserId, NULL, NULL);
	$res1Fetch = mysql_fetch_object($res1);
	$permission = $res1Fetch->permissions!='' ? $res1Fetch->permissions : 0;

	$res=$db->select('tbl_adminsection','id,type,section_name', NULL, NULL, '`order` ASC');
	if(mysql_num_rows($res)>0) {
		$i=0;
		while($row=mysql_fetch_array($res)) {
			$per_wh_con = '';
			if($res1Fetch->adminType == 'g')
				$per_wh_con=($permission!='0')?(' AND id IN('.str_replace('|',',',$permission.')')):'';
			$status_wh=($res1Fetch->adminType == 's' && $flag == false) ?  " status IN ('a','s')":"status='a'";
			$qry_role="sectionid='".$row['id']."' AND ".$status_wh.$per_wh_con;
			$res_role=$db->select('tbl_adminrole','id,title,pagenm,image', $qry_role, NULL, '`seq` ASC', 0);
			if($tot=mysql_num_rows($res_role)>0) {
				$temp=$j=0;
				while($row_role=mysql_fetch_array($res_role)) {
					$arr[$i]['id']=$row_role['id'];
					$arr[$i]['text']=$row_role['title'];
					$arr[$i]['pagenm']=$row_role['pagenm'];
					$arr[$i]['image']=$row_role['image'];
					if($j==0) {
						$arr[$i]['optlbl']=$row['section_name'];
						$temp=$row['id'];$j++;
					} else if($j==($tot-1)) {
						$j=0;
					}
					$i++;
				}
			}
		}
	}
	return $arr;
}
function makeConstantFile($default_lang=0,$insertId=0){
	global $db, $adminUserId;
	if($default_lang > 0 && $insertId > 0){
		$qrysel1 = $db->select("tbl_language", "*",array("default_lan"=>"y"),"", "", 0)->results();
		foreach($qrysel1 as $fetchSel){
			$fp = fopen(DIR_INC. "language-nct/".$insertId.".php","wb");
			$content = '';
			$qsel1 = $db->select("tbl_constant","*",array("languageId"=>$fetchSel['id']))->results();
			$content.='<?php ';
			foreach($qsel1 as $fetchSel1){
				$content.= ' define("'.$fetchSel1['constantName'].'","'.filtering($fetchSel1['constantValue'],'output','string').'"); ';
			}
			$content.=' ?>';
			fwrite($fp,$content);
			fclose($fp);
			 /*for javascript*/

			$js_filePath = DIR_INC . "language-nct/js/" .$insertId . ".js";
			if (is_file($js_filePath)) {
				unlink($js_filePath);
			}

			$js_fp      = fopen($js_filePath, (file_exists($js_filePath)) ? 'a' : 'w');
			$js_content = '';

			$js_content .= 'var lang = { ';
			foreach ($qsel1 as $fetchSel1) {
				$js_content .= $fetchSel1['constantName'] . ' : "' . trim(preg_replace('/\s+/', ' ', $fetchSel1['constantValue'])) . '", ';
			}
			$js_content .= ' };';
			fwrite($js_fp, $js_content);
			fclose($js_fp);
		}
	}else{
		$jsfiles = glob(DIR_INC.'language-nct/js/*');
		foreach($jsfiles as $file){
		  if(is_file($file))
			unlink($file);
		}

		$files = glob(DIR_INC.'language-nct/*');
		foreach($files as $file){
		  if(is_file($file))
			unlink($file);
		}
		$qrysel1 = $db->select("tbl_language", "*",array(),"", "", 0)->results();
		foreach($qrysel1 as $fetchSel){
			$fp = fopen(DIR_INC. "language-nct/".$fetchSel['id'].".php","wb");
			$content = '';
			$qsel1 = $db->pdoQuery("select * from tbl_constant")->results();

			$content.='<?php ';
			 $value_data='value_'.$fetchSel['id'];

			foreach($qsel1 as $fetchSel1){
				 $content.= ' define("'.$fetchSel1['constantName'].'","'.$fetchSel1[$value_data].'"); ';
					//$content.= "\r\n";
			}
			$content.=' ?>';
			fwrite($fp,$content);
			fclose($fp);
			 /*for javascript*/

			$js_filePath = DIR_INC . "language-nct/js/" . $fetchSel['id'] . ".js";
			if (is_file($js_filePath)) {
				unlink($js_filePath);
			}

			$js_fp      = fopen($js_filePath, (file_exists($js_filePath)) ? 'a' : 'w');
			$js_content = '';
			$value_data='value_'.$fetchSel['id'];

			$js_content .= 'var lang = { ';
			foreach ($qsel1 as $fetchSel1) {
				$js_content .= $fetchSel1['constantName'] . ' : "' . trim(preg_replace('/\s+/', ' ', $fetchSel1[$value_data])) . '", ';
			}
			$js_content .= ' };';
			fwrite($js_fp, $js_content);
			fclose($js_fp);
		}
	}



}
function mysql_get_prim_key($table){
	global $db;
	$sql = "SHOW INDEX FROM $table WHERE Key_name = 'PRIMARY'";
	$gp = mysql_query($sql);
	$cgp = mysql_num_rows($gp);
	$cgp=$db->pdoQuery($sql)->result();
	if(count($cgp) > 0){
		$Column_name=$cgp['Column_name'];
//	extract($agp);
		return($Column_name);
	}else{
	//return(false);
		return '';
	}
}

function searchInMultidimensionalArray($array, $key, $value) {

	$response = array();
	$response['status'] = false;

	foreach ($array as $main_key => $val) {
		if ($val[$key] == $value) {
			$response['status'] = true;
			$response['key'] = $main_key;

			return $response;
		}
	}

	return $response;
}


function getAdminUnreadNotificationsCount()
{
	global $db, $adminUserId;

	$get_notifications_count = $db->pdoQuery("SELECT COUNT(*) as notifications_count FROM tbl_admin_notifications WHERE admin_id = " . $adminUserId . " AND is_read = 'n'")->result();
	return $get_notifications_count['notifications_count'];
}

function getAllNotificationsAdmin($limit = 5, $offset = 0, $listing_type = 'general')
{
	global $db, $adminUserId;

	$query = "SELECT *
	FROM tbl_admin_notifications
	WHERE admin_id = " . filtering($adminUserId, 'input', 'int') . "
	ORDER BY id DESC LIMIT $offset, $limit";

	$get_notifications = $db->pdoQuery($query)->results();

	if ($get_notifications) {
		if($listing_type == 'notifications-nct'){
			$notification = new MainTemplater(DIR_ADMIN_TMPL . $listing_type . "/single-notification-nct.tpl.php");

		}else{
			$notification = new MainTemplater(DIR_ADMIN_TMPL . "/notification-li-nct.tpl.php");

		}
		$notification_parsed = $notification->parse();

		$field = array(
			'%NOTIFICATION%',
			'%NOTIFICATION_URL%',
			'%NOTIFICATION_TITLE%',
			'%NOTIFICATION_DATE%',
			'%TIME_AGO%',
		);
		$counter      = 0;
		$final_result = null;
		foreach ($get_notifications as $notification) {

			$notification_date = date("d M, Y", strtotime($notification['createdDate']));
			$response          = get_time_difference($notification['createdDate'], date("Y-m-d H:i:s"));

			if ($response['days']) {
				$time_ago = $response['days'] . " Days ago";
			} else if ($response['hours']) {
				$time_ago = $response['hours'] . " Hours ago";
			} else if ($response['minutes']) {
				$time_ago = $response['minutes'] . " Mins ago";
			} else if ($response['seconds']) {
				$time_ago = $response['seconds'] . " Secs ago";
			}

			$type = $notification['type'];
			//type: new_user, dispute, new_project, contact_us

			switch ($type) {
				case 'new_user' : {
					$user_details = $db->select("tbl_users", "*", array("id" => $notification['entity_id']))->result();
					$notification_text = "New user ".$user_details['firstName']."  has been registered.";
					$notification_url = SITE_ADM_MOD . "users-nct";
					$notification_title = "New user registered.";
					break;
				}
				case 'contact_us' : {
					$notification_text = "User sent a message on Contact Us.";
					$notification_url = SITE_ADM_MOD . "contactus-nct";
					$notification_title = "New Contact us message.";
					break;
				}
				case 'user_reported' : {
					$notification_text = "New user is reported";
					$notification_url = SITE_ADM_MOD . "reported_user-nct";
					$notification_title = "User reported.";
					break;
				}
				case 'new_ride' : {
					$user_details = $db->select("tbl_users", "*", array("id" => $notification['entity_id']))->result();
					$notification_text = $user_details['firstName']." added new ride.";
					$notification_url = SITE_ADM_MOD . "view_rides-nct";
					$notification_title = "New ride added.";
					break;
				}
				case 'ride_payment_done' : {
					$user_details = $db->select("tbl_users", "*", array("id" => $notification['entity_id']))->result();
					$notification_text = "Ride payment done by user.";
					$notification_url = SITE_ADM_MOD . "manage_ride_payments-nct";
					$notification_title = "Ride payment.";
					break;
				}
				case 'payment_not_done' : {
					$notification_text = "Ride request accepted by driver but, payment was not completed by customer.";
					$notification_url = SITE_ADM_MOD . "manage_ride_payments-nct";
					$notification_title = "Ride payment pending.";
					break;
				}

				case 'ride_cancel_by_customer' : {
					$notification_text = "Ride cancelled by customer.";
					$notification_url = SITE_ADM_MOD . "manage_ride_payments-nct";
					$notification_title = "Ride cancelled.";
					break;
				}
				case 'ride_cancel_by_driver' : {
					$notification_text = "Ride cancelled by Driver.";
					$notification_url = SITE_ADM_MOD . "manage_ride_payments-nct";
					$notification_title = "Ride cancelled.";
					break;
				}
				case 'feedback' : {
					$notification_text = "New feedback received";
					$notification_url = SITE_ADM_MOD . "feedback-nct";
					$notification_title = "Feedback received.";
					break;
				}
				default :{
					$notification_text = "New notification received";
					$notification_url = "javascript:void(0)";
					$notification_title = "New notification .";
				}

			}
			$field_replace = array(
				filtering($notification_text),
				filtering($notification_url),
				filtering($notification_title),
				$notification_date,
				$time_ago,
			);

			$final_result .= str_replace($field, $field_replace, $notification_parsed);
			//$db->update("tbl_admin_notifications", array("is_notified" => 'y'), array("id" => $notification['id']));
			$counter++;
		}
	} else {
		if($listing_type != 'notifications-nct'){
			$final_result = '<li id="no_notification"> <p>No new notification.</p> </li>';
		}else{
			$final_result = "";
		}

	}

	return $final_result;
}


?>
