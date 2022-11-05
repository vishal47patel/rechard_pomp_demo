<span id="status" class="d-none"></span>
<?php if($_GET['viewType'] != 'app') { ?>
<footer>
	<div class="footer-block">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<ul class="footer-links">
						<li>
							<a href="{SITE_URL}">
								{HOME}
							</a>
						</li>
						%FOOTER%
						
						<li>
							<a href="{SITE_URL}contact-us">
								{CONTACT_US}#callToUser
							</a>
						</li>
					</ul>
					<p>
						<?php echo str_replace(array("< " , "< /") , array("<" , "</") , filtering(FOOTER_COPYRIGHT)); ?> 
					</p>
				</div>
				<div class="col-sm-12 col-md-4 footer-links">
		    		<ul class="social-links">
		    			<li>
		    				<a href="{FB_LINK}" target="_blank">
		    					<i class="fab fa-facebook-f"></i>
		    				</a>
		    			</li>
		    			<li>
		    				<a href="{TWIITER_LINK}" target="_blank">
		    					<i class="fab fa-twitter"></i>
		    				</a>
		    			</li>
		    			<li>
		    				<a href="{LINKEDIN_LINK}" target="_blank">
		    					<i class="fab fab fa-linkedin-in"></i>
		    				</a>
		    			</li>
		    		</ul>
		    		%FOOTER_LOGO%		    		
				</div>
			</div>
		</div>
	</div>
</footer>
<?php } ?>
<div class="modal fade feedback-popup" id="FeedbackModel" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form action="{SITE_URL}" method="post" id="feedForm" name="feedForm">
				<div class="modal-header">
					<h3 class="modal-title" id="exampleModalLongTitle">{FEEDBACK_FORM}</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="md-input is-desc">

							<div class="md-input form-group cf">
								<input type="hidden" name="action" value="postFeedback">
								<textarea id="message" class="form-control" name="message" rows="4" placeholder="{FEEDBACK}"></textarea>
							</div>

					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="submit" class="btn large-btn">{SEND}</button>
						<button type="button" class="btn close-btn" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade message-popup" id="messageModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<form action="{SITE_URL}message-room" method="post" id="msgModalForm" name="msgModalForm">
				<div class="modal-header text-center">
                	<h2 id="header" class="modal-title mt-0 w-100">{SEND_MSG}</h2>
				</div>
				<div class="modal-body">
					<div class="md-input">
							<div class="form-group">
								<input type="hidden" name="action" value="sendMessage">
								<input type="hidden" name="receiverId" id="msgModalReceiverId" value="">
								<textarea id="msgModalMessage"  class="form-control" name="message" rows="4" placeholder="{ENTER_MSG}{MEND_SIGN}"></textarea>
							</div>

					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="button" class="btn-main btn-main-red mb-0" id="sendMsgBtn">{SEND}</button>
						<button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div data-keyboard="false" data-backdrop="static" class="modal fade call-popup" id="callModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
                <h2 id="header" class="modal-title mt-0 w-100"><?php echo ($_SESSION['user_type'] == 'customer') ? CALL_TO_PROVIDER : CALL_TO_CUSTOMER; ?></h2>
             </div>
			<form method="post">
				<div class="modal-body">
				    <div id="events">&nbsp;</div>
				    <input type="hidden" id="destinationUserName" value="" />
                	<div class="text-center w-100 d-block mt-3">
						<button type="button" class="btn-main mb-0" id="callToUser">{CALL}</button>
						<button type="button" class="btn-main mb-0" id="btn_hangup">{HANG_UP}</button>
					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="button" id="callToCloseBtn" class="btn-main btn-main-red mb-0" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div data-keyboard="false" data-backdrop="static" class="modal fade incomingCall-popup" id="incomingCallModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
                <h2 id="header" class="modal-title mt-0 w-100">{INCOMING_CALL_FROM} <span id="callerName"></span></h2>
             </div>
			<form method="post">
				<div class="modal-body">
				    <div id="events">&nbsp;</div>				    
                	<div class="text-center w-100 d-block mt-3">
						<button type="button" id="btn_accept" class="btn-main mb-0" onclick="Accept();">{ACCEPT}</button>
                		<button type="button" id="btn_reject" class="btn-main mb-0" onclick="Reject();">{REJECT}</button><br />
                		<button type="button" id="btn_hangup_incoming" class="btn-main mb-0" onclick="Hangup();">{HANG_UP}</button><br />
					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal" onclick="Hangup();">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div data-keyboard="false" data-backdrop="static" class="modal fade incomingMsg-popup" id="incomingMsgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
                <h2 id="header" class="modal-title mt-0 w-100">{INCOMING_MSG}</h2>
             </div>
			<form method="post">
				<div class="modal-body">			    
                	<div class="text-center w-100 d-block mt-3">
						<div class="incoming-message">{RCVD_MSG_FROM}<span class="msgSenderName"></span>. <a href="javascript:void(0);" id="redirectToInbox">{CLICK_HERE}</a> {TO_CHAT_WITH} <span class="msgSenderName"></span></div>
					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- <input type="hidden" placeholder="VoIP Server address" id="serveraddress" value="voip.mizu-voip.com" autocapitalize="off"><br />
            <input type="hidden" placeholder="Username" id="username" value="%USR_MIZUTECH_NAME%" autocapitalize="off"><br />
            <input type="hidden" placeholder="Password" id="password" value="%USR_MIZUTECH_PWD%" autocapitalize="off"><br /> -->

