$(document).ready(function(){
	var latitude = $("#addLat").val();
	var longitude = $("#addLong").val();

	try {
		//tt.setProductInfo('<your-product-name>', '<your-product-version>');
	    var map = tt.map({
	        key: TOMTOM_KEY,
	        container: 'map',
	        center: [longitude,latitude],
	        zoom: 10
	    });

	    var marker = new tt.Marker().setLngLat([longitude,latitude]).addTo(map);
    }
	catch(err) {
		console.log(err.message);
	}

    $('#addAmountForm').validate({
		rules: {
			amountVal: {
				required: true,
				number: true,
				min: 1
			}
		},
		messages: {
			amountVal: {
				required: lang.PLZ_ENTER_AMOUNT,
				number: lang.ENTER_VALID_NUMBER,
				min: lang.MSG_ENTER_MIN_ONE
			}
		}
	});

	$('#paymentMethodForm').validate({
		rules: {
			payment_method: {
				required: true
			}
		},
		messages: {
			payment_method: {
				required: lang.PLZ_SELECT_PAYMENT_METHOD
			}
		},
		errorPlacement: function (error, element) {
            if (element.attr("name") == 'payment_method') {
                error.appendTo($("#disp_method_error"));
            } else {
                error.insertAfter(element);
            }
        }
	});

    $("#rating_val").rateYo({
		rating: 3,
		starWidth: "20px"
	});

	$('#post_review').click(function() {
		if (!$('#post-review-form').valid()) {
			return false;
		}
		$.ajax({
			url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
			type: "POST",
			dataType: 'json',
			data: {
				action: "postReview",
				request_id: $('#request_id').val(),
				description: $('#description').val(),
				receiver_id: $('#receiver_id').val(),
				rating: $("#rating_val").rateYo('rating')
			},
			beforeSend: function() {
				showLoader();
			},
			complete: function() {
				//hideLoader();
			},
			success: function(data) {
				window.location.href = data.redirectLink;
			}
		});
	});
	$('#post-review-form').validate({
		rules: {
			description: {
				required: true
			}
		},
		messages: {
			description: {
				required: lang.MSG_ENTER_REVIEW
			}
		}
	});

    $("#startService").click(function(){
    	var response = confirm(lang.MSG_SURE_START_SERVICE);
		if (response) {
	    	var ele = $(this);

			$.ajax({
				url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
				type: "POST",
				dataType: 'json',
				data: {
					action: "startService",
					request_id: $('#request_id').val(),
				},
				beforeSend: function() {
					showLoader();
				},
				complete: function() {
					//hideLoader();
				},
				success: function(data) {
					window.location.href = data.redirectLink;
				}
			});
		}
    });

    $('#cancelService').click(function() {
		var response = confirm(lang.MSG_SURE_CANCEL_SERVICE);
		if (response) {
			var ele = $(this);

			$.ajax({
				url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
				type: "POST",
				dataType: 'json',
				data: {
					action: "cancelService",
					request_id: $('#request_id').val(),
					userType: ele.attr("userType")
				},
				beforeSend: function() {
					showLoader();
				},
				complete: function() {
					//hideLoader();
				},
				success: function(data) {
					window.location.href = data.redirectLink;
				}
			});
		}
	});

	$('#completionForm').validate({
		rules: {
			// completionMessage: {
				// required: true
			// },
			amountVal: {
				required: true,
				number: true,
				min: 1
			}
		},
		messages: {
			// completionMessage: {
				// required: lang.PLZ_ENTER_COMPL_MSG
			// },
			amountVal: {
				required: lang.PLZ_ENTER_AMOUNT,
				number: lang.ENTER_VALID_NUMBER,
				min: lang.MSG_ENTER_MIN_ONE
			}
		}
	});

	$('#completeService').click(function() {
		if($('#completionForm').valid()) {
			var response = confirm(lang.MSG_SURE_COMPLETE_SERVICE);
			if (response) {
				var ele = $(this);

				$.ajax({
					url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
					type: "POST",
					dataType: 'json',
					data: {
						action: "completeService",
						request_id: $('#request_id').val(),
						userType: ele.attr("userType"),
						completionMessage: $("#completionMessage").val(),
						accept_paypal: $('input[name="accept_paypal"]:checked').val(),
						amountVal: $("#amountVal").val(),
						payment_method: (ele.attr("userType") == 'customer') ? $('input[name="payment_method"]:checked').val() : ""
					},
					beforeSend: function() {
						showLoader();
					},
					complete: function() {
						//hideLoader();
					},
					success: function(data) {
						window.location.href = data.redirectLink;
					}
				});
			}
		}
	});
});