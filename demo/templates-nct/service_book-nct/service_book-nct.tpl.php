<div class="breadcrumbs-main">
  <div class="container">
    <h1>
      {SERVICE_BOOK_DETAIL}
    </h1>
    <ul class="breadcrumb">
      <li><a href="{SITE_URL}">{HOME}</a></li>
      <li>{SERVICE_BOOK_DETAIL}</li>
    </ul>
  </div>
</div>

{GOOGLE_ADS_SECTION}

<div class="main-content">
  <div class="container">
    <form method="post" action="" id="searchFrm" class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="row">
          <div class="form-group col-lg-9">
            <input type="text" name="vin_number" id="vin_number" placeholder="{ENTER_VIN} {MEND_SIGN}" class="form-control">
          </div>
          <div class="form-group col-lg-3">
            <button class="btn-main btn-main-red w-100" type="button" id="searchVINBtn">
              {SEARCH}
            </button>
          </div>
        </div>                
      </div>
    </form>
    <div class="result_page">
    </div>
  </div>
</div>