$(document).on("click",".servicePagi .buttonPage",function(){
    pageNo = $(this).attr('data-page');
    $.ajax({
        url: siteUrl+'profile/'+$("#considerUserId").val(),
        type: "POST",
        data: {
            action: 'serviceAjaxPagination',
            pageNo: pageNo,
        },
        dataType : 'json',
        beforeSend : function(){
            showLoader();
        },
        success: function(data) {
            if(data.success){
                $("#serviceBody").html(data.content);
                $("#servicePageContent").html(data.pageContent);
            }
            hideLoader();
        }
    });
});

$(document).on("click",".reviewPagi .buttonPage",function(){
    pageNo = $(this).attr('data-page');
    $.ajax({
        url: siteUrl+'profile/'+$("#considerUserId").val(),
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
                $("#reviewBody").html(data.content);
                $("#pageContent").html(data.pageContent);
            }
            hideLoader();
        }
    });
});

$(document).on("change","#isAvailability",function(){
	var isAvailability='n';

	var availability=$("#isAvailability").prop('checked');

	if(availability){
		isAvailability='y';
	}else{
		isAvailability='n';
	}

	var url = siteUrl + 'modules-nct/' + phpModule + '/index.php';
	if (sessUserId > 0) {
		$.post(url, {
			isAvailability: isAvailability,
			userId: sessUserId,
			action: 'changeAvailability'
		}, function(returnedData) {
			toastr['success'](returnedData['message']);
		}, 'json');
	} else {
		toastr['error'](lang.MSG_SOMETHING_WRONG);
	}
});

$(document).ready(function() { 
    $('.vehicle-img-slider').owlCarousel({
        loop:true,
        nav:true,
        items:1,
        dots:false,
        navText : ["<i class='icon-left-arrow'></i>","<i class='icon-next'></i>"]
    });
    
    if($("#user_service_type").val() == 'mechanic') {
    	var calendar = $('#calendar').fullCalendar({
    	defaultView: 'agendaWeek',
        editable:false,
        displayEventTime: false,
        slotLabelFormat: "HH:mm",
        allDaySlot: false,
        height: 'auto',
        header:{
         left:'prev,next today',
         center:'title',
         right:''
        },
        events: siteUrl + 'slot_load.php?user_id=' + sessUserId,
        selectable:false,
        selectHelper:false,
        slotDuration:"01:00:00",    
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            dow: [], // Monday - Thursday
            start: '08:00', // a start time (10am in this example)
            end: '23:00', // an end time (6pm in this example)
        },
        editable:false
       });
    }
    else {
        var calendar = $('#calendar').fullCalendar({
        initialView: 'dayGridMonth',
        editable:false,
        displayEventTime: false,
        height: 'auto',
        header:{
         left:'prev,next today',
         center:'title',
         right:''
        },
        events: siteUrl + 'day_load.php?user_id=' + sessUserId,
        selectable:false,
        selectHelper:false,
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            dow: [], // Monday - Thursday
            
        },
        editable:false
       });
    }

    $('#addStatusFrm').validate({
        rules: {
            addStatus: {
                required: true
            }
        },
        messages: {
            addStatus: {
                required: lang.PLZ_ENTER_STATUS
            }
        }
    });

    $("#add_status_btn").click(function(){
    	if($('#addStatusFrm').valid()) {
	    	if (sessUserId > 0) {
				$.post(siteUrl + 'modules-nct/' + phpModule + '/index.php', {
					addStatus: $("#addStatus").val(),
					userId: sessUserId,
					action: 'add_status'
				}, function(returnedData) {
                    $("#dispStatus").html($("#addStatus").val());
                    $("#addStatus").val("");
					$("#addStatusModal").modal('hide');                    
					toastr['success'](returnedData['message']);
				}, 'json');
			} else {
				toastr['error'](lang.MSG_SOMETHING_WRONG);
			}
		}
    });

    $('#openStatusModal').click(function (e) {
        $("#addStatusFrm").validate().resetForm();
        $("#addStatusModal").modal('show');
        
    });

    $('#openingHrsFrm').validate({
        rules: {
            openingHrs: {
                required: true
            }
        },
        messages: {
            openingHrs: {
                required: lang.PLZ_ENTER_OPENING_HRS
            }
        }
    });

    $("#opening_hrs_btn").click(function(){
        if($('#openingHrsFrm').valid()) {
            if (sessUserId > 0) {
                $.post(siteUrl + 'modules-nct/' + phpModule + '/index.php', {
                    openingHrs: $("#openingHrs").val(),
                    userId: sessUserId,
                    action: 'add_opening_hours'
                }, function(returnedData) {
                    $("#dispOpeningHrs").html($("#openingHrs").val());
                    $("#openingHrs").val("");
                    $("#openingHrsModal").modal('hide');                    
                    toastr['success'](returnedData['message']);
                }, 'json');
            } else {
                toastr['error'](lang.MSG_SOMETHING_WRONG);
            }
        }
    });

    $('#openOpeningHrsModal').click(function (e) {
        $("#openingHrsFrm").validate().resetForm();
        $("#openingHrsModal").modal('show');
        
    });
});