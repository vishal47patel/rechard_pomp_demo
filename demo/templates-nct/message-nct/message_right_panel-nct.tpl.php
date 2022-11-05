<h2 class="msg-title mt-0">
	<!-- <a href="javascript:void(0)" class="back-arrow" id="back" data-type="">
		<i class="fas fa-arrow-left"></i>
	</a> -->
	<span>{CONVERSTION_WITH} <u><a href="{SITE_URL}profile/%RECEIVER_ID%">%USER_NAME%</a></u></span>

	<?php if($_SESSION['user_type'] == 'provider') { ?>
		<a href="{SITE_URL}provider-service-request/%RECEIVER_ID%" class="sound-msg openCallModal msg-add-request" userid="16">
			{ADD_REQUEST}
		</a>
	<?php } ?>
	<a href="javascript:void(0)" class="sound-msg openCallModal" userid="%RECEIVER_ID%">
		<button class="btn chat-btn" type="submit" id="msgSubmit" name="msgSubmit" title="{SEND}" style="width: 33px; height: 33px;font-size: 16px;padding: 0px;">
        	    <i class="fa fa-phone"></i>
        </button>
	</a>	
	<!--<a href="javascript:void(0)" class="sound-msg openCallModal" userid="%RECEIVER_ID%">
		<i class="icon-speaker"></i>
	</a>-->
</h2>
<div id="bunchDiv" class="msg-chat-scroll mCustomScrollbar">
	<div id="messageBunch" class="message_%BUNCH_ID% msg-chat-main">
		<div class="msg-inbox-chat">
			%MSG_CONTAINER%
		</div>
	</div>
</div>

<input type="hidden" id="receiverId" name="receiverId" value="%RECEIVER_ID%">
%FORM_CONTAINER%