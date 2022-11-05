<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <?php
        echo $this->breadcrumb;
        ?>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
    <!-- Begin: life time stats -->
        <div class="portlet box blue-dark">
            <div class="portlet-title ">
                <div class="caption">
                <i class="fa fa-envelope"></i><?php echo $this->headTitle; ?>
                </div>
            </div>

            <div class="portlet-body portlet-toggler">
            	<!-- <div class="row">
	                <div class="col-md-2">
	                    <label>Payment Type :</label>&nbsp;
	                </div>
	                <div class="col-md-2">
	                    <select id="filter_payment_type" class="form-control">
		                	<option value="">Payment Type</option>
		                	<option value="received">Received</option>
		                	<option value="paid">Paid</option>
		                </select>
	                </div>
                </div> -->
                <div style="margin-bottom:10px; clear:both;"></div>
                <div class="clear"></div>
            </div>

            <div class="portlet-body portlet-toggler">
                <table id="example123" class="table table-striped table-bordered table-hover"></table>
            </div>
            <div class="portlet-body portlet-toggler pageform" style="display:none;"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
	OTable= $('#example123').dataTable( {
		bProcessing: true,
		bServerSide: true,
		sAjaxSource: "ajax.<?php echo $this->module;?>.php",
		fnServerData: function (sSource, aoData, fnCallback) {
			$.ajax({
			   dataType: 'json',
			   type: "POST",
			   url: sSource,
			   data: aoData,
			   success: fnCallback
			});
		 },
		 aaSorting : [],
		 aoColumns: [
		 	{ sName: "id", sTitle : 'Id', 'bVisible': false},
		 	{ sName: "unique_id", sTitle : 'Service ID'},
		 	{ sName: "consider_date", sTitle : 'Service Date'},
		 	{ sName: "provider_name", sTitle : 'Customer Name'},
		 	{ sName: "customer_name", sTitle : 'Provider Name'}	
		 	<?php if (in_array('view', $this->Permission) ) { ?>
				, {"sName": "operation", 'sTitle': 'Operation', bSortable: false, bSearchable: false}
			<?php } ?>

		],
		fnServerParams: function(aoData){
			setTitle(aoData, this)
			var paymentType = $("#filter_payment_type").val();

            if(paymentType !=''){ aoData.push({ "name": "paymentType", "value": paymentType}); }
		},
		fnDrawCallback: function( oSettings ) {
		}
	});
	$('.dataTables_filter').css({float:'right'});
	$('.dataTables_filter input').addClass("form-control input-inline");

	$(document).on('change', '#filter_payment_type', function (e) {
        OTable.fnDraw();
    });
});
</script>