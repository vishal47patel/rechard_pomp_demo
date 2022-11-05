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
<div class="ratting1"></div>
<div class="row">
    <div class="col-md-12">
    <!-- Begin: life time stats -->
        <div class="portlet box blue-dark">
            <div class="portlet-title ">
                <div class="caption">
                <i class="fa fa-envelope"></i><?php echo $this->headTitle; ?>
                </div>
                <div class="actions portlet-toggler">               

                <div class="btn-group"></div>
                </div>
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
		 	{ "sName": "sellerName", 'sTitle' : 'Receiver Name'},
			{ "sName": "reviewerName", 'sTitle' : 'Sender Name'},
			{ "sName": "unique_id", 'sTitle' : 'Service ID'},
			{ "sName": "description", 'sTitle' : 'Description'},				
			{ "sName": "", 'sTitle' : 'Rating', bSortable:false, bSearchable:false},									
			{ "sName": "posted_date", 'sTitle' : 'Posted Date'}
		 	<?php if (in_array('status', $this->Permission)) { ?>
					//, { "sName": "isActive", 'sTitle' : 'Status', bSortable:false, bSearchable:false}
				<?php } ?>
			<?php if(in_array('edit',$this->Permission) || in_array('delete',$this->Permission) || in_array('view',$this->Permission)){ ?>
				,{ "sName": "operation", 'sTitle' : 'Operation' ,bSortable:false,bSearchable:false}
				<?php } ?>
		],
		fnServerParams: function(aoData){setTitle(aoData, this)},
		fnDrawCallback: function( oSettings ) {
			$('.make-switch').bootstrapSwitch();
			$('.make-switch').bootstrapSwitch('setOnClass', 'success');
			$('.make-switch').bootstrapSwitch('setOffClass', 'danger');
		},
		"fnRowCallback": function ( row, data, index ) {
		 	$('td:eq(4)', row).find('.ratting').rateYo({
			    readOnly:true,
			    starWidth: "20px",
			    rating:$('td:eq(4)', row).find('.ratting').attr('rating')
			});			   
		  }
	});
	$('.dataTables_filter').css({float:'right'});
	$('.dataTables_filter input').addClass("form-control input-inline");
});

</script>
