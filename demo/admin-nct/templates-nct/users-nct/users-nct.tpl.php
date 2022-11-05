
<script type="text/javascript">
	$(function () {

		ajaxSourceUrl = "<?php echo SITE_ADM_MOD.  $this->module; ?>/ajax.<?php echo $this->module; ?>.php";

		OTable = $('#dt_users').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": ajaxSourceUrl,
			"fnServerData": function (sSource, aoData, fnCallback) {
				$.ajax({
					"dataType": 'json',
					"type": "POST",
					"url": sSource,
					"data": aoData,
					"success": fnCallback
				});
			},
			"aaSorting" : [],
			"aoColumns": [
				{ sName: "id", sTitle : 'User Id', 'bVisible': false},
				{"sName": "u.firstName", 'sTitle': 'First Name'},
				{"sName": "u.lastName", 'sTitle': 'Last Name'},
				{"sName": "u.email", 'sTitle': 'Email Address'},
				//{"sName": "u.gender", 'sTitle': 'Gender'},
				{ sName: "u.createdDate", sTitle : 'Registered On'}
				<?php if (in_array('status', $this->Permission)) { ?>
					, { "sName": "status", 'sTitle' : 'Status', bSortable:false, bSearchable:false}
				<?php } ?>
				<?php if (in_array('edit', $this->Permission) || in_array('delete', $this->Permission) || in_array('view', $this->Permission) ) { ?>
									, {"sName": "operation", 'sTitle': 'Operation', bSortable: false, bSearchable: false}
				<?php } ?>
			],
			fnServerParams: function(aoData){
	            setTitle(aoData, this)
	            var activeStatus = $("#activeStatus").val();
	            
	            if(activeStatus !=''){ aoData.push({ "name": "activeStatus", "value": activeStatus}); }
	        },
			"fnDrawCallback"
					: function (oSettings) {
						$('.make-switch').bootstrapSwitch();
						$('.make-switch').bootstrapSwitch('setOnClass', 'success');
						$('.make-switch').bootstrapSwitch('setOffClass', 'danger');

					}

		});
		$('.dataTables_filter').css({float: 'right'});
		$('.dataTables_filter input').addClass("form-control input-inline");

		$(document).on('change', '#activeStatus', function (e) {        
	        OTable.fnDraw();
	    });

		$.validator.addMethod('pagenm', function (value, element) {
			return /^[a-zA-Z0-9][a-zA-Z0-9\_\-]*$/.test(value);
		}, 'Page name is not valid. Only alphanumeric and _ are allowed'
				);
		$(document).on('submit', '#frmCont', function (e) {
			$("#frmCont").on('submit', function () {
				for (var instanceName in CKEDITOR.instances) {
					CKEDITOR.instances[instanceName].updateElement();
				}
			})
			$("#frmCont").validate({
				ignore: [],
				errorClass: 'help-block',
				errorElement: 'span',
				rules: {
				},
				messages: {
				},
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
			if ($("#frmCont").valid()) {
				return true;
			} else {
				return false;
			}
		});

		  //////cropping/////
			$(document).on('change', '#file', function(event) {
				var _this = $(this);
				var value = _this.val();
				var allowedFiles = ["jpg", "jpeg", "png"];
				var extension = value.split('.').pop().toLowerCase();

				if(value && value!='') {
					if ($.inArray(extension, allowedFiles) < 0) {
						toastr['info']("Please select valid image. (e.g. jpg, jpeg, png)");
					} /*else if (this.files[0].size > 4194304) {
						toastr['info']("Image size must be less then 4MB");
					}*/ else {

						var url = URL.createObjectURL(event.target.files[0]);
						var img = $('<img src="' + url + '">');
						$('.avatar-wrapper').empty().html('<img src="' + url + '">');
						$('#avatar-modal').modal('show');
					}
				}else {
					$("#file").val("");
					event.preventDefault();
				}
			});

			$(document).on('hidden.bs.modal', '#avatar-modal', function() {
				$('.avatar-wrapper img').cropper('destroy');
				$('.avatar-wrapper').empty();
				$("#file").val("");

			});

			$(document).on('shown.bs.modal', '#avatar-modal', function() {
				$('.avatar-wrapper img').cropper({
					aspectRatio: 1/1,
					strict: true,
					responsive : true,
					viewMode : 2,
					crop: function(e) {
						var json = [
							'{"x":' + e.x,
							'"y":' + e.y,
							'"height":' + e.height,
							'"width":' + e.width,
							'"rotate":' + e.rotate + '}'
						].join();
						$('.avatar-data').val(json);
					}
				});
			});

			$(document).on('click', '#btnCrop', function(evn) {
				evn.preventDefault();
				var avatarForm = $('.avatar-form');
				var frmCont = $('#frmCont');
				var url = '<?php echo SITE_ADM_INC; ?>crop.php';

				var data =  new FormData(frmCont[0]);
				data.append('avatar_src', $('#avatar_src').val());
				data.append('avatar_data', $('#avatar_data').val());

				$.ajax(url, {
					type: 'post',
					data: data,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function() {
						addOverlay();
					},
					success: function(data) {
						console.log(data);
						if(data.state==200) {
							$('#show-croped-picture').attr('src', data.source);
							$('#hiddenImg').val(data.image);
							$('#avatar-modal').modal('hide');
							removeOverlay();
						} else {}
					},
					complete: function() {
						//removeOverlay();
					},
					error: function(data) {
			            removeOverlay();
			            $(function() {
			                toastr['error']("There seems some issue with this file. Please try to upload other image.");
			            });
			            $('#avatar-modal').modal('hide');
			        }
				});
			});

		//////cropping/////

		/*google auto complete*/

		$(document).on('focus', "input[name='address']", function() {
			initAutocomplete();
		});

		var autocomplete;

		function initAutocomplete() {

		    autocomplete = new google.maps.places.Autocomplete(
		            (document.getElementById("address")),
		            {types: ["geocode"]}
		    );
		    autocomplete.addListener("place_changed", fillInAddress);
		}

		function fillInAddress() {
		        // Get the place details from the autocomplete object.
		        var place = autocomplete.getPlace();
		        if (!place.geometry) {
		            window.alert("Autocomplete returned place contains no geometry");
		            return;
		        } else {
		            formatted_address = place.formatted_address;
		            latitude = place.geometry.location.lat();
		            longitude = place.geometry.location.lng();
		            $("#addLat").val(latitude);
		            $("#addLong").val(longitude);
		        }
		    }
		});


