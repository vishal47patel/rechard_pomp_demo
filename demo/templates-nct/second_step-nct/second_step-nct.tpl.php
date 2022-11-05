<div class="main-content">
    <div class="container">
        <div class="col-lg-12 reg-main p-0">
            <div class="row center-item m-0">
                <div class="col-lg-6 pr-0 pl-0 reg-img">
                    <img src="{SITE_IMG}left2.png">
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 right-block">
                            <div class="main-title">
                                <h1>
                                    {AFTER_REGISTRATION}
                                </h1>
                                <div class="main-title-icon">
                                    <span class="icon-customer-support"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                                </div>
                            </div>
                            <div class="form-register">
                                <form method="post" name="frmSecondStep" id="frmSecondStep" enctype="multipart/form-data">

                                    <?php if($_SESSION['user_type'] == 'provider') { ?>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="{BUSINESS_NAME}{MEND_SIGN}" name="business_name" id="business_name" type="text" value="%BNAME%">
                                    </div>
                                    <?php } else { ?>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="{ENTER_BRAND_NAME}" name="vehi_brand" id="vehi_brand" type="text" value="">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="{ENTER_MODEL_NAME}" name="vehi_model" id="vehi_model" type="text" value="">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="{ENTER_YEAR}" name="vehi_year" id="vehi_year" type="text" value="">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="{ENTER_ENGINE_NO}" name="vehi_engine" id="vehi_engine" type="text" value="">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="{ENTER_MILEAGE}" name="vehi_mileage" id="vehi_mileage" type="text" value="">
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label>{UPLOAD_IMAGE}</label>
                                        <div class="row upload-img-listing" id="allCarImages">                                            
                                            <div class="col-6 col-sm-4 col-md-4 form-group" id="upload_image_section">
                                                <label class="upload-img-lbl" for="file">
                                                    <div class="upload-img-inner">
                                                        <img src="{SITE_IMG}plus.png">
                                                        <span>{UPLOAD_IMAGE}</span>
                                                    </div>
                                                    <input type="file" name="file" id="file">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" id="dest_site_folder" name="dest_site_folder" value="%DEST_SITE_URL%">
                                        
                                        <input type="hidden" id="dest_dir_folder" name="dest_dir_folder" value="%DEST_DIR_URL%">    
                                        
                                        <input type="hidden" name="btnSecondStep" value="edit_profile" />

                                        <button type="submit" class="btn-main btn-main-red w-100" id="btnSecondStep" name="btnSecondStep">
                                            {SUBMIT}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--profile_image_cropper content-->
<div class="modal " id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="avatar-form" id="avatar-form" action="" enctype="multipart/form-data" method="post">
                <div class="modal-header text-center">
                <h2 class="modal-title mt-0 w-100">{UPLOAD_IMAGE}</h2>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <!-- Upload image and data -->
                        <div class="avatar-upload">
                            <input type="hidden" class="avatar-src" name="avatar_src" id="avatar_src" />
                            <input type="hidden" class="avatar-data" name="avatar_data" id="avatar_data" />
                            
                        </div>
                        <!-- Crop and preview -->
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="avatar-wrapper img-container "></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCrop" name="btnCrop" type="button" class="btn-main btn-main-red mb-0">
                        {CROP}
                    </button>
                    <button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal">
                        {CLOSE}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--profile_image_cropper content-->