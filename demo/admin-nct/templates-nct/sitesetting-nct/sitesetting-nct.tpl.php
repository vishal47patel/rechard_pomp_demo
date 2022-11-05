<script type="text/javascript">
// var flag1 = 1;
// var flag2 = 1;
var flag = 1;
	function Upload() {
		$(".error_logo_size").remove();
		var fileUpload = document.getElementsByClassName("mobile_logo");
		console.log(fileUpload);
		console.log(fileUpload[0].files);
		console.log(fileUpload[0].files[0].size);
        if (typeof (fileUpload[0].files) != "undefined") {
			var reader = new FileReader();
			reader.readAsDataURL(fileUpload[0].files[0]);
            reader.onload = function (e) {
				
				//Initiate the JavaScript Image object.
                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height > 150|| width > 150) {
                        // alert("Height and Width must not exceed 100px.");
						$('<span class="help-block1 error error_logo_size">'+$('#error_logo_size').val()+'</span>').insertAfter(".mobile_logo");
						// flag1 = 0;
						flag = 1;
                        return false;
                    }else{
						// flag1 = 1;
					}
                    // alert("Uploaded image has valid Height and Width.");
                    return true;
                };
 
            }           
        } else {
            alert("Please upload image");
        }
		
	}
	function Upload2() {
		$(".error_image_size").remove();
		var fileUpload = document.getElementsByClassName("mobile_image");
		console.log(fileUpload);
		console.log(fileUpload[0].files);
		console.log(fileUpload[0].files[0].size);
        if (typeof (fileUpload[0].files) != "undefined") {
			var reader = new FileReader();
			reader.readAsDataURL(fileUpload[0].files[0]);
            reader.onload = function (e) {
				
				//Initiate the JavaScript Image object.
                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height > 550|| width > 250) {
						// flag2 = 0;
						flag = 1;
						$('<span class="help-block1 error error_image_size">'+$('#error_image_size').val()+'</span>').insertAfter(".mobile_image");
                        //alert("Height and Width must not exceed 100px.");
                        return false;
                    }else{
						// flag2 = 1;
					}
                    // alert("Uploaded image has valid Height and Width.");
                    return true;
                };
 
            }           
        } else {
            alert("Please upload image");
        }
		
	}
    $(document).on('submit', '#frmSS', function (e) {
        $("#frmSS").validate({
			
            ignore: [],
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
        if ($("#frmSS").valid()) {
			// if(flag1==1 && flag2==1){
				// return true;
			// }else{
				// return false;
			// }
			if(flag==1){
				return true;
			}else{
				return false;
			}
            
        } else {
            return false;
        }
    });
</script>
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
        <div class="portlet box blue-dark">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i><?php echo $this->headTitle; ?>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="frmSS" id="frmSS" class="form-horizontal" enctype="multipart/form-data">
				<input type="hidden" id="error_logo_size" value="<?php echo ERROR_LOGO_SIZE;?>" />
				<input type="hidden" id="error_image_size" value="<?php echo ERROR_IMAGE_SIZE;?>" />
                    <div class="form-body">
                        <?php echo $this->getForm; ?>
                    </div>	
                </form> 
            </div>
        </div>   
    </div>
</div>    	