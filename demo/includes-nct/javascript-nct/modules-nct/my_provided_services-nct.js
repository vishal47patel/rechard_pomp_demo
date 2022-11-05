$(document).on("click",".buttonPage",function(){
	pageNo = $(this).attr('data-page');
	$.ajax({
		url: siteUrl+'my-provided-services',
		type: "POST",
		data: {
			action: 'ajaxPagination',
			pageNo: pageNo,
		},
		dataType : 'json',
		beforeSend : function(){
			showLoader();
		},
		success: function(data) {
			if(data.success){
				$("#serviceBody").html(data.content);
				$("#pageContent").html(data.pageContent);
				scrollToTop();
			}
			hideLoader();
		}
	});
});

$(document).ready(function(){
	$('#openAddServiceModal').click(function (e) {
		$("#service_name").val("");
        $("#frmAddService").validate().resetForm();
        $("#add_new_service").modal('show');
        
    });

	$('#frmAddService').validate({
        rules: {
            service_name: {
                required: true
            }
        },
        messages: {
            service_name: {
                required: lang.PLZ_ENTER_SERVICE_NAME
            }
        }
    });
});