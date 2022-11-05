<form id="frmTaxiServiceRequest" name="frmTaxiServiceRequest" method="POST" class="row">
    <div class="col-md-6">
        <div class="form-group">
        	<input type="text" id="start_date" name="start_date" placeholder="{SELECT_SERVICE_START_DATE}{MEND_SIGN}" class="form-control" autocomplete="off" readonly='true'>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        	<input type="text" id="end_date" name="end_date" placeholder="{SELECT_TIME}{MEND_SIGN}" class="clockpicker form-control" autocomplete="off" readonly='true' data-autoclose="true">
        </div>
    </div>
	<?php 
	$col = 'col-md-12';
	if($_SESSION['service_type'] != 'mechanic' || $_SESSION['user_type'] != 'provider'){ 
		$col = 'col-md-6';
	} 
	?>
    <div class="<?php echo $col; ?>">
        <div class="form-group">
        	<textarea id="location_details" name="location_details" placeholder="{LOCATION_DETAILS}" class="form-control"></textarea>
        </div>
    </div>
	<?php 
	$col = 'col-md-12';
	if($_SESSION['service_type'] != 'mechanic' || $_SESSION['user_type'] != 'provider' ){ ?>
	<div class="col-md-6">
        <div class="form-group">
		<textarea id="dest_detail" name="dest_detail" placeholder="{DEST_DETAIL}" class="form-control"></textarea>
           
        </div>
    </div>
	<?php 
	} ?>
	<div class="col-md-12">
        <div class="form-group">
            <textarea id="cust_message" name="cust_message" placeholder="{ENTER_MSG}" class="form-control"></textarea>
        </div>
    </div>
	<?php 
	if($_SESSION['service_type'] != 'mechanic' || $_SESSION['user_type'] != 'provider'){ ?>
	<div class="col-md-6">
        <div class="form-group">
            <input type="text" id="num_pass" name="num_pass" placeholder="{NUM_PASS}" class="form-control">
        </div>
    </div>
    <?php 
	} ?>
	<!-- <div class="col-md-6">
        <div class="form-group">
            <input type="text" id="dest_detail" name="dest_detail" placeholder="{DEST_DETAIL}" class="form-control" >
        </div>
    </div>
	<div class="col-md-6">
        <div class="form-group">
            <input type="text" id="num_pass" name="num_pass" placeholder="{NUM_PASS}" class="form-control">
        </div>
    </div> -->

    <div class="col-md-12">
        <div class="form-group text-center">
        	<input type="hidden" id="provider_id" name="provider_id" value="%PROVIDER_ID%" />
        	<input type="hidden" id="action" name="action" value="saveTaxiService" />
        	<button class="btn-main btn-main-red" type="button" id="btnAddTaxiService" name="btnAddTaxiService">
        		{SUBMIT}
        	</button>
        </div>
    </div>
</form>