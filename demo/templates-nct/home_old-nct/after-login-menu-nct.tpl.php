<li class="nav-item dropdown">
	<a class="nav-link btn-main btn-main-red dropdown-toggle profile-btn" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<img src="%USER_IMAGE%" title="%USER_NAME%" alt=""> %USER_NAME% <i class="icon-down-arrow"></i>
	</a>
	<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
		<a class="dropdown-item" href="{SITE_URL}profile/%SESSUSERID%/">{PROFILE}</a>
		<div class="dropdown-divider"></div>		
		<a class="dropdown-item" href="#">{INBOX}</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="#">{MY_WALLET}</a>
		<div class="dropdown-divider"></div>
		<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='provider' ){ ?>
		<a class="dropdown-item" href="{SITE_URL}my-provided-services">{MY_PRO_SERS}</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{SITE_URL}my-received-reviews">{MY_REC_REVIEWS}</a>
		<div class="dropdown-divider"></div>
		
		<?php }?>
		
		<a class="dropdown-item" href="{SITE_URL}account-setting">{ACCOUNT_SETTINGS}</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{SITE_URL}logout/">{SIGN_OUT}</a>
	</div>
</li>