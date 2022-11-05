<div class="breadcrumbs-main">
	<div class="container">
		<h1>
			{CONTACT_US}
		</h1>
		<ul class="breadcrumb">
			<li><a href="{SITE_URL}">{HOME}</a></li>
			<li>{CONTACT_US}</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="col-xl-8 offset-xl-2 offset-lg-1 col-lg-10 reg-main p-0">
			<div class="row center-item m-0">
				<div class="col-lg-6 pr-0 pl-0 reg-img">
					<img src="{SITE_IMG}contact-us.png" class="w-100">
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-12 right-block">
							<div class="form-register">
								<form action="{SITE_URL}" name="frmContact" id="frmContact" method="post">
									<div class="form-group">
										<input type="text" id="firstName" name="firstName" placeholder="{ENTER} {FNAME}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" id="lastName" name="lastName" placeholder="{ENTER} {LNAME}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" id="contactNo" name="contactNo" placeholder="{ENTER} {CONTACT_NO}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" id="email" name="email" placeholder="{ENTER} {EMAIL}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" id="subject" name="subject" placeholder="{ENTER} {SUBJECT}{MEND_SIGN}" class="form-control">
									</div>
									<div class="form-group">
										<textarea class="form-control" placeholder="{ENTER} {MESSAGE}{MEND_SIGN}" rows="3" id="message" name="message"></textarea>
									</div>
									<div>
										<input type="hidden" name="action" value="postConctactUs">
										<button class="btn-main btn-main-red w-100" type="submit" id="submit" name="submit">
											{SUBMIT}
										</button>
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