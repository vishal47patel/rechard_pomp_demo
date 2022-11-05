<?php
//create user account in mizutech site
function createMizutechUserAcc($data=array()){
    global $db;
	extract($data);
    //print_r($data);exit;
	$curl = curl_init();

	curl_setopt_array($curl, array(
	// vspl changes 26-06-2022
	  // CURLOPT_URL => "http://sip.autoservice.ltd/mvapireq/?apientry=newuseru&authkey=97275263&u_username=".$u_username."&u_password=".$u_password."&u_name=".$u_name."&u_email=".$u_email."&u_phone=".$u_phone."&u_currency=USD&u_country=USA&u_address=x&deviceid=DEVICEID&now=555&newuseru_maxperipperday=50",
	  CURLOPT_URL => "https://vishal.vindaloosofttech.com/demo/mvapireq/?apientry=newuseru&authkey=97275263&u_username=".$u_username."&u_password=".$u_password."&u_name=".$u_name."&u_email=".$u_email."&u_phone=".$u_phone."&u_currency=USD&u_country=USA&u_address=x&deviceid=DEVICEID&now=555&newuseru_maxperipperday=50",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_POSTFIELDS => "",
	  CURLOPT_HTTPHEADER => array(
	    "Postman-Token: 0e2433e6-5456-4db0-93ae-9321779a6181",
	    "cache-control: no-cache"
	  ),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	//print_r($response);exit;
	if($response=="OK: user added"){
		return true;	
	}else{
	    return false;
	}
}


//generate mizutech username
function mizutechUsername(){
	global $db;
	$mizutech_name=genrateRandom(10);

	$qrySel = $db->pdoQuery('SELECT id FROM tbl_users WHERE mizutech_name = "'.$mizutech_name.'" ')->affectedRows();

	if($qrySel > 0){
		mizutechUsername();
	}else{
		return $mizutech_name;
	}

}

function prepare_time_slots(){
     
    $time_slots = "";
    $start_time    = strtotime("00:00"); //change to strtotime
    $end_time      = strtotime("23:59"); //change to strtotime
     
    $add_mins  = 60 * 60;
     
    for ($i = 1; $start_time <= $end_time; $i++) // loop between time
    {
       $time1 = date("H:i", $start_time);
       $start_time += $add_mins;
       $time2 = date("H:i", $start_time);

       $time_slots .= "<option value='".$i."'>".$time1 . " - " . $time2 ."</option>";
    }

    return $time_slots;
}
function getSlotFromId($slotId = '') {
	$slotName = '';
	if($slotId != '') {
		$start_time = strtotime("00:00");

		$time1 = date("H:i", $start_time + ( ($slotId - 1) * 60 * 60));
		$time2 = date("H:i", $start_time + ($slotId * 60 * 60));

		$slotName = $time1 . " - " . $time2;
	}

	return $slotName;
}
function getSocialLinks($user_id=0,$social_type=''){
    global $db;
   	$sql          = "SELECT firstName,lastName,profileImg FROM tbl_users WHERE id = '".$user_id."' ";
    $res = $db->pdoQuery($sql)->result();
    extract($res);
    $profile_link=SITE_URL.'profile/'.$user_id;
    $user_name=$firstName.' '.$lastName;
    if($social_type=='f'){
        //$user_img=checkImage('profile/'.$user_id.'/th2_'.$profileImg);
        $user_img = checkImage('profile/'.$user_id.'/th2_',$profileImg, "mainImage");

        $facebook_link="http://www.facebook.com/sharer.php?s=100&p[url]=".urlencode($profile_link)."&p[images][0]=".urlencode($user_img)."&p[title]=".urlencode($user_name);    
        /*."&p[summary]=".urlencode($description)*/
        return $facebook_link;
    }
    
    if($social_type=='t'){
        $twitter_link = "http://twitter.com/share".'?text=' . urlencode($user_name) . '+-' .'&amp;url=' . urlencode($profile_link);
        return $twitter_link;
    }

    if($social_type=='i'){
        $insta_link = "https://www.instagram.com/sharer.php?u=".urlencode($profile_link);
        return $insta_link;
    }

    if($social_type=='g'){
        $google_link = "https://plus.google.com/share?url=".urlencode($profile_link);
        return $google_link;
    }
    if($social_type=='l'){
        $linkedin_link = "https://www.linkedin.com/shareArticle?mini=true&url=".urlencode($profile_link)."&title=".urlencode($user_name)."&source=LinkedIn";
        /*"&summary=".urlencode($description).*/
        return $linkedin_link;
    }
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function convertToWebP($file = '') {    
    $image = imagecreatefromstring(file_get_contents($file));
    ob_start();
    imagejpeg($image,NULL,100);
    $cont = ob_get_contents();
    ob_end_clean();
    imagedestroy($image);
    $content = imagecreatefromstring($cont);

    $pathInfo = pathinfo($file);
    $output = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
    imagewebp($content,$output);
    imagedestroy($content);
}
function redirectPage($url) {
	header('Location:' . $url);
	exit;
}

/*
 * returns parsed html if array not provided then returns without replacing variables
 * format for $replace array
 * $replace = array(
 *  '%variable1%' => $value1,
 *  '%variable2%' => $value2,
 *  '%variable3%' => $value3,
 *  '%variable4%' => $value4,
 * );
 */
function get_view($tpl_path, $replace = array()){
	$tpl        = new MainTemplater($tpl_path);
	$parsed_tpl = $tpl->parse();
	if (!empty($replace)) {

		return str_replace(array_keys($replace), array_values($replace), $parsed_tpl);
	} else {
		return $parsed_tpl;
	}
}

function recaptchaVerify($data = ''){
	$secret = GOOGLE_RECAPTCHA_SECRET_KEY;
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$data);

	$responseData = json_decode($verifyResponse);
	if($responseData->success){
		return true;
	}else{
		return false;
	}
}

function isExist($variable = '',$type = '',$wo = false,$user_id = ''){
	global $db;

	if($wo == true){
		$condition = 'AND id != '.$user_id;
	}else{
		$condition = '';
	}

	$qrySel = $db->pdoQuery('SELECT id FROM tbl_users WHERE isActive != "r" AND '.$type.' = ? '.$condition.' ',array($variable))->affectedRows();

	if($qrySel > 0){
		return false;
	}else{
		return true;
	}
}

function checkUniqueName($firstName = '',$lastName = '',$user_id = ''){
	global $db;

	if($user_id != ''){
		$condition = 'AND id != '.$user_id;
	}else{
		$condition = '';
	}

	$qrySel = $db->pdoQuery('SELECT id FROM tbl_users WHERE isActive != "r" AND firstName = "'.$firstName.'" AND lastName = "'.$lastName.'" '.$condition)->affectedRows();

	if($qrySel > 0){
		return false;
	}else{
		return true;
	}
}

function fetchUserImage($user_id = ''){
	global $db;

	$qrySel = $db->pdoQuery('SELECT profileImg FROM tbl_users WHERE id = ? ',array($user_id))->result();

	if(!empty($qrySel)){
		return $qrySel['profileImg'];
	}else{
		return false;
	}
}

function isPasswordValid($user_id = '',$password = ''){
	global $db;

	$qrySel = $db->pdoQuery('SELECT id FROM tbl_users WHERE id = ? AND password = ?',array($user_id,md5($password)))->affectedRows();

	if($qrySel > 0){
		return true;
	}else{
		return false;
	}
}

function isUserExist($userId = ''){
	global $db;

	$qrySel = $db->pdoQuery('SELECT id FROM tbl_users WHERE id = ? AND isActive = "y" AND isEmailVerify = "y"',array($userId))->affectedRows();

	if($qrySel > 0){
		return true;
	}else{
		return false;
	}
}

function renderStarRating($rating, $maxRating = 5){
	$fullStar = '<li><a href="javascript:void(0);"><i class="fas fa-star"></i></a></li>';
	$halfStar = '<li><a href="javascript:void(0);"><i class="fas fa-star-half-alt"></i></a></li>';
	$emptyStar = '<li><a href="javascript:void(0);"><i class="far fa-star"></i></a></li>';

	$rating = $rating <= $maxRating ? $rating : $maxRating;

	$fullStarCount  = (int) $rating;
	$halfStarCount  = ceil($rating) - $fullStarCount;
	$emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

	$html = str_repeat($fullStar, $fullStarCount);
	$html .= str_repeat($halfStar, $halfStarCount);
	$html .= str_repeat($emptyStar, $emptyStarCount);

	return $html;
}

function checkNotiEnable($user_id = '',$type = ''){
	global $db;

	$qrySel = $db->pdoQuery("SELECT id FROM tbl_email_notification_setting WHERE userId = ? AND $type = 'y'",array($user_id))->affectedRows();

	if($qrySel > 0){
		return true;
	}else{
		return false;
	}
}

/* Upload any image and resize with full scale image including transparency*/
function uploadImagewithResize($uploadDir = '',$destination = '',$tmpFileName = '',$fileName = '',$thumbnailArray = array()){

	if(!file_exists($uploadDir))
	{
		mkdir($uploadDir,0777);
	}

	copy($tmpFileName, $destination);
	convertToWebP($destination);

	/* Generate Thumbnail based on Heigth/Width*/
	if(!empty($thumbnailArray)){
		for($i=0;$i<count($thumbnailArray);$i++){

			$copyFileName = $uploadDir.'th'.($i+1).'_'.$fileName;

			if (!copy($destination, $copyFileName)) {
				echo "Failed to Generate New Thumbnail";
				return false;
			}

			$fileExtension = strtolower(getExt($copyFileName));
			$fileInfos = getimagesize($copyFileName);

			if ($fileInfos['mime'] == "image/jpeg" OR $fileInfos['mime'] == "image/jpg") {
				$img = imagecreatefromjpeg($copyFileName);
			} else if ($fileInfos['mime'] == "image/png") {
				$img = imagecreatefrompng($copyFileName);
			} else if ($fileInfos['mime'] == "image/gif") {
				$img = imagecreatefromgif($copyFileName);
			} else {
				$img = imagecreatefromjpeg($copyFileName);
			}

			list($width, $height) = getimagesize($copyFileName);

			$thumb = imagecreatetruecolor($thumbnailArray[$i]['newWidth'], $thumbnailArray[$i]['newHeight']);

			imagealphablending($thumb, false);
			imagesavealpha($thumb,true);
			$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
			imagefilledrectangle($thumb, 0, 0, $thumbnailArray[$i]['newWidth'], $thumbnailArray[$i]['newHeight'], $transparent);

			imagecopyresampled($thumb, $img, 0, 0, 0, 0, $thumbnailArray[$i]['newWidth'], $thumbnailArray[$i]['newHeight'], $width, $height);

			if ($fileInfos['mime'] == "image/jpeg" OR $fileInfos['mime'] == "image/jpg") {
				$createImageSave = imagejpeg($thumb, $copyFileName, 90);
			} else if ($fileInfos['mime'] == "image/png") {
				$createImageSave = imagepng($thumb, $copyFileName, 9);
			} else if ($fileInfos['mime'] == "image/gif") {
				$createImageSave = imagegif($thumb, $copyFileName, 90);
			} else {
				$createImageSave = imagejpeg($thumb, $copyFileName, 90);
			}
		}
	}
}

/* delete useless files of directory */
function deletefile($path = '',$filesToKeep = array(),$extensionsToKeep = array()){
	$dirList = glob($path . '*');

	foreach ($dirList as $file) {

		if (!in_array($file, $filesToKeep)) {
			if (is_dir($file)) {
				rmdir($file);
			} else {
				$fileExtArr = explode('.', $file);
				$fileExt = $fileExtArr[count($fileExtArr)-1];
				if(!in_array($fileExt, $extensionsToKeep)){
					unlink($file);
				}
			}//END IF
		}//END IF
	}
	return true;
}

/* Santitize Output */
function sanitize_output($buffer) {

	$search  = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s');
	$replace = array('>', '<', '\\1', '');
	$buffer  = preg_replace($search, $replace, $buffer);
	return $buffer;
}

/* Use to remove whitespacs,Spaces and make string to lower case. Add '-' where Space. */
function Slug($string) {
	$slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	$slug_exists = slug_exist($slug);

	if($slug_exists) {
		$i = 1; $baseSlug = $slug;
		while(slug_exist($slug)){
			$slug = $baseSlug . "-" . $i++;
		}
	}

	return $slug;
}

function slug_exist($slug) {
	global $db;
	$sql          = "SELECT page_slug FROM tbl_content WHERE page_slug = '".$slug."' ";
	$content_page = $db->pdoQuery($sql)->result();

	if ($content_page) {
		return true;
	}
}

/* Comment Remaining */
function requiredLoginId() {
	global $sessUserType, $sesspUserId, $memberId;
	if (isset($sessUserType) && $sessUserType == 's')
		return $sesspUserId;
	else
		return $memberId;
}

function closetags($html) {
	#put all opened tags into an array
	preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);

	$openedtags = $result[1];   #put all closed tags into an array
	preg_match_all('#</([a-z]+)>#iU', $html, $result);
	$closedtags = $result[1];
	$len_opened = count($openedtags);
	# all tags are closed
	if (count($closedtags) == $len_opened) {
		return $html;
	}
	$openedtags = array_reverse($openedtags);
	# close tags
	for ($i = 0; $i < $len_opened; $i++) {

		if (!in_array($openedtags[$i], $closedtags)) {

			$html .= '</' . $openedtags[$i] . '>';
		} else {

			unset($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
	} return $html;
}

/* Get IP Address of current system. */
function get_ip_address() {
	foreach (array(
	'HTTP_CLIENT_IP',
	 'HTTP_X_FORWARDED_FOR',
	 'HTTP_X_FORWARDED',
	 'HTTP_X_CLUSTER_CLIENT_IP',
	 'HTTP_FORWARDED_FOR',
	 'HTTP_FORWARDED',
	 'REMOTE_ADDR'
		) as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
}

/* Get Domain name from url */
function GetDomainName($url) {
	$now1   = ereg_replace('www\.', '', $url);
	$now2   = ereg_replace('\.com', '', $now1);
	$domain = parse_url($now2);
	if (!empty($domain["host"])) {
		return $domain["host"];
	} else {
		return $domain["path"];
	}
}

/* Generate Random String as type alpha,nume,alphanumeric,hexidec */
function genrateRandom($length = 8, $seeds = 'alphanum') {
	// Possible seeds
	$seedings['alpha']    = 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$seedings['numeric']  = '0123456789';
	$seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$seedings['hexidec']  = '0123456789abcdef';
	// Choose seed
	if (isset($seedings[$seeds])) {
		$seeds = $seedings[$seeds];
	}
	// Seed generator
	list($usec, $sec) = explode(' ', microtime());
	$seed = (float) $sec + ((float) $usec * 100000);
	mt_srand($seed);
	// Generate
	$str = '';
	$seeds_count = strlen($seeds);
	for ($i = 0; $length > $i; $i++) {
		$str .= $seeds{mt_rand(0, $seeds_count - 1)};
	}
	return $str;
}

/* Sub admin Check Permission */
function checkPermission($usertype, $pagenm, $permission) {
	if ($usertype == 'a') {
		$flag = 0;
		$sadm_page = array('subadmin');
		if (in_array($pagenm, $sadm_page)) {
			$flag = 1;
		} else {
			$getval = getValFromTbl('id', 'adminrole', 'id IN (' . $permission . ') AND pagenm="' . $pagenm . '"');
			if ($getval == 0)
				$flag = 1;
		}
		if ($flag == 1) {

			$_SESSION['notice'] = NOTPER;
			redirectPage(SITE_URL . get_language_url() . 'admin/dashboard');
			exit;
		}
	}
}

/* Load Css Set directory and give filenname as array */
function load_css($filename = array()) {
	$returnStyle = '';
	$filePath = array();
	if (!empty($filename)) {
		if (domain_details('dir') == 'admin-nct') {
			foreach ($filename as $k => $v) {
				if (is_array($v)) {
					if (isset($v[1]) && $v[1] != "") {
						$filePath[] = $v[1] . $v[0];
					} else {
						$filePath[] = SITE_ADM_CSS . $v[0];
					}
				} else {
					$filePath[] = SITE_ADM_CSS . $v;
				}
			}
		} else {
			foreach ($filename as $k => $v) {
				if (is_array($v)) {
					if (isset($v[1]) && $v[1] != "") {
						$filePath[] = $v[1] . $v[0];
					} else {
						$filePath[] = SITE_CSS . $v[0];
					}
				} else {
					$filePath[] = SITE_CSS . $v;
				}
			}
		}
	}
	foreach ($filePath as $style) {
		$returnStyle .= '<link rel="stylesheet" type="text/css" href="' . $style . '">';
	}
	return $returnStyle;
}

/* Define JS variable */
function load_js_variable($js_variable = NULL) {
	$returnVariable = NULL;
	if($js_variable!=NULL){
		$returnVariable .= '<script type="text/javascript" >'.$js_variable .'</script>';
	}
	return $returnVariable;
}

/* Load JS Set directory and give filenname as array */
function load_js($filename = array()) {

	$returnScripts = '';
	$filePath = array();
	if (!empty($filename)) {
		if (domain_details('dir') == 'admin-nct') {
			foreach ($filename as $k => $v) {
				if (is_array($v)) {
					if (isset($v[1]) && $v[1] != "") {
						$filePath[] = $v[1] . $v[0];
					} else {
						$filePath[] = SITE_ADM_JS . $v[0];
					}
				} else {
					$filePath[] = SITE_ADM_JS . $v;
				}
			}
		} else {
			foreach ($filename as $k => $v) {
				if (is_array($v)) {
					if (isset($v[1]) && $v[1] != "") {
						$filePath[] = $v[1] . $v[0];
					} else {
						$filePath[] = SITE_JS . $v[0];
					}
				} else {
					$filePath[] = SITE_JS . $v;
				}
			}
		}
	}
	foreach ($filePath as $scripts) {
		$returnScripts .= '<script type="text/javascript" src="' . $scripts . '"></script>';
	}

	return $returnScripts;
}

/* Diplay message function*/
function disMessage($msgArray, $script = true) {
	if(domain_details('dir') == 'admin-nct'){
		$script = false;
	}
	$message = '';
	$content = '';
	$type = isset($msgArray["type"]) ? $msgArray["type"] : NULL;
	//$message = isset($msgArray["var"]) ? $msgArray["var"] : NULL;
	$var = isset($msgArray["var"]) ? $msgArray["var"] : NULL;
	if (!is_null($var)) {
		switch ($var) {
			case 'loginRequired' : {
					$message = "Please login to continue";
					break;
				}
			case 'invaildUsers' : {
					$message = "Invalid username/email or password";
					break;
				}
			case 'NRF' : {
					$message = "No result found";
					break;
				}
			case 'alreadytaken': {
					$message = "Username or Email is already taken";
					break;
				}
			case 'fillAllvalues' : {
					$message = "Please fill in all the attributes to complete form";
					break;
				}
			case 'InvalidEmail' : {
					$message = "Please enter proper email address or multiple email with colon separator";
					break;
				}
			case 'EnterEmail' : {
					$message = "Enter email address";
					break;
				}
			case 'succActivateAccount' : {
					$message = "You have successfully verified your email. Please wait for administrator approval";
					break;
				}
			case 'inactivatedUser' : {
					$message = "You haven't verified your email yet, please check your inbox";
					break;
				}
			case 'unapprovedUser' : {
					$message = "Your account has not been approved, please contact support for more details";
					break;
				}
			case 'succChangePass' : {
					$message = "You have successfully changed your password";
					break;
				}
			case 'succLogin' : {
					$message = "You have successfully login to your account";
					break;
				}
			case 'incorectActivate' : {
					$message = "Incorrect account, Problem to activate your account";
					break;
				}

			## global admin
			case 'userExist' : {
					$message = "Username already exists";
					break;
				}
			case 'emailExist' : {
					$message = "Email address already exists";
					break;
				}
			case 'sucNewslater' : {
					$message = "Your have successfully subscribed to our newsletter";
					break;
				}
			case 'sucNewslater2' : {
					$message = "Your have successfully activated your subscription";
					break;
				}
			case 'userNameExist' : {
					$message = "Username already exists";
					break;
				}
			case 'succLogout' : {
					$message = "You have sucessfully logged out from the site";
					break;
				}
			case 'succregwithoutact' : {
					$message = "You have successfully registered, please check your email";
					break;
				}

			case 'recAdded' : {
					$message = "Record has been added successfully";
					break;
				}
			case 'recEdited' : {
					$message = "Record has been edited successfully";
					break;
				}
			case 'recActivated' : {
					$message = "Record has been activated successfully";
					break;
				}
			case 'recDeActivated' : {
					$message = "Record has been inactivated successfully";
					break;
				}
			case 'recDeleted' : {
					$message = "Record has been deleted successfully";
					break;
				}
			case 'recExist' : {
					$message = "Record already exists";
					break;
				}

			case 'wrongPass' : {
					$message = "You have entered an incorrect password";
					break;
				}
			case 'passNotmatch' : {
					$message = "New password entry and password confirmation doesn't match";
					break;
				}
			case 'NoPermission' : {
					$message = "You don't have permission to access this module";
					break;
				}
			case 'recImported' : {
					$message = "Record has been imported successfully";
					break;
				}
			case 'succForgotPass' : {
					$message = "Your password reminder requested has been accepted, please check your email";
					break;
				}
			case 'invalidCaptcha' : {
					$message = "Please enter valid captcha";
					break;
				}
			case 'BlockedUser' : {
					$message = "Your account has been blocked. Please contact support";
					break;
				}
			case 'RemainEmailVerify' : {
					$message = "Your email verification is not complete. You can login after completing this process";
					break;
				}
			case 'wrongemail' : {
					$message = "You have entered the wrong email address";
					break;
				}
			case 'incorectReset' : {
					$message = "Incorrect account, Problem to reset your account";
					break;
				}
			default : {
					$message = $var;
					break;
				}
		}
	}
	$type1 = ($type == 'suc' ? 'success' : ($type == 'inf' ? 'info' : ($type == 'war' ? 'warning' : 'error')));
	if ($script) {
		$content = '<script type="text/javascript"> toastr["' . $type1 . '"]("' . $message . '");</script>';
	} else {
		$content = 'toastr["' . $type1 . '"]("' . $message . '");';
	}

	return $content;
}

/* Check Authentication */
function Authentication($reqAuth = false, $redirect = true, $allowedUserType = 'a') {
	$todays_date = date("Y-m-d");

	global $adminUserId, $sessUserId, $db;

	$whichSide = domain_details('dir');
	if ($reqAuth == true) {
		if ($whichSide == 'admin-nct') {

			if ($adminUserId == 0) {
				$_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'loginRequired'));
				$_SESSION['req_uri_adm'] = $_SERVER['REQUEST_URI'];

				if ($redirect) {
					redirectPage(SITE_ADMIN_URL);
				} else {
					return false;
				}
			} else {
				return true;
			}
		} else {

			if ($sessUserId <= 0) {
				$_SESSION["toastr_message"] = disMessage(array('type' => 'err', 'var' => 'loginRequired'));
				$_SESSION['req_uri'] = $_SERVER['REQUEST_URI'];

				if ($redirect) {
					redirectPage(SITE_URL.'login');
				} else {
					return false;
				}
			}
			return true;
		}
	}
}

function getTableValue($table, $field, $wherecon = array()) {
	global $db;
	$qrySel   = $db->select($table, array($field), $wherecon);
	$qrysel1  = $qrySel->result();
	$totalRow = $qrySel->affectedRows();
	$fetchRes = $qrysel1;

	if ($totalRow > 0) {
		return $fetchRes[$field];
	} else {
		return "";
	}
}

function getExt($file) {
	$path_parts = pathinfo($file);
	$ext = $path_parts['extension'];
	return $ext;
}

function GenerateThumbnail($varPhoto, $uploadDir, $tmp_name, $th_arr = array(), $file_nm = '', $addExt = true, $crop_coords = array()) {
	//$ext=strtoupper(substr($varPhoto,strlen($varPhoto)-4));die;
	$ext = '.' . strtoupper(getExt($varPhoto));
	$tot_th = count($th_arr);


	if (($ext == ".JPG" || $ext == ".GIF" || $ext == ".PNG" || $ext == ".BMP" || $ext == ".JPEG" || $ext == ".ICO")) {
		if (!file_exists($uploadDir)) {
			mkdir($uploadDir, 0777);
		}

		if ($file_nm == '')
			$imagename = rand() . time();
		else
			$imagename = $file_nm;

		if ($addExt || $file_nm == '')
			$imagename = $imagename . $ext;

		$pathToImages = $uploadDir . $imagename;
		$Photo_Source = copy($tmp_name, $pathToImages);

		if ($Photo_Source) {
			for ($i = 0; $i < $tot_th; $i++) {
				resizeImage($uploadDir . $imagename, $uploadDir . 'th' . ($i + 1) . '_' . $imagename, $th_arr[$i]['width'], $th_arr[$i]['height'], false, $crop_coords);
			}

			return $imagename;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);

	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image);
			break;
		case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image);
			break;
	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
			imagegif($newImage,$thumb_image_name);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($newImage,$thumb_image_name,100);
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);
			break;
	}
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