<script>

	var siteNm = '{SITE_NM}',
		siteUrl = '{SITE_URL}',
		siteImg = '{SITE_IMG}',
		phpModule = '%CURRENT_MODULE%',
		FB_APP_ID = '{FB_APP_ID}',
		siteMode = '{SITE_MOD}',
		sessUserId = '%SESS_USER_ID%',
		currencyId = '%CURRENCY_ID%',
		currencyCode = '%CURRENCY_CODE%',
		currencySign = '{CURRENCY_SIGN}',
		selectedCurrencyRate = '%SELECTED_CURRENCY_RATE%',
		defaultCurrencyRate = '%DEFAULT_CURRENCY_RATE%',
		currentPageURL = '{CURRENT_PAGE_URL}',
		userMizutechName = '%USR_MIZUTECH_NAME%',
		userMizutechPwd = '%USR_MIZUTECH_PWD%';



</script>
<!--common jquery starts-->
<script src="{SITE_JS}jquery.min.js"></script> 
<script src="{SITE_JS}popper.min.js"></script>
<script src="{SITE_JS}bootstrap.min.js"></script>
<script src="{SITE_JS}bootstrap-select.js"></script>
<script src="{SITE_INC}language-nct/js/%LANG_ID%.js"></script>
<script src="{SITE_JS}jquery.validate.js"></script>
<script src="{SITE_JS}custom.js"></script>
<!-- <script src="https://maps.google.co.in/maps/api/js?key={GOOGLE_MAP_KEY}&libraries=geometry,places"></script>
 -->

<?php if(($this->module == 'edit_profile-nct') || ($this->module == 'registration-nct')) { ?>
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>
<?php } ?>

<?php if($this->module == 'service_detail-nct') { ?>
<script src='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.12.0/maps/maps-web.min.js'></script>
<?php } ?>

<?php if( ($this->module == 'profile-nct') || ($this->module == 'edit_profile-nct') || ($this->module == 'service_request-nct') ) { ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<?php } ?>

<script type="text/javascript" src="{SITE_JS}webphone/webphone_api.js?jscodeversion=510"></script>
<script type="text/javascript" src="{SITE_JS}custom_api.js?jscodeversion=510"></script>

