<form action="" method="post" name="frmCont" id="frmCont" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">
	<div class="form-body">
		<!-- <div class="form-group">
			<label for="subject" class="control-label col-md-3"> %MEND_SIGN%
				First Name: &nbsp;
			</label>
			<div class="col-md-4">
				<input type="text" class="form-control logintextbox-bg required" name="firstName" id="firstName" value="%FIRSTNAME%"></div>
		</div>
		<div class="form-group">
			<label for="subject" class="control-label col-md-3"> %MEND_SIGN%
				Last Name: &nbsp;
			</label>
			<div class="col-md-4">
				<input type="text" class="form-control logintextbox-bg required" name="lastName" id="lastName" value="%LASTNAME%"></div>
		</div>
		<div class="padtop10 flclear"></div>
		<div class="form-group">
			<label for="subject" class="control-label col-md-3"> %MEND_SIGN%
				Email: &nbsp;
			</label>
			<div class="col-md-4">
				<input type="text" class="form-control logintextbox-bg required" name="email" id="email" value="%EMAIL%"></div>
		</div>
		<div class="padtop10 flclear"></div>
		<div class="form-group">
			<label for="subject" class="control-label col-md-3"> %MEND_SIGN%
				Contact Number: &nbsp;
			</label>
			<div class="col-md-4">
				<input type="text" class="form-control logintextbox-bg required" name="contactno" id="contactno" value="%CONTACTNO%"></div>
		</div>
		<div class="padtop10 flclear"></div>
		<div class="form-group">
			<label class="control-label col-md-3">
				{MEND_SIGN}Message: &nbsp;
			</label>
			<div class="col-md-4">
				<textarea class="form-control textarea-bg required" name="message" id="message">
					%MESSAGE%
				</textarea>
			</div>
		</div>
		<div class="padtop10 flclear"></div> -->
		<div class="form-group">
			<label class="control-label col-md-3">
				{MEND_SIGN}Reply Message: &nbsp;
			</label>
			<div class="col-md-4">
				<textarea class="form-control textarea-bg required" name="replayMessage" id="replayMessage">
					%REPLAYMESSAGE%
				</textarea>
			</div>
		</div>

		<div class="flclear clearfix"></div>
		<input type="hidden" name="type" id="type" value="%TYPE%">
		<div class="flclear clearfix"></div>
		<input type="hidden" name="id" id="id" value="%ID%">
		<div class="padtop20"></div>
	</div>
	<div class="form-actions fluid">
		<div class="col-md-offset-3 col-md-9">
			<button type="submit" name="submitAddForm" class="btn green" id="submitAddForm">Submit</button>
			<button type="button" name="cn" class="btn btn-toggler" id="cn">Cancel</button>
		</div>
	</div>
</form>