function resizeImage($filename, $newfilename = "", $max_width, $max_height = '', $withSampling = true, $crop_coords = array()) {

	if ($newfilename == "") {
		$newfilename = $filename;
	}

	$fileExtension = strtolower(getExt($filename));
	if ($fileExtension == "jpg" || $fileExtension == "jpeg") {
		$img = imagecreatefromjpeg($filename);
	} else if ($fileExtension == "png") {
		$img = imagecreatefrompng($filename);
	} else if ($fileExtension == "gif") {
		$img = imagecreatefromgif($filename);
	} else {
		$img = imagecreatefromjpeg($filename);
	}

	$width = imageSX($img);
	$height = imageSY($img);

	// Build the thumbnail
	$target_width = $max_width;
	$target_height = $max_height;
	$target_ratio = $target_width / $target_height;
	$img_ratio = $width / $height;

	if (empty($crop_coords)) {

		if ($target_ratio > $img_ratio) {
			$new_height = $target_height;
			$new_width = $img_ratio * $target_height;
		} else {
			$new_height = $target_width / $img_ratio;
			$new_width = $target_width;
		}

		if ($new_height > $target_height) {
			$new_height = $target_height;
		}
		if ($new_width > $target_width) {
			$new_height = $target_width;
		}
		$new_img = imagecreatetruecolor($target_width, $target_height);

		$white = imagecolorallocate($new_img, 255, 255, 255);
		imagecolortransparent($new_img);
		@imagefilledrectangle($new_img, 0, 0, $target_width - 1, $target_height - 1, $white);
		@imagecopyresampled($new_img, $img, ($target_width - $new_width) / 2, ($target_height - $new_height) / 2, 0, 0, $new_width, $new_height, $width, $height);

		//$new_img = imagecreatetruecolor($new_width, $new_height);
		//@imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	} else {
		$new_img = imagecreatetruecolor($target_width, $target_height);
		$white = imagecolorallocate($new_img, 255, 255, 255);
		@imagefilledrectangle($new_img, 0, 0, $target_width - 1, $target_height - 1, $white);
		@imagecopyresampled($new_img, $img, 0, 0, $crop_coords['x1'], $crop_coords['y1'], $target_width, $target_height, $crop_coords['x2'], $crop_coords['y2']);
	}

	if ($fileExtension == "jpg" || $fileExtension == "jpeg") {
		$createImageSave = imagejpeg($new_img, $newfilename, 90);
	} else if ($fileExtension == 'png') {
		$createImageSave = imagepng($new_img, $newfilename, 9);
	} else if ($fileExtension == "gif") {
		$createImageSave = imagegif($new_img, $newfilename, 90);
	} else {
		$createImageSave = imagejpeg($new_img, $newfilename, 90);
	}
}

