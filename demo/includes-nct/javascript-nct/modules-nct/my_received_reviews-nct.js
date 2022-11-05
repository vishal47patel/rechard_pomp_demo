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

$(document).on("click",".rpy_btn",function(){
	var id=$(this).data('id');
	$(".post_rpy"+id).toggleClass("hide");
	$(this).hide();
});

$(document).on("click",".cancelReply",function(){
	var id=$(this).data('id');
	$(".post_rpy"+id).toggleClass("hide");
	$(".rply_btn"+id).show();
});

$(document).ready(function() {
    $('#frmPostReply').validate({
        rules: {
            description: {
                required: true
            }
        },
        messages: {
            description: {
                required: lang.REPLY_THIS_REVIEW
            }
        }
    });
});