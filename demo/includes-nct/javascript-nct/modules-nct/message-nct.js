var removeClass = true;
var msgUrl = siteUrl + 'message-room';
var cloneValue = 0;
var destiUserName = '';
var sendChatMsg = '';

$(document).on("click", ".is-dotted-bx", function() {
	$('.lft-inbox').toggleClass('is-active');
	$('.is-dotted-bx').toggleClass('open');
	removeClass = false;
});
$(document).on("click", ".inbox-srch, .lft-inbox .nav-tabs li", function() {
	removeClass = false;
})
$(document).on("click", "html, .lft-inbox .tab-content ul li", function() {
	if (removeClass) {
		$('.lft-inbox').removeClass('is-active');
		$('.is-dotted-bx').removeClass('open');
	}
	removeClass = true;
});
$(document).ready(function($) {
	$(".lft-inbox, #messageBunch").mCustomScrollbar({
		theme: "dark"
	});
	setFancyBox();
	if($("#receiverId").val() > 0) {
		$('.getChat[data-userid="'+$("#receiverId").val()+'"]').click();
	}
});

function validate() {
	$msgForm = "#msgForm"; {
		$($msgForm).validate({
			rules: {
				message: {
					required: true
				},
			},
			messages: {
				message: {
					required: lang.MSG_REQ
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
	}
}
var tabType = 'i';
var userList = "";
var name = "";
$(document).on('click', '.search', function(event) {
	event.preventDefault();
	var tabType = $(this).attr('data-type');
	var name = $(this).closest('.inbox-srch').find('.txtSearch').val();
	var userList = $(this).closest('.messageTab').find('.userList');
	getUserList(tabType, userList, name);
});
$(document).on('click', '.tabLink,#back', function(event) {
	event.preventDefault();
	var tabType = $(this).attr('data-type');
	if (tabType == 'i') {
		var tt = 'inbox';
	} else {
		var tt = 'trashTab';
	}
	var userList = $('.messageTab');
	userList.removeClass('chat-tab');
	//var userList = $(this).closest('.main-div').find('#myTabContent').find('.userList');
	userList.attr('data-type', tt)
	$("#trashsrc , #inboxsrc").val('');

	$('#inbox-trash-tab').html('<div class="no-results text-center">'+ lang.PLZ_SELECT_ATLEAST_ONE_USER +'</div>');

	getUserList(tabType, userList, name);
});

function getUserList(tabType, userList, name) {
	name = name == "" ? "" : name;
	$.ajax({
		url: msgUrl,
		dataType: 'json',
		type: 'post',
		data: {
			action: 'getUserList',
			type: tabType,
			searchName: name
		},
		beforeSend: function() {
			showLoader();
		},
		success: function(response) {
			userList.html(response.retData);
			hideLoader();
		},
		error: function(response) {
			hideLoader();
			$(function() {
				toastr['error'](lang.MSG_SOMETHING_WRONG);
			});
		}
	});
}

function readStatus() {
	$.ajax({
		url: msgUrl,
		dataType: 'json',
		type: 'post',
		data: {
			action: 'readStatus'
		},
		success: function(response) {},
		error: function(response) {
			hideLoader();
			$(function() {
				toastr['error'](lang.MSG_SOMETHING_WRONG);
			});
		}
	});
}
$(document).on('click', '.deleteChat', function(event) {
	event.preventDefault();
	var receiverId = $(this).attr('data-userId');
	var $this = $(this);
	if (receiverId > 0) {
		if (confirm(lang.SURE_MOVE_TO_TRASH) == true) {

			var tabType = "i";
			var tt = 'inbox';

			var userList = $('.messageTab');
			userList.removeClass('chat-tab');
			userList.attr('data-type', tt)
			$("#trashsrc , #inboxsrc").val('');

			$("#inbox-trash-tab").removeClass('chat-tab');
			$('#inbox-trash-tab').html('<div class="no-results text-center">'+ lang.PLZ_SELECT_ATLEAST_ONE_USER +'</div>');
		

			$.ajax({
				url: msgUrl,
				dataType: 'json',
				type: 'post',
				data: {
					action: 'deleteMessage',
					receiverId: receiverId
				},
				beforeSend: function() {
					showLoader();
				},
				success: function(response) {
					if (response.status) {
						$this.closest('.mainUserLi').find('.lastMsgP').html(response.retData);
						$('.message_' + receiverId).html(response.msgData);
						userList.html(response.userList);
						
						toastr['success'](response.message);
					} else {
						toastr['error'](response.message);
					}
					hideLoader();
				},
				error: function(response) {
					hideLoader();
					$(function() {
						toastr['error'](lang.MSG_SOMETHING_WRONG);
					});
				}
			});
		}
	} else {
		toastr['error'](lang.MSG_SOMETHING_WRONG);
	}
});
$(document).on('click', '.getChat', function(event) {
	var tt = 'i';
	$('.mainUserLi').removeClass('active');
	$this = $(this);
	var receiverId = $this.attr('data-userId');
	var tabType = $this.closest('.messageTab').attr('data-type');
	if (tabType == 'inbox') {
		tt = 'i';
	} else {
		tt = 't';
	}
	if (receiverId > 0) {
		$.ajax({
			url: msgUrl,
			dataType: 'json',
			type: 'post',
			data: {
				action: 'getRightPanel',
				receiverId: receiverId,
				tabType: tabType
			},
			beforeSend: function() {
				showLoader();
			},
			success: function(response) {
				if (response.status) {
					if(!$this.closest('.mainUserLi').find(".unread_cnt").hasClass("d-none")) {
						$this.closest('.mainUserLi').find(".unread_cnt").addClass("d-none");
						$this.closest('.mainUserLi').find(".unread_cnt").removeClass("d-inline-block");
					}					

					$this.closest('.mainUserLi').addClass('active');
					$this.find('.countmy').remove();
					$('#inbox-trash-tab').html(response.retData);
					$("#inbox-trash-tab").addClass('chat-tab');
					$("#back").attr('data-type', tt);
					$("#bunchDiv").mCustomScrollbar('destroy');
					$("#bunchDiv").mCustomScrollbar({
						theme: "dark"
					});
					$("#bunchDiv").mCustomScrollbar("scrollTo", 'bottom', {
						scrollInertia: 0
					});
					//scrollToElement('h1');
					if (response.count > 0) {
						//$("#noti_count_msg").removeClass('d-none');
						$(".messageCount").html(response.count);
					} else {
						$(".messageCount").html(response.count);
						$(".messageCount").addClass('d-none');
					}
					destiUserName = response.destiUserName;
					setFancyBox();
					validate();
				} else {
					toastr['error'](lang.MSG_SOMETHING_WRONG);
				}
				hideLoader();
			},
			error: function(response) {
				hideLoader();
				$(function() {
					toastr['error'](lang.MSG_SOMETHING_WRONG);
				});
			}
		});
	}
});

$(document).on('click', '.loadPrev', function(event) {
	event.preventDefault();
	var $this = $(this);
	var receiverId = $("#receiverId").val();
	var pageNo = $this.attr('data-page');
	var tabType = $this.attr('data-tab-type');
	/*console.log(tabType);*/
	$.ajax({
		url: msgUrl,
		dataType: 'json',
		type: 'post',
		data: {
			action: 'getMessages',
			receiverId: receiverId,
			pageNo: pageNo,
			tabType: tabType
		},
		beforeSend: function() {
			showLoader();
		},
		success: function(response) {
			if (response.status) {
				$(".tempDate").remove();
				$("#messageBunch").prepend(response.retData)
				$("#rightPanel").mCustomScrollbar({
					theme: "dark"
				});
				$("#rightPanel").mCustomScrollbar("scrollTo", $this, {
					scrollInertia: 0
				});
				setFancyBox();
				$this.remove();
			} else {
				toastr['error'](lang.MSG_SOMETHING_WRONG);
			}
			hideLoader();
		},
		error: function(response) {
			hideLoader();
			$(function() {
				toastr['error'](lang.MSG_SOMETHING_WRONG);
			});
		}
	});
});
$(document).on('submit', '#msgForm', function(event) {
	event.preventDefault();
	var formData = new FormData(this);
	formData.append('returnType', 'y');
	formData.append('action', 'sendMessage');
	/*	formData.push({name: 'returnType', value: 'y'});
	formData.push({name: 'action', value: 'sendMessage'});*/
	var receiverId = $("#receiverId").val();
	sendChatMsg = $("#message").val();
	sendMessage(formData);
});
$(document).on('change', 'input[type=file]', function(event) {
	var filechk = $(this).val();
	if (filechk) {
		var formData = new FormData();
		var receiverId = $("#receiverId").val();
		formData.append('msgFile', this.files[0]);
		formData.append('receiverId', receiverId);
		formData.append('returnType', 'y');
		formData.append('action', 'sendMessage');
		sendChatMsg = "file sent";
		sendMessage(formData);
	}
});

function sendMessage(formData) {
	receiverId = $('#receiverId').val();
	/*parentDiv = $('.msg_inb_'+receiverId+'.active');
	cloneDiv =  parentDiv.clone(true);
	*/
	$.ajax({
		url: msgUrl,
		type: 'post',
		data: formData,
		dataType: 'json',
		contentType: false,
		processData: false,
		beforeSend: function() {
			showLoader();
		},
		success: function(response) {
			if (response.type == 'success') {
				//parentDiv.remove();
				$(".noMsgDiv").remove();
				$("#message").val('');
				$('#msgFile').val('');
				$("#messageBunch").append(response.content);
				$('.msg_inb_' + receiverId).find('.lastMsgP').html(response.plainMsg);
				//$('.userList').prepend(cloneDiv);
				//cloneValue = 1;
				$("#rightPanel").mCustomScrollbar("scrollTo", 'bottom', {
					scrollInertia: 0
				});
				webphone_api.sendchat(destiUserName, sendChatMsg);
				setFancyBox();
				hideLoader();
			} else {
				toastr[response.type](response.message);
				hideLoader();
			}
		},
		error: function(response) {
			hideLoader();
			$(function() {
				toastr['error'](lang.MSG_SOMETHING_WRONG);
			});
		}
	});
}

function setFancyBox() {
	$('a.imgFancy').fancybox({
		afterLoad: function() {
			this.title = '<a href="' + this.href + '">Download</a>';
		},
		helpers: {
			title: {
				type: 'inside'
			}
		}
	});
}
$newMessageForm = "#newMessageForm"; {
	$($newMessageForm).validate({
		ignore:"",
		rules: {
			message: {
				required: true
			},
			receiverId: {
				required: true
			},
		},
		messages: {
			message: {
				required: lang.MSG_REQ
			},
			receiverId: {
				required: lang.MSG_SELECT_USER
			},
		},
        errorPlacement: function (error, element) {
            if (element.attr("data-error-container")) {
              error.appendTo(element.attr("data-error-container"));
            } else {
              error.insertAfter(element);
            }
        }
	});
}

$(document).on('click','#newMessage',function(e){
	//$('.selectpicker').selectpicker('destroy');
	$('#user_list').selectpicker();
	$('#user_list').selectpicker('refresh');
	$('#newMessageForm')[0].reset();
	$('#newMessageModal').modal('show');
})

$('.selectpicker').on( 'hide.bs.select', function ( ) {
    $(this).trigger("focusout");
});

$(document).on('click', '.getChat1', function(event) {
	$this = $(this);
	var receiverId = $this.attr('data-userId');
	showLoader();	      
    setTimeout(function() {
        window.location.href = msgUrl + "/" + receiverId;
    }, 1000);
	
});

$( document ).ready(function() {
	var url = $(location).attr('href'),
    parts = url.split("/"),
	last_part = parts[parts.length-1];
    last_part_second = parts[parts.length-2];
	receiverId = last_part;
	var tabType = $('.messageTab').attr('data-type');
	if (tabType == 'inbox') {
		tt = 'i';
	} else {
		tt = 't';
	}
	if(last_part != 'message-room' && last_part_second == 'message-room'){
		if (receiverId > 0) {
			$.ajax({
				url: msgUrl,
				dataType: 'json',
				type: 'post',
				data: {
					action: 'getRightPanel',
					receiverId: receiverId,
					tabType: tabType
				},
				beforeSend: function() {
					showLoader();
				},
				success: function(response) {
					if (response.status) {
						
						$('#inbox-trash-tab').html(response.retData);
						$("#inbox-trash-tab").addClass('chat-tab');
						$("#back").attr('data-type', tt);
						$("#bunchDiv").mCustomScrollbar('destroy');
						$("#bunchDiv").mCustomScrollbar({
							theme: "dark"
						});
						$("#bunchDiv").mCustomScrollbar("scrollTo", 'bottom', {
							scrollInertia: 0
						});
						
						if (response.count > 0) {
							
							$(".messageCount").html(response.count);
						} else {
							$(".messageCount").html(response.count);
							$(".messageCount").addClass('d-none');
						}
						destiUserName = response.destiUserName;
						setFancyBox();
						validate();
					} else {
						toastr['error'](lang.MSG_SOMETHING_WRONG);
					}
					hideLoader();
				},
				error: function(response) {
					hideLoader();
					$(function() {
						toastr['error'](lang.MSG_SOMETHING_WRONG);
					});
				}
			});
		}
		
	}
	
});