if (!function_exists('dump')) {
	function dump($var, $label = 'Dump', $exit = false, $echo = TRUE) {
		// Store dump in variable
		ob_start();
		var_dump($var);
		$output = ob_get_clean();

		// Add formatting
		$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
		$output = '<pre style="background: rgba(244, 25, 113, 1);
					color: #FFFFFF;
					border: 1px dotted #000;
					padding: 10px;
					margin: 10px 0;
					text-align: left;
					font-size: 14px;">' . $label . ' => ' . $output . '</pre>';

		// Output
		if ($echo == TRUE) {
			echo $output;
		} else {
			return $output;
		}
		if ($exit) {
			die();
		}
	}
}

function getTotalRows($tableName, $condition = '', $countField = '*'){

	global $db;
	//$db->select($tableName,$countField,$condition);

	$qSel = "SELECT * from " . $tableName . " WHERE " . $condition;

	$qrysel0   = $db->pdoQuery($qSel);
	$totlaRows = $qrysel0->affectedRows();
	return $totlaRows;
}

function getMetaTags($metaArray) {
	$content = NULL;
	$content = '<meta name="description" content="' . $metaArray["description"] . ', ' . $metaArray["keywords"] . ', ' . SITE_NM . ', ' . REGARDS . '" />
		<meta name="keywords" content="' . $metaArray["keywords"] . '" />
		<meta name="author" content="' . $metaArray["author"] . '" />
		<meta name="og:title" content="' . $metaArray["og:title"] . '" />
		<meta name="og:description" content="' . $metaArray["og:description"] . '" />
		<meta name="og:image" content="' . $metaArray["og:image"] . '" />';

	if (isset($metaArray["nocache"]) && $metaArray["nocache"] == true) {
		$content .= '<meta HTTP-EQUIV="CACHE-CONTROL" content="NO-CACHE" />
		';
	}

	return sanitize_output($content);
}

