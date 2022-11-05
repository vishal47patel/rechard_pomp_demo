$(document).ready(function(){
    $('#frmResetPwd').validate({
            rules: {
                newPwd: {
                    required: true,
                    minlength: 6
                },
                cnfNewPwd: {
                    required: true,
                    equalTo: "#newPwd"
                }
            },
            messages: {
                newPwd: {
                    required: lang.ENTER_NEW_PASS,
                    minlength: lang.MIN_SIX_CHAR_REQUIRED
                },
                cnfNewPwd: {
                    required: lang.ENTER_CNFM_PASS,
                    equalTo: lang.NEW_CNFM_PASS_MATCH
                }
            }
        });
});