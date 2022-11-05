$(document).ready(function(){

	$(document).on("click" , "#openServiceModal" , function(){
		$("#service_date").val("");
		$("#description").val("");
		$("#amount").val("");
		$("#frmServiceRecord").validate().resetForm();
    	$('#add_new_service').modal('show');
	});

	$.validator.addMethod("letterRegex", function(value, element) {
        return this.optional(element) || (value.match(/[a-zA-Z]/));
    }, lang.ONE_LETTER_REQUIRED);

    $.validator.addMethod("checkVIN", function(value, element) {
    	var re = new RegExp("^[A-HJ-NPR-Z\\d]{8}[\\dX][A-HJ-NPR-Z\\d]{2}\\d{6}$");
  		return value.match(re);
    }, lang.ENTER_VALID_VIN);

	$("#searchFrm").validate({
		ignore: "",
		rules: {
			vin_number: {
				required: true,
				letterRegex: true,
				checkVIN: true
            }
		},
		messages: {
			vin_number: {
				required: lang.PLZ_ENTER_VIN_NUMBER
			}
		}
	});

    $('#searchVINBtn').click(function(){
    	if($("#searchFrm").valid()) {
	    	var vin_number = $('#vin_number').val();
	    	$.ajax({
			    url: siteUrl+'modules-nct/'+phpModule+'/index.php',
			    type: "POST",
			    data: {
				    vin_number: vin_number,
				    pageNo: 1,
				    action: "getVINDetails"
			    },
			    dataType : 'json',
			    beforeSend : function(){
			    	showLoader();
			    },
			    complete: function() {
			    	scrollToTop();
			    	hideLoader();
			    },
			    success: function(result) {			    	
			    	if(result.success){
						$(".result_page").html(result.content);

						$("#frmServiceRecord").validate({
							ignore: "",
							rules: {
								description: {
									required: true,
									minlength: 3
								},			
								service_date: {
									required: true
								},			
					            amount: {
					            	required: true,
					            	number : true,
					            	min: 1
					            },
							},
							messages: {
								description: {
									required: lang.MSG_DESCRIPTION_REQ,
									minlength: lang.MSG_MIN_3_CHAR
								},			
								service_date: {
									required: lang.PLZ_SELECT_SERVICE_DATE
								},
								amount: {
									required: lang.PLZ_ENTER_AMOUNT,
									number : lang.PLZ_ENTER_VALID_NUMBER,
									min: lang.MSG_ENTER_MIN_ONE	
								}
							}
						});

						$('#service_date').datepicker({
							format: 'dd-mm-yyyy',
							endDate: '+0d',
						    autoclose: true
						});

						$('.datepicker').css('z-index','1600 !important;');
					}
			    }
			});
	    }
    });

    $(document).on("click",".buttonPage",function(){
    	$('#currentPage').val($(this).data('page'));
		getSearchResults();
	});
});

function getSearchResults() {
	var vin_number = $('#vin_number').val();
	var pageNo = $('#currentPage').val();

	dataurl = siteUrl + 'service-book/?' + 'vin_number=' + vin_number 
			+ '&pageNo=' + pageNo;

	$.ajax({
	    url: siteUrl+'modules-nct/'+phpModule+'/index.php',
	    type: "POST",
	    data: {
		    vin_number: vin_number,
		    pageNo: pageNo,
		    action: "getSearchResults"
	    },
	    dataType : 'json',
	    beforeSend : function(){
	    	showLoader();
	    },
	    complete: function() {
	    	scrollToTop();
	    	hideLoader();
	    },
	    success: function(result) {
	    	/*if (typeof (history.pushState) != "undefined") {
		        var obj = { Title: 'serviceBook', Url: dataurl };
		        history.pushState(obj, obj.Title, obj.Url);
		    }*/
	    	if(result.success){
				$(".rgt-srch-list").html(result.content);
				$(".pagination").html(result.pagination);
			}
	    }
	});
}