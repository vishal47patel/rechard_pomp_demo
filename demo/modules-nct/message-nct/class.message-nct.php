<?php
class Message {
	function __construct($contentArray = array()) {
		global $sessUserId,$objHome,$sessRequestType;
		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);

		$this->module          = $module;
		$this->objHome         = $objHome;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId      = isset($userId) && $userId > 0 ? $userId : $sessUserId;
		$this->pageNo          = isset($pageNo)?$pageNo:1;
		$this->searchName      = issetor($searchName);
		$this->receiverId      = issetor($receiverId,0);
		$user = $this->db->pdoQuery("SELECT profileImg,CONCAT_WS(' ', firstName, lastName) AS userFullName FROM tbl_users WHERE id = ?",array($this->sessUserId))->result();
		extract($user);
		$this->senderPhoto = checkImage('profile/'.$this->sessUserId.'/th2_'.$profileImg);
		$this->senderPhotoMain = checkImage('profile/'.$this->sessUserId.'/th2_'.$profileImg , "" , "mainImage");

		$this->userFullName = filtering(ucwords($userFullName));
	}
	public function getPageContent() {
		$replace = array();
		$leftInbox = $this->getLeftPanel('i');
		//$leftTrash = $this->getLeftPanel('t');
		$newUserList = '';//$this->getNewUser();

		if($leftInbox['status']) {
			$replace = array(
							'%RECEIVER_ID%'=>$this->receiverId,
							'%CONTAINER%'=>$leftInbox['retData'],
							/*'%TRASH_USER%'=>$leftTrash['retData'],*/
							'%RIGHT_PANEL%'=>'<div class="no-results text-center">'.PLZ_SELECT_ATLEAST_ONE_USER.'</div>',
							'%NEW_USER_LIST%'=>$newUserList);
			$content = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php",$replace);
		}
		else {
			$content = get_view(DIR_TMPL . $this->module . "/empty_inbox-nct.tpl.php",$replace);
		}
		return $content;
	}
	public function sendMessage($msgArray = array()){
		try{
			if(!empty($msgArray)){
				$objPost = new stdClass();
				$extMsg = $retMsgData = $finalName = "";
				extract($msgArray);

				$date = new DateTime();
				$timeZone = $date->getTimezone();

				$time = new DateTime(date('Y-m-d H:i:s'));

		      	$timezone = new DateTimeZone($timeZone->getName());
		      	$time->setTimezone($timezone);

		      	$createdDate = $time->format('Y-m-d H:i:s');

				$returnType           = issetor($returnType,'y');
				$objPost->message     = isset($message) ? filtering($message,'input','text') : '';
				$objPost->senderId    = $this->sessUserId;
				$objPost->receiverId  = isset($receiverId) ? filtering($receiverId,'input') : 0;
				$objPost->createdDate = $createdDate;
				$objPost->ipAddress   = get_ip_address();
				$objPost->msgType     = 't';

				if(isset($_FILES) && isset($_FILES['msgFile']['name'])){
					$org_filename=$_FILES['msgFile']['name'];
					$ext = getExt($org_filename);

					//$allowed = array('jpg','jpeg','png','gif','mp3','mp4','wmv','wav');
					$mime = mime_content_type($_FILES['msgFile']);
					if ( (!strstr($mime, "video/")) && (!strstr($mime, "image/")) && (!strstr($mime, "audio/")) ) {
					    throw new Exception(UPLD_VALID_FILE);
					}
					
					$objPost->msgType = 'f';
					$objPost->message = $finalName = mt_rand().mt_rand().'.'.$ext;
				}

				if($objPost->message != "" && $objPost->receiverId > 0 && $objPost->senderId > 0){
					if(isset($_FILES) && isset($_FILES['msgFile']['name'])){

						$uploadbDir = DIR_UPD."message/";
						if (!file_exists($uploadbDir)) {
							  mkdir($uploadbDir, 0777, true);
						}

						if(!move_uploaded_file($_FILES["msgFile"]["tmp_name"],$uploadbDir.$finalName))
						{
			    			throw new Exception(MSG_SOMETHING_WRONG);
						}
					}
					$lastId = $this->db->insert('tbl_messages',(array)$objPost)->getLastInsertId();
					//$lastId = 1;
					if($lastId){					
						if($returnType == 'y'){
							$getId = $this->db->pdoQuery("SELECT id FROM tbl_messages WHERE DATE(createdDate) = '".date("Y-m-d")."' AND ((senderId = ? AND receiverId = ?) OR (receiverId = ? AND senderId = ?)) AND senderDelete = ? AND id < ?",array($this->sessUserId,$objPost->receiverId,$this->sessUserId,$objPost->receiverId,'n',$lastId))->affectedRows();

							if($getId <= 0){
								$retMsgData .=  get_view(DIR_TMPL . $this->module . "/date-nct.tpl.php",array('%DATE%'=>'Today','%CLASS%'=>''));
							}
							$plainMsg = $msgReturn = filtering($objPost->message);
							if($objPost->msgType == 'f'){
								$downloadUrl = SITE_URL.'download-attachment/'.base64_encode($lastId).'/';
								$plainMsg = $linkContent = '<i class="fa fa-paperclip"></i> '.DOWNLOAD_FILE;
								$extMsg = getExt($objPost->message);
								$imgUrl = SITE_UPD.'message/'.$objPost->message;
									$extraAttr = 'target="_blank"';
									$classImg = '';
								if(in_array($extMsg,array('jpg','jpeg','png','gif'))){
									$linkContent = '<img src="'.SITE_UPD.'message/'.$objPost->message.'" width="100px">';
									$downloadUrl = $imgUrl;
										$extraAttr = '';
										$classImg = 'imgFancy';
								}
								$msgReturn =  get_view(DIR_TMPL . $this->module . "/download_link-nct.tpl.php",array('%DOWNLOAD_URL%'=>$downloadUrl,'%CONTENT_LINK%'=>$linkContent,'%EXTRA%'=>$extraAttr,'%CLASS_IMG%'=>$classImg));

								/*$msgReturn =  get_view(DIR_TMPL . $this->module . "/download_link-nct.tpl.php",array('%DOWNLOAD_URL%'=>$downloadUrl));*/
							}
							$msgCreatedDate = date("H:i | d-m-Y",strtotime($objPost->createdDate));

							$msgReplaceArr = array(
													'%MSG%'=>$msgReturn,
													'%MSG_DATE%' =>  $msgCreatedDate,
													'%USER_PHOTO%' => $this->senderPhoto,
													'%USER_PHOTO_MAIN%' => $this->senderPhotoMain,
													'%USER_NAME%' => $this->userFullName
												);
							$retMsgData .= get_view(DIR_TMPL . $this->module . "/sender_single_message-nct.tpl.php",$msgReplaceArr);
							//$leftPanel = $this->getLeftPanel();
							$leftPanel ['retData'] = "";
							$returnResponse = array(
												'redirectLink'	=> SITE_URL.'message-room',
												'status'		=> true,
												'message'   	=> MSG_MSG_SENT_SUC,
												'retData'  		=> $retMsgData,
												'plainMsg'		=> $plainMsg,
												'leftPanel'		=> $leftPanel['retData']
											);
						}else{						
							$msgData = array();

							if($this->sessRequestType == 'app') {
								$lastMsg = $this->db->pdoQuery("SELECT m.*,s.profileImg,CONCAT_WS(' ', s.firstName, s.lastName) AS fullName FROM tbl_messages AS m INNER JOIN tbl_users AS s ON m.senderId = s.id WHERE m.id = ?",array($lastId))->result();

								if($lastMsg['senderId'] == $this->sessUserId){
									$isSender = 'y';
									$photo    = $this->senderPhoto;
									$fullName = $this->userFullName;
								}else{
									$isSender = 'n';
									$photo    = checkImage('profile/'.$this->receiverId.'/th2_'.$lastMsg['profileImg']);
									$fullName = $lastMsg['fullName'];
								}

								$msgData['msgId']       = $lastId;
								$msgData['msgDate']     = $lastMsg['createdDate'];
								$msgData['photo']       = $photo;
								$msgData['fullName']    = $fullName;
								$msgData['msgType']     = $lastMsg['msgType'];
								$msgData['extMsg']      = ($lastMsg['msgType'] == 'f') ? getExt($lastMsg['message']) : "";
								$msgData['imgUrl']      = ($lastMsg['msgType'] == 'f') ? SITE_UPD.'message/'.$lastMsg['message'] : "";
								$msgData['message']     = $lastMsg['message'];
								$msgData['isSender']    = $isSender;
								$msgData['downloadUrl'] = ($lastMsg['msgType'] == 'f') ? SITE_URL.'download-attachment/'.base64_encode($lastId).'/' : "";	
							}

							$returnResponse = array(
												'redirectLink'	=> SITE_URL.'message-room',
												'status'		=> true,
												'message'   	=> MSG_MSG_SENT_SUC,
												'data'  		=> $msgData
											);
						}
					}else{
						throw new Exception(MSG_SOMETHING_WRONG);
					}
				}else{
					throw new Exception(MSG_FILL_ALL_VALUE);
				}
			}else{
				throw new Exception(MSG_FILL_ALL_VALUE);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'message-room',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'retData'  		=> array());
		}
		return $returnResponse;
	}
	public function getLastMsg($request = array()) {
		$msgData = array();

		$lastMsg = $this->db->pdoQuery("SELECT m.*,s.profileImg,CONCAT_WS(' ', s.firstName, s.lastName) AS fullName FROM tbl_messages AS m INNER JOIN tbl_users AS s ON m.senderId = s.id WHERE ((m.senderId = ? AND m.receiverId = ?) OR (m.senderId = ? AND m.receiverId = ?)) ORDER BY id DESC LIMIT 1",array($request['other_user_id'],$this->sessUserId,$this->sessUserId,$request['other_user_id']))->result();

		if($lastMsg['senderId'] == $this->sessUserId){
			$isSender = 'y';
			$photo    = $this->senderPhoto;
			$fullName = $this->userFullName;
		}else{
			$isSender = 'n';
			$photo    = checkImage('profile/'.$request['other_user_id'].'/th2_'.$lastMsg['profileImg']);
			$fullName = $lastMsg['fullName'];
		}

		$msgData['msgId']       = $lastMsg['id'];
		$msgData['msgDate']     = $lastMsg['createdDate'];
		$msgData['photo']       = $photo;
		$msgData['fullName']    = $fullName;
		$msgData['msgType']     = $lastMsg['msgType'];
		$msgData['extMsg']      = ($lastMsg['msgType'] == 'f') ? getExt($lastMsg['message']) : "";
		$msgData['imgUrl']      = ($lastMsg['msgType'] == 'f') ? SITE_UPD.'message/'.$lastMsg['message'] : "";
		$msgData['message']     = $lastMsg['message'];
		$msgData['isSender']    = $isSender;
		$msgData['downloadUrl'] = ($lastMsg['msgType'] == 'f') ? SITE_URL.'download-attachment/'.base64_encode($lastMsg['id']).'/' : "";

		$returnResponse = array(
			'redirectLink'	=> "",
			'status'		=> true,
			'message'   	=> "",
			'data'  		=> $msgData
		);	

		return $returnResponse;
	}
	public function getLeftPanel($tabType = 'i'){
		/*tabType 'i' = inbox and  't' = trash

		  innerWhrCond is used for inner single message query.
		*/
		try{
			$whrCondReceiver = $whrCondSender = $html = null;
			$msgData = $tabTypeArr = $list_data= array();

			$innerWhrCond = 'AND (IF(senderId = ? , senderDelete , receiverDelete) = "n")';

			if($this->searchName != ""){
				$whrCondReceiver = ' AND IF(m.senderId != ? ,(s.firstName LIKE "%'.$this->searchName.'%" OR s.lastName LIKE "%'.$this->searchName.'%" OR CONCAT_WS(" ", s.firstName, s.lastName) LIKE "%'.$this->searchName.'%") , (r.firstName LIKE "%'.$this->searchName.'%" OR r.lastName LIKE "%'.$this->searchName.'%" OR CONCAT_WS(" ", r.firstName, r.lastName) LIKE "%'.$this->searchName.'%"))';
				$tabTypeArr[] =$this->sessUserId;

			}
			$readStatus = 'n';
			if($tabType == 't'){
				//$whrCondSender   .= ' AND (IF(m.receiverId = ? , receiverDelete , senderDelete) = "y") ';
				$whrCondReceiver .= ' AND (IF(m.senderId = ? , senderDelete , receiverDelete) = "y") ';
				$tabTypeArr[] =$this->sessUserId;

				$innerWhrCond    = 'AND (IF(senderId = ? , senderDelete , receiverDelete) = "y")';

				$readStatus      = 'y';

			}
			//$userQry = 'SELECT * FROM ( ( SELECT m.senderId AS userId, CONCAT_WS(" ", s.firstName, s.lastName) AS fullName, s.profileImg FROM tbl_messages AS m INNER JOIN tbl_users AS s ON m.senderId = s.id WHERE m.receiverId = ? AND s.isActive = "y" '.$whrCondSender.' ORDER BY m.id DESC ) UNION ( SELECT m.receiverId AS userId, CONCAT_WS(" ", r.firstName, r.lastName) AS fullName, r.profileImg FROM tbl_messages AS m INNER JOIN tbl_users AS r ON m.receiverId = r.id WHERE m.senderId = ? AND r.isActive = "y" '.$whrCondReceiver.' ORDER BY m.id DESC ) ) AS com';

			$userQry = 'SELECT DISTINCT IF( m.`senderid` != ? , m.`senderid`, m.`receiverid`) AS userId,MAX(m.id) AS msgid,IF( m.`senderid` != ? , CONCAT_WS(" ", s.firstname, s.lastname), CONCAT_WS(" ", r.firstname, r.lastname)) AS fullName,IF(m.`senderid` != ?,s.profileImg,r.profileImg) AS profileImg,IF(m.`senderid` != ?,s.mizutech_name,r.mizutech_name) AS mizutech_name FROM tbl_messages AS m INNER JOIN tbl_users AS s ON m.`senderid` = s.`id` INNER JOIN tbl_users AS r ON m.`receiverid` = r.`id` WHERE (m.`receiverid` = ? OR m.`senderid` = ? ) '.$whrCondReceiver.' GROUP BY IF(m.`senderid` != ? ,m.`senderid`,m.`receiverid`) ORDER BY msgid DESC';

			$mainArr     = array($this->sessUserId,$this->sessUserId,$this->sessUserId,$this->sessUserId,$this->sessUserId,$this->sessUserId,$this->sessUserId);
			$mainCondArr = array_merge($mainArr,$tabTypeArr);

			$results     = $this->db->pdoQuery($userQry, $mainCondArr)->results();
			//$results = $results;
			/*pri($results);*/
			if (!empty($results)) {
				$i = 0;
				foreach ($results as $key => $value) {

					extract($value);
					$tot_unread = 0;

					$userPhoto =checkImage('profile/'.$userId.'/th2_'.$profileImg);
					$userPhotoMain =checkImage('profile/'.$userId.'/th2_'.$profileImg , "" , "mainImage");

					$userProfileLink = 'javascript:void(0)';

					$lastMsg = $this->db->pdoQuery("SELECT message,msgType,createdDate FROM tbl_messages WHERE ((senderId = ? AND receiverId = ?) OR (senderId = ? AND receiverId = ?)) ".$innerWhrCond." ORDER BY id DESC LIMIT 1",array($userId,$this->sessUserId,$this->sessUserId,$userId,$this->sessUserId))->result();

					if($lastMsg['message'] == '') {
						continue;
					}

					$message = ($lastMsg['message'] != '') ? filtering($lastMsg['message'],'output','text') : MSG_NO_MSG_FOUND;

					$message = myTruncate($message,30);

					if($lastMsg['msgType'] == 'f'){
						if($this->sessRequestType == 'app'){
							$message = DOWNLOAD_FILE;
						}else{
							$message = '<i class="fa fa-paperclip"></i> '.DOWNLOAD_FILE;
						}
					}


					$deleteBtn = "";
					$in_tr_class = 'msg_tra_'.$userId;
					if($tabType != 't'){
						$deleteBtn = get_view(DIR_TMPL . $this->module . "/delete_button-nct.tpl.php",array("%USER_ID%"=>$userId));
						$in_tr_class = 'msg_inb_'.$userId;
					}

					$tot_unread = $this->db->pdoQuery("SELECT COUNT(id) AS unread FROM tbl_messages WHERE senderId = ? AND receiverId = ? AND readStatus = ? AND receiverDelete = ?",array($userId,$this->sessUserId,'n',$readStatus))->result();

					$tot_unread =$tot_unread['unread'];

					$hide_show_cls = 'd-none';
					$msgClass = 'old-msg';
					if($tot_unread > 0){
						$hide_show_cls = 'd-inline-block';
						$msgClass = '';
					}
					$msgDate = date("H:i",strtotime($lastMsg['createdDate']));

					if($lastMsg['createdDate'] == ''){
						$lastMsg = $this->db->pdoQuery("SELECT createdDate FROM tbl_messages WHERE ((senderId = ? AND receiverId = ?) OR (senderId = ? AND receiverId = ?))  ORDER BY id DESC LIMIT 1",array($userId,$this->sessUserId,$this->sessUserId,$userId))->result();
					}
					$time = ($lastMsg['createdDate'] != '') ? getTime($lastMsg['createdDate']) : '';


					$list_data[]=array("userId"=>$userId,"userPhoto"=>$userPhoto,"fullName"=>$fullName,"totUnread"=>$tot_unread,"lastMsg"=>$message,"msgDate"=>issetor($lastMsg['createdDate']));


					$userReplaceArr =  array(
						'%ACTIVE_CLASS%' => null,
						'%IN_TR_CLASS%' => $in_tr_class,
						'%USER_PROFILE_LINK%' => $userProfileLink,
						'%USER_PHOTO%'=>$userPhoto,
						'%USER_PHOTO_MAIN%' => $userPhotoMain,
						'%USER_NAME%' => $fullName,
						'%TOTAL_UNREAD%' => $tot_unread,
						'%USER_ID%' => $userId,
						'%HIDE_SHOW_CLASS%'=> $hide_show_cls,
						'%LAST_MSG%' => $message,
						'%DELETE_BUTTON%' => $deleteBtn,
						'%MSG_CLASS%' => $msgClass,
						'%TIME%'=>$time,
						"%MIZUTECH_NAME%" => $mizutech_name
					);

					$html .= get_view(DIR_TMPL . $this->module . "/single_user_detail-nct.tpl.php",$userReplaceArr);
					$i++;
				}
				$msgData['userList']=$list_data;
				if($this->sessRequestType == 'app'){
					$returnResponse = array(
						'redirectLink'	=> SITE_URL.'message-room',
						'status'		=> true,
						'message'		=> 'success',
						'data'		=> $msgData,);
				}else{

					if($html == "") {
						$html = '<div class="no-results text-center">'.MSG_NO_MSG_FOUND.'</div>';
					}

					$userListContainer = array('%USER_LIST%'=>$html);
					$htmlUserList = get_view(DIR_TMPL . $this->module . "/message_user_list-nct.tpl.php",$userListContainer);

					$returnResponse = array(
					'redirectLink'	=> SITE_URL.'message-room',
					'status'		=> true,
					'message'   	=> 'success',
					'retData'  		=> $htmlUserList);
				}

			}else{

				if($this->sessRequestType == 'app'){
					$returnResponse = array(
					'redirectLink'	=> SITE_URL.'message-room',
					'status'		=> false,
					'message'   	=> NO_USER_FOUND,
					'data'  		=> array());
				}else{
					$userListContainer = array('%USER_LIST%'=>NRF);

					$html = get_view(DIR_TMPL . $this->module . "/message_user_list-nct.tpl.php",$userListContainer);

					$returnResponse = array(
						'redirectLink'	=> SITE_URL.'message-room',
						'status'		=> false,
						'message'   	=> NO_USER_FOUND,
						'retData'  		=> $html);
				}
			}


		}
		catch(Exception $e){

			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'message-room',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'retData'  		=> array());
		}
		return $returnResponse;
	}
	public function totUnread(){

				$tot_unread = $this->db->pdoQuery("SELECT COUNT(id) AS unread FROM tbl_messages WHERE receiverId = ? AND readStatus = ? ",array($this->sessUserId,'n'))->result();
				$unread =$tot_unread['unread'];

			$arr['count'] = $unread;
			return $unread;
	}
	public function deleteMessage(){
		try{
			if($this->receiverId > 0){
				/*$qry = "UPDATE tbl_messages SET senderDelete = (IF(senderId = ? ,'y' , 'n')),receiverDelete = (IF(receiverId = ? ,'y' , 'n')) WHERE ((senderId = ? AND receiverId = ?) OR (receiverId = ? AND senderId = ?)) ";*/

				$qry = "UPDATE tbl_messages SET
								senderDelete =  CASE
									WHEN senderId = ? THEN 'y'
									WHEN senderDelete = 'y' THEN 'y'
									WHEN senderDelete = 'n' THEN 'n'
								END,
								receiverDelete =  CASE
									WHEN receiverId = ? THEN 'y'
									WHEN receiverDelete = 'y' THEN 'y'
									WHEN receiverDelete = 'n' THEN 'n'
								END
								WHERE
									(
										(senderId = ? AND receiverId = ?)
											OR
										(receiverId = ? AND senderId = ?)
									)";

				$this->db->pdoQuery($qry,array($this->sessUserId,$this->sessUserId,$this->receiverId,$this->sessUserId,$this->receiverId,$this->sessUserId));

				if($this->sessRequestType == 'app'){
					$msgData = MSG_NO_MSG_FOUND;
				}
				else {
					$msgData = '<p class="text-center noMsgDiv">'.MSG_NO_MSG_FOUND.'</p>';
				}

				$userList = $this->getLeftPanel("i");

				$returnResponse = array(
								'redirectLink'	=> SITE_URL.'message-room',
								'status'		=> true,
								'message'   	=> MSG_MSG_MOVED_TO_TRASH,
								'msgData'   	=> $msgData,
								'retData'  		=> MSG_NO_MSG_FOUND,
								'userList'      => $userList['retData']);

			}else{
				throw new Exception(MSG_SOMETHING_WRONG);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'message-room',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'retData'  		=> array());
		}
		return $returnResponse;
	}
	public function getRightPanel(){
		try{
			if($this->receiverId > 0){
				$html = "";
				if($_REQUEST['tabType'] == 'inbox'){
					$tabType = 'i';

					$formContainer = get_view(DIR_TMPL . $this->module . "/form_message-nct.tpl.php",array('%RECEIVER_ID%'=>$this->receiverId));
					$bunchId = $this->receiverId;

				}else{
					$tabType = 't';
					$formContainer = "";
					$bunchId = 0;
				}
				$msgArr = $this->getMessages($tabType);
				$receiverName = $this->db->pdoQuery("SELECT CONCAT_WS(' ', firstName, lastName) as fullName , mizutech_name FROM tbl_users WHERE id = ?",array($this->receiverId))->result();
				$rightRepArr = array(
									'%FORM_CONTAINER%'=>$formContainer,
									'%MSG_CONTAINER%'=> $msgArr['retData'],
									'%RECEIVER_ID%'=>$this->receiverId,
									'%BUNCH_ID%' => $bunchId,
									'%USER_NAME%' => $receiverName['fullName']);
				$html .= get_view(DIR_TMPL . $this->module . "/message_right_panel-nct.tpl.php",$rightRepArr);

				$totalUnread = $this->totUnread();
				$returnResponse = array(
								'redirectLink'	=> SITE_URL.'message-room',
								'status'		=> true,
								'message'   	=> 'success',
								'retData'  		=> $html,
								'count'			=> (int)$totalUnread,
								'destiUserName' => $receiverName['mizutech_name']
							);
			}else{
				throw new Exception(MSG_SOMETHING_WRONG);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'message-room',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'retData'  		=> array());
		}
		return $returnResponse;
	}
	public function getMessages($tabType='i'){
		try{
			$extMsg=$imgUrl=$html = "";
			if($this->receiverId > 0){
				if($tabType == 'i'){
					$msgCond = 'n';
				}else{
					$msgCond = 'y';
				}
				$msgQry = "SELECT m.*,s.profileImg,CONCAT_WS(' ', s.firstName, s.lastName) AS fullName FROM tbl_messages AS m INNER JOIN tbl_users AS s ON m.senderId = s.id  WHERE ((m.senderId = ? AND m.receiverId = ?) OR (m.senderId = ? AND m.receiverId = ?)) AND (IF(m.senderId = ? , m.senderDelete , m.receiverDelete) = '".$msgCond."') ORDER BY id DESC ";

				$whrArr = array($this->receiverId,$this->sessUserId,$this->sessUserId,$this->receiverId,$this->sessUserId);
				$affRows = $this->db->pdoQuery($msgQry,$whrArr)->affectedRows();

				$pageNo = isset($this->pageNo) ? $this->pageNo : 1;
				$nextPage = $pageNo + 1;
				$pager = getPagerData($affRows, MSG_SCROLL_LIMIT, $pageNo);

				$this->readMessages($tabType);

				if($this->sessRequestType == 'app'){
					$pagination['current_page'] = issetor($pager ->page,0);
					$pagination['total_pages']  = issetor($pager ->numPages,0);
					$pagination['total']        = issetor($affRows,0);
				}

				if ($pageNo <= $pager -> numPages) {

					$offset = $pager -> offset;

					if ($offset < 0) {
						$offset = 0;
					}

					$limit = $pager -> limit;

					$page = $pager -> page;

					$limit_cond = " LIMIT $offset, $limit";


					$msgQueryList = $this->db->pdoQuery('SELECT msg.* FROM ('.$msgQry.$limit_cond.') AS msg ORDER BY msg.id ASC',$whrArr);
					$NoOfrows = $msgQueryList->affectedRows();

					if($NoOfrows > 0){
						$msgList = $msgQueryList ->results();

						$tmp = 0;
    					$msgStDate=null;

						foreach ($msgList as $key => $value) {
							$extMsg = $imgUrl="";
							$message        = filtering($value['message'],'output','text');
							$msgType        = filtering($value['msgType']);
							$msgId          = filtering($value['id']);
							$fullName       = filtering(ucwords($value['fullName']),'output','text');
							/*$msgCreatedDate = */
							$createdDate = date("d-m-Y",strtotime($value['createdDate']));
							/*17:47 | 2017-06-01*/
							/*$msgCreatedDate = date("H:i | d-m-Y",strtotime($value['createdDate']));
							$appDate     = $value['createdDate'];*/


							$date = new DateTime();
							$timeZone = $date->getTimezone();

							$time = new DateTime($value['createdDate']);

					      	$timezone = new DateTimeZone($timeZone->getName());
					      	$time->setTimezone($timezone);

					      	$msgCreatedDate = $appDate = $time->format('H:i | d-m-Y');

							if($value['senderId'] == $this->sessUserId){
								$isSender = 'y';
								$photo    = $this->senderPhoto;
								$photoMain    = $this->senderPhotoMain;
								$fullName = $this->userFullName;
								$filename = 'sender_single_message-nct.tpl.php';
							}else{
								$isSender = 'n';
								$photo    = checkImage('profile/'.$this->receiverId.'/th2_'.$value['profileImg']);
								$photoMain    = checkImage('profile/'.$this->receiverId.'/th2_'.$value['profileImg'] , "" , "mainImage");
								$fullName = $fullName;
								$filename = 'receiver_single_message-nct.tpl.php';
							}
							/*if (strtotime($createdDate) >= strtotime("today")){
								$msgCreatedDate  = date("h:i a",strtotime($value['createdDate']));
							}*/

							if($msgStDate != $createdDate || $tmp == 0){
								if (strtotime($createdDate) >= strtotime("today")){
									$msgStDate = TODAY;

								} else if (strtotime($createdDate) >= strtotime("yesterday")){
									$msgStDate = YESTERDAY;

                				}else{
									$msgStDate = $createdDate;
								}
                    			$label_id=($tmp==0)?"tempDate":"";


								$html .= get_view(DIR_TMPL . $this->module . "/date-nct.tpl.php",array('%DATE%'=>$msgStDate,'%CLASS%'=>$label_id));
								$msgStDate = $createdDate;

								$tmp = 1;
							}
							$downloadUrl = '';
							if($msgType == 'f' && is_file(DIR_UPD.'message/'.$message)){
								$downloadUrl = SITE_URL.'download-attachment/'.base64_encode($msgId).'/';
								if($this->sessRequestType == 'app'){
									/*$message = '';*/
									if(in_array(getExt($message),array('jpg','jpeg','png','gif'))){
										$extMsg = getExt($message);
										$imgUrl = SITE_UPD.'message/'.$message;
									}
								}else{
									$linkContent = '<i class="fa fa-paperclip"></i> '.DOWNLOAD_FILE;
									$extMsg = getExt($message);
									$imgUrl = SITE_UPD.'message/'.$message;
									$extraAttr = 'target="_blank"';
									$classImg = '';
									if(in_array(getExt($message),array('jpg','jpeg','png','gif'))){
										$linkContent = '<img src="'.$imgUrl.'" width="100px">';
										$downloadUrl = $imgUrl;
										$extraAttr = '';
										$classImg = 'imgFancy';
									}
									$message =  get_view(DIR_TMPL . $this->module . "/download_link-nct.tpl.php",array('%DOWNLOAD_URL%'=>$downloadUrl,'%CONTENT_LINK%'=>$linkContent,'%EXTRA%'=>$extraAttr,'%CLASS_IMG%'=>$classImg));
								}
							}

							$msgData['msgBunch'][$key]['msgId']       = $msgId;
							$msgData['msgBunch'][$key]['msgDate']     = $appDate;
							$msgData['msgBunch'][$key]['photo']       = $photo;
							$msgData['msgBunch'][$key]['fullName']    = $fullName;
							$msgData['msgBunch'][$key]['msgType']     = $msgType;
							$msgData['msgBunch'][$key]['extMsg']      = $extMsg;
							$msgData['msgBunch'][$key]['imgUrl']      = $imgUrl;
							$msgData['msgBunch'][$key]['message']     = $message;
							$msgData['msgBunch'][$key]['isSender']    = $isSender;
							$msgData['msgBunch'][$key]['downloadUrl'] = $downloadUrl;

							$msgReplaceArr = array(
												'%MSG%' => $message,
												'%MSG_DATE%' => $msgCreatedDate,
												'%USER_PHOTO%' => $photo,
												'%USER_PHOTO_MAIN%' => $photoMain,
												'%USER_NAME%' => $fullName,
												);

							$html .= get_view(DIR_TMPL . $this->module . "/".$filename,$msgReplaceArr);
						}
						if($nextPage <= $pager->numPages){
							if($tabType == 'i'){
								$tab = 'index';
							}else{
								$tab = 'trashTab';
							}
							$loadPrev = get_view(DIR_TMPL . $this->module . "/load_prev-nct.tpl.php",array('%PAGE%'=>$nextPage,'%TAB_TYPE%'=>$tab));

							$html = $loadPrev.$html;
						}
						if($this->sessRequestType == 'app'){

							$user = $this->db->pdoQuery("SELECT profileImg,CONCAT_WS(' ', firstName, lastName) AS userFullName FROM tbl_users WHERE id = ?",array($this->receiverId))->result();
							extract($user);
							$this->receiverPhoto = checkImage('profile/'.$this->receiverId.'/th2_'.$profileImg);

							$this->userFullName = filtering(ucwords($userFullName));

							$msgData['receiverPhoto'] = $this->receiverPhoto;
							$msgData['receiverName']  = $this->userFullName;
							$msgData['receiverId']    = $this->receiverId;
							$msgData['pagination']    = $pagination;
							$returnResponse = array(
											'redirectLink'	=> SITE_URL.'message-room',
											'status'		=> true,
											'message'   	=> 'success',
											'data'  		=> $msgData
										);
						}else{
							$returnResponse = array(
											'redirectLink'	=> SITE_URL.'message-room',
											'status'		=> true,
											'message'   	=> 'success',
											'retData'  		=> $html
										);
						}
					}
				}else{
					if($this->sessRequestType == 'app'){

						$returnResponse = array(
											'redirectLink'	=> SITE_URL.'message-room',
											'status'		=> false,
											'message'   	=> MSG_NO_MSG_FOUND,
											'data'  		=> '<p class="text-center noMsgDiv">'.MSG_NO_MSG_FOUND.'</p>'
										);
					}
					else {
					$returnResponse = array(
											'redirectLink'	=> SITE_URL.'message-room',
											'status'		=> false,
											'message'   	=> 'success',
											'retData'  		=> '<p class="text-center noMsgDiv">'.MSG_NO_MSG_FOUND.'</p>'
										);
					}
				}
			}else{
				throw new Exception(MSG_SOMETHING_WRONG);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'message-room',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'retData'  		=> array());
		}
		return $returnResponse;
	}
	public function readMessages($tabType){
		try{
			if($this->receiverId > 0){
					$deleteCond = 'n';
				if($tabType == 't'){
					$deleteCond = 'y';
				}
				$qry = "UPDATE tbl_messages SET readStatus = ? WHERE  receiverId = ? AND senderId = ? AND receiverDelete = ?";


				$this->db->pdoQuery($qry,array('y',$this->sessUserId,$this->receiverId,$deleteCond));

				$returnResponse = array(
								'redirectLink'	=> SITE_URL.'message-room',
								'status'		=> true,
								'message'   	=> '',
								'retData'  		=> array());

			}else{
				throw new Exception(MSG_SOMETHING_WRONG);
			}
		}
		catch(Exception $e){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'message-room',
				'status'		=> false,
				'message'   	=> $e->getMessage(),
				'retData'  		=> array());
		}
		return $returnResponse;
	}
	public function getNewUser()
	{
		$returnUserList = array();
		$userQry = 'SELECT DISTINCT IF(b.`driverId` != ?, b.`driverId`, b.`customerId`) AS userid, IF( b.`driverId` != ?, CONCAT_WS(" ", s.firstname, s.lastname), CONCAT_WS(" ", r.firstname, r.lastname) ) AS fullname FROM tbl_booking AS b INNER JOIN tbl_users AS s ON b.`driverId` = s.`id` INNER JOIN tbl_users AS r ON b.`customerId` = r.`id` WHERE ( b.`driverId` = ? OR b.`customerId` = ? ) GROUP BY IF( b.`driverId` != ?, b.`driverId`, b.`customerId` ) ORDER BY b.id DESC';
			$html = NULL;
			$mainArr     = array($this->sessUserId,$this->sessUserId,$this->sessUserId,$this->sessUserId,$this->sessUserId);
			$results     = $this->db->pdoQuery($userQry, $mainArr)->results();

		foreach ($results as $key => $value) {
			$returnUserList['list'][$key]['id'] = $value['userid'];
			$returnUserList['list'][$key]['fullname'] = filtering($value['fullname']);
			$arr = array('%ID%'=>$value['userid'],'%VALUE%'=>ucwords($value['fullname']),'%extra%'=>'','%selected%'=>'');

			$html .= get_view(DIR_TMPL . "/option-country-code-nct.tpl.php",$arr);
		}
		if($this->sessRequestType == 'app'){
			$returnResponse = array(
				'redirectLink'	=> SITE_URL.'message-room',
				'status'		=> true,
				'message'   	=> 'success',
				'retData'  		=> $returnUserList);
			return $returnResponse;
		}else{
			return $html;
		}
	}
}
?>