$(document).on("click",".buttonPage",function(){
	pageNo = $(this).attr('data-page');
	$.ajax({
		url: siteUrl+'my-service-request',
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