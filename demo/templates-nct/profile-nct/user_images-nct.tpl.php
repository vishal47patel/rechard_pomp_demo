<div>
	<div class="row">
		<div class="col-md-6 mb-2">
			<div class="owl-carousel owl-theme vehicle-img-slider">
				%USER_IMGS%
			</div>
		</div>
		<div class="col-md-6">
			<h3 class="mb-1 profile-user-name text-truncate mt-0">
				%FIRST_NAME% %LAST_NAME%
			</h3>
			<p class="profile-service-type">
				%BUSINESS_NAME%
			</p>
			<div class="rating-review mt-1 mb-1">
	    		<ul class="rate-bx mr-0">
                    %AVG_RATING%
                </ul>
	    	</div>
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
			<!-- %USER_IMGS_SECTION% -->
		</div>
	</div>
</div>