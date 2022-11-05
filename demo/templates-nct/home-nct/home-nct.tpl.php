<div class="main-content nearby-provider-sec">
	<div class="container">		
		<ul class="nav nav-tabs service-tab">
			<li>
				<a data-toggle="tab" href="#tab_autoService" class="service-tab-link active">
					<div>{AUTO} <span>{SERVICE}</span></div>
				</a>
			</li>
		  	<li>
		  		<a data-toggle="tab" href="#tab_taxiService" class="service-tab-link">
		  			<div>{TAXI} <span>{SERVICE}</span></div>
		  		</a>
		  	</li>
		  	<li>
		  		<a data-toggle="tab" href="#tab_bookService" class="service-tab-link">
		  			<div>{SERVICE} <span>{HISTORY}</span></div>
		  		</a>
		  		<!-- <a href="{SITE_URL}service-book" class="service-tab-link">
		  			<div>{SERVICE} <span>{HISTORY}</span></div>
		  		</a> -->
		  	</li>
		</ul>
		<div class="tab-content">
			<div id="tab_autoService" class="tab-pane in active">
			
				<div class="mechanicFilterSec top-gray-btn row mb-3">
					<div class="col-md-7">
						<a href="javascript:void(0);" class="btn-gray mechanicBtn" vehicle_type="car">
							<span class="icon-car-van"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span>
						</a>
						<a href="javascript:void(0);" class="btn-gray mechanicBtn" vehicle_type="bike">
							<span class="icon-motorbike"></span>
						</a>
					</div>
					<div class="col-md-5">
						<div class="service-right-filter">
							<span class="mr-2">
								<i class="icon-placeholder"></i>
								<span id="currentCityName"></span>
							</span>
							<span class="km-span">
								{NEARBY_RADIUS} {KM}
							</span>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="owl-carousel owl-theme nearby-provider-slider" id="nearByProviderSection">
				</div>
				<div id="noProviderFound" class="d-none no-proivder-section no-data-block">{NO_NEARBY_PROVIDER_FOUND}</div>
			</div>
			<div id="tab_taxiService" class="tab-pane">
			
				<div class="owl-carousel owl-theme nearby-taxi-slider" id="nearByTaxiSection">
				</div>
				<div id="noTaxiFound" class="d-none no-proivder-section no-data-block">{NO_NEARBY_PROVIDER_FOUND}</div>
			</div>
			<div id="tab_bookService" class="tab-pane">
			
				<div class="container">
				    <form method="post" action="" id="searchVINFrm" class="row">
				      <div class="col-lg-6 offset-lg-3">
				        <div class="row">
				          <div class="form-group col-lg-9">
				            <input type="text" name="vin_number" id="vin_number" placeholder="{ENTER_VIN} {MEND_SIGN}" class="form-control">
				          </div>
				          <div class="form-group col-lg-3">
				            <button class="btn-main btn-main-red w-100" type="button" id="searchVINBtn">
				              {SEARCH}
				            </button>
				          </div>
				        </div>                
				      </div>
				    </form>
				    <div class="result_page">
				    </div>
				  </div>		
			</div>
		</div>
	</div>
</div>

<div class="home-banner">
	<div class="container">
		<div class="home-banner-inner">
			<div class="home-banner-inner-left">				
				<a href="#" class="google-play-block">
					<img src="{SITE_IMG}google-play.png">
				</a>
			</div>
			%HOME_BANNER_SECTION%
		</div>
	</div>
</div>

{GOOGLE_ADS_SECTION}

<div class="main-content" %HIDE% >
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

{GOOGLE_ADS_SECTION}