$(document).ready(function() {
    $("#frmChngEmail").validate({
        rules: {
            new_email_id: {
                required: true
            }
        },
        messages: {
            new_email_id: {
                required: lang.MSG_NEW_EMAIL_REQ
            }
        }
    });
    $("#frmChngPaymentID").validate({
        rules: {
            paypalEmail: {
                required: true
            }
        },
        messages: {
            paypalEmail: {
                required: lang.MSG_ENT_PAY_GATE_ID
            }
        }
    });

    $("#frmMizutech").validate({
        rules: {
            mizutech_name: {
                required: true
            },
            mizutech_pwd: {
                required: true
            }
        },
        messages: {
            mizutech_name: {
                required: lang.MSG_ENT_MIZU_NAME
            },
            mizutech_pwd: {
                required: lang.MSG_ENT_MIZU_PWD
            }
        }
    });
});

$(document).on('click', '#btnChangePwd', function() {
    jQuery.validator.addMethod("notSame", function(value, element) {
        return $('#oldPwd').val() != $('#newPwd').val()
    }, 'Current Password and New Password can not be same.');

    $("#frmChngPwd").validate({
        rules: {
            oldPwd: {
                required: true,
                maxlength: 32,
                remote: {
                    url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
                    type: "post",
                    async: false,
                    data: {
                        oldPwd: function() {
                            return $("#oldPwd").val();
                        },
                        method: 'checkValidate'
                    }
                }
            },
            newPwd: {
                required: true,
                minlength: 6,
                maxlength: 32,
                notSame: true
            },
            cnfNewPwd: {
                required: true,
                minlength: 6,
                equalTo: newPwd,
                maxlength: 32
            }
        },
        messages: {
            oldPwd: {
                remote: lang.MSG_CURR_PASS_NOT_MATCH,
                required: lang.MSG_CURR_PASS_REQ
            },
            newPwd: {
                required: lang.MSG_NEW_PASS_REQ,
                minlength: lang.MSG_MIN_LENGTH
            },
            cnfNewPwd: {
                required: lang.MSG_CONF_PASS_REQ,
                minlength: lang.MSG_MIN_LENGTH,
                equalTo: lang.MSG_PASS_EQUAL
            }
        }
    });
    
   /* if ($("#frmChngPwd").valid()) {
        $.ajax({
            method: 'POST',
            url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
            data: {
                action: 'changePassword',
                newPwd: $("#newPwd").val(),
                oldPwd: $("#oldPwd").val(),
                cnfNewPwd: $("#cnfNewPwd").val()
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data.type == 'success') $("#newPwd").val('');
                $("#oldPwd").val('');
                $("#cnfNewPwd").val('');
                $(function() {
                    toastr[data.type](data.message);
                });
            }
        });
        return true;
    } else {
        return false;
    }*/
});
$(document).on('change', '[data-main="notificationSetting"]', function() {
    var notification_type = $(this).data('type');
    var check = $(this).is(':checked') == true ? 'y' : 'n';
    $.ajax({
        method: 'POST',
        url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
        data: {
            action: 'notiSettings',
            check: check,
            notification_type: notification_type
        },
        dataType: 'json',
        beforeSend: function() {
            showLoader();
        },
        complete: function() {
            hideLoader();
        },
        success: function(data) {
            if (data.type == 'success') toastr.clear();
            setTimeout(function() {
                $(function() {
                    toastr[data.type](data.message);
                });
            }, 500);
        }
    });
});

$(document).on('click','#deleteAccount',function (argument) {

    var response = confirm(lang.SURE_TO_DELETE_ACCOUNT+" "+siteNm+" ?");
    if (response) {
        window.location = siteUrl+'delete-account/';
    }
});

$(document).on('click', '#btnupdatepaypalEmail', function() {
	
	// $("#frmpaypalEmail").validate({
        // rules: {
            // paypalEmail: {
                // required: true,
			// }
		// },
		// messages: {
            // paypalEmail: {
				// required: lang.MSG_ENT_PAY_GATE_ID
			// }
		// }
	// });
	
	$('#btnupdatepaypalEmail').click(function() {
		
		// if ($("#frmpaypalEmail").valid()) {
			var paypalEmail = $('#paypalEmail').val();
            $.ajax({
                url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
                type: "POST",
                data: {
                    action: "changePaymentID",
					paypalEmail: paypalEmail
                },
                beforeSend: function() {
                    showLoader();
                },
                complete: function() {
                    hideLoader();
                },
                success: function(data) {
                    if (data == 'false') {
                        toastr['error'](lang.MSG_ENT_PAY_GATE_ID);
                    } else {
                        $("#frmEditProfile").submit();
                    }
                }
            });
        // }
    });
	
});