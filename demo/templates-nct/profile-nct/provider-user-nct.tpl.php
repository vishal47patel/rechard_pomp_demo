%AVIALIBILITY_BTN%
<div class="box-shadow-main profile-box">
	<div class="profile-main">
		<div class=""> <!--profile-main-left-->
		    %DISP_AVAILABILITY%
			%USER_IMGS_SECTION%
			<!-- <figure class="mb-0">
				<img src="%USER_IMAGE%" alt="%FIRST_NAME% %LAST_NAME%">
			</figure> -->
		</div>
		%SHOW_IT%
		<!--<div class="profile-main-right">
			<h3 class="mb-1 profile-user-name text-truncate">
				%FIRST_NAME% %LAST_NAME%
			</h3>
			<p class="profile-service-type">
				%BUSINESS_NAME%
			</p>
			<table>
				<tr class="profile-user-li">
					<td>
						<span class="profile-icon"><i class="icon-menu"></i></span>
					</td>
					<td>
						<span class="profile-user-value">%SERVICE_TYPE%</span>
					</td>
				</tr>
				<tr class="profile-user-li">
					<td>
						<span class="profile-icon"><i class="icon-telephone"></i></span>
					</td>
					<td>
						<span class="profile-user-value">%CONTACT_NO%</span>
					</td>
				</tr>
				<tr class="profile-user-li">
					<td>
						<span class="profile-icon"><i class="icon-mail"></i></span>
					</td>
					<td>
						<span class="profile-user-value">%EMAIL%</span>
					</td>
				</tr>
				<tr class="profile-user-li">
					<td>
						<span class="profile-icon"><i class="icon-placeholder"></i></span>
					</td>
					<td>
						<span class="profile-user-value">%LOCATION%</span>
					</td>
				</tr>
			</table>
			<div class="my-2">
			    <h3 class="color-gray mt-0 mb-1">
			        {STATUS}
			    </h3>
				<p id="dispStatus">%USER_STATUS%</p>
			</div>
			<div class="my-2">
			    <h3 class="color-gray mt-0 mb-1">
			        {OPENING_HOURS}
			    </h3>
				<p id="dispOpeningHrs">%USER_OPENING_HOURS%</p>
			</div>
			<div class="my-2">
			    <h3 class="color-gray mt-0 mb-1">
			        {BUSINESS_DETAILS}
			    </h3>
				<p id="dispBusinessDetails">%BUSINESS_DETAILS%</p>
			</div>
			<?php if($this->sessUserId != $this->userId) { ?> 
				<div>
				    <a href="javascript:void(0);" userid="%USER_ID%" class="openCallModal btn-icon-name">
				        <i class="icon-telephone"></i>
				        <span>{CALL}</span>
				    </a>
				    <a href="javascript:void(0);" userid="%USER_ID%" class="openSendMsgModal btn-icon-name">
				        <i class="icon-speech-bubble"></i>
				        <span>{MESSAGE}</span>
				    </a>
				    <a href="{SITE_URL}service-request/%USER_ID%" class="btn-icon-name">
				        <i class="icon-instructions"></i>
				        <span>{BOOK}</span>
				    </a>
				</div>
			<?php } ?>
		</div>-->
	</div>
	
	<div class="row">
	    <div class="col-md-12">
	        <div class="row">
	            <div class="col-md-4">
	                <div class="mb-2 red-area-block">
            		    <h3 class="color-gray mt-0 mb-1">
            		        {STATUS}
            		    </h3>
            			<p id="dispStatus" class="mb-1">%USER_STATUS%</p>
            		</div>
	            </div>
	            <div class="col-md-6">
	                %ADD_STATUS%
	            </div>
	        </div>
	    </div>
	    <div class="col-md-12">
	        <div class="row">
	            <div class="col-md-4">
	                <div class="mb-2 red-area-block">
            		    <h3 class="color-gray mt-0 mb-1">
            		        {OPENING_HOURS}
            		    </h3>
            			<p id="dispStatus" class="mb-1">%USER_OPENING_HOURS%</p>
            		</div>
	            </div>
	            <div class="col-md-6">
	                %ADD_OPENING_HOURS%
	            </div>
	        </div>
	    </div>
	    <div class="col-md-12">
	        <div class="my-2">
    		    <h3 class="color-gray mt-0 mb-1">
    		        {BUSINESS_DETAILS}
    		    </h3>
				sdsdssdsdf  sf sdf
    			<p id="dispBusinessDetails" class="mb-1">%BUSINESS_DETAILS%</p>
        	</div>
	    </div>
	</div>
    	
    <div class="profile-calendar">
			<div class="row">
				<div class="col-md-12">
					<h3>
						{SERVICES_PROVIDED}
					</h3>
				</div>
			</div>
			<div class="row m-0 services-list" id="serviceBody">
				%SERVICE_LIST%			
			</div>
			<nav aria-label="..." class="pagination-main mt-2">
				<ul class="pagination justify-content-center servicePagi">
					<div id="servicePageContent">
	                    %SERVICE_PAGINATION%
	                </div>	
				</ul>
			</nav>

			<?php if($this->sessUserId != $this->userId) { ?> 
			<div class="row">
				<div class="col-md-12">
					<h3 class="customer-detail-title color-red">
						{RCVD_REVIEWS_RATINGS}
					</h3>
				</div>
			</div>
			<div class="review-ul" id="reviewBody">
				%REVIEW_LIST%
			</div>
			<nav aria-label="..." class="pagination-main mt-4">
				<ul class="pagination justify-content-center reviewPagi">
					<div id="pageContent">
	                    %REVIEW_PAGINATION%
	                </div>	
				</ul>
			</nav>
			<?php } ?>
		</div>
		
	<?php if($this->sessUserId == $this->userId) { ?> 
		<div class="profile-calendar">
			<div class="row">
				<div class="col-md-12">
					<h3>
						{AVAILABILITY_SLOTS}
					</h3>
				</div>			
			</div>
			<input type="hidden" id="user_service_type" value="%USR_SERVICE_TYPE%" />
			<div class="">
			   <div id="calendar"></div>
			</div>
		</div>	
	<?php } ?>
	
</div>

<div class="modal fade" id="addStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
                <h2 id="header" class="modal-title mt-0 w-100"></h2>
             </div>
			<form id="addStatusFrm" method="post" action="">
				<div class="modal-body">
                	<div class="col-md-12">
						<div class="md-input form-group cf">
							<textarea class="form-control" id="addStatus" name="addStatus" placeholder="{ENTER_STATUS}{MEND_SIGN}"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="button" class="btn-main btn-main-red mb-0" id="add_status_btn">{SUBMIT}</button>
						<button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="openingHrsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
                <h2 id="header" class="modal-title mt-0 w-100"></h2>
             </div>
			<form id="openingHrsFrm" method="post" action="">
				<div class="modal-body">
                	<div class="col-md-12">
						<div class="md-input form-group cf">
							<textarea class="form-control" id="openingHrs" name="openingHrs" placeholder="{ENTER_OPENING_HOURS}{MEND_SIGN}"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="button" class="btn-main btn-main-red mb-0" id="opening_hrs_btn">{SUBMIT}</button>
						<button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>