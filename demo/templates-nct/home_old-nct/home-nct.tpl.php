<div class="home-banner">
	<div class="container">
		<div class="home-banner-inner">
			<div class="home-banner-inner-left">
				<h1 class="banner-heading">
					{LOOKING_FOR_PROVIDER}
				</h1>
				<form method="post" action="" id="searchFrm">
					<div class="form-group">
						<select name="service_type" id="service_type" class="form-control">
							<option value="">{SELECT_SERVICE_TYPE}</option>
							<option value="mechanic">{MECHANIC}</option>
							<option value="taxi">{TAXI}</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="radius_val" id="radius_val" placeholder="{ENTER_SEARCH_RADIUS}{MEND_SIGN}" class="form-control">
					</div>
					<div class="form-group">
						<button type="button" class="nav-link btn-main btn-main-red" id="searchBtn">
							{SEARCH}
						</button>
					</div>
				</form>
				<a href="#" class="google-play-block">
					<img src="{SITE_IMG}google-play.png">
				</a>
			</div>
			%HOME_BANNER_SECTION%
		</div>
	</div>
</div>
<div class="main-content nearby-provider-sec">
			<div class="container">
				<div class="main-title">
					<h1>
						{NEARBY_PROVIDERS}
					</h1>
					<div class="main-title-icon">
						<span class="icon-customer-support"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
					</div>
				</div>
				<div class="owl-carousel owl-theme nearby-provider-slider" id="nearByProviderSection">				    
				</div>
				<div id="noProviderFound" class="d-none no-proivder-section no-data-block">{NO_NEARBY_PROVIDER_FOUND}</div>
			</div>
		</div>
<div class="main-content">
	<div class="container">
		<div class="row center-item">
			<div class="col-md-6">
				<img src="{SITE_IMG}hifi.png" class="content-img">
			</div>
			<div class="col-md-6 content-des">
				<h1>
					{ARE_YOU_PROVIDER}
				</h1>
				%PROVIDER_CONTENT%
				<a href="{SITE_URL}sign-up" class="btn-main btn-main-red">
					{SIGN_UP_NOW}
				</a>
			</div>
		</div>
	</div>
</div>