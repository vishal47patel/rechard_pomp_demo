<div class="contact-sec cf">
	<div class="container">
		<h2>Contact Us</h2>
		<div class="row">
			<div class="col-md-1 col-lg-1"></div>
			<div class="col-md-10 col-lg-10">
				<form name="frmContact" id="frmContact" method="post">
					<input type="hidden" name="action" value="postConctactUs">
					<div class="form-row">
						<div class="form-group col-md-6">
							<div class="md-input">
								<label>User Name {MEND_SIGN}</label>
								<input name="userName" id="userName" type="text" >
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="md-input">
								<label>Email {MEND_SIGN}</label>
								<input name="email" id="email" type="text" >
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<div class="md-input">
								<label>Contact Number {MEND_SIGN}</label>
								<input name="contactNo" id="contactNo" type="text" >
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="md-input">
								<label>Address {MEND_SIGN}</label>
								<input name="location" id="location" placeholder="" type="text" >
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<div class="md-input form-group is-desc">
								<label>Description {MEND_SIGN}</label>
								<textarea id="description" name="message"></textarea>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12 text-center">
							<input type="submit" id="submit" name="submit" class="btn green-btn" value="Submit">
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-1 col-lg-1"></div>
		</div>
	</div>
</div>