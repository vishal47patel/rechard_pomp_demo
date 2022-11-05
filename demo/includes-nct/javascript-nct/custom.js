function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}
$(document).ready(function($) {

    $("#hdr_searchFrm").validate({
        ignore: "",
        rules: {
            hdr_service_type: {
                required: true
            },
            hdr_radius_val: {
                required: true,
                digits: true,
                min: 1
            }
        },
        messages: {
            hdr_service_type: {
                required: lang.MSG_SERVICE_TYPE_REQ
            },
            hdr_radius_val: {
                required: lang.PLZ_ENTER_SEARCH_RADIUS,
                digits: lang.MSG_ONLY_DIGIT,
                min: lang.MSG_ENTER_MIN_ONE
            }
        }
    });

    $('#hdr_searchBtn').click(function(){
        if($("#hdr_searchFrm").valid()) {
            window.location.href = siteUrl + 'search?service_type='+$("#hdr_service_type").val()+'&radius='+$("#hdr_radius_val").val() + '&provider_name=' + $("#srch_provider_name").val();
        }
    });
    
    $feedForm = "#feedForm"; {
        $($feedForm).validate({
            rules: {
                message: {
                    required: true
                },
            },
            messages: {
                message: {
                    required: lang.MSG_FEEDBACK_REQ
                },
            }
        });
    }
    $(document).on('click', '.sendUserMessage', function(event) {
        var receiverId = $(this).attr('data-userId');
        $("#msgModalReceiverId").val(receiverId);
        $('#messageModal').modal('show');
    });
    $msgModalForm = "#msgModalForm"; {
        $($msgModalForm).validate({
            rules: {
                message: {
                    required: true
                },
            },
            messages: {
                message: {
                    required: lang.MSG_REQ
                },
            }
        });
    }
    $(document).on('submit', '#msgModalForm,#newMessageForm', function(e) {

        e.preventDefault();
        var action = $(this).attr('action');
        var formData = $(this).serializeArray();
        formData.push({
            name: 'returnType',
            value: 'n'
        });
        $.ajax({
            url: action,
            dataType: 'json',
            type: 'post',
            data: formData,
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                $(function() {
                    toastr[response.type](response.message);
                });
                if (response.type == 'success') {
                    $("#msgModalMessage").val('');
                    window.setTimeout(function() {
                        window.location = response.callBackUrl;
                    }, 1000);
                } else {
                    hideLoader();
                }
            },
            error: function(response) {
                hideLoader();
                $(function() {
                    toastr['error'](lang.MSG_SOMETHING_WRONG);
                });
            }
        });
    });
});

function showLoader() {
    $('.loader').removeClass('d-none');
    $('.loader').addClass('d-block');
}

function hideLoader() {
    $('.loader').removeClass('d-block');
    $('.loader').addClass('d-none');
}

function scrollToTop(argument) {
    $("html, body").animate({
        scrollTop: 0
    }, "slow");
}

function scrollToElement(e) {
    $('html, body').animate({
        scrollTop: $(e).offset().top
    }, 1000);
}

function changeLanguage(e){
    showLoader();
    $.post(SITE_URL+"modules-nct/home-nct/index.php",
        {language:e , action : 'changeLanguage'},function(e){
            window.location.reload();
        });
}