function issetor(&$var, $default = false) {
	return isset($var) ? $var : $default;

}

/* Send SMTP Mail */
function generateEmailTemplate($type, $arrayCont) {
	global $sessUserId;
	global $db;

	$query = $db->select('tbl_email_templates', array("subject", "templates"), array("constant" => $type))->result();
	$q = $query;

	$subject = trim(stripslashes($q["subject"]));
	$subject = str_replace("###SITE_NM###", SITE_NM, $subject);

	$message = trim(stripslashes($q["templates"]));
	$message = str_replace("###SITE_LOGO_URL###", SITE_IMG.SITE_LOGO, $message);
	$message = str_replace("###SITE_URL###", SITE_URL, $message);
	$message = str_replace("###SITE_NM###", SITE_NM, $message);
	$message = str_replace("###YEAR###", date('Y'), $message);

	$array_keys = (array_keys($arrayCont));

	for ($i = 0; $i < count($array_keys); $i++) {
		$message = str_replace("###".$array_keys[$i]."###", "".$arrayCont[$array_keys[$i]] . "",$message);
		$subject = str_replace("###" . $array_keys[$i] . "###", "" . $arrayCont[$array_keys[$i]] . "", $subject);
	}

	$data['message'] = $message;
	$data['subject'] = $subject;
	return $data;
}

