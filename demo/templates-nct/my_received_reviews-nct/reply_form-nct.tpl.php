<a href="javascript:void(0);" class="btn-main btn-main-red btn-sm rpy_btn rply_btn%ID%" data-id="%ID%">
	{LBL_REPLY}
</a>
<form class="mt-4 post_rpy%ID% hide" id="frmPostReply" name="frmPostReply" method="POST">
	<div class="form-group">
		<textarea class="form-control" id="description" name="description" placeholder="{ADD_REPLY_REVIEW}{MEND_SIGN}" rows="4"></textarea>
	</div>
	<div class="form-group text-right">
		<input type="hidden" name="action" id="action" value="add_review_reply">
		<input type="hidden" name="id" id="id" value="%ID%">
		<button type="submit" class="btn-main btn-main-red">
			{POST_REPLY}
		</button>
		<!-- <button type="button" class="btn-main btn-main-red cancelReply" data-id="%ID%">
			{CANCEL}
		</button> -->
	</div>
</form>