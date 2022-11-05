<form action="" method="post" name="frmCont" id="frmCont" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">
    <div class="form-body">

        <div class="form-group">
            <label for="uName" class="control-label col-md-3">{MEND_SIGN}User Name: &nbsp;</label>
            <div class="col-md-4">
                <input type="text" class="form-control logintextbox-bg required" name="uName" id="uName" value="%USER_NAME%" />
            </div>
        </div>

        <div class="form-group">
            <label for="uPass" class="control-label col-md-3">{MEND_SIGN}Password: &nbsp;</label>
            <div class="col-md-4">
                <input type="password" class="form-control logintextbox-bg required" name="uPass" id="uPass" value="" />
            </div>
        </div>

        <div class="form-group">
            <label for="uEmail" class="control-label col-md-3">{MEND_SIGN}Email Address: &nbsp;</label>
            <div class="col-md-4">
                <input type="text" class="form-control logintextbox-bg required" name="uEmail" id="uEmail" value="%EMAIL_ADDRESS%" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Status: &nbsp;</label>
            <div class="col-md-4">
                <div class="radio-list" data-error-container="#form_2_Status: _error">
                    <label class="">
                        <input class="radioBtn-bg required" id="a" name="status" type="radio" value="a" %STATUS_A%> Active
                    </label>
                    <span for="status" class="help-block"></span>
                    <label class="">
                        <input class="radioBtn-bg required" id="d" name="status" type="radio" value="d" %STATUS_D%> Deactive
                    </label>
                    <span for="status" class="help-block"></span>
                </div>
                <div id="form_2_Status: _error"></div>
            </div>
        </div>
        <div class="flclear clearfix"></div>

        <hr>
        <h3 class="text-center">Module Permission</h3>
        <hr>
        %MODULE_LIST%
        <input type="hidden" name="type" id="type" value="%TYPE%"><div class="flclear clearfix"></div>
        <input type="hidden" name="id" id="id" value="%ID%"><div class="padtop20"></div>
    </div>

    <div class="form-actions fluid">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" name="submitAddForm" class="btn green" id="submitAddForm">Submit</button><button type="button" name="cn" class="btn btn-toggler" id="cn">Cancel</button>
        </div>
    </div>
</form>