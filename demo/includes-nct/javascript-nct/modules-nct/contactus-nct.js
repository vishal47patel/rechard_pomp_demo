$frmFeed = "#frmFeed"; {
    $($frmFeed).validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            message: {
                required: true
            },
            firstName: {
                required: true
            },
            lastName: {
                required: true
            },

        },
        messages: {
            email: {
                required: lang.MSG_EMAIL_REQ
            },
            message: {
                required: lang.MSG_REQ
            },
            firstName: {
                required: lang.MSG_FNAME_REQ
            },
            lastName: {
                required: lang.MSG_LNAME_REQ
            },

        }
    });
}