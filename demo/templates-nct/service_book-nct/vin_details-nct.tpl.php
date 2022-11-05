<div class="box-shadow-main service-detail-page">
<h3 class="service-title">
{VEHICLE_DETAILS}

<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='provider' ){ ?>
  <a href="javascript:void(0)" id="openServiceModal">
    + {ADD_SERVICE_RECORD}
  </a>
<?php } ?>
</h3>
<table class="vehicle-detail-tb">
<tr>
  <td>
    <p class="top-title">
      VIN
    </p>
    <p class="title-value">
      %VIN_NUMBER% 
    </p>
  </td>
  <td>
    <p class="top-title">
      {VEHICLE_MAKE}
    </p>
    <p class="title-value">
      %VEHICLE_MAKE%
    </p>
  </td>
  <td>
    <p class="top-title">
      {VEHICLE_MODEL}
    </p>
    <p class="title-value">
      %VEHICLE_MODEL%
    </p>
  </td>
</tr>
<tr>
  <td>
    <p class="top-title">
      {VEHICLE_YEAR}
    </p>
    <p class="title-value">
      %VEHICLE_YEAR%
    </p>
  </td>
  <td>
    <p class="top-title">
      {VEHICLE_ENGINE}
    </p>
    <p class="title-value">
      %VEHICLE_ENGINE%
    </p>
  </td>
  <td>
    <p class="top-title">
      {ENGINE_POWER} (kW)
    </p>
    <p class="title-value">
      %ENGINE_POWER%
    </p>
  </td>
</tr>
</table>
<h3 class="service-title">
{SERVICE_DETAILS}
</h3>
<div class="row rgt-srch-list">
  %SERVICE_DETAILS%
</div>
<input type="hidden" id="currentPage" value="%PAGE%" />
%PAGINATION%
</div>

<div class="modal" id="add_new_service">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header text-center">
        <h2 class="modal-title mt-0 w-100">{ADD_SERVICE_RECORD}</h2>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="frmServiceRecord" name="frmServiceRecord" method="POST">
          <div class="form-group">
            <input type="text" id="service_date" name="service_date" placeholder="{SELECT_SERVICE_DATE}{MEND_SIGN}" class="form-control" autocomplete="off" readonly="true">
          </div>
          <div class="form-group">
            <textarea id="description" name="description" placeholder="{ENTER} {DESCRIPTION}{MEND_SIGN}" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <input type="text" id="amount" name="amount" placeholder="{ENTER} {AMOUNT} ({DEFAULT_CURRENCY_SIGN}){MEND_SIGN}" class="form-control">
          </div>
          <div class="text-left">
            <input type="hidden" id="action" name="action" value="addServiceRecord" />
            <input type="hidden" id="vin_number" name="vin_number" value="%VIN_NUMBER%" />
            <button type="submit" class="btn-main btn-main-red mb-0">
              {SUBMIT}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>