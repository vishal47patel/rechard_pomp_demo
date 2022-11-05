var walletUrl = siteUrl + 'manage-wallet';
var flag = 0;
$(document).ready(function(e) {
  
	$('#frmDepositMoney').validate({
		rules: {
			amount: {
				required: true,
				number:true,
				min:1,
				max:50000,
			},
		},
		messages: {
			amount: {
				required: lang.PLZ_ENTER_AMOUNT,
				number : lang.MSG_ONLY_DIGIT,
				min:lang.VAL_GRE_THAN_ZERO,
				max:lang.VAL_LESS_THAN_NO_MORE,
			},
		},
		errorPlacement: function(error, element) {
			if (element.attr("data-error-container")) {
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element);
			}
		}
	});

});
