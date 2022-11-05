<form action="" method="post" name="frmCont" id="frmCont" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">
	<div class="form-body">

		%ONLY_ADD_DATA%

		<div class="form-group">
			<label for="types" class="control-label col-md-3"> %MEND_SIGN%
				Type: &nbsp;
			</label>
			<div class="col-md-4">
				<input type="text" class="form-control logintextbox-bg required" name="types" id="types" value="%TYPES%"></div>
		</div>
		<div class="padtop10 flclear"></div>

		<div class="form-group">
			<label for="subject" class="control-label col-md-3"> %MEND_SIGN%
				Subject: &nbsp;
			</label>
			<div class="col-md-4">
				<input type="text" class="form-control logintextbox-bg required" name="subject" id="subject" value="%SUBJECT%"></div>
		</div>
		<div class="padtop10 flclear"></div>
		<div class="form-group">
			<label class="control-label col-md-3">
				Description: &nbsp;
			</label>
			<div class="col-md-4">
				<textarea class="ckeditor form-control textarea-bg" name="description" id="description">
					%DESCRIPTION%
				</textarea>
			</div>
		</div>
		<div class="padtop10 flclear"></div>
		<div class="form-group">
			<label class="control-label col-md-3"> %MEND_SIGN%
				Template: &nbsp;
			</label>
			<div class="col-md-9">
				<textarea class="ckeditor form-control textarea-bg required" name="templates" id="templates">
					%TEMPLATES%
				</textarea>
			</div>
		</div>
		<script type="text/javascript">$(function(){loadCKE("templates");});</script>
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