<div class="box-shadow-main profile-box">
	<div class="profile-main">
		<div class="profile-main-left">
			<figure>
				<img src="%USER_IMAGE%" alt="%FIRST_NAME% %LAST_NAME%">
			</figure>
			<!-- <div class="rating-review">
	    		<ul class="rate-bx mr-0">
                    %AVG_RATING%
                </ul>
	    	</div> -->
		</div>
		%SHOW_IT%
		<div class="profile-main-right">
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
			<div>
				<h3>
					{VEHICLE_DETAILS}
				</h3>
				<div class="row">
					%USER_IMGS_SECTION%
					<div class="col-md-6">
						<ul class="vehicle-detail">
							<li>
								{VEHI_BRAND}
								<span>%VEHI_BRAND%</span>
							</li>
							<li>
								{VEHI_MODEL}
								<span>%VEHI_MODEL%</span>
							</li>
							<li>
								{VEHI_YEAR}
								<span>%VEHI_YEAR%</span>
							</li>
							<li>
								{VEHI_ENGINE}
								<span>%VEHI_ENGINE%</span>
							</li>
							<li>
								{VEHI_MILEAGE}
								<span>%VEHI_MILEAGE%</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
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