<div class="review-li">
	<figure class="m-0">
		<!-- <img src="%USER_IMG%" class="img-rounded" alt="%USER_NAME%"> -->
		<picture>
          <source srcset="%USER_IMG%" alt="%USER_NAME%" type="image/webp">
          <source srcset="%USER_IMG_MAIN%" alt="%USER_NAME%" type="image/jpg"> 
          <img src="%USER_IMG_MAIN%" alt="%USER_NAME%" />
        </picture>
	</figure>
	<div class="review-inner">
		<h3 class="review-heading mb-1 mt-0">
			%USER_NAME%
			<span>
				%POSTED_DATE%
			</span>
		</h3>
		<ul class="rate-bx mr-0">
      %RATING%
    </ul>
        <p class="mb-0">
        	{SERVICE_ID}: <b>%SERVICE_ID%</b>
        </p>
		<p>
			%REVIEW%
		</p>
		%REPLY_FORM%
	</div>							
</div>