function sendEmailAddress($to, $subject, $message) {

	require_once("class.phpmailer.php");
	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->Host     = SMTP_HOST;
	$mail->Port     = SMTP_PORT;

    $mail->SMTPSecure   = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        //$mail->Port         = 465; // or 58
    $mail->IsHTML(true);
	$mail->Username = SMTP_USERNAME;
	$mail->Password = SMTP_PASSWORD;
	//$mail->SetFrom(SMTP_USERNAME);
	$mail->SetFrom(FROM_EMAIL, FROM_NM);

	$mail->AddReplyTo(FROM_EMAIL, FROM_NM);
	$mail->Subject  = $subject;
	$mail->Body     = $message;
	$mail->AddAddress($to);
	$result = true;

	if($_SERVER["SERVER_NAME"] != 'localhost' && $_SERVER["SERVER_NAME"] != 'nct128' && $_SERVER["SERVER_NAME"] != '192.168.100.128'){
		// if(!$mail->Send()){
			//echo "Mailer Error: " . $mail->ErrorInfo;
			// $result = false;
		// }
	}

	return $result;
}
/*function sendEmailAddress($to, $subject, $message) {

    require_once("class.phpmailer.php");
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug    = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth     = true; // authentication enabled
    $mail->Debugoutput  = 'error_log';
    //mail via hosting server
    $mail->Host         = SMTP_HOST;
    if (SMTP_HOST == 'smtp.gmail.com') {

        $mail->SMTPSecure   = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Port         = 465; // or 58

        //$mail->SMTPSecure   = 'tls';
        //$mail->Port         = SMTP_PORT; // or 58
    }
    else{
        $mail->Port         = 587; // or 58
    }
    $mail->IsHTML(true);

    $mail->Username     = SMTP_USERNAME;
    $mail->Password     = SMTP_PASSWORD;

    //$mail->SetFrom(SMTP_USERNAME);
    $mail->SetFrom(SMTP_USERNAME, FROM_NM);
    $mail->AddReplyTo(ADMIN_EMAIL, SITE_NM);
    $mail->Subject  = $subject;
    $mail->Body     = $message;
    $mail->AddAddress($to);
    // $mail->AddBCC("nikunj.padhiyar@ncrypted.com", "Nikunj Padhiyar");
    $result = true;

    if (!$mail->Send()) {
        //echo "Mailer Error: " . $mail->ErrorInfo;
        $result = false;
    }
    return $result;
}*/
/*Admin Functions*/
function convertDate($date, $time = false, $what = 'default') {
	if ($what == 'wherecond') {
		return date('Y-m-d', strtotime($date));
	} else if ($what == 'display') {
		return date('M d, Y h:i A', strtotime($date));
	} else if ($what == 'onlyDate') {
		return date('M d, Y', strtotime($date));
	} else if ($what == 'gmail') {
		return date('D, M d, Y - h:i A', strtotime($date));
		//Tue, Jul 16, 2013 at 12:14 PM
	} else if ($what == 'default') {
		if (trim($date) != '' && $date != '0000-00-00' && $date != '1970-01-01') {

			if ($time != false) {

				$retDt = date('d-m-Y', strtotime($date));
				return $retDt == '01-01-1970' ? '' : $retDt;
			} else {
				'1970-01-01 01:00:00';
				'01-01-1970 01:00 AM';
				$retDt = date('d-m-Y h:i A', strtotime($date));
				return $retDt == '01-01-1970 01:00 AM' ? '' : $retDt;
			}
		} else {
			return '';
		}

	} else if ($what == 'db') {
		if (trim($date) != '' && $date != '0000-00-00' && $date != '1970-01-01') {
			if (!$time) {
				$retDt = date('Y-m-d', strtotime($date));
				return $retDt == '1970-01-01' ? '' : $retDt;
			} else {
				$retDt = date('Y-m-d H:i:s', strtotime($date));
				return $retDt == '1970-01-01 01:00:00' ? '' : $retDt;
			}
		} else {
			return '';
		}

	}
}

