<form id="frmTaxiServiceRequest" name="frmTaxiServiceRequest" method="POST" class="row">
    <div class="col-md-12 form-group selectpicker-h search-dropdown">
        <select id="customer_id" name="customer_id" class="form-control selectpicker" data-live-search="true">
            <option hidden="true" value="">{SELECT_CUSTOMER}{MEND_SIGN}</option>
            %CUSTOMER_LIST%
        </select>
        <div id="disp_customer_error"></div>
    </div>
    <div class="col-md-6 form-group">
        <input type="text" id="start_date" name="start_date" placeholder="{SELECT_SERVICE_START_DATE}{MEND_SIGN}" class="form-control" autocomplete="off" readonly='true'>
    </div>
    <div class="col-md-6 form-group">
        <input type="text" id="end_date" name="end_date" placeholder="{SELECT_TIME}{MEND_SIGN}" class="clockpicker form-control" autocomplete="off" readonly='true' data-autoclose="true">
    </div>
    <div class="col-md-6 form-group">
        <textarea id="location_details" name="location_details" placeholder="{LOCATION_DETAILS}" class="form-control"></textarea>
    </div>
    <div class="col-md-6 form-group">
        <textarea id="dest_detail" name="dest_detail" placeholder="{DEST_DETAIL}" class="form-control"></textarea>
    </div>
    <div class="col-md-6 form-group">
        <input type="text" id="num_pass" name="num_pass" placeholder="{NUM_PASS}" class="form-control">
    </div>
    <div class="col-md-12 form-group text-center">
        <input type="hidden" id="provider_id" name="provider_id" value="%PROVIDER_ID%" />
        <input type="hidden" id="action" name="action" value="saveTaxiService" />
        <button class="btn-main btn-main-red" type="button" id="btnAddTaxiService" name="btnAddTaxiService">
            {SUBMIT}
        </button>
    </div>
</form>