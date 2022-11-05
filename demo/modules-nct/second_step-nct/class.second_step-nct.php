<?php
class second_step
{
	public function __construct($contentArray = array())
	{
		global $sessUserId, $sessRequestType, $objHome;

		foreach ($GLOBALS as $key => $values) {
			$this->$key = $values;
		}
		extract($contentArray);
		$this->module          = $module;
		$this->sessRequestType = $sessRequestType;
		$this->sessUserId      = isset($userId) && $userId > 0 ? $userId : $sessUserId;
		$this->objHome         = $objHome;
		// $this->business_name   = $usiness_name;
	}

	public function submitUserData($request = array())
	{
		try {
			if (!empty($request)) {
				extract($request);
				$objPost->business_name = isset($business_name) ? filtering($business_name, 'input') : '';
				$objPost->vehi_brand = isset($vehi_brand) ? filtering($vehi_brand, 'input') : '';
				$objPost->vehi_model = isset($vehi_model) ? filtering($vehi_model, 'input') : '';
				$objPost->vehi_year = isset($vehi_year) ? filtering($vehi_year, 'input') : '';
				$objPost->vehi_engine = isset($vehi_engine) ? filtering($vehi_engine, 'input') : '';
				$objPost->vehi_mileage = isset($vehi_mileage) ? filtering($vehi_mileage, 'input') : '';
				$objPost->second_step_complete = 'y';
				
				if ($this->sessRequestType == 'app') {
					foreach ($_FILES['uploadedImages']['tmp_name'] as $uploadedImages) {
						$hiddenImg = rand().time().'.png';
				        $upload_dir = DIR_UPD.'images/'.$this->sessUserId. '/';

				        if(!file_exists($upload_dir))
				        {
				            mkdir($upload_dir,0777);
				        }
				        
				        copy($uploadedImages, $upload_dir.$hiddenImg);
				        convertToWebP($upload_dir.$hiddenImg);

				        /*$thumbnailArray[0] = array('newWidth'=>360,'newHeight'=>127);
	                
		                uploadImagewithResize($upload_dir,$upload_dir.$hiddenImg,DIR_UPD.'images/temp_dir/'.$hiddenImg,$hiddenImg,$thumbnailArray);
		                convertToWebP($upload_dir.'th1_'.$hiddenImg);*/

				        $this->db->insert("tbl_user_images" , array("image_name" => $hiddenImg , "user_id" => $this->sessUserId));
				    }
				}
				else {
					if(!empty($request['uploadedImages'])) {

						foreach ($request['uploadedImages'] as $hiddenImg) {

					        $upload_dir = DIR_UPD.'images/'.$this->sessUserId. '/';

					        if(!file_exists($upload_dir))
					        {
					            mkdir($upload_dir,0777);
					        }
					        
					        copy(DIR_UPD.'images/temp_dir/'.$this->sessUserId.'/'.$hiddenImg, $upload_dir.$hiddenImg);
					        convertToWebP($upload_dir.$hiddenImg);

					        /*$thumbnailArray[0] = array('newWidth'=>360,'newHeight'=>127);
		                
			                uploadImagewithResize($upload_dir,$upload_dir.$hiddenImg,DIR_UPD.'images/temp_dir/'.$hiddenImg,$hiddenImg,$thumbnailArray);
			                convertToWebP($upload_dir.'th1_'.$hiddenImg);*/

					        $this->db->insert("tbl_user_images" , array("image_name" => $hiddenImg , "user_id" => $this->sessUserId));
					    }


					    $tempFile = glob(DIR_UPD."images/temp_dir/".$this->sessUserId."/*"); // get all file names
				        foreach($tempFile as $fileList)
				        { // iterate files
				            if(is_file($fileList))
				                unlink($fileList); // delete file
				        }

				        rmdir(DIR_UPD."images/temp_dir/".$this->sessUserId);
					}
				}

				$this->db->update('tbl_users', (array) $objPost, array('id' => $this->sessUserId));

				$returnResponse = array(
					'redirectLink' => SITE_URL,
					'status'       => true,
					'message'      => MSG_DETAILS_SAVED_SUC,
					'data'         => array());

				return $returnResponse;
				
			} else {
				throw new Exception(FILL_VALUES);
			}
		} catch (Exception $e) {
			$returnResponse = array(
				'redirectLink' => SITE_URL . 'second-step',
				'status'       => false,
				'message'      => $e->getMessage(),
				'data'         => array());

			return $returnResponse;
		}
	}

	public function getPageContent()
	{
		$query = "SELECT * FROM tbl_users where id=".$this->sessUserId;
		$customerQry = $this->db->pdoQuery($query)->results();
		
		$dataArray = array(
			"%DEST_SITE_URL%" => SITE_UPD.'images/temp_dir/'.$this->sessUserId . "/",
			"%DEST_DIR_URL%" => DIR_UPD.'images/temp_dir/'.$this->sessUserId . "/",
			"%BNAME%" => $customerQry[0]['business_name']
		);
		$content = get_view(DIR_TMPL . $this->module . "/" . $this->module . ".tpl.php", $dataArray);
		return $content;
	}
}
