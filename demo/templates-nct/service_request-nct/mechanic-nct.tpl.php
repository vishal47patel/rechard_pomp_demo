<form id="frmMechServiceRequest" name="frmMechServiceRequest" method="POST" class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" id="service_date" name="service_date" placeholder="{SELECT_SERVICE_DATE}{MEND_SIGN}" class="form-control" autocomplete="off" readonly='true'>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <select id="service_time_slot" name="service_time_slot" class="form-control">
                <option hidden="true" value="">{SELECT_SERVICE_TIME}{MEND_SIGN}</option>
                %TIME_SLOTS%
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <textarea id="cust_message" name="cust_message" placeholder="{ENTER_MSG}" class="form-control"></textarea>
        </div>
    </div>
    <div class="col-md-12 text-center">
        <div class="form-group">
            <input type="hidden" id="provider_id" name="provider_id" value="%PROVIDER_ID%" />
            <input type="hidden" id="action" name="action" value="saveMechService" />
            <button class="btn-main btn-main-red" type="button" id="btnAddMechService" name="btnAddMechService">
                {SUBMIT}
            </button>
        </div>
    </div>
</form>