function curPageURL() {
	$pageURL = 'http';

	if (isset($_SERVER["HTTPS"])) {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}

	define('CURRENT_PAGE_URL', $pageURL);
}

function curPageName() {
	$pageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
	define('CURRENT_PAGE_NAME', $pageName);
}

function checkIfIsActive() {
	global $db;

	if (isset($_SESSION['user_id']) && '' != $_SESSION['user_id']) {
		$user_details = $db->select("tbl_users", "*", array(
					"id" => $_SESSION['user_id']
				))->result();
		if ($user_details) {
			if ('n' == $user_details['isActive']) {
				unset($_SESSION['user_id']);
				unset($_SESSION['first_name']);
				unset($_SESSION['last_name']);
				$msgType = $_SESSION['msgType'] = disMessage(array('type' => 'err', 'var' => MSG_ACCT_DEACTIVED));
				redirectPage(SITE_URL);

				return false;
			} else if ('n' == $user_details['isEmailVerify']) {
				unset($_SESSION['user_id']);
				unset($_SESSION['first_name']);
				unset($_SESSION['last_name']);

				$msgType = $_SESSION['msgType'] = disMessage(array('type' => 'err', 'var' => "You have not verified the email address that is registered with us. Please try logging in again after verifying your email address."));
				redirectPage(SITE_URL);
				return false;
			} else {
				return true;
			}
		} else {
			unset($_SESSION['user_id']);
			unset($_SESSION['first_name']);
			unset($_SESSION['last_name']);

			$toastr_message = $_SESSION['toastr_message'] = disMessage(array('type' => 'err', 'var' => "There seems to be an issue. Please try logging in again."));
			redirectPage(SITE_URL);
			return false;
		}
	} else {
		return true;
	}
}

/* get domain details, pass module, dir, file or file-module whichever required. */
function domain_details($returnWhat){

	global $localFolderNm;
	$arrScriptName = explode('/', $_SERVER['SCRIPT_NAME']);
	foreach ($arrScriptName as $singleSciptName) {

		if ($singleSciptName == "admin-nct") {
			return $singleSciptName;
			break;
		}
	}
}

function generatePassword($length = 8) {
	// start with a blank password
	$password = "";
	// define possible characters - any character in this string can be
	// picked for use in the password, so if you want to put vowels back in
	// or add special characters such as exclamation marks, this is where
	// you should do it
	$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
	// we refer to the length of $possible a few times, so let's grab it now
	$maxlength = strlen($possible);
	// check for length overflow and truncate if necessary
	if ($length > $maxlength) {
		$length = $maxlength;
	}
	// set up a counter for how many characters are in the password so far
	$i = 0;
	// add random characters to $password until $length is reached
	while ($i < $length) {

		// pick a random character from the possible ones
		$char = substr($possible, mt_rand(0, $maxlength - 1), 1);

		// have we already used this character in $password?
		if (!strstr($password, $char)) {
			// no, so it's OK to add it onto the end of whatever we've already got...
			$password .= $char;
			// ... and increase the counter by one
			$i++;
		}
	}
	return $password;
}

function humanTiming($time) {

	$time = time() - $time; // to get the time since that moment

	$tokens = array(
		31536000 => YEAR,
		2592000 => MONTH,
		604800 => WEEK,
		86400 => DAY,
		3600 => HOUR,
		60 => MINUTE,
		1 => SECOND,
	);

	foreach ($tokens as $unit => $text) {
		if ($time < $unit) {
			continue;
		}

		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
	}
}

function getTime($date) {
	$time = humanTiming(strtotime($date));
	if ($time == "") {
		$time = JUST_NOW;
	} else {
		$time .= " ".AGO;
	}

	return $time;
}

function endsWith($haystack, $needle){
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}

	return (substr($haystack, -$length) === $needle);
}

