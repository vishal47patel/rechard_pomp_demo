<div class="breadcrumbs-main">
	<div class="container">
		<h1>
			{MY_PRO_SERS}
		</h1>
		<ul class="breadcrumb">
			<li><a href="{SITE_URL}">{HOME}</a></li>
			<li>{MY_PRO_SERS}</li>
		</ul>
	</div>
</div>

{GOOGLE_ADS_SECTION}

<div class="main-content service-main">
	<div class="container">
		<div class="text-center">
			<a href="javascript:void(0)" class="btn-main btn-main-red mb-4" id="openAddServiceModal">
				<i class="icon-plus"></i> {ADD_NEW_SER}
			</a>
			<div class="modal" id="add_new_service">
				<div class="modal-dialog">
					<div class="modal-content">

						<!-- Modal Header -->
						<div class="modal-header text-center">
							<h2 class="modal-title mt-0 w-100">{ADD_NEW_SER}</h2>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<!-- Modal body -->
						<div class="modal-body">
							<form id="frmAddService" name="frmAddService" method="POST" action="">
								<div class="form-group">
									<input type="text" name="service_name" id="service_name" placeholder="{ENTER_SERVICE_NAME}{MEND_SIGN}" class="form-control">
								</div>
								<div class="text-left">
									<input type="hidden" name="action" id="action" value="addNewService">
									<button type="submit" id="btn_submit" name="btn_submit" class="btn-main btn-main-red mb-0">
										{SUBMIT}
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-shadow-main p-3 text-center %NO_RECORD_CLASS%">{NO_ANY_SER_ADDED}</div>
		<div class="row" id="serviceBody">
			%SERVICE_LIST%
		</div>
		<nav aria-label="..." class="pagination-main mt-2">
			<ul class="pagination justify-content-center">
				<div id="pageContent">
                    %SERVICE_PAGINATION%
                </div>	
			</ul>
		</nav>
	</div>
</div>