<div class="breadcrumbs-main">
    <div class="container">
      <h1>
        {SEARCH_RESULT}
      </h1>
      <ul class="breadcrumb">
        <li><a href="{SITE_URL}">{HOME}</a></li>
        <li>{SEARCH_RESULT}</li>
      </ul>
    </div>
  </div>
  <div class="main-content">
    <div class="container">
      <form method="post" action="" id="searchFrm" class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="form-group col-lg-4">
              <select name="service_type" id="service_type" class="form-control">
                <option value="mechanic" %MECH_SELECTED%>{MECHANIC}</option>
                <option value="taxi" %TAXI_SELCTED%>{TAXI}</option>
              </select>
            </div>
            <div class="form-group col-lg-5">
              <input type="text" value="%RADIUS%" name="radius" id="radius" placeholder="{ENTER_SEARCH_RADIUS}{MEND_SIGN}" class="form-control">
            </div>
            <div class="form-group col-lg-3">
              <input type="hidden" id="considerRadius" value="%RADIUS_CONSIDER%" />
              <button type="button" class="btn-main btn-main-red w-100" id="searchBtn">
                {SEARCH}
              </button>
            </div>
          </div>                
        </div>
        <div class="offset-lg-2 col-lg-2">
          <!--<select class="form-control">
            <option hidden="true">
              Filter by
            </option>
            <option>
              1
            </option>
          </select>-->
            <a href="#" class="form-control dropdown-toggle filter-by-a position-relative" data-toggle="dropdown">
          Filter by
          <i class="icon-down-arrow"></i>
        </a>
        <div class="dropdown-menu filter-price-main p-0">
            <div class="shadow-1 lft-srch-form">
                    <div class="form-group cf">
                      <div class="our-prices">
                        <label for="amount">{RADIUS}: </label>
                        <!-- <input type="text" id="amount" readonly> -->
                        <span id="minRadiusDisp">%MIN_RADIUS%km</span>
                        <span>-</span>
                        <span id="maxRadiusDisp">%MAX_RADIUS%km</span>
                        <input type="hidden" id="minRadius" value="%MIN_RADIUS%" />
                        <input type="hidden" id="maxRadius" value="%MAX_RADIUS%" />
        
                        <input type="hidden" id="slider_minRadius" value="%SLIDER_MIN_RADIUS%" />
                        <input type="hidden" id="slider_maxRadius" value="%SLIDER_MAX_RADIUS%" />
                        <div id="slider-range"></div>
                      </div>
                    </div>
                    <div class="min-max-price">
            <span class="min-price-h">1 km</span>
            <span class="max-price-h">100 km</span>
          </div>
                </div>
        </div>
        </div>
      </form>
      <div class="">
        <div class="col-md-12 col-lg-4">
          
        </div>
        </div>
      <div class="rgt-srch-list row">
      </div>
      <input type="hidden" id="currentPage" value="%PAGE%" />
      <nav aria-label="Page navigation example" class="pagination-main mt-5">
        <ul class="pagination justify-content-center">          
        </ul>
      </nav>
    </div>
  </div>