function validRecaptcha() {
  $("#hiddenRecaptcha").valid();
}

$.validator.addMethod("letterRegex", function(value, element) {
        return this.optional(element) || (value.match(/[a-zA-Z]/));
    }, lang.ONE_LETTER_REQUIRED);

$frmRegi = "#frmRegi"; {
	$($frmRegi).validate({
		ignore: "",
		rules: {
			businessName: {
				required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				},
			},
			firstName: {
				required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return false;
			          }
			          else {
			          	return false;
			          }
			        }
				},
				letterRegex: true,
				minlength: 3,
				maxlength: 15,
				remote: {
                    url: siteUrl + 'sign-up',
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
				required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return false;
			          }
			          else {
			          	return false;
			          }
			        }
				},
				letterRegex: true,
				minlength: 3,
				maxlength: 15,
				remote: {
                    url: siteUrl + 'sign-up',
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
			user_type: {
				required: true
			},
			service_type: {
				required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				}
			},
			vehicle_type: {
				required: {
					depends: function(element) {
			          if($("#service_type").val() == "mechanic") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				}
			},
			email: {
				required: true,
				email: true,
				remote:
	              {
	                 url: siteUrl+'modules-nct/'+phpModule+'/index.php',
	                 type: "post",
	                 async:false,
	                 data: {
	                    email: function() {
	                      return $( "#email" ).val();
	                    },
	                    method : 'checkValidate'
	                 }
	              }
            },
			/* vspl changes start changes 26-09-2022 */
			line1: {
				required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				},
            },
			line2: {
               required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				},
            },
			city: {
                required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				},
            },
			postcode: {
                required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				},
            },
			country: {
                required: {
					depends: function(element) {
			          if($("#user_type").val() == "provider") {
			          	return true;
			          }
			          else {
			          	return false;
			          }
			        }
				},
            },
			/* vspl changes end changes 26-09-2022 */
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
			/* vspl changes start changes 26-09-2022
            address: {
                required: true
            }, */
			password: {
				required: true,
				minlength : 6
			},
			c_password: {
				required: true,
				minlength: 6,
				equalTo : "#password"
			},
			// hiddenRecaptcha: {
                // required: function () {
                    // if (grecaptcha.getResponse() == '') {
                        // return true;
                    // } else {
                        // return false;
                    // }
                // }
            // }
            
		},
		messages: {
			
			businessName: {
				required: lang.MSG_BNAME_REQ,
			},
			/* vspl changes start changes 26-09-2022 */
			line1: {
				required:lang.MSG_LINE1_REQ, 
            },
			line2: {
               required:lang.MSG_LINE2_REQ,
            },
			city: {
                required:lang.MSG_CITY_REQ,
            },
			postcode: {
                required:lang.MSG_POSTCODE_REQ,
            },
			country: {
                required:lang.MSG_COUNTRY_REQ,
            },
			/* vspl changes end changes 26-09-2022 */
			firstName: {
				// required: lang.MSG_FNAME_REQ,
				minlength: lang.MSG_MIN_3_CHAR,
				maxlength: lang.MSG_MAX_15_CHAR,
				remote: lang.NAME_ALREADY_EXIST
			},
			lastName: {
				// required: lang.MSG_LNAME_REQ,
				minlength: lang.MSG_MIN_3_CHAR,
				maxlength: lang.MSG_MAX_15_CHAR,
				remote: lang.NAME_ALREADY_EXIST
			},
			user_type: {
				required: lang.MSG_USER_TYPE_REQ
			},
			service_type: {
				required: lang.MSG_SERVICE_TYPE_REQ
			},
			vehicle_type: {
				required: lang.MSG_VEHI_TYPE_REQ
			},
			email: {
				required: lang.MSG_EMAIL_REQ,
				email: lang.MSG_VALID_EMAIL,
				remote : lang.MSG_EMAIL_EXISTS
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
			password: {
				required: lang.MSG_PASS_REQ,
				minlength: lang.MIN_SIX_CHAR_REQUIRED
			},
			c_password: {
				required: lang.ENTER_CNFM_PASS,
				minlength: lang.MIN_SIX_CHAR_REQUIRED,
				equalTo : lang.MSG_PASS_CONF_NOT_MATCH
			},
			// hiddenRecaptcha:{required:lang.MSG_NOT_ROBO}
		},
		errorPlacement: function (error, element) {
            if (element.attr("name") == 'address') {
                error.appendTo($("#addressError"));
            } else {
                error.insertAfter(element);
            }
        }
	});
}

$(document).ready(function(){

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
	console.log("test");
	console.log(TOMTOM_KEY);
	// console.log(options);
    var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
    var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
    $("#locationSection").html(searchBoxHTML);
    $(".tt-search-box-input").attr("id" , "address");
    $(".tt-search-box-input").attr("name" , "address");
    $(".tt-search-box-input").attr("autocomplete", "off");

    ttSearchBox.on('tomtom.searchbox.resultselected', handleResultSelection);
	/* vspl changes start 26-09-2022 */
	$( "#line1, #line2, #city, #postcode, #country").change(function(){		
		var add =$( "#line1").val()+', '+$("#line2").val()+', '+$("#city").val()+', '+$("#postcode").val()+', '+$("#country").val();
		
		$.ajax( {
		url  : 'https://api.tomtom.com/search/2/geocode/'+add+'.json?key='+TOMTOM_KEY,
		
			success : function( data, textStatus ) {
				console.log(textStatus);
				console.log("sucess");
				// console.log( textStatus, data );
				if(data && data.results && data.results[0]){
					
					console.log(data.results[0].position);
					$("#addLat").val(data.results[0].position.lat);
					$("#addLong").val(data.results[0].position.lon);
				}
			}
		} );
		
		/* vspl changes end 26-09-2022 */
		
		// const data = await tt.services.poiSearch({
			// key: TOMTOM_KEY
			// query: add,			
		// });
		
		
		// g = geocoder.tomtom('San Francisco, CA', TOMTOM_KEY)
		// console.log(data);
		// console.log(g);
		
		
		// "https://api.tomtom.com/search/2/geocode/statue of .json?key=eohS7UZzOKxManf1TAoOOaEGND6giY1U"
		// $("#addLat").val(event.data.result.position.lat);
        // $("#addLong").val(event.data.result.position.lng);
	})

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

	var user_type = 'provider';
	$(".user_type_selection").click(function(){	

		if($(this).attr('id') == "provider_btn") {
			if(!$("#provider_btn").hasClass("user-selected")) {
				$("#provider_btn").addClass("user-selected");
			}
			$("#customer_btn").removeClass("user-selected");
			user_type = 'provider';			
		}
		else {
			if(!$("#customer_btn").hasClass("user-selected")) {
				$("#customer_btn").addClass("user-selected");
			}
			$("#provider_btn").removeClass("user-selected");
			user_type = 'customer';
		}
	});

	$("#nextBtn").click(function(){
		window.location.href = siteUrl + "sign-up/" + user_type;
	});

	$("#service_type").change(function(){
		if($(this).val() == "mechanic") {
			$(".vehicleTypeSection").removeClass("d-none");
		}
		else {
			$(".vehicleTypeSection").addClass("d-none");
		}
	});
});