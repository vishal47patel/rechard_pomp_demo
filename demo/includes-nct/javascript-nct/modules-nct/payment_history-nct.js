$(document).on("click",".buttonPage",function(){
	pageNo = $(this).attr('data-page');
	$.ajax({
		url: siteUrl+'payment-history',
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
				$(".table_row").remove();
				$("#tableBody").append(data.content);
				$("#pageContent").html(data.pageContent);
				scrollToTop();
			}
			hideLoader();
		}
	});
});