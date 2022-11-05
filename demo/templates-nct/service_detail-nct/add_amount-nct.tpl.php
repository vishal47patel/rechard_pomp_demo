<h3 class="customer-detail-title">
	{ADD_AMOUNT}
</h3>
<form id="addAmountForm" method="POST" action="" class="mt-3">

<div class="form-group">
	<input type="text" id="amountVal" name="amountVal" class="form-control" placeholder="{ENTER} {AMOUNT} ({DEFAULT_CURRENCY_SIGN}){MEND_SIGN}" />
	<div class="text-center all-btns mt-3">
		<input type="hidden" name="service_request_id" value="%SERVICE_REQ_ID%" />
		<button type="submit" id="addAmountBtn" name="addAmountBtn" class="btn-main btn-main-red btn large-btn">{SUBMIT}</button>
	</div>
</div>

</form>