function myTruncate($string, $limit, $break = " ", $pad = "...", $onlyText = true) {
	$string = ($onlyText == true) ? str_replace('&nbsp;', ' ', $string) : $string;
	if (strlen($string) <= $limit)
		return $string;
	if (false !== ($breakpoint = strpos($string, $break, $limit))) {
		if ($breakpoint < strlen($string) - 1) {
			$string = substr($string, 0, $breakpoint) . $pad;
		}
	}
	return $string;
}

function pri($data, $exit=true) {
	print '<pre>'; print_r($data); print '</pre>';
	(($exit)?exit():'');
}

function checkImage($imagePath, $imageName='', $imageType = '') {
	if (is_file(DIR_UPD . $imagePath . $imageName)) {
		if($imageType == "") {
			$pathInfo = pathinfo(SITE_UPD . $imagePath . $imageName);
	        $webPImg = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
	    }else {
	    	$webPImg = SITE_UPD . $imagePath . $imageName;
	    }
		return $webPImg;
	} else {
		if(strpos($imagePath , 'profile/') !== false) {
			return SITE_IMG . 'user_default.png';
		}
		else if(strpos($imagePath , 'images/') !== false) {
			return SITE_IMG . 'no_image_thumb.png';
		}
		else {
			return SITE_IMG . 'no_image_thumb.png';
		}
	}
}

function filtering($value = '', $type = 'output', $valType = 'string', $funcArray = '') {
	global $abuse_array, $abuse_array_value;

	if ($valType != 'int' && $type == 'output') {
		$value = str_ireplace($abuse_array, $abuse_array_value, $value);
	}

	if ($type == 'input' && $valType == 'string') {
		$value = str_replace('< ', '<', $value);
		$value = str_replace('<', '< ', $value);
	}

	$content = $filterValues = '';
	if ($valType == 'int')
		$filterValues = (isset($value) ? (int) strip_tags(trim($value)) : 0);
	if ($valType == 'float')
		$filterValues = (isset($value) ? (float) strip_tags(trim($value)) : 0);
	else if ($valType == 'string')
		$filterValues = (isset($value) ? (string) strip_tags(trim($value)) : NULL);
	else if ($valType == 'text')
		$filterValues = (isset($value) ? (string) trim($value) : NULL);
	else
		$filterValues = (isset($value) ? trim($value) : NULL);

	if ($type == 'input') {
		//$content = mysql_real_escape_string($filterValues);
		//$content = $filterValues;
		//$value = str_replace('<', '< ', $filterValues);
		$content = addslashes($filterValues);
	} else if ($type == 'output') {
		if ($valType == 'string')
			$filterValues = html_entity_decode($filterValues);

		$value = str_replace(array('\r', '\n', ''), array('', '', ''), $filterValues);
		$content = stripslashes($value);
	}
	else {
		$content = $filterValues;
	}

	if ($funcArray != '') {
		$funcArray = explode(',', $funcArray);
		foreach ($funcArray as $functions) {
			if ($functions != '' && $functions != ' ') {
				if (function_exists($functions)) {
					$content = $functions($content);
				}
			}
		}
	}

	return $content;
}

/* Functions for getting time diffrance */
function get_time_difference($start, $end){
	$uts['start'] = strtotime($start);
	$uts['end']   = strtotime($end);
	if ($uts['start'] !== -1 && $uts['end'] !== -1) {
		if ($uts['end'] >= $uts['start']) {
			$diff = $uts['end'] - $uts['start'];
			if ($days = intval((floor($diff / 86400)))) {
				$diff = $diff % 86400;
			}

			if ($hours = intval((floor($diff / 3600)))) {
				$diff = $diff % 3600;
			}

			if ($minutes = intval((floor($diff / 60)))) {
				$diff = $diff % 60;
			}

			$diff = intval($diff);
			return (array(
				'days'    => $days,
				'hours'   => $hours,
				'minutes' => $minutes,
				'seconds' => $diff,
			));
		} else {
			trigger_error("Ending date/time is earlier than the start date/time", E_USER_WARNING);
		}
	} else {
		trigger_error("Invalid date/time data detected", E_USER_WARNING);
	}
	return (false);
}

function addAdminNotification($arr=array()){
	global $db;
	$objPostAdmin = new stdClass();

	if(!empty($arr)){
		extract($arr);
		$objPostAdmin->admin_id = 1;
		$objPostAdmin->entity_id = $entity_id;
		$objPostAdmin->type = $type;

		$db->insert('tbl_admin_notifications',(array)$objPostAdmin);
	}
}

function getPagerData($numHits, $limit, $page){
	$numHits  = (int) $numHits;
	$limit    = max((int) $limit, 1);
	$page     = (int) $page;
	$numPages = ceil($numHits / $limit);
	$page = max($page, 1);
	$page = min($page, $numPages);
	$offset = ($page - 1) * $limit;

	$ret = new stdClass;
	$ret->offset   = $offset;
	$ret->limit    = $limit;
	$ret->numPages = $numPages;
	$ret->page     = $page;

	return $ret;
}

