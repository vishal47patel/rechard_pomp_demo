$(document).ready(function(){
    $('#forgot_pwd_form').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter email ID",
                email: "Please enter valid email ID"
            }
        }
    });
});