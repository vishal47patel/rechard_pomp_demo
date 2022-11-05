<div class="box-shadow-main profile-box">
	<div class="profile-main">
	    <div class="row">
    		<div class="col-md-6">
    		    %USER_IMGS_SECTION%
    		</div>
    		<div class="col-md-6">
    			<h3 class="mb-1 profile-user-name text-truncate">
    				%FIRST_NAME% %LAST_NAME%
			    </h3>
    			<table>
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
    			</table>
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
				</div>
    			<?php } ?>
    		</div>
    		<div class="col-md-12">
        		<h3>
        			{VEHICLE_DETAILS}
        		</h3>
        		<div class="row m-0">
        			<div class="col-md-12">
        				<ul class="vehicle-detail row">
        					<li class="col-md-6">
        						{VEHI_BRAND}
        						<span>%VEHI_BRAND%</span>
        					</li>
        					<li class="col-md-6">
        						{VEHI_MODEL}
        						<span>%VEHI_MODEL%</span>
        					</li>
        					<li class="col-md-6">
        						{VEHI_YEAR}
        						<span>%VEHI_YEAR%</span>
        					</li>
        					<li class="col-md-6">
        						{VEHI_ENGINE}
        						<span>%VEHI_ENGINE%</span>
        					</li>
        					<li class="col-md-6">
        						{VEHI_MILEAGE}
        						<span>%VEHI_MILEAGE%</span>
        					</li>
        				</ul>
        			</div>
        		</div>
        	</div>
    		%SHOW_IT%
		</div>
	</div>		

	<!-- <div class="profile-calendar">
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
	</div> -->				
</div>	