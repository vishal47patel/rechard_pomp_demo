<div class="breadcrumbs-main">
    <div class="container">
        <h1>
            {EDIT_PROFILE}
        </h1>
        <ul class="breadcrumb">
            <li><a href="{SITE_URL}">{HOME}</a></li>
            <li>{EDIT_PROFILE}</li>
        </ul>
    </div>
</div>

{GOOGLE_ADS_SECTION}

<div class="main-content">
    <div class="container">
        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 col-12 content-des">
            <div class="box-shadow-main">
                <div class="profile-box profile-box2">
                    <form id="frmEditProfile" name="frmEditProfile" method="POST" enctype="multipart/form-data">
                        <div class="profile-main profile-main2">
                            <div class="edit-profile-img">
                                <label for="edit_profile">
                                    <figure>
                                        <img src="%USER_IMAGE%" alt="%FIRST_NAME% %LAST_NAME%" id="user_image" name="user_image">
                                        <div class="profile-icon-edit">
                                            <i class="icon-camera" id="pro_img"></i>
                                        </div>
                                    </figure>                                       
                                </label>
                                <input type="file" name="img_name" id="img_name" value="">
                                <input type="hidden" id="img_name_hdn" name="img_name_hdn" value="%USER_IMAGE_HDN%" />
                            </div>
                            <div id="profilePicError"></div>
                        </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="firstName" id="firstName" class="form-control" placeholder="{ENTER} {FNAME}{MEND_SIGN}" value="%FIRST_NAME%">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="lastName" id="lastName" class="form-control" placeholder="{ENTER} {LNAME}{MEND_SIGN}" value="%LAST_NAME%">
                                </div>
                                <?php if($_SESSION["user_type"]=='provider'){ ?>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="business_name" id="business_name" class="form-control" placeholder="{BUSINESS_NAME}{MEND_SIGN}" value="%BUSINESS_NAME%">
                                </div>
        
                                <?php if($_SESSION["service_type"]=='mechanic'){ ?>
                                    <div class="col-md-6 form-group">
                                        <select class="form-control" id="vehicle_type" name="vehicle_type">
                                            <option value="">{SELECT_VEHICLE_TYPE}{MEND_SIGN}</option>
                                            <option value="car" %CAR_SELCTED%>{CAR}</option>
                                            <option value="bike" %BIKE_SELCTED%>{BIKE}</option>
                                            <option value="both" %BOTH_SELCTED%>{BOTH}</option>
                                        </select>
                                    </div>
                                <?php }?>
                                <?php }?>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="contactNo" id="contactNo" class="form-control" placeholder="{ENTER} {CONTACT_NO}{MEND_SIGN}" value="%CONTACT_NO%">
                                </div>
                                <?php if($_SESSION["user_type"]=='provider'){ ?>

                                    <!--<div class="col-md-6 form-group">
                                        <input type="email" name="paypalEmail" id="paypalEmail" class="form-control" placeholder="{ENT_PAY_GATE_ID}*" value="%PAYMENT_GATEWAY_ID%">
                                    </div>-->
                                
                                <div class="col-md-12 form-group">
                                    <input type="hidden" id="addLat" name="addLat" value="%ADDRESS_LAT%" />
                                    <input type="hidden" id="addLong" name="addLong" value="%ADDRESS_LNG%" />
                                    <input type="hidden" id="addressVal" value="%ADDRESS%">
        
                                    <div class="form-group" id="locationSection" class="form-control">
                                    </div>

                                    <div id="addressError"></div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea name="business_details" id="business_details" class="form-control" placeholder="{ENTER_BUSINESS_DETAILS}">%BUSINESS_DETAILS%</textarea>
                                </div>
                                <?php }?>
                            </div>
                            <?php if($_SESSION["user_type"]=='customer'){ ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="gray-title-18">{VEHICLE_DETAILS}</h3>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="vehi_brand" id="vehi_brand" class="form-control" placeholder="{ENTER_BRAND_NAME}" value="%VEHI_BRAND%">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="vehi_model" id="vehi_model" class="form-control" placeholder="{ENTER_MODEL_NAME}" value="%VEHI_MODEL%">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="vehi_year" id="vehi_year" class="form-control" placeholder="{ENTER_YEAR}" value="%VEHI_YEAR%">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="vehi_engine" id="vehi_engine" class="form-control" placeholder="{ENTER_ENGINE_NO}" value="%VEHI_ENGINE%">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="vehi_mileage" id="vehi_mileage" class="form-control" placeholder="{ENTER_MILEAGE}" value="%VEHI_MILEAGE%">
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="gray-title-18">{UPLOAD_IMAGE}</h3>
                                    <div class="row row-5 upload-img-listing" id="allCarImages">                                            
                                        <div class="col-6 col-sm-4 col-md-3 form-group" id="upload_image_section">
                                            <label class="upload-img-lbl" for="file">
                                                <div class="upload-img-inner">
                                                    <img src="{SITE_IMG}plus.png">
                                                    <span>{UPLOAD_IMAGE}</span>
                                                </div>
                                                <input type="file" name="file" id="file">
                                            </label>
                                        </div>
        
                                        %UPLOADED_IMAGES%
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center form-group">
                                    <input type="hidden" id="dest_site_folder" name="dest_site_folder" value="%DEST_SITE_URL%">
                                                
                                    <input type="hidden" id="dest_dir_folder" name="dest_dir_folder" value="%DEST_DIR_URL%">
        
                                    <input type="hidden" name="action" id="action" value="updateDetails">
                                    <button type="submit" id="btnEditProfile" name="btnEditProfile" class="btn-main btn-main-red service-detail-btn">{SAVE}</button>
                                    <a href="{SITE_URL}profile/<?php echo $_SESSION['user_id']; ?>" class="btn-main btn-red-outer service-detail-btn">{CANCEL}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php if($_SESSION["user_type"]=='provider'){ ?>
                    <hr>
                    <form id="availabilityFrm" method="POST">
                        <input type="hidden" id="user_service_type" value="%USR_SERVICE_TYPE%" />
                        <div class="profile-calendar form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        {AVAILABILITY_SLOTS}
                                    </h3>
                                </div>          
                            </div>
    
                            <div class="mb-3">
                               <div id="calendar"></div>
                            </div>                  
    
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" id="start_date" name="start_date" class="form-control" placeholder="{START_DATE}{MEND_SIGN}" autocomplete="off" readonly='true'>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" id="end_date" name="end_date" class="form-control" placeholder="{END_DATE}{MEND_SIGN}" autocomplete="off" readonly='true'>
                                </div>
    
                                <?php if($_SESSION["service_type"]=='mechanic'){ ?>
                                    <div class="col-md-6">
                                        <select class="form-control" id="service_time_slot" name="service_time_slot">
                                            <option value="">{SELECT_TIME_SLOT}{MEND_SIGN}</option>
                                            %TIME_SLOTS%
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="col-md-6">
                                    <select class="form-control" id="man_availabilty" name="man_availabilty">
                                        <option hidden="true" value="">{SELECT_AVAILABILITY}{MEND_SIGN}</option>
                                        <option value="yes">{LBL_YES}</option>
                                        <option value="no">{LBL_NO}</option>
                                    </select>
                                </div>
                            </div>
                        </div>          
                        <div class="text-center">
                            <button type="button" id="manualAvailabilityBtn" class="btn-main btn-main-red service-detail-btn">{LBL_UPDATE}</button>
                        </div>
                    </form>     
                    <?php }?>   
                </div>
            </div>                  
        </div>
    </div>
</div>

<div id="myModal" class="modal fade edit-profile-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{PROFILE_IMG}</h4>
                <button type="button" id="close_modal" class="close" data-dismiss="modal">&times;</button>
                <br>
            </div>
            <div class="modal-body">
                <input type="hidden" id="file_src" name="file_src" src="">
                <div class="img-container">
                    <img id="imagepreview">
                </div>
                <div class="imageProcess"></div>
            </div>
            <div class="modal-footer">
                <div class="text-center w-100 d-block mt-3">
                    <button id="crop_img" name="crop_img" type="button" class="btn-main btn-main-red service-detail-btn">{SAVE}</button>
                    <button type="button" class="btn-main btn-red-outer service-detail-btn" id="btnclose" data-dismiss="modal">{CANCEL}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="setAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 id="header" class="modal-title mt-0 w-100"></h2>
             </div>
            <form id="addStatusFrm" method="post" action="">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="md-input form-group cf">        
                            
                            <select class="form-control" id="availability_status" name="availability_status">
                                <option value="">{SELECT_AVAILABILITY}{MEND_SIGN}</option>
                                <!-- <option value="yes">{LBL_YES}</option> -->
                                <option value="no">{LBL_NO}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center w-100 d-block mt-3">
                        <button type="button" class="btn-main btn-main-red mb-0" id="setAvailabilityBtn">{SUBMIT}</button>
                        <button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal">{CLOSE}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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