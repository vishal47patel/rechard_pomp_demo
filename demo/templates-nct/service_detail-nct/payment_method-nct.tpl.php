<form id="paymentMethodForm" method="POST" action="">
    <div class="form-group d-inline-block mr-2">
        <label class="container-radio"> {ONLINE}
            <input type="radio" id="online" name="payment_method" value="online" style="display: block !important;">
            <span class="checkmark"></span>
        </label>
    	<!--<input type="radio" id="online" name="payment_method" value="online" style="display: block !important;">
    	<label for="online">{ONLINE}</label>-->
    </div>
    <div class="form-group d-inline-block">
        <label class="container-radio"> {OFFLINE}
            <input type="radio" id="offline" name="payment_method" value="offline" style="display: block !important;">
            <span class="checkmark"></span>
        </label>
    	<!--<input type="radio" id="offline" name="payment_method" value="offline" style="display: block !important;">
    	<label for="offline">{OFFLINE}</label>-->
    </div>
    	<div id="disp_method_error"></div>
    	<div class="text-center all-btns mt-3">
    		<input type="hidden" name="service_request_id" value="%SERVICE_REQ_ID%" />
    		<button type="submit" id="paymentMethod" name="paymentMethod" class="btn-main btn-main-red btn large-btn">{SUBMIT}</button>
    	</div>
    </div>

</form>