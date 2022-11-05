<li class="nav-item dropdown">
	<a class="nav-link btn-main btn-main-red dropdown-toggle profile-btn" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<!-- <img id="userThumb" src="%USER_IMAGE%" title="%USER_NAME%" alt="">  -->
		<picture>
          <source srcset="%USER_IMAGE%" type="image/webp">
          <source srcset="%USER_IMAGE_MAIN%" type="image/jpg"> 
          <img id="userThumb" src="%USER_IMAGE_MAIN%" title="%USER_NAME%" alt="">
        </picture>
		%USER_NAME% <i class="icon-down-arrow"></i>
	</a>
	<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
		<a class="dropdown-item" href="{SITE_URL}profile/%SESSUSERID%/">{PROFILE}</a>
		<div class="dropdown-divider"></div>		
		<!-- <a class="dropdown-item" href="{SITE_URL}message-room">{INBOX}<span class="messageCount %MESSAGE_NOTIFICATION_CLASS%">%MESSAGE_COUNT%</span></a>
		<div class="dropdown-divider"></div> -->
		<!-- <a class="dropdown-item" href="{SITE_URL}">{MY_WALLET}</a>
		<div class="dropdown-divider"></div> -->
		<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='provider' ){ ?>
		<a class="dropdown-item" href="{SITE_URL}my-provided-services">{MY_PRO_SERS}</a>
		<div class="dropdown-divider"></div>		
		<a class="dropdown-item" href="{SITE_URL}new-service-request">{NEW_SERVICE_REQUEST}</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{SITE_URL}provider-service-request">{SERVICE_REQUEST}</a>
		<div class="dropdown-divider"></div>
		<?php } else { ?>
		<a class="dropdown-item" href="{SITE_URL}my-service-request">{MY_SERVICE_REQUEST}</a>
		<div class="dropdown-divider"></div>
		<?php } ?>
		
		<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='customer' ){ ?>	
			<a class="dropdown-item" href="{SITE_URL}my-given-reviews">{MY_GIVEN_REVIEWS}</a>
			<div class="dropdown-divider"></div>	
		<?php } ?>

		<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='provider' ){ ?>	
			<a class="dropdown-item" href="{SITE_URL}my-received-reviews">{MY_REC_REVIEWS}</a>
			<div class="dropdown-divider"></div>
		<?php } ?>
		
		<a class="dropdown-item" href="{SITE_URL}service-book">{SERVICE_BOOK_DETAIL}</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{SITE_URL}payment-history">{PAYMENT_HISTORY}</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{SITE_URL}account-setting">{ACCOUNT_SETTINGS}</a>
		<div class="dropdown-divider"></div>		
		<a class="dropdown-item" href="{SITE_URL}logout/">{SIGN_OUT}</a>
	</div>
</li>