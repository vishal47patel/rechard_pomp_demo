<div class="breadcrumbs-main">
	<div class="container">
		<h1>
			{INBOX}
		</h1>
		<ul class="breadcrumb">
			<li><a href="{SITE_URL}">{HOME}</a></li>
			<li>{INBOX}</li>
		</ul>
	</div>
</div>

{GOOGLE_ADS_SECTION}
<?php
$url = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$url_para = explode("/", $url);
$url_para = array_reverse($url_para);
?>
<section class="inner-section message-main">
	<div class="container">
		<div class="clearfix"></div>
		<div class="row main-div">
			<div class="offset-lg-3 offset-md-3 col-lg-6 col-md-6"<?php if($url_para[0] != 'message-room' && $url_para[1] == 'message-room'){ echo "style='display:none'"; } ?> >
				<div class="msg-left box-shadow">
					<!-- <a href="javascript:void(0)" class="btn large-btn" id="newMessage"><i class="fas fa-comments"></i> {NEW_MESSAGE}</a> -->
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active tabLink"  id="inbox-tab" data-toggle="tab" href="javascript:void(0)" role="tab" aria-controls="inbox-tab" aria-selected="true" data-type="i">{INBOX}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link tabLink" id="trashTab-tab" data-toggle="tab" href="javascript:void(0)" role="tab" aria-controls="trash-link" aria-selected="false" data-type="t">{TRASH}</a>
						</li>
					</ul>

					<div class="tab-content box-shadow" id="myTabContent">
					
						<div class="tab-pane password-pane fade show active messageTab"  data-type="inbox" role="tabpanel" aria-labelledby="inbox-link">
							%CONTAINER%
						</div>
					</div>
				</div>
			</div>
			<div class=" <?php if($url_para[0] != 'message-room' && $url_para[1] == 'message-room'){ echo "col-sm-12 col-xs-12 offset-lg-2 offset-md-2 col-lg-8 col-md-8"; } ?>" <?php if($url_para[0] == 'message-room'){ echo 'style="display: none;"'; } ?>>			
					<div class="" id="inbox-trash-tab">		
						%RIGHT_PANEL%				
					</div>
			</div>
		</div>
	</div>
</section>

<!-- new message modal -->
<div class="modal fade forgot-popup" id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2 id="header">{SEND_MSG}</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<input type="hidden" id="receiverId" value="%RECEIVER_ID%">
			<form id="newMessageForm" method="post">
				<div class="modal-body">

						<div class="form-group">
							<select id="user_lists" name="receiverId" data-error-container="#user-error-class"  class="selectpicker form-control bs-select-hidden required" title="{CHOOSE_ONE}" data-live-search="true">
								%NEW_USER_LIST%
							</select>
							<div class="error" id="user-error-class"></div>
						</div>


						<div class="md-input form-group cf">
							<input type="hidden" name="action" value="sendMessage">
							<textarea id="msgModalMessage"  class="form-control" name="message" rows="4" placeholder="{ENTER_MSG}"></textarea>
						</div>

				</div>
				<div class="modal-footer">
          			<div class="text-center w-100 d-block mt-3">
						<button type="submit" class="btn large-btn" name="reset_pwd">{SEND}</button>
						<button type="button" class="btn close-btn" data-dismiss="modal">{CLOSE}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>