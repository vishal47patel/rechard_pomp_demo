<form action="" method="post" name="frmCont" id="frmCont" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">
    <div class="form-body">
        <!-- %CONSTANT_VALUE_CONTENT% -->
       
        <div class="form-group" id="123">
            <label class="control-label col-md-3">
                Banner Image:
            </label>
            <div class="col-md-4">
                <input type="file" class="form-control logintextbox-bg"  name="file" id="file" value="%FILE%">
                <div id="fileCnt">
                    %FILE_CONTENT%
                </div>
                <input type="hidden" id="height" name="height" value="565">
                <input type="hidden" id="width" name="width" value="925">
                <input type="hidden" id="hiddenImg" name="hiddenImg" value="">
                <input type="hidden" id="dest_frm" name="dest_site_folder" value="%DEST_SITE_URL%">
                <input type="hidden" id="dir_frm" name="dest_dir_folder" value="%DEST_DIR_URL%">
            </div>
        </div>

        <!-- <div class="form-group">
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
        </div> -->

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



