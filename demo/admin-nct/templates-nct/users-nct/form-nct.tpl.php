<form action="" method="post" name="frmCont" id="frmCont" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">
    <div class="form-body">

        <div class="form-group">
            <label for="first_name" class="control-label col-md-3">%MEND_SIGN% First Name: &nbsp;</label>
            <div class="col-md-4">
                <input type="text" class="form-control logintextbox-bg required" name="first_name" id="first_name" value="%FIRST_NAME%" />
            </div>
        </div>

        <div class="form-group">
            <label for="last_name" class="control-label col-md-3">%MEND_SIGN% Last Name: &nbsp;</label>
            <div class="col-md-4">
                <input type="text" class="form-control logintextbox-bg required" name="last_name" id="last_name" value="%LAST_NAME%" />
            </div>
        </div>

        <div class="form-group">
            <label for="email_address" class="control-label col-md-3">%MEND_SIGN% Email Address: &nbsp;</label>
            <div class="col-md-4">
                <input type="text" class="form-control logintextbox-bg required" name="email_address" id="email_address" value="%EMAIL_ADDRESS%" readonly="readonly" />
            </div>
        </div>
        <div class="form-group" id="123">
            <label class="control-label col-md-3">
                Profile Image :
            </label>
            <div class="col-md-4">
                <input type="file" class="form-control logintextbox-bg %REQUIRED%" name="file" id="file" value="%IMAGE_URL%">

                <img id="show-croped-picture" src="%IMAGE_URL%" alt="Image" width="100" style="margin-top: 10px;">
                <input type="hidden" id="hiddenImg" name="hiddenImg" value="">
                <input type="hidden" id="dest_frm" name="dest_site_folder" value="%DEST_SITE_URL%">
                <input type="hidden" id="dir_frm" name="dest_dir_folder" value="%DEST_DIR_URL%">

            </div>
        </div>

        <!-- <div class="form-group">
            <label for="address" class="control-label col-md-3">%MEND_SIGN% Address: &nbsp;</label>
            <div class="col-md-4">
                <input type="text" class="form-control logintextbox-bg required" name="address" id="address" value="%ADDRESS%"  data-error-container="#address_error"" />
                <input type="hidden" class="" name="addLat" id="addLat" value="%ADD_LAT%" data-error-container="#address_error"" >
                <input type="hidden" class="" name="addLong" id="addLong" value="%ADD_LONG%" data-error-container="#address_error"" >
                 <div id="address_error"></div>

            </div>
        </div> -->

        <div class="form-group">
            <label class="control-label col-md-3">Status: &nbsp;</label>
            <div class="col-md-4">
                <div class="radio-list" data-error-container="#form_2_Status: _error">
                    <label class="">
                        <input class="radioBtn-bg required" id="y" name="isActive" type="radio" value="y" %STATUS_A%> Active
                    </label>
                    <span for="isActive" class="help-block"></span>
                    <label class="">
                        <input class="radioBtn-bg required" id="n" name="isActive" type="radio" value="n" %STATUS_D%> Deactive
                    </label>
                    <span for="isActive" class="help-block"></span>
                </div>
                <div id="form_2_Status: _error"></div>
            </div>
        </div>

        <div class="flclear clearfix"></div>

        <input type="hidden" name="type" id="type" value="%TYPE%"><div class="flclear clearfix"></div>
        <input type="hidden" name="id" id="id" value="%ID%"><div class="padtop20"></div>
    </div>

    <div class="form-actions fluid">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" name="submitAddForm" class="btn green" id="submitAddForm">Submit</button><button type="button" name="cn" class="btn btn-toggler" id="cn">Cancel</button>
        </div>
    </div>
</form>



