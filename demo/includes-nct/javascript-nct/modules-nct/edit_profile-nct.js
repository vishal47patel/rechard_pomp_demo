$(document).ready(function() {

    if($('.img-preview-list').length >= 5) {
        $("#upload_image_section").hide();
    }
    $(document).on("click" , '.softImgDelete' , function(){
        $(this).parent().parent().remove();

        if($('.img-preview-list').length < 5) {
            $("#upload_image_section").show();
        }
    });

    $(document).on("click" , '.hardImgDelete' , function(){
        $(this).parent().parent().remove();
        $("#frmEditProfile").append("<input type='hidden' name='removeImages[]' value='"+$(this).attr('imageId')+"' />");

        if($('.img-preview-list').length < 5) {
            $("#upload_image_section").show();
        }
    });

    function IsDateHasEvent(date) {
        var allEvents = [];
        allEvents = $('#calendar').fullCalendar('clientEvents');
        var event = $.grep(allEvents, function (v) {
            return +v.start === +date;
        });
        return event.length > 0;
    }

    var cal_start_date = cal_end_date = "";
    var service_type = '';

    if($("#user_service_type").val() == 'mechanic') {
        service_type = 'mechanic';
        var calendar = $('#calendar').fullCalendar({
            defaultView: 'agendaWeek',
            editable:true,
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
            selectable:true,
            selectHelper:true,
            slotDuration:"01:00:00",    
            businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                dow: [], // Monday - Thursday
                start: '08:00', // a start time (10am in this example)
                end: '23:00', // an end time (6pm in this example)
            },
            editable:false,
            /*selectConstraint: {
                start: moment().format('YYYY-MM-DD HH:mm'),
                end: '2200-01-01'
            },  */  
            select: function(start, end, allDay)
            {
                /*if(end.getTime() != start.getTime()){
                  calendar.fullCalendar( 'unselect' ) ;
                }*/
                if (!IsDateHasEvent(start)) {
                    var check = start.toJSON().slice(0,10); 
                    var today = new Date().toJSON().slice(0,10);
                    if(check < today){
                        alert(lang.NOT_SELECT_PAST_TIME);
                        calendar.fullCalendar( 'unselect' );
                    }else{             
                        cal_start_date = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm");
                        cal_end_date = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm");

                        $("#availability_status").val("");
                        $("#setAvailabilityModal").modal("show");                          
                    }
                }
            },
            eventClick:function(event)
            {
                var eventDate = moment(event.start).format("YYYY-MM-DD"); 
                var check = eventDate; 
                var today = new Date().toJSON().slice(0,10);

                if( (event.type == 'availability') && ((check >= today)) ) {
                     if(confirm(lang.MAKE_SLOT_AVAILABLE_MSG))
                     {
                      var id = event.id;
                      $.ajax({
                            url: siteUrl+'edit-profile',
                            type: "POST",
                            data: {
                                availability_status: "yes",
                                action: 'setAvailabilityById',
                                availability_id: id
                            },
                            dataType : 'json',
                            beforeSend : function(){
                                showLoader();
                            },
                            complete: function() {
                                hideLoader();
                            },
                            success: function(data) {                   
                                if(data.status){
                                    calendar.fullCalendar('refetchEvents');
                                    toastr["success"](data.message);
                                }
                                else {
                                    toastr["error"](data.message);
                                }
                            }
                        });   
                     }
                 }
            },

           });
    }
    else {
        service_type = 'taxi';
        var calendar = $('#calendar').fullCalendar({
            initialView: 'dayGridMonth',
            displayEventTime: false,
            editable:true,            
            height: 'auto',
            header:{
             left:'prev,next today',
             center:'title',
             right:''
            },
            events: siteUrl + 'day_load.php?user_id=' + sessUserId,
            selectable:true,
            selectHelper:true,            
            businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                dow: [], // Monday - Thursday
                
            },
            editable:false,
            /*selectConstraint: {
                start: moment().format('YYYY-MM-DD'),
                end: '2200-01-01'
            },  */  
            select: function(start, end, allDay)
            {
                /*if(end.getTime() != start.getTime()){
                  calendar.fullCalendar( 'unselect' ) ;
                }*/

                if (!IsDateHasEvent(start)) {
                    var check = start.toJSON().slice(0,10); 
                    var today = new Date().toJSON().slice(0,10);
                    if(check < today){
                        alert(lang.NOT_SELECT_PAST_TIME);
                        calendar.fullCalendar( 'unselect' );
                    }else{             
                        cal_start_date = $.fullCalendar.formatDate(start, "Y-MM-DD");
                        cal_end_date = $.fullCalendar.formatDate(end, "Y-MM-DD");

                        $("#availability_status").val("");
                        $("#setAvailabilityModal").modal("show");                          
                    }
                }
            },
            eventClick:function(event)
            {
                var eventDate = moment(event.start).format("YYYY-MM-DD"); 
                var check = eventDate; 
                var today = new Date().toJSON().slice(0,10);

                if( (event.type == 'availability') && ((check >= today)) ) {
                 if(confirm(lang.MAKE_DATE_AVAILABLE_MSG))
                 {
                  var id = event.id;
                  $.ajax({
                        url: siteUrl+'edit-profile',
                        type: "POST",
                        data: {
                            availability_status: "yes",
                            action: 'setAvailabilityById',
                            availability_id: id
                        },
                        dataType : 'json',
                        beforeSend : function(){
                            showLoader();
                        },
                        complete: function() {
                            hideLoader();
                        },
                        success: function(data) {                   
                            if(data.status){
                                calendar.fullCalendar('refetchEvents');
                                toastr["success"](data.message);
                            }
                            else {
                                toastr["error"](data.message);
                            }
                        }
                    });   
                 }
             }
            },

           });
    }    

    $("#setAvailabilityBtn").click(function(){
        if($('#availability_status').val() != "") {   
            if(service_type == 'mechanic') {
                $.ajax({
                    url: siteUrl+'edit-profile',
                    type: "POST",
                    data: {
                        availability_status: $("#availability_status").val(),
                        action: 'setAvailability',
                        cal_start_date: cal_start_date,
                        cal_end_date: cal_end_date
                    },
                    dataType : 'json',
                    beforeSend : function(){
                        showLoader();
                    },
                    complete: function() {
                        hideLoader();
                    },
                    success: function(data) {                   
                        if(data.status){
                            $("#setAvailabilityModal").modal("hide");
                            calendar.fullCalendar('refetchEvents');
                            toastr["success"](data.message);
                        }
                        else {
                            toastr["error"](data.message);
                        }
                    }
                });     
            }
            else {
                $.ajax({
                url: siteUrl+'edit-profile',
                type: "POST",
                data: {
                    availability_status: $("#availability_status").val(),
                    action: 'setTaxiAvailability',
                    cal_start_date: cal_start_date,
                    cal_end_date: cal_end_date,
                    slot: 0
                },
                dataType : 'json',
                beforeSend : function(){
                    showLoader();
                },
                complete: function() {
                    hideLoader();
                },
                success: function(data) {                   
                    if(data.status){             
                        $("#setAvailabilityModal").modal("hide");           
                        calendar.fullCalendar('refetchEvents');
                        toastr["success"](data.message);
                    }
                    else {
                        toastr["error"](data.message);
                    }
                }
            });
            }

        }
        else {
            toastr['error'](lang.PLZ_SELECT_AVAILABILITY);
        }
    });

    $('#start_date').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '+0d',
        autoclose: true
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', minDate);

            var checkInDate = new Date($('#start_date').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            var checkOutDate = new Date($('#end_date').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            if(checkInDate > checkOutDate) {
                $('#end_date').datepicker('setDate', minDate);
            }
        });
    
    $('#end_date').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '+0d',
        autoclose: true
    });

    $('#availabilityFrm').validate({
        rules: {
            man_availabilty: {
                required: true
            },
            start_date: {
                required: true
            },
            end_date: {
                required: true
            },
            service_time_slot: {
                required: true
            }
        },
        messages: {
            man_availabilty: {
                required: lang.PLZ_SELECT_AVAILABILITY
            },
            start_date: {
                required: lang.PLZ_SELECT_START_DATE
            },
            end_date: {
                required: lang.PLZ_SELECT_END_DATE
            },
            service_time_slot: {
                required: lang.PLZ_SELECT_TIME_SLOT
            }
        }
    });

    $("#manualAvailabilityBtn").click(function(){
        if($('#availabilityFrm').valid()) {   

            var slot = '0';
            if(service_type == 'mechanic') {
                slot = $("#service_time_slot").val();
            }

            $.ajax({
                url: siteUrl+'edit-profile',
                type: "POST",
                data: {
                    availability_status: $("#man_availabilty").val(),
                    action: 'setManualAvailability',
                    cal_start_date: $("#start_date").val(),
                    cal_end_date: $("#end_date").val(),
                    slot: slot
                },
                dataType : 'json',
                beforeSend : function(){
                    showLoader();
                },
                complete: function() {
                    hideLoader();
                },
                success: function(data) {                   
                    if(data.status){                        
                        calendar.fullCalendar('refetchEvents');
                        toastr["success"](data.message);

                        $("#start_date").val("");
                        $("#end_date").val("");
                        $("#man_availabilty").val("");

                        if(service_type == 'mechanic') {
                            $("#service_time_slot").val("");
                        }                        
                    }
                    else {
                        toastr["error"](data.message);
                    }
                }
            });           
        }
    });

    // tomtomapi start
    var options = {
            placeholder: lang.ENTER + " " + lang.LOCATION + MEND_SIGN,
            searchOptions: {
                key: TOMTOM_KEY,
                language: 'en-GB',
                limit: 5
            },
            autocompleteOptions: {
                key: TOMTOM_KEY,
                language: 'en-GB'
            }
        };
        var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
        var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
        $("#locationSection").html(searchBoxHTML);
        $(".tt-search-box-input").attr("id" , "address");
        $(".tt-search-box-input").attr("name" , "address");
        $(".tt-search-box-input").attr("autocomplete", "off");
        $(".tt-search-box-input").val($("#addressVal").val());

        ttSearchBox.on('tomtom.searchbox.resultselected', handleResultSelection);

        function handleResultSelection(event) {
            $("#addLat").val(event.data.result.position.lat);
            $("#addLong").val(event.data.result.position.lng);
            
            /*if (isFuzzySearchResult(event)) {
                // Display selected result on the map
                var result = event.data.result;
                resultsManager.success();
                searchMarkersManager.draw([result]);
                fillResultsList([result]);
                searchMarkersManager.openPopup(result.id);
                fitToViewport(result);
                state.callbackId = null;
                infoHint.hide();
            } else if (stateChangedSinceLastCall(event)) {
                var currentCallbackId = Math.random().toString(36).substring(2, 9);
                state.callbackId = currentCallbackId;
                // Make fuzzySearch call with selected autocomplete result as filter
                handleFuzzyCallForSegment(event, currentCallbackId);
            }*/
        }
        // tomtom api ends

    $.validator.addMethod("letterRegex", function(value, element) {
        return this.optional(element) || (value.match(/[a-zA-Z]/));
    }, lang.ONE_LETTER_REQUIRED);

    $("#frmEditProfile").validate({
        ignore: "",
        rules: {
            firstName: {
                required: true,
                letterRegex: true,
                minlength: 3,
                maxlength: 15,
                remote: {
                    url: siteUrl + 'edit-profile',
                    type: "post",
                    async: false,
                    data: {
                        firstName: function() {
                            return $("#firstName").val();
                        },
                        lastName: function() {
                            return $("#lastName").val();
                        },
                        method: 'checkUniqueName'
                    }
                }
            },
            lastName: {
                required: true,
                letterRegex: true,
                minlength: 3,
                maxlength: 15,
                remote: {
                    url: siteUrl + 'edit-profile',
                    type: "post",
                    async: false,
                    data: {
                        firstName: function() {
                            return $("#firstName").val();
                        },
                        lastName: function() {
                            return $("#lastName").val();
                        },
                        method: 'checkUniqueName'
                    }
                }
            },            
            vehicle_type: {
                required: true
            },    
            business_name: {
                required: true
            },          
            // paypalEmail: {
                // required: true
            // },
            contactNo: {required: true,digits : true,minlength: 10,maxlength:15,remote:
              {
                 url: siteUrl+'modules-nct/'+phpModule+'/index.php',
                 type: "post",
                 async:false,
                 data: {
                    contactNo: function() {
                      return $( "#contactNo" ).val();
                    },
                    method : 'checkValidate'
                 }
              }
            },
            address: {
                required: true
            },
            img_name_hdn: {
                required: true
            }
        },
        messages: {
            firstName: {
                required: lang.MSG_FNAME_REQ,
                minlength: lang.MSG_MIN_3_CHAR,
                maxlength: lang.MSG_MAX_15_CHAR,
                remote: lang.NAME_ALREADY_EXIST
            },
            lastName: {
                required: lang.MSG_LNAME_REQ,
                minlength: lang.MSG_MIN_3_CHAR,
                maxlength: lang.MSG_MAX_15_CHAR,
                remote: lang.NAME_ALREADY_EXIST
            },            
            vehicle_type: {
                required: lang.MSG_VEHI_TYPE_REQ
            },   
            business_name: {
                required: lang.MSG_BNAME_REQ
            },       
            paypalEmail: {
                required: lang.MSG_ENT_PAY_GATE_ID
            },     
            contactNo: {
                required: lang.MSG_CONTACT_REQ,
                minlength: lang.MSG_MIN_10_CHAR,
                maxlength: lang.MSG_MAX_15_CHAR,
                digits : lang.MSG_ONLY_DIGIT,
                remote : lang.MSG_CONTACT_EXISTS
            },
            address: {
                required: lang.MSG_LOCATION_REQUIRED
            },
            img_name_hdn: {
                required: lang.PLZ_UPLAOD_PROFILE_PIC
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == 'img_name_hdn') {
                error.appendTo($("#profilePicError"));
            }else if (element.attr("name") == 'address') {
                error.appendTo($("#addressError"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    $('#btnEditProfile').click(function() {
        if ($("#frmEditProfile").valid()) {
			//console.log("phpModule" + phpModule);
            $.ajax({
                url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
                type: "POST",
                data: {
                    action: "checkProfileImg"
                },
                beforeSend: function() {
                    showLoader();
                },
                complete: function() {
                    hideLoader();
                },
                success: function(data) {
                    if (data == 'false') {
                        toastr['error'](lang.MSG_PROFILE_IMG_REQ);
                    } else {
                        $("#frmEditProfile").submit();
                    }
                }
            });
        }
    });
});
$(document).on("click","#pro_img",function(){
    $("#img_name").click();
});
var _URL = window.URL || window.webkitURL;
$('input[type=file][name=img_name]').on('change', function(event) {
    if ($(this).val() == '') {
        return;
    }
    var ext = $('#img_name').val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        $(function() {
            toastr['error'](lang.MSG_INVALID_IMG_TYPE);
        });
        $("#img_name").attr('value', '');
        return;
    }
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        $(img).on('load', function() {
            if (this.width >= 100 && this.height >= 100) {
                var path = URL.createObjectURL(event.target.files[0]);
                $('#file_src').attr('src', path);
                $('#imagepreview').attr('src', path);
                $('#myModal').modal('show');
            } else {
                $("#img_name").attr('value', '');
                $(function() {
                    toastr['error'](lang.MSG_UPLOAD_IMG_SIZE);
                });
            }
        });
        img.src = _URL.createObjectURL(file);
    }
});

function dataURLtoBlob(dataURL) {
    var BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        var parts = dataURL.split(',');
        var contentType = parts[0].split(':')[1];
        var raw = decodeURIComponent(parts[1]);
        return new Blob([raw], {
            type: contentType
        });
    }
    var parts = dataURL.split(BASE64_MARKER);
    var contentType = parts[0].split(':')[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;
    var uInt8Array = new Uint8Array(rawLength);
    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    try {
       blob = new Blob([uInt8Array], {
        type: contentType
    });
    }
    catch (e) {
       // Old browser, need to use blob builder
       window.BlobBuilder = window.BlobBuilder ||
                            window.WebKitBlobBuilder ||
                            window.MozBlobBuilder ||
                            window.MSBlobBuilder;
       if (window.BlobBuilder) {
           var bb = new BlobBuilder();
           bb.append(uInt8Array);
           blob = bb.getBlob(contentType);
       }
    }
    return blob;
}

function getCanvas(sourceCanvas) {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    var width = sourceCanvas.width;
    var height = sourceCanvas.height;
    canvas.width = width;
    canvas.height = height;
    context.drawImage(sourceCanvas, 0, 0, width, height);
    return canvas;
}
var $image = $('.img-container > img'),
    cropBoxData,
    canvasData,
    $btn = $('#crop_img');
$('#myModal').on('shown.bs.modal', function() {
    $(this).find('img').attr('src', $('#file_src').attr('src'));
    $image.cropper({
        aspectRatio: 1 / 1,
        strict: true,
        responsive: true,
        viewMode: 1,
        zoomable: true,
        zoomOnTouch: true,
        zoomOnWheel: true,
        responsive: true,
        movable: true,
        built: function() {
            $image.cropper('setCropBoxData', cropBoxData);
            $image.cropper('setCanvasData', canvasData);
        }
    });
    /*modal box hide event code*/
}).on('hidden.bs.modal', function() {
    cropBoxData = $image.cropper('getCropBoxData');
    canvasData = $image.cropper('getCanvasData');
    $("#img_name").val('');
    $image.cropper('destroy');
});
$('#crop_img').on('click', function(event) {
    event.preventDefault();
    var cropcanvas = $image.cropper('getCroppedCanvas');
    canvas = getCanvas(cropcanvas);
    console.log(canvas);
    roundedImage = document.createElement('img');
    roundedImage.src = canvas.toDataURL('image/png');
    formData = new FormData();
    var blob = dataURLtoBlob(roundedImage.src);
    formData.append('cropped_image', blob);
    $.ajax({
        url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        dataType: 'json',
        processData: false,
        beforeSend: function() {
            showLoader();
        },
        success: function(data) {
            hideLoader();
            $(function() {
                toastr[data.type](data.text);
            });
            $("#user_image").attr('src', data.imageURL);
            $("#userThumb").attr('src', data.smallImageURL);
            $('#myModal').modal('hide');
            $("#img_name_hdn").val(data.imageURL);
            $("#img_name_hdn").valid();
        },
        error: function(data) {
            hideLoader();
            $(function() {
                toastr['error'](lang.TRY_OTHER_IMAGE);
            });
            $('#myModal').modal('hide');
        }
    });
});

//////cropping/////
$(document).on('change', '#file', function(event) {
    var _this = $(this);
    var value = _this.val();
    var allowedFiles = ["jpg", "jpeg", "png"];
    var extension = value.split('.').pop().toLowerCase();

    if(value && value!='') {
        if ($.inArray(extension, allowedFiles) < 0) {
            toastr['info']("Please select valid image. (e.g. jpg, jpeg, png)");
        } else if (this.files[0].size > 4194304) {
            toastr['info']("Image size must be less then 4MB");
        } else {

            var url = URL.createObjectURL(event.target.files[0]);
            var img = $('<img src="' + url + '">');
            $('.avatar-wrapper').empty().html('<img src="' + url + '">');
            $('#avatar-modal').modal('show');
        }
    }else {
        $("#file").val("");
        event.preventDefault();
    }
});

$(document).on('hidden.bs.modal', '#avatar-modal', function() {
    $('.avatar-wrapper img').cropper('destroy');
    $('.avatar-wrapper').empty();
    $("#file").val("");

});

$(document).on('shown.bs.modal', '#avatar-modal', function() {
    $('.avatar-wrapper img').cropper({
        aspectRatio: 1/1,
        strict: true,
        responsive : true,
        viewMode : 2,
        crop: function(e) {
            var json = [
                '{"x":' + e.x,
                '"y":' + e.y,
                '"height":' + e.height,
                '"width":' + e.width,
                '"rotate":' + e.rotate + '}'
            ].join();
            $('.avatar-data').val(json);
        }
    });
});

$(document).on('click', '#btnCrop', function(evn) {
    evn.preventDefault();
    var avatarForm = $('.avatar-form');
    var frmCont = $('#frmEditProfile');
    var url = SITE_URL+'includes-nct/crop.php';

    var data =  new FormData(frmCont[0]);

    data.append('avatar_src', $('#avatar_src').val());
    data.append('avatar_data', $('#avatar_data').val());
    data.append('dest_site_folder', $('#dest_site_folder').val());
    data.append('dest_dir_folder', $('#dest_dir_folder').val());
    data.append('height', '265');
    data.append('width', '265');

    $.ajax(url, {
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function() {
            showLoader();
        },
        success: function(data) {
            //console.log(data);
            hideLoader();

            if(data.state==200) {
                //$('#show-croped-picture').attr('src', data.source);
                $('#allCarImages').append('<div class="col-6 col-sm-4 col-md-3 form-group"><div class="position-relative"><div class="img-preview-list"><img src="'+data.source+'" class="w-100"></div><a href="javascript:void(0)" class="close-icon softImgDelete"><i class="fa fa-times"></i></a><input type="hidden" name="uploadedImages[]" value="'+data.image+'" /></div></div>');
                $("#file").val("");
                $('#hiddenImg').val(data.image);
                $('#avatar-modal').modal('hide');

                if($('.img-preview-list').length >= 5) {
                    $("#upload_image_section").hide();
                }
            } else {}
        },
        complete: function() {
            //$('.loading').fadeOut();
            hideLoader();
        },
        error: function(data) {
            hideLoader();
            $(function() {
                toastr['error'](lang.TRY_OTHER_IMAGE);
            });
            $('#avatar-modal').modal('hide');
        }
    });
});

//////cropping/////