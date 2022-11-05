 $frmContact = "#frmContact"; {
        $($frmContact).validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                firstName: {
                    required: true,
                    minlength: 3
                },
                lastName: {
                    required: true,
                    minlength: 3
                },
                contactNo: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength:15
                },
                subject: {
                    required: true,
                },
                message: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: lang.MSG_EMAIL_REQ,
                    email: lang.MSG_VALID_EMAIL,
                },
                firstName: {
                    required: lang.MSG_FNAME_REQ,
                    minlength: lang.MSG_MIN_3_CHAR
                },
                lastName: {
                    required: lang.MSG_LNAME_REQ,
                    minlength: lang.MSG_MIN_3_CHAR
                },
                contactNo: {
                    required: lang.MSG_CONTACT_REQ,
                    minlength: lang.MSG_MIN_10_CHAR,
                    maxlength: lang.MSG_MAX_15_CHAR,
                    digits : lang.MSG_ONLY_DIGIT,
                },
                subject: {
                    required: lang.MSG_SUBJECT_REQ,
                },
                message: {
                    required: lang.MSG_REQ,
                }
            }
        });
    }