<h2>
{CHANGE_PASS}
</h2>
<form id="frmChngPwd" name="frmChngPwd" method="POST" novalidate="novalidate" action="">
	<div class="form-group">
	  <input type="password" name="oldPwd" id="oldPwd" class="form-control" placeholder="{CURRENT_PASSWORD}*">
	</div>
	<div class="form-group">
	  <input type="password" name="newPwd" id="newPwd" class="form-control" placeholder="{ENTER_NEW_PASSWORD}*">
	</div>
	<div class="form-group">
	  <input type="password" name="cnfNewPwd" id="cnfNewPwd" class="form-control" placeholder="{CONFIRM_PASSWORD}*">
	</div>
	<div class="form-group">
		<input type="hidden" name="action" id="action" value="changePassword">
	  <button type="submit" class="btn-main btn-main-red mr-2 mb-2" id="btnChangePwd" name="btnChangePwd">
	    {LBL_UPDATE}
	  </button>
	  <a href="{SITE_URL}account-setting" class="btn-main btn-red-outer mb-2" id="cnlChangePwd" name="cnlChangePwd">{CANCEL}</a>
	</div>
</form>