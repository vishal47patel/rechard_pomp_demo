<form action="" method="post" name="frmCP" id="frmCP" class="form-horizontal" enctype="multipart/form-data">
    <div class="form-body"><div class="flclear clearfix"></div>
        <input type="hidden" name="passvalue" id="passvalue" value="%PASS_VALUE%">
        <div class="form-group">
            <label for="adsense_code" class="control-label col-md-3"><font color="#FF0000">*</font>Google AdSense Code: &nbsp;</label>
            <div class="col-md-4">
                <textarea class="form-control logintextbox-bg required" name="adsense_code" id="adsense_code">%ADSENSE_CODE%</textarea>
            </div>
        </div>
    </div>
    <div class="form-actions fluid">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" name="submitChange" class="btn green" id="submitChange">Submit</button>
            <button type="button" name="cn" class="btn default" id="cn" onclick="location.href = '<?php echo SITE_ADM_MOD; ?>home-nct/'">Cancel</button>
        </div>
    </div>
</form>