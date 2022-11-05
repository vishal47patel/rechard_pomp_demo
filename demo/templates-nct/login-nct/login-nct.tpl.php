<div class="main-content">
	<div class="container">
		<div class="col-lg-12 reg-main p-0">
			<div class="row center-item m-0">
				<div class="col-lg-6 pr-0 pl-0 reg-img">
					<img src="{SITE_IMG}left2.png">
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-12 right-block">
							<div class="main-title">
								<h1>
									{LOGIN}
								</h1>
								<div class="main-title-icon">
									<span class="icon-customer-support"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
								</div>
							</div>
							<div class="form-register">
								<form name="frmLogin" id="frmLogin" method="post">
									<div class="form-group">
										<input type="text" name="email" value="%EMAIL%" id="email" placeholder="{EMAIL_OR_CONTACT_NO}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="password" placeholder="{PASSWORD}{MEND_SIGN}" name="password" value="%PASSWORD%" id="password" class="form-control">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-12">
								                <div class="rememberme-main"><label class="custom-chkbx">{REMEMBER_ME}<input type="checkbox" id="isRemember" name="isRemember" value="y" %REMEMBER_ME%><span class="checkmark"></span></label></div>
								                <div class="f-pw"><a href="{SITE_URL}forgot-pass"><u>{FORGOT_PASSWORD}?</u></a></div>
								            </div>
								        </div>
							        </div>
									<div class="form-group">
										<input type="hidden" name="action" value="submitLoginFrm" />
										<button class="btn-main btn-main-red w-100"  type="submit" id="sbtLogin" name="sbtLogin">
											{LOGIN}
										</button>
									</div>									
									<div class="form-group text-center">                	
										<p>{RESEND_ONE} <a href="javascript:void(0)" data-toggle="modal" data-target="#forgotPwdModal" id="resendMail">{CLICK_HERE}</a> {RESEND_TWO}</p>
										
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

<!-- Forgot Password Modal -->
<div class="modal fade forgot-popup" id="forgotPwdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
                <h2 id="header" class="modal-title mt-0 w-100"></h2>
             </div>
			<form id="forgot_pwd_form" method="post">
				<div class="modal-body">
                	<div class="col-md-12">
						<div class="md-input form-group cf">
							<input type="text" class="form-control" id="resendemail" name="email" placeholder="{EMAIL}">
						</div>
					</div>
				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<input type="hidden" value="forgot_password" name="action" id="action" />
						<button type="submit" class="btn-main btn-main-red mb-0" name="reset_pwd">{SUBMIT}</button>
						<button type="button" class="btn-main btn-main-red mb-0" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>