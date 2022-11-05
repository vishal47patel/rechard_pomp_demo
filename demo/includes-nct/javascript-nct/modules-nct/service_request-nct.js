$(document).ready(function(){
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
        events: siteUrl + 'slot_load.php?user_id=' + $("#provider_id").val(),
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
        events: siteUrl + 'day_load.php?user_id=' + $("#provider_id").val(),
        selectable:false,
        selectHelper:false,
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            dow: [], // Monday - Thursday
            
        },
        editable:false
       });
    }

	$('#service_date').datepicker({
		format: 'dd-mm-yyyy',
		startDate: '+0d',
	    autoclose: true
	});

	$.validator.addMethod("checkPastTime", function(value, element) {       
        var service_time = $("#service_time_slot").val();
		var currentDate = new Date();
		var selectedDate = new Date($('#service_date').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3") + ' ' + (service_time - 1) + ":00");

		if(selectedDate <= currentDate) {
			return false;
		}
		else {
			return true;
		}

    }, lang.PAST_TIME_NOT_ALLOWED);

	$("#frmMechServiceRequest").validate({
		ignore: "",
		rules: {					
			service_date: {
				required: true
			},			
            service_time_slot: {
            	required: true,
            	checkPastTime: true
            },
		},
		messages: {					
			service_date: {
				required: lang.PLZ_SELECT_SERVICE_DATE
			},
			service_time_slot: {
				required: lang.PLZ_SELECT_SERVICE_TIME
			}
		}
	});

	$('#start_date').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '+0d',
        autoclose: true
    }).on('changeDate', function (selected) {
            /*var minDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', minDate);

            var checkInDate = new Date($('#start_date').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            var checkOutDate = new Date($('#end_date').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            if(checkInDate > checkOutDate) {
                $('#end_date').datepicker('setDate', minDate);
            }*/

            if($("#end_date").val() != "") {
            	$("#end_date").valid();
            }
        });
    
    /*$('#end_date').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '+0d',
        autoclose: true
    });*/

    $('.clockpicker').clockpicker();

    jQuery.validator.addMethod("customChkOnwardTime", function(value, element) {
	  	var selectedDate = new Date($('#start_date').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3") + ' ' + $(element).val());
		var currentDate = new Date();

		if(currentDate > selectedDate){
			return false;
		}
		else {
			return true;
		}
	}, lang.PAST_TIME_NOT_ALLOWED);

    $("#frmTaxiServiceRequest").validate({
		ignore: "",
		rules: {					
			start_date: {
				required: true
			},			
            end_date: {
            	required: true,
            	customChkOnwardTime: true
            },
		},
		messages: {					
			start_date: {
				required: lang.PLZ_SELECT_START_DATE
			},
			end_date: {
				required: lang.PLZ_SELECT_TIME
			}
		}
	});

	$("#btnAddMechService").click(function(){
		if($("#frmMechServiceRequest").valid()) {

			var service_time = $("#service_time_slot").val();
			var currentDate = new Date();
			var selectedDate = new Date($('#service_date').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3") + ' ' + (service_time - 1) + ":00");

			if(selectedDate <= currentDate) {
				toastr["error"](lang.PAST_TIME_NOT_ALLOWED);
			}
			else {
				var provider_id = $("#provider_id").val();

				$.ajax({
				    url: siteUrl+'modules-nct/'+phpModule+'/index.php',
				    type: "POST",
				    data: {
					    provider_id: provider_id,
					    service_date: $("#service_date").val(),
					    service_time_slot: $("#service_time_slot").val(),
					    action: "checkProviderAvailability"
				    },
				    dataType : 'json',
				    beforeSend : function(){
				    	showLoader();
				    },
				    complete: function() {
				    	
				    },
				    success: function(data) {			    	
				    	if(data.result == 'success'){
				    		$("#frmMechServiceRequest").submit();
						}
						else {
							toastr["error"](lang.PROV_NOT_AVAILABLE);
						}
						hideLoader();
				    }
				});				
			}
		}
	});

	$("#btnAddTaxiService").click(function(){
		if($("#frmTaxiServiceRequest").valid()) {			
			var provider_id = $("#provider_id").val();

			$.ajax({
			    url: siteUrl+'modules-nct/'+phpModule+'/index.php',
			    type: "POST",
			    data: {
				    provider_id: provider_id,
				    start_date: $("#start_date").val(),
				    end_date: $("#end_date").val(),
				    action: "checkTaxiProvAvailability"
			    },
			    dataType : 'json',
			    beforeSend : function(){
			    	showLoader();
			    },
			    complete: function() {
			    	
			    },
			    success: function(data) {			    	
			    	if(data.result == 'success'){
			    		$("#frmTaxiServiceRequest").submit();
					}
					else {
						toastr["error"](lang.TAXI_PROV_NOT_AVAILABLE);
					}
					hideLoader();
			    }
			});				
			
		}
	});
});