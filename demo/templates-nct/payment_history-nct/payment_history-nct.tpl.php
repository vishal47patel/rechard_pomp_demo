<style type="text/css">
	.hide{
		display: none;
	}
</style>
<div class="breadcrumbs-main">
	<div class="container">
		<h1>
			{PAYMENT_HISTORY}
		</h1>
		<ul class="breadcrumb">
			<li><a href="{SITE_URL}">{HOME}</a></li>
			<li>{PAYMENT_HISTORY}</li>
		</ul>
	</div>
</div>

{GOOGLE_ADS_SECTION}

<div class="main-content">
	<div class="container">
		<div class="table white-box-shadow table-25" id="tableBody">
			<div class="theader %HEADER%">
				<div class="table_header">{TRANSACTION_ID}</div>
				<div class="table_header">{SERVICE_ID}</div>
				<div class="table_header">{USER_NAME}</div>
				<div class="table_header">{PAYMENT_METHOD}</div>
				<div class="table_header">{TRANS_DATE}</div>
				<div class="table_header">{AMOUNT}</div>
			</div>			
			%HISTORY_LIST%			
		</div>
		<nav aria-label="..." class="pagination-main mt-2">
			<ul class="pagination justify-content-center">
				<div id="pageContent">
                    %HISTORY_PAGINATION%
                </div>	
			</ul>
		</nav>		
	</div>
</div>