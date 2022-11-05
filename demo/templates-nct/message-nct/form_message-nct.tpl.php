<div class="position-relative msg-form-div">
    <form id="msgForm" name="msgForm" method="post" autocomplete="off" class="chat-form">
    	<textarea class="form-control" id="message" name="message"  placeholder="{ENTER_MSG}"></textarea>
    	<div class="chat-btn-div">
        	<button class="btn chat-btn" type="submit" id="msgSubmit" name="msgSubmit" title="{SEND}">
        	    <i class="icon-airplane"></i>
        	</button>
        	<input type="hidden" id="receiverId" name="receiverId" value="%RECEIVER_ID%">
    	</div>
    </form>
    <button class="btn chat-btn upload-file-btn">
        <label class="upload-img" for="msgFile">
        	<input id="msgFile" type="file" name="msgFile" accept="video/*,image/*,audio/*" size="40" class="d-none">
        	<span class="icon-paper-clip-1"><span class="path1"></span><span class="path2"></span></span>
        </label>
    </button>
</div>
