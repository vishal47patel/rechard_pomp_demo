<?php
	require_once("config-nct.php");
	$messageQry = $db->pdoQuery("SELECT * FROM tbl_messages WHERE id = ?",array(base64_decode($_GET['id'])));

	if($messageQry->affectedRows() > 0){

		$docDetails = $messageQry->result();

		$file = DIR_UPD.'message/'.$docDetails['message'];

		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}
	}else{
		echo NO_FILE_FOUND;
	}
?>