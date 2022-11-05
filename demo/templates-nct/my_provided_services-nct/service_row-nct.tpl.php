<div class="col-md-6 col-lg-4 service-btn-div">
	<div class="service-block-li text-capitalize w-100">
		%SERVICE_NAME%
		<a type="button" onclick="return confirm('{MSG_SURE_DELETE}');" class="float-right" href="<?php echo $_SERVER['REQUEST_URI']."?action=deleteService&service_id="; ?>%ID%">
          <span class="text-danger"><i class="fa fa-trash"></i></span>
        </a>
	</div>
</div>