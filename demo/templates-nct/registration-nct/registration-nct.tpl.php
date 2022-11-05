
<?php if($this->regiUserType == 'provider'){ ?>

<style>

.reg-img {
    height: 1270px;
}
</style>
<?php } ?>
<div class="main-content">
	<div class="container">
		<div class="col-lg-12 reg-main p-0">
			<div class="row center-item m-0">
				<div class="col-lg-6 pr-0 pl-0 reg-img">
					<img src="{SITE_IMG}left1.png">
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-12 right-block">
							<div class="main-title">
								<h1>
									{CREATE_ACCOUNT}
								</h1>
								<div class="main-title-icon">
									<span class="icon-customer-support"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
								</div>
							</div>
							<div class="form-register">
								<form id="frmRegi" name="frmRegi" method="POST">
									<input type="hidden" id="user_type" name="user_type" value="%USER_TYPE%">	<?php
									// echo "tome ";
									// echo"<pre>";
									// print_r($_SESSION);
									?>								
									<div class="form-group serviceTypeSection %PROV_CLASS%">
										<select class="form-control" name="service_type" id="service_type">
											<option value="">{SELECT_SERVICE_TYPE}{MEND_SIGN}</option>
											<option value="mechanic">{MECHANIC}</option>
											<option value="taxi">{TAXI}</option>
										</select>
									</div>
									<div class="form-group vehicleTypeSection d-none">
										<select class="form-control" name="vehicle_type" id="vehicle_type">
											<option value="">{SELECT_VEHICLE_TYPE}{MEND_SIGN}</option>
											<option value="car">{CAR}</option>
											<option value="bike">{BIKE}</option>
											<option value="both">{BOTH}</option>
										</select>
									</div>
									<?php if($this->regiUserType == 'provider'){ ?>
									<div class="form-group">
										<input type="text" name="businessName" id="businessName" placeholder="{ENTER} {BUSINESS_NAME}{MEND_SIGN}" class="form-control">
									</div>
									<?php }else{ ?>
									<div class="form-group">
										<input type="text" name="firstName" id="firstName" placeholder="{ENTER} {FNAME}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" name="lastName" id="lastName" placeholder="{ENTER} {LNAME}<?php echo ($this->regiUserType == 'provider') ? MEND_SIGN : ''; ?>" class="form-control">
									</div>
									<?php } ?>
									<div class="form-group">
										<input type="text" name="contactNo" id="contactNo" placeholder="{ENTER} {CONTACT_NO}{MEND_SIGN}" class="form-control">
									</div>

									<?php if($this->regiUserType == 'provider'){ ?>					
									<div class="form-group">
										<input type="text" name="line1" id="line1" placeholder="{ENTER} {LINE_A}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" name="line2" id="line2" placeholder="{ENTER} {LINE_B}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" name="city" id="city" placeholder="{ENTER} {CITY}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" name="postcode" id="postcode" placeholder="{ENTER} {POSTCODE}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" name="country" id="country" placeholder="{ENTER} {COUNTRY}{MEND_SIGN}" class="form-control">
									</div>
									<input type="hidden" id="addLat" name="addLat" value="" />
		                             <input type="hidden" id="addLong" name="addLong" value="" />
									<?php 
									// <div class="form-group">
											// <input type="hidden" id="addLat" name="addLat" value="" />
		                                    // <input type="hidden" id="addLong" name="addLong" value="" />
		                                    // <input type="hidden" id="addressVal" value="">
		        
		                                    // <div class="form-group" id="locationSection" class="form-control">
		                                    // </div>

		                                    // <div id="addressError"></div>
										// </div>
										?>
										
										
									<?php } ?>

									<div class="form-group">
										<input type="text" name="email" id="email" placeholder="{ENTER} {EMAIL}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" placeholder="{ENTER} {PASSWORD}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="password" name="c_password" id="c_password" placeholder="{ENTER} {CONFIRM_PASSWORD}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="hidden" class="hiddenRecaptcha " name="hiddenRecaptcha" id="hiddenRecaptcha">
										<div class="g-recaptcha" data-sitekey="{GOOGLE_RECAPTCHA_KEY}" data-callback="validRecaptcha"></div>
										<label for="hiddenRecaptcha" generated="true" class="error" style="display:none"></label>
									</div>
									<div class="form-group">
										<button class="btn-main btn-main-red w-100" type="submit" id="btnSignUpSubmit" name="btnSignUpSubmit">
											{SIGNUP}
										</button>
									</div>
									<div class="form-group text-center">
										<p>
											{ALREADY_HAVE_ACCOUNT} <a href="{SITE_URL}login"><b>{LOGIN}</b></a>
										</p>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>