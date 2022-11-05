$(document).ready(function(){

    var crd_latitude = crd_longitude = '';
    var mechanicOwl;

    $(document).on("click" , ".mechanicBtn" , function(){
        $(".mechanicBtn").removeClass("active");
        if(!$(this).hasClass("active")) {
            $(this).addClass("active");
        }

        $.ajax({
            method: 'POST',
            url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
            data: {
                action: 'getNearByProvidersMech',
                latitude: crd_latitude,
                longitude: crd_longitude,
                vehicle_type: $(this).attr("vehicle_type")
            },
            dataType: 'json',
            beforeSend: function() {showLoader();},
            complete: function() {hideLoader();},
            success: function(data) {
                if (data.type == 'success') {
                    
                    $("#nearByProviderSection").html(data.content);
                    if($(".nearby-provider-items").length > 0) {                               
                        $("#nearByProviderSection").show();
                        if(!$("#noProviderFound").hasClass("d-none")) {
                            $("#noProviderFound").addClass("d-none");
                        }

                        mechanicOwl.trigger("destroy.owl.carousel");

                        $('.nearby-provider-slider').owlCarousel({
                            loop: false,
                            rewind: true,
                            margin:30,
                            nav:true,
                            navText : ["<i class='icon-left-arrow'></i>","<i class='icon-next'></i>"],
                            responsive:{
                                0:{
                                    items:1
                                },
                                600:{
                                    items:2
                                },
                                1000:{
                                    items:3
                                },
                                1500:{
                                    items:3
                                }
                            }
                        });

                        if($(".nearby-provider-items").length <= 3) {
                            $(".nearby-provider-slider").find(".owl-prev").remove();
                            $(".nearby-provider-slider").find(".owl-next").remove();
                        }
                    }
                    else {
                        $("#nearByProviderSection").html("");
                        //$("#nearByProviderSection").hide();
                        $("#noProviderFound").removeClass("d-none");
                    }
                }                        
            }
        });
    });

    if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position){
                var crd = position.coords;
                var lat = crd_latitude = crd.latitude;
                var long = crd_longitude = crd.longitude;
                
                /*if(sessUserId == 34) {
                    lat = crd_latitude = "23.0225";
                    long = crd_longitude = "72.5714";
                }*/
                /*tt.services.reverseGeocode({
                    key: TOMTOM_KEY,
                    position: lat + ',' + long,
                    language: 'en-GB'
                }).then(function(response){
                    console.log(response.addresses[0].address);
                });*/
            
                $.ajax({
                    method: 'GET',
                    url: "https://api.tomtom.com/search/2/reverseGeocode/"+lat + ',' + long+".json?key="+TOMTOM_KEY,
                    data: {},                    
                    success: function(response) {
                        $("#currentCityName").html(response.addresses[0].address.localName);
                    }
                });

                //get mechanics
                $.ajax({
                    method: 'POST',
                    url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
                    data: {
                        action: 'getNearByProvidersMech',
                        latitude: crd_latitude,
                        longitude: crd_longitude,
                    },
                    dataType: 'json',
                    beforeSend: function() {showLoader();},
                    complete: function() {hideLoader();},
                    success: function(data) {
                        if (data.type == 'success') {                           

                            $("#nearByProviderSection").html(data.content);
                            if($(".nearby-provider-items").length > 0) {                               

                                mechanicOwl = $('.nearby-provider-slider').owlCarousel({
                                    loop: false,
                                    rewind: true,
                                    margin:30,
                                    nav:true,
                                    navText : ["<i class='icon-left-arrow'></i>","<i class='icon-next'></i>"],
                                    responsive:{
                                        0:{
                                            items:1
                                        },
                                        600:{
                                            items:2
                                        },
                                        1000:{
                                            items:3
                                        },
                                        1500:{
                                            items:3
                                        }
                                    }
                                });

                                if($(".nearby-provider-items").length <= 3) {
                                    $(".nearby-provider-slider").find(".owl-prev").remove();
                                    $(".nearby-provider-slider").find(".owl-next").remove();
                                }
                            }
                            else {
                                $("#nearByProviderSection").hide();
                                $("#noProviderFound").html(lang.NO_NEARBY_PROVIDER_FOUND);
                                $("#noProviderFound").removeClass("d-none");
                                $(".mechanicFilterSec").hide();
                            }
                        }                        
                    }
                });

                //get taxi
                $.ajax({
                    method: 'POST',
                    url: siteUrl + 'modules-nct/' + phpModule + '/index.php',
                    data: {
                        action: 'getNearByProvidersTaxi',
                        latitude: crd.latitude,
                        longitude: crd.longitude,
                    },
                    dataType: 'json',
                    beforeSend: function() {showLoader();},
                    complete: function() {hideLoader();},
                    success: function(data) {
                        if (data.type == 'success') {                           

                            $("#nearByTaxiSection").html(data.content);
                            if($(".nearby-taxi-items").length > 0) {                               

                                $('.nearby-taxi-slider').owlCarousel({
                                    loop: false,
                                    rewind: true,
                                    margin:30,
                                    nav:true,
                                    navText : ["<i class='icon-left-arrow'></i>","<i class='icon-next'></i>"],
                                    responsive:{
                                        0:{
                                            items:1
                                        },
                                        600:{
                                            items:2
                                        },
                                        1000:{
                                            items:3
                                        },
                                        1500:{
                                            items:3
                                        }
                                    }
                                });

                                if($(".nearby-taxi-items").length <= 3) {
                                    $(".nearby-taxi-slider").find(".owl-prev").remove();
                                    $(".nearby-taxi-slider").find(".owl-next").remove();
                                }
                            }
                            else {
                                $("#nearByTaxiSection").hide();
                                $("#noTaxiFound").html(lang.NO_NEARBY_PROVIDER_FOUND);
                                $("#noTaxiFound").removeClass("d-none");
                            }
                        }                        
                    }
                });
                } , function() {                    
                        $("#nearByProviderSection").hide();
                        $("#nearByTaxiSection").hide();
                        $("#noProviderFound").html(lang.PLZ_ENABLE_LOCATION);
                        $("#noProviderFound").removeClass("d-none");
                        $("#noTaxiFound").html(lang.PLZ_ENABLE_LOCATION);
                        $("#noTaxiFound").removeClass("d-none");
        });
    }
    else {
        toastr["error"]("Geolocation is not supported by this browser.");
    }

    $("#searchFrm").validate({
        ignore: "",
        rules: {
            service_type: {
                required: true
            },
            radius_val: {
                required: true,
                digits: true,
                min: 1
            }
        },
        messages: {
            service_type: {
                required: lang.MSG_SERVICE_TYPE_REQ
            },
            radius_val: {
                required: lang.PLZ_ENTER_SEARCH_RADIUS,
                digits: lang.MSG_ONLY_DIGIT,
                min: lang.MSG_ENTER_MIN_ONE
            }
        }
    });

	$('#searchBtn').click(function(){
        if($("#searchFrm").valid()) {
            window.location.href = siteUrl + 'search?service-type='+$("#service_type").val()+'&radius='+$("#radius_val").val();
        }
	});

    /// Service Book
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

    $("#searchVINFrm").validate({
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
        if($("#searchVINFrm").valid()) {
            var vin_number = $('#vin_number').val();
            $.ajax({
                url: siteUrl+'modules-nct/service_book-nct/index.php',
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
        url: siteUrl+'modules-nct/service_book-nct/index.php',
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