function pagination($pager, $page, $totalRow) {

	$pagination_container = $page_li_list = $jsFuncVariables = '';
	if($pager->numPages > 1 && $totalRow > 0){
		$adjacents = 1;
		//Here we generates the range of the page numbers which will display.
		if($pager->numPages <= (1+($adjacents * 2))) {
			$startPage = 1;
			$endPage   = $pager->numPages;
		} else {
			if(($page - $adjacents) > 1) {
			  if(($page + $adjacents) < $pager->numPages) {
				$startPage = ($page - $adjacents);
				$endPage   = ($page + $adjacents);
			  } else {
				$startPage = ($pager->numPages - (1+($adjacents*2)));
				$endPage   = $pager->numPages;
			  }
			} else {
			  $startPage = 1;
			  $endPage   = (1+($adjacents * 2));
			}
		}



		/*$page_li_list .= '<nav aria-label="Page navigation example"><ul class="pagination justify-content-end">';*/
		if($page == -1)
			$page = 0;
		$previousPage = $page-1;
		$nextPage = $page+1;
		if ($page == 1 || $page == 0) // this is the first page - there is no previous page
			$page_li_list .= '';
		else if ($page > 1)  {        // not the first page, link to the previous page{

	/*			$page_li_list .= '<li class="page-item"><a href="javascript:void(0);" data-page="'.$startPage.'" class="oBtnSecondary page-link oPageBtn buttonPage" title="First"><span>&laquo; </span></a></li>';
			$page_li_list .= '<li class="page-item"><a href="javascript:void(0);" data-page="'.$previousPage.'" class="oBtnSecondary page-link oPageBtn buttonPage" title="Previous"><span>&lsaquo;</span></a></li>';*/

			$li_arr = array("%LI_CLASS%"=>"",
							"%DATA_PAGE%"=>$previousPage,
							"%LI_A_CLASS%"=>"oBtnSecondary oPageBtn buttonPage",
							"%DISP_TEXT%"=>PREVIOUS);
			$page_li_list .= get_view(DIR_TMPL . "/pagination_li-nct.tpl.php",$li_arr);


			//$page_li_list .= '<li class="page-item"><a href="javascript:void(0);" data-page="'.$previousPage.'" class="oBtnSecondary page-link oPageBtn buttonPage" title="Previous"><span>Previous</span></a></li>';
		}
		if($endPage > $pager->numPages){
			$dispPageNo = $pager->numPages;
		}else{
			$dispPageNo = $endPage;
		}

		for($i = $startPage; $i <= $dispPageNo ; $i++){
			if ($i == $pager->page){
				$li_arr = array("%LI_CLASS%"=>"active disabled",
							"%DATA_PAGE%"=>"",
							"%LI_A_CLASS%"=>"buttonPageActive",
							"%DISP_TEXT%"=>$i);
				$page_li_list .= get_view(DIR_TMPL . "/pagination_li-nct.tpl.php",$li_arr);

				//$page_li_list .= '<li class="page-item active disabled"><a href="javascript:void(0);" class="buttonPageActive  page-link">'.$i.'</a></li>';
			}
			else{
				$li_arr = array("%LI_CLASS%"=>"",
							"%DATA_PAGE%"=>$i,
							"%LI_A_CLASS%"=>"buttonPage next",
							"%DISP_TEXT%"=>$i);
				$page_li_list .= get_view(DIR_TMPL . "/pagination_li-nct.tpl.php",$li_arr);

				//$page_li_list .= '<li class="page-item"><a class="buttonPage next page-link" data-page="'.$i.'" href="javascript:void(0);">'.$i.'</a></li>';
			}
		}
		if($page == $pager->numPages) // this is the last page - there is no next page
			$page_li_list .= "";
		else{
			/*$page_li_list .= '<li class="page-item"><a href="javascript:void(0);" data-page="'.$nextPage.'" class="oBtnSecondary page-link oPageBtn buttonPage" title="Next"><span> &rsaquo;</span></a></li>';
			$page_li_list .= '<li class="page-item"><a href="javascript:void(0);" data-page="'.$pager->numPages.'" class="oBtnSecondary page-link oPageBtn buttonPage" title="Last"><span> &raquo;</span></a></li>';
			*/
			$li_arr = array("%LI_CLASS%"=>"",
							"%DATA_PAGE%"=>$nextPage,
							"%LI_A_CLASS%"=>"oBtnSecondary oPageBtn buttonPage",
							"%DISP_TEXT%"=>NEXT);
			$page_li_list .= get_view(DIR_TMPL . "/pagination_li-nct.tpl.php",$li_arr);

			//$page_li_list .= '<li class="page-item"><a href="javascript:void(0);" data-page="'.$nextPage.'" class="oBtnSecondary page-link oPageBtn buttonPage" title="Next"><span> Next</span></a></li>';

		}
		$page_li_list .= '</ul"></nav>';
		$li_list = array("%LI_PAGE_LIST%"=>$page_li_list);
		$pagination_container = get_view(DIR_TMPL . "/pagination_ul_container-nct.tpl.php",$li_list);
	}
	return $pagination_container;
}

/*manage user device id for push notifications*/
function manageDeviceId($userId = 0 , $device_id = ""){
	global $db;
	if($userId > 0 && $device_id != ""){
		$affRows = $db->pdoQuery("SELECT id FROM tbl_users_tokens WHERE userId = ? AND device_id = ?",array($userId,$device_id))->affectedRows();

		if($affRows>0){
			$db->query("UPDATE tbl_users_tokens SET isLoggedIn = 'y',updatedDate = '".date('Y-m-d H:i:s')."' WHERE userId = '".$userId."' AND device_id ='".$device_id."'");
		}else{
			$insArr['userId'] = $userId;
			$insArr['device_id'] = $device_id;
			$insArr['createdDate'] = date('Y-m-d H:i:s');
			$insArr['updatedDate'] = date('Y-m-d H:i:s');
			$db->insert("tbl_users_tokens",$insArr);
		}
	}
}

function mapArray($arr=array()){
	if(!empty($arr)){
		$arr = array_map(function($v){
			return $v ?: '';
		},$arr);
		return $arr;
	}
}

function sendUserNotification($data = array()) {
	global $db;
	$objPostData = new stdClass();

	if(!empty($data)){		
		pushToAndroid($data);
	}
}

function strLeft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}

function selfURL(){
	if(!isset($_SERVER['REQUEST_URI'])){
		$serverrequri = $_SERVER['PHP_SELF'];
	}else{
		$serverrequri = $_SERVER['REQUEST_URI'];
	}
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = strLeft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;
}

function pushToAndroid($dataArray){
	global $db;
	$result = NULL;
	if($dataArray['receiverId'] > 0){
		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

		define('PUSH_NOTIFICATION_SERVER_KEY', 'AAAAeestAqs:APA91bFNYInjks4CnwU6Y9YOi9ph7fwgwrA1feU12KGAayetIn3szmQ8rTPdPlF8h1ZwofPzo0nWRTd_79FDDZroK103FTf2-hE3efEuTexN1E0xOvbXa6BoGfyd9Hvi1d2rz_EUfRd0');	

		$title = $dataArray['siteName'] = SITE_NM;
		$body = $dataArray['notification'];

		$userDevice = $db->pdoQuery("SELECT device_id FROM tbl_users_tokens WHERE isLoggedIn = ? AND userId = ?",array('y',$dataArray['receiverId']));
		if($userDevice->affectedRows() > 0){

			$deviceList = $userDevice->results();

			$token = array();
			foreach ($deviceList as $key => $value) {
				array_push($token ,$value['device_id']);
			}
			if(!empty($token)){
				$fields = array(
					/*'to' => $value['device_id'],*/
					'registration_ids' => $token,
					/*'notification'     => array(
						'title' => '',
						'body'  => '',
						'sound' => 'default',
					),*/
					'data'=> $dataArray,
				);

				/*echo json_encode($fields);die;*/

				$headers = array(
					'Authorization:key=' . PUSH_NOTIFICATION_SERVER_KEY,
					'Content-Type:application/json',
				);

				$options = array(
						'http' => array(
							'header'=> $headers ,
							'method'  => 'POST',
							'content' => json_encode($fields),
						),
					);
				$context  = stream_context_create($options);
				$result = file_get_contents($path_to_firebase_cm, false, $context);
			}

		}
		return $result;
	}
}
