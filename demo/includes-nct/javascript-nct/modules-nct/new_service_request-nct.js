$(document).on("click",".buttonPage",function(){
	pageNo = $(this).attr('data-page');
	$.ajax({
		url: siteUrl+'new-service-request',
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

$(document).on("click",".acpt_rej_req",function(){
		var id=$(this).data('id');
		var type=$(this).data('type');

		var url = siteUrl + 'modules-nct/' + phpModule + '/index.php';
		if (sessUserId > 0) {

			$.ajax({
				url: url,
				type: "POST",
				data: {
					type: type,
					userId: sessUserId,
					id: id,
					action: 'acpt_rej_req',
				},
				dataType : 'json',
				beforeSend : function(){
					showLoader();
				},
				success: function(data) {
					if(type == 'a') {
						window.location.href = SITE_URL + 'service-detail/' + id;
					}
					else {
						window.location.reload();
					}
					hideLoader();
				}
			});

		} else {
			toastr['error'](lang.MSG_SOMETHING_WRONG);
		}
	});