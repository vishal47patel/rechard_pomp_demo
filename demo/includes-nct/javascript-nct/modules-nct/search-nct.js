var latitude = '';
var longitude = '';
var radiusConsider = '';

$(document).ready(function(){
	if($("#considerRadius").val() != "") {
		radiusConsider = $("#considerRadius").val();
	}
	else {
		radiusConsider = 'single';
	}

	$("#searchFrm").validate({
        ignore: "",
        rules: {
            service_type: {
                required: true
            },
            radius: {
                required: true,
                digits: true,
                min: 1
            }
        },
        messages: {
            service_type: {
                required: lang.MSG_SERVICE_TYPE_REQ
            },
            radius: {
                required: lang.PLZ_ENTER_SEARCH_RADIUS,
                digits: lang.MSG_ONLY_DIGIT,
                min: lang.MSG_ENTER_MIN_ONE
            }
        }
    });

	if (navigator.geolocation) {
    	navigator.geolocation.getCurrentPosition(function(position){
	        var crd = position.coords;
	        latitude = crd.latitude;
	        longitude = crd.longitude;

	        /*if(sessUserId == 34) {
				latitude = "23.0225";
				longitude = "72.5714";
			}*/
	        getSearchResults();
       } , function() {      
            $('.rgt-srch-list').html('<div class="no-proivder-section no-data-block">' + lang.PLZ_ENABLE_LOCATION + '</div>');
        });
   }

	$( "#slider-range" ).slider({
      range: true,
      min: parseInt($('#slider_minRadius').val()),
      max: parseInt($('#slider_maxRadius').val()),
      values: [ $('#minRadius').val(), $('#maxRadius').val() ],
      slide: function( event, ui ) {
       // $( "#amount" ).val(  ui.values[ 0 ] + " - "+ ui.values[ 1 ] );
        $('#minRadius').val(ui.values[ 0 ]);
        $('#maxRadius').val(ui.values[ 1 ]);
        $('#minRadiusDisp').html(ui.values[ 0 ] + lang.KM);
        $('#maxRadiusDisp').html(ui.values[ 1 ] + lang.KM);
      },
      stop: function( event, ui ) {
      	$('#currentPage').val('1');
      	radiusConsider = 'double';
      	getSearchResults();
      }
    });

    $( "#amount" ).val(  $( "#slider-range" ).slider( "values", 0 ) +
      " - "+ $( "#slider-range" ).slider( "values", 1 ) );

    $('#searchBtn').click(function(){
    	if (navigator.geolocation) {
	    	navigator.geolocation.getCurrentPosition(function(position){
		        var crd = position.coords;
		        latitude = crd.latitude;
		        longitude = crd.longitude;

		        /*if(sessUserId == 34) {
					latitude = "23.0225";
					longitude = "72.5714";
				}*/

				if($('#searchFrm').valid()) {
			    	$('#currentPage').val('1');
			    	radiusConsider = 'single';

			    	//if($("#radius").val() > $('#slider_maxRadius').val()) {
			    		$('#slider_maxRadius').val($("#radius").val());
			    		$('#maxRadius').val($("#radius").val());
			    		$("#maxRadiusDisp").html($("#radius").val() + lang.KM);
			    		$(".max-price-h").html($("#radius").val() + lang.KM);
			    	//}
			    	getSearchResults();
			    }
	       } , function() {      
	            $('.rgt-srch-list').html('<div class="no-proivder-section no-data-block">' + lang.PLZ_ENABLE_LOCATION + '</div>');
	        });
	   }
    });

    $(document).on("click",".buttonPage",function(){
    	$('#currentPage').val($(this).data('page'));
		getSearchResults();
	});
});

function getSearchResults() {
	var service_type = $('#service_type').val();
	var radius = $('#radius').val();
	var toLat = $('#to_location_lat').val();
	var toLng = $('#to_location_lng').val();
	var stprice = $('#sortByPrice').val();
	var sttime = $('#sortByTime').val();
	var date = $('#journey_date').val();
	var eradius = $('#extend_radius').val();
	var minRadius = $('#minRadius').val();
	var maxRadius = $('#maxRadius').val();
	var ibook = $('#instant_book').is(":checked") ? 'y' : '';
	var isAc = $('#isAc').is(":checked") ? 'y' : '';
	var isTwoBackSeat = $('#isTwoBackSeat').is(":checked") ? 'y' : '';
	var pageNo = $('#currentPage').val();
	var provider_name = $('#provider_name').val();

	dataurl = siteUrl + 'search/?' + 'service_type=' + service_type + '&radius='
			+ radius + '&minRadius=' + minRadius + '&maxRadius=' + maxRadius
			+ '&pageNo=' + pageNo + '&radiusConsider=' + radiusConsider + '&provider_name=' + provider_name;

	$.ajax({
	    url: siteUrl+'modules-nct/'+phpModule+'/index.php',
	    type: "POST",
	    data: {
		    service_type: service_type,
		    radius: radius,
		    minRadius: minRadius,
		    maxRadius: maxRadius,
		    pageNo: pageNo,
		    action: "getSearchResults",
		    latitude: latitude,
		    longitude: longitude,
		    radiusConsider: radiusConsider,
		    provider_name: provider_name
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
	    	if (typeof (history.pushState) != "undefined") {
		        var obj = { Title: 'search', Url: dataurl };
		        history.pushState(obj, obj.Title, obj.Url);
		    }
	    	if(result.success){
				$(".rgt-srch-list").html(result.content);
				$(".pagination").html(result.pagination);
			}
	    }
	});
}