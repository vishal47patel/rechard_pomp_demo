<li class="user-card msg-cell %ACTIVE_CLASS% mainUserLi %IN_TR_CLASS%">
	<a href="javascript:void(0)" class="msg-box %MSG_CLASS% getChat1" data-userId="%USER_ID%" data-usermizutechname="%MIZUTECH_NAME%">
		<div class="usr-img inbox-img">
			<!-- <img src="%USER_PHOTO%" alt="%USER_NAME%"> -->
			<picture>
                      <source alt="%USER_NAME%" srcset="%USER_PHOTO%" type="image/webp">
                      <source alt="%USER_NAME%" srcset="%USER_PHOTO_MAIN%" type="image/jpg"> 
                      <img alt="%USER_NAME%" src="%USER_PHOTO_MAIN%" />
                    </picture>			
		</div>
		<div class="usr-det">
    		<h3>%USER_NAME% <span class="unread_cnt %HIDE_SHOW_CLASS%">(%TOTAL_UNREAD%)</span></h3>
    		<span class="time-text">%TIME%</span>
    		<p class="lastMsgP">%LAST_MSG% </p>
		</div>
	</a>
	%DELETE_BUTTON%
</li>
