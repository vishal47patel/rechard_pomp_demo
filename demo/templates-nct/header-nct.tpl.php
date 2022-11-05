<div class="loader d-none">	
	<img src="{SITE_IMG}loader.gif" alt="loader">
</div>

<header>
	<nav class="navbar navbar-expand-lg site-header">
		<div class="container">
			<a class="navbar-brand" href="{SITE_URL}">
				<img src="{SITE_IMG}{SITE_LOGO}">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<div class="hamburger">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</div>
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
				<ul class="navbar-nav mt-0 hdr-rightbar">

					<?php if( ($_SESSION['user_type'] == "") || ($_SESSION['user_type'] == "customer") ) { ?>
					<li class="nav-item dropdown hdr-search-div">
						<a class="dropdown-toggle hdr-search" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <i class="icon-loupe"></i>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
							<div>
					    		<h2 class="mt-0">
					    			{LOOKING_FOR_PROVIDER}
					    		</h2>
					    		<form method="post" action="" id="hdr_searchFrm">
					    			<div class="form-group">
					    				<select name="hdr_service_type" id="hdr_service_type" class="form-control">
											<option value="">{SELECT_SERVICE_TYPE}{MEND_SIGN}</option>
											<option value="mechanic">{MECHANIC}</option>
											<option value="taxi">{TAXI}</option>
										</select>
					    			</div>
					    			<div class="form-group">
					    				<input type="text" name="srch_provider_name" id="srch_provider_name" placeholder="{PROVIDER_NAME}" class="form-control">
					    			</div>
					    			<div class="form-group">
					    				<input type="text" name="hdr_radius_val" id="hdr_radius_val" placeholder="{ENTER_SEARCH_RADIUS} ({KM}){MEND_SIGN}" class="form-control">
					    			</div>
					    			<div class="">
					    				<button type="button" class="nav-link btn-main btn-main-red" id="hdr_searchBtn">
											{SEARCH}
										</button>
					    			</div>
					    		</form>
					    	</div>
						</div>
					</li>
				<?php } ?>

				<?php if( ($_SESSION['user_id'] > 0)) { ?>

					<?php if($_SESSION['user_type']=='provider') { ?>
                    <li class="hdr-search-div">
                        <a href="{SITE_URL}new-service-request" class="dropdown-toggle hdr-search">
                        <i class="fas fa-list"></i></a>
                    </li>
                	<?php } else { ?>
                		<li class="hdr-search-div">
                        <a href="{SITE_URL}my-service-request" class="dropdown-toggle hdr-search">
                        <i class="fas fa-list"></i></a>
                    </li>
                    <?php } ?>

					<li class="hdr-search-div">
                        <a href="{SITE_URL}message-room" class="dropdown-toggle hdr-search">
                            <i class="far fa-comment-dots"></i>
                            <span class="messageCount messageCount2 %MESSAGE_NOTIFICATION_CLASS%">%MESSAGE_COUNT%</span>
                        </a>
                    </li>
                    <?php } ?>

					%MENU%	
					
					<li class="nav-item dropdown">
						<select class="form-control select-white" onchange="changeLanguage(this.value);">
							%LANGUAGE_LIST%
						</select>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>