</script>
<style type="text/css">
  /* Github Issue solution*/

  .img-container {
  /* Never limit the container height here */
  max-width: 100%;
}

.img-container img {
  /* This is important */
  width: 100%;
}
</style>
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
				<div class="caption"><i class="fa fa-list-alt"></i><?php echo $this->headTitle; ?></div>
				<div class="actions portlet-toggler">
					%VIEW_ALL_RECORDS_BTN%
					<div class="btn-group"></div>
				</div>
			</div>

			<div class="portlet-body portlet-toggler">
                <div class="row">
                    <div class="col-md-2">
                        <label>Filter By Status :</label>&nbsp;
                    </div>
                    <div class="col-md-3">
                       <select id="activeStatus" class="form-control">
                            <option value="">Status</option>
                            <option value="y">Active</option>
                            <option value="n">Deactive</option>
                        </select>
                    </div>
                </div>
            </div>

			<div class="portlet-body portlet-toggler">
				<table id="dt_users" class="table table-striped table-bordered table-hover"></table>
			</div>
			<div class="portlet-toggler pageform" style="display:none;"></div>
		</div>
	</div>
</div>


<!--profile_image_cropper content-->
<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<form class="avatar-form" id="avatar-form" action="" enctype="multipart/form-data" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title">Change Profile Picture</h3>
				</div>
				<div class="modal-body-">
					<div class="avatar-body">
						<!-- Upload image and data -->
						<div class="avatar-upload">
							<input type="hidden" class="avatar-src" name="avatar_src" id="avatar_src" />
							<input type="hidden" class="avatar-data" name="avatar_data" id="avatar_data" />
						</div>
						<!-- Crop and preview -->
						<div class="row">
							<div class="col-md-12 text-center">
								<div class="avatar-wrapper img-container "></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="btnCrop" name="btnCrop" type="button" class="btn btn-success">
						Crop
					</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Close
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--profile_image_cropper content-->