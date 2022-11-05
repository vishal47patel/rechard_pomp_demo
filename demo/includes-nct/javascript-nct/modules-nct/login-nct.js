$frmLogin = "#frmLogin"; {
    $($frmLogin).validate({
        rules: {
            email: {
                required: true,
                email: {
                    depends: function(element) {
                      return isNaN($("#email").val());
                    }
                },
                minlength: function () {
                  if(isNaN($("#email").val())) {
                    return 0;
                  }
                  else {
                    return 10;
                  }
                },
                maxlength: function () {
                  if(isNaN($("#email").val())) {
                    return 1000;
                  }
                  else {
                    return 15;
                  }
                }
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: lang.MSG_EMAIL_OR_NO_REQ,
                email: lang.MSG_VALID_EMAIL,
                minlength: lang.MSG_MIN_10_CHAR,
                maxlength: lang.MSG_MAX_15_CHAR,
            },
            password: {
                required: lang.MSG_PASS_REQ,
                minlength: lang.MIN_SIX_CHAR_REQUIRED
            }
        }
    });
}
$(document).ready(function() {    
    $('#forgot_pwd_form').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: lang.MSG_EMAIL_REQ,
                email: lang.MSG_VALID_EMAIL
            }
        }
    });

    $('#forgot_pwd_form').submit(function(e) {
        if($('#forgot_pwd_form').valid()) {
            showLoader();
        }
    });

    $('#forgotPwd , #resendMail').click(function() {
        $('#forgot_pwd_form')[0].reset();
        $('#forgot_pwd_form').validate().resetForm();
        if ($(this).attr('id') == 'forgotPwd') {
            $('#forgotPwdModal').find('#header').html('Forgot Password');
            $('#forgotPwdModal').find('#action').val('forgot_password');
        } else {
            $('#forgotPwdModal').find('#header').html('Resend Verification Mail');
            $('#forgotPwdModal').find('#action').val('resend_verification');
        }
    });
});