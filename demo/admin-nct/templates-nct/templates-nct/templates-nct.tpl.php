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
                <div class="actions portlet-toggler">

                <?php if(in_array('add',$this->Permission)){ ?>
                <a href="<?php echo SITE_ADM_MOD.$this->module.'/';?>ajax.<?php echo $this->module;?>.php?action=add" class="btn blue btn-add">
                    <i class="fa fa-pencil"></i> Add
                </a>
                <?php } ?>

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
	CKEDITOR.on( 'instanceReady', function( ev ) {
            $('iframe.cke_wysiwyg_frame', ev.editor.container.$).contents().on('click', function() {
                ev.editor.focus();
            });
        }); 
	
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
		 	{ sName: "id", sTitle : 'Template Id', bVisible: false},
		 	{ sName: "constant", sTitle : 'Constant'},
			{ sName: "types", sTitle : 'Types'},
			{ sName: "description", sTitle : 'Description', bSearchable:false}
			<?php if(in_array('status',$this->Permission)){ ?>
				,{ "sName": "status", 'sTitle' : 'Status' ,bSortable:false,bSearchable:false}
				<?php } ?>
			<?php if(in_array('edit',$this->Permission) || in_array('delete',$this->Permission) || in_array('view',$this->Permission) ){ ?>
				,{ "sName": "operation", 'sTitle' : 'Operation' ,bSortable:false,bSearchable:false}
				<?php } ?>
		],
		fnServerParams: function(aoData){setTitle(aoData, this)},
		fnDrawCallback: function( oSettings ) {
			$('.make-switch').bootstrapSwitch();
			$('.make-switch').bootstrapSwitch('setOnClass', 'success');
			$('.make-switch').bootstrapSwitch('setOffClass', 'danger');

		}
	});
	$('.dataTables_filter').css({float:'right'});
	$('.dataTables_filter input').addClass("form-control input-inline");

	$.validator.addMethod('pagenm',function (value, element) {
		return /^[a-zA-Z0-9][a-zA-Z0-9\-\_]*$/.test(value);
		},'Page name is not valid. Only alphanumeric and -,_ are allowed'
	);
	$(document).on('submit','#frmCont', function(e){
		$("#frmCont").on('submit', function() {
			for(var instanceName in CKEDITOR.instances) {
				CKEDITOR.instances[instanceName].updateElement();
			}
		})
		$("#frmCont").validate({
			ignore:[],
			errorClass: 'help-block',
			errorElement: 'span',
            highlight: function (element) {
			   $(element).closest('.form-group').addClass('has-error');
			},
			unhighlight: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			},
			errorPlacement: function (error, element) {
				if (element.attr("data-error-container")) {
					error.appendTo(element.attr("data-error-container"));
				} else {
					error.insertAfter(element);
				}
            }
		});
		if($("#frmCont").valid()){
			return true;
		}else{
			return false;
		}
	});
});
</script>
