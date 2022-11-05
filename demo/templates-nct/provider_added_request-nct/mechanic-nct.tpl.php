<form id="frmMechServiceRequest" name="frmMechServiceRequest" method="POST" class="row">
    <div class="col-md-12 form-group selectpicker-h search-dropdown">
        <select id="customer_id" name="customer_id" class="form-control selectpicker" data-live-search="true">
            <option hidden="true" value="">{SELECT_CUSTOMER}{MEND_SIGN}</option>
            %CUSTOMER_LIST%
        </select>
        <div id="disp_customer_error"></div>
    </div>
    <div class="col-md-6 form-group">
        <input type="text" id="service_date" name="service_date" placeholder="{SELECT_SERVICE_DATE}{MEND_SIGN}" class="form-control" autocomplete="off" readonly='true'>
    </div>
    <div class="col-md-6 form-group">
        <select id="service_time_slot" name="service_time_slot" class="form-control">
            <option hidden="true">{SELECT_SERVICE_TIME}{MEND_SIGN}</option>
            %TIME_SLOTS%
        </select>
    </div>
	
    <!--<div class="col-md-6 form-group">
        <input type="text" id="dest_detail" name="dest_detail" placeholder="{DEST_DETAIL}" class="form-control" >
    </div>
    <div class="col-md-6 form-group">
        <input type="text" id="num_pass" name="num_pass" placeholder="{NUM_PASS}" class="form-control">
    </div>-->
    <div class="col-md-12 form-group text-center">
        <input type="hidden" id="provider_id" name="provider_id" value="%PROVIDER_ID%" />
        <input type="hidden" id="action" name="action" value="saveMechService" />
        <button class="btn-main btn-main-red" type="button" id="btnAddMechService" name="btnAddMechService">
            {SUBMIT}
        </button>
    </div>
</form>