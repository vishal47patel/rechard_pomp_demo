<?php
require_once('config-nct.php');

if(isset($_FILES['upload'])){
        $filen = $_FILES['upload']['tmp_name'];
		$check = getimagesize($filen);

		$check=GenerateThumbnail($_FILES['upload']['name'],DIR_UPD.'ckeditor/',$_FILES['upload']['tmp_name']);
		if(!$check)
		{
			$message =  "Unsupported file type";
		}
		else
		{
	       $url = SITE_UPD."ckeditor/".$check;
		}
   $funcNum = $_GET['CKEditorFuncNum'] ;
   // Optional: instance name (might be used to load a specific configuration file or anything else).
   $CKEditor = $_GET['CKEditor'] ;
   // Optional: might be used to provide localized messages.
   $langCode = $_GET['langCode'] ;

   // Usually you will only assign something here if the file could not be uploaded.
   echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
}
?>