<script type="text/javascript">
	
	webphone_api.onCallStateChange(function (event, direction, peername, peerdisplayname, line, callid)
    {
        document.getElementById('events').innerHTML = '{CALL} ' + event;

        if (event === 'setup')
        {
            //document.getElementById('btn_hangup').disabled = false;
            hideLoader();
            $("#btn_hangup").show();
            if (direction == 1)
            {
                // means it's outgoing call
            }
            else if (direction == 2)
            {
                // means it's icoming call
                $("#btn_accept").show();
		        $("#btn_reject").show();
		        $("#btn_hangup_incoming").hide();
                $('#incomingCallModal').modal('show');

                $.ajax({
	                url: siteUrl,
	                type: 'post',
	                dataType: 'json',
	                data: {
	                	"action" : "getPeername",
	                	peername : peername
	                },
	                success: function(data) {
	                	$("#callerName").html(data.peername);
	                }
	            });
            }

            document.getElementById('events').innerHTML = '{CALL_SETUP}';
        }
        //detecting the end of a call, even if it wasn't successfull
        else if (event === 'disconnected')
        {
            //document.getElementById('btn_hangup').disabled = true;
            $("#btn_hangup").hide();
            //document.getElementById('callToUser').disabled = false;
            $("#callToUser").show();
            $('#incomingCallModal').modal('hide');

            document.getElementById('events').innerHTML = '{CALL_DISCONNECTED}';
        }
    });

    /** Receive incoming messages*/
	webphone_api.onChat(function (from, msg, line)
	{	
		if(phpModule != "message-nct") {
			$.ajax({
                url: siteUrl,
                type: 'post',
                dataType: 'json',
                data: {
                	"action" : "getPeername",
                	peername : from
                },
                success: function(data) {
                	$(".msgSenderName").html(data.peername);
                }
            });
			$("#redirectToInbox").attr("href" , siteUrl + 'message-room/sender/' + from)			;
			$("#incomingMsgModal").modal("show");
		}
		else {
			$('.getChat[data-usermizutechname="'+from+'"]').click();
		}
	});

    function Accept()
    {
        //$('#incomingCallModal').modal('hide');        
        webphone_api.accept();
        $("#btn_accept").hide();
        $("#btn_reject").hide();
        $("#btn_hangup_incoming").show();
    }
    
    function Reject()
    {
        $('#incomingCallModal').modal('hide');
        webphone_api.reject();
    }

    function Hangup() {
    	webphone_api.hangup();
    	$('#incomingCallModal').modal('hide');
    	$("#btn_accept").show();
        $("#btn_reject").show();
        $("#btn_hangup_incoming").hide();
    }

    $(document).ready(function(){

    	//Start();
    	
    	$("#msgModalForm").validate({
            rules: {
                message: {
                    required: true
                },
            },
            messages: {
                message: {
                    required: lang.MSG_REQ
                },
            }
        });

        $(document).on('click', '#sendMsgBtn', function(e) {
        	if($("#msgModalForm").valid()) {
		        var action = $("#msgModalForm").attr('action');
		        var formData = $("#msgModalForm").serializeArray();
		        formData.push({
		            name: 'returnType',
		            value: 'n'
		        });
		        $.ajax({
		            url: action,
		            dataType: 'json',
		            type: 'post',
		            data: formData,
		            beforeSend: function() {
		                showLoader();
		            },
		            complete: function() {
		                hideLoader();
		            },
		            success: function(response) {	                
		                if (response.type == 'success') {
		                    $("#msgModalMessage").val('');
		                    $('#messageModal').modal('hide');
		                    toastr["success"](lang.MSG_MSG_SENT_SUC);
		                }
		            },
		            error: function(response) {	                
		                toastr['error'](lang.MSG_SOMETHING_WRONG);
		            }
		        });
		    }
	    });

    	$(document).on("click" , ".openSendMsgModal" , function(){
    		if(sessUserId == '' || sessUserId == 0) {
    			toastr["error"](lang.PLZ_LOGIN_TO_CONTINUE);
    		}
    		else {
    			$("#msgModalReceiverId").val($(this).attr("userid"));
    			$("#msgModalMessage").val("");
    			$("#msgModalForm").validate().resetForm();
    			$('#messageModal').modal('show');
    		}
    	});

    	$(document).on("click" , ".openCallModal" , function(){
    		if(sessUserId == '' || sessUserId == 0) {
    			toastr["error"](lang.PLZ_LOGIN_TO_CONTINUE);
    		}
    		else {
	    		$.ajax({
	                url: siteUrl,
	                type: 'post',
	                dataType: 'json',
	                data: {
	                	"action" : "getUserMizutechDetails",
	                	destiUserId : $(this).attr("userid")
	                },
	                beforeSend: function() {
	                    showLoader();
	                },
	                complete: function() {
	                    hideLoader();
	                },
	                success: function(data) {

	                	if((data.mizutech_name == null) || (data.mizutech_pwd == null)) {
	                		toastr["error"](lang.PLZ_ENTER_MIZUTECH_DETAILS);
	                	}
	                	else if(data.destinationUserName == null) {
	                    	toastr["error"](lang.PROV_NOT_HAVE_MIZUTECH_DETAILS);
	                    }
	                    else {
	                    	$("#destinationUserName").val(data.destinationUserName);
	                    	//document.getElementById('callToUser').disabled = false;
	                    	$("#callToUser").show();
	                    	//document.getElementById('btn_hangup').disabled = true;
	                    	$("#btn_hangup").hide();
	                    	$("#events").html("");
	                        $('#callModal').modal('show');

	                        if(webphone_api.getparameter('serveraddress') == "") {
	                        	console.log("mizutech set parameter");
		                        webphone_api.setparameter('serveraddress' ,VOIP_SERVER_ADDRESS);
		                        webphone_api.setparameter('username' , data.mizutech_name);
		                        webphone_api.setparameter('password' , data.mizutech_pwd);
		                        webphone_api.start();//pooja:comment
		                    }
	                    }
	                }
	            });
	    	}
    	});    	

        $(document).on("click" , "#callToUser" , function(){    
            webphone_api.setparameter('destination', $("#destinationUserName").val());
            webphone_api.call($("#destinationUserName").val());
            //document.getElementById('callToUser').disabled = true;
            $("#callToUser").hide();
            showLoader();
        });
        
        $(document).on("click" , "#btn_hangup , #callToCloseBtn" , function(){
           webphone_api.hangup();
           //document.getElementById('callToUser').disabled = false;
           $("#callToUser").show();
           //document.getElementById('btn_hangup').disabled = true;
           $("#btn_hangup").hide();
        });

        <?php if($_SESSION["isLogout"] == "y") { ?>
			//webphone_api.stop();
		<?php 
			$_SESSION["isLogout"] = "n";
		} ?>
    });
</script>