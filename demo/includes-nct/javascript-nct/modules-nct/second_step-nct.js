$(document).ready(function() {
    $(document).on("click" , '.softImgDelete' , function(){
        $(this).parent().parent().remove();

        if($('.img-preview-list').length < 5) {
            $("#upload_image_section").show();
        }
    });
    $("#frmSecondStep").validate({
        ignore: "",
        rules: {
            business_name: {
                required: true
            },
            vehi_year: {
                digits: true
            }
        },
        messages: {
            business_name: {
                required:lang.MSG_BNAME_REQ,
            },
            vehi_year: {
                digits: lang.MSG_ONLY_DIGIT
            }
        }
    });
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
        } else if (this.files[0].size > 4194304) {
            toastr['info']("Image size must be less then 4MB");
        } else {

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
    var frmCont = $('#frmSecondStep');
    var url = SITE_URL+'includes-nct/crop.php';

    var data =  new FormData(frmCont[0]);

    data.append('avatar_src', $('#avatar_src').val());
    data.append('avatar_data', $('#avatar_data').val());
    data.append('dest_site_folder', $('#dest_site_folder').val());
    data.append('dest_dir_folder', $('#dest_dir_folder').val());
    data.append('height', '265');
    data.append('width', '265');

    $.ajax(url, {
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function() {
            showLoader();
        },
        success: function(data) {
            //console.log(data);
            hideLoader();

            if(data.state==200) {
                //$('#show-croped-picture').attr('src', data.source);
                $('#allCarImages').append('<div class="col-6 col-sm-4 col-md-4 form-group"><div class="position-relative"><div class="img-preview-list"><img src="'+data.source+'" class="w-100"></div><a href="javascript:void(0)" class="close-icon softImgDelete"><i class="fa fa-times"></i></a><input type="hidden" name="uploadedImages[]" value="'+data.image+'" /></div></div>');
                $("#file").val("");
                $('#hiddenImg').val(data.image);
                $('#avatar-modal').modal('hide');

                if($('.img-preview-list').length >= 5) {
                    $("#upload_image_section").hide();
                }
            } else {}
        },
        complete: function() {
            //$('.loading').fadeOut();
            hideLoader();
        }
    });
});

//////cropping/////