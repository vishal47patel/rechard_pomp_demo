<div class="breadcrumbs-main">
  <div class="container">
    <h1>
      {ACCOUNT_SETTINGS}
    </h1>
    <ul class="breadcrumb">
      <li><a href="{SITE_URL}">{HOME}</a></li>
      <li>{ACCOUNT_SETTINGS}</li>
    </ul>
  </div>
</div>

{GOOGLE_ADS_SECTION}

<div class="main-content">
  <div class="container">
    <div class="col-md-8 offset-md-2 content-des acc-main">
      <h2>
        {CHANGE_EMAIL_ADD}
      </h2>
      <form id="frmChngEmail" name="frmChngEmail" method="POST" novalidate="novalidate">
        <div class="form-group">
          <input type="email" name="new_email_id" id="new_email_id" class="form-control" placeholder="{ENTER_NEW_EMAIL_ID}*">
        </div>
        <div class="form-group">
          <input type="hidden" name="action" id="action" value="changeEmail">
          <button type="submit" class="btn-main btn-main-red mr-2 mb-2" id="btnChangeEmail" name="btnChangeEmail">
            {LBL_UPDATE}
          </button>
          <a href="{SITE_URL}account-setting" class="btn-main btn-red-outer mb-2" id="cnlChangeEmail" name="cnlChangeEmail">{CANCEL}</a>
        </div>
      </form>
	  
	  <h2>{PAY_GATE_ID}  
      </h2>
	  <form id="frmpaypalEmail" name="frmpaypalEmail" method="POST" novalidate="novalidate">
        <div class="form-group">
		<!--<input type="text" name="paypalEmail" id="paypalEmail" class="form-control" placeholder="{ENT_PAY_GATE_ID}*" value="%PAYMENT_GATEWAY_ID%">-->
          <input type="text" name="paypalEmail" id="paypalEmail" class="form-control" placeholder="{ENT_PAY_GATE_ID}" value="%PAYMENT_GATEWAY_ID%">
        </div>
        <div class="form-group">
          <input type="hidden" name="action" id="action" value="changePaymentID">
          <button type="submit" class="btn-main btn-main-red mr-2 mb-2 btnupdatepaypalEmail" id="btnupdatepaypalEmail" name="btnupdatepaypalEmail">
            {LBL_UPDATE}
          </button>
          <a href="{SITE_URL}account-setting" class="btn-main btn-red-outer mb-2" id="cnlChangeEmail" name="cnlChangeEmail">{CANCEL}</a>
        </div>
      </form>
	  
      %CHANGE_PWD_TAB%
      <h2>
        {NOTI_PREFE}
      </h2>
      <ul class="notification-ul">
        %NOTIFICATION_LIST%
      </ul>
      
     <!--  <h2>
        {MIZUTECH_DETAILS}
      </h2>
      <form id="frmMizutech" name="frmMizutech" method="POST" novalidate="novalidate">
        <div class="form-group">
          <input type="text" name="mizutech_name" id="mizutech_name" class="form-control" placeholder="{ENTER_MIZU_NAME}*" value="%MIZU_NAME%">
        </div>
        <div class="form-group">
          <input type="text" name="mizutech_pwd" id="mizutech_pwd" class="form-control" placeholder="{ENTER_MIZU_PWD}*" value="%MIZU_PWD%">
        </div>
        <div class="form-group mb-0">
          <input type="hidden" name="action" id="action" value="changeMizutechDetails">
          <button class="btn-main btn-main-red" id="btnMizutech" name="btnMizutech">
            {SUBMIT}
          </button>
        </div>
      </form> -->
      
    </div>
  </div>
</div>
