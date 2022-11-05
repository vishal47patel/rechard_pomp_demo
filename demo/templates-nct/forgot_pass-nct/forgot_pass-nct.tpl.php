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
                  {FORGOT_PASSWORD}
                </h1>
                <div class="main-title-icon">
                  <span class="icon-customer-support"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                </div>
              </div>
              <div class="form-register">
                <form id="forgot_pwd_form" method="post">
                  <div class="form-group">
                    <input type="email" name="email"  id="resendemail" value="%EMAIL%" placeholder="{ENTER} {EMAIL}{MEND_SIGN}" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="hidden" value="forgot_password" name="action" id="action" />
                    <button type="submit" class="btn-main btn-main-red w-100" id="reset_pwd" name="reset_pwd">
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