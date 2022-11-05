<h3 class="customer-detail-title">
	{PROVIDER_DETAILS}
</h3>
<div class="review-ul">
	<div class="review-li border-bottom-0 pb-0">
		<figure class="m-0">
			<!-- <img src="%USER_IMG%" class="img-rounded"> -->
			<picture>
                      <source srcset="%USER_IMG%" type="image/webp" class="img-rounded">
                      <source srcset="%USER_IMG_MAIN%" type="image/jpg" class="img-rounded"> 
                      <img src="%USER_IMG_MAIN%" class="img-rounded" />
                    </picture>
		</figure>
		<div class="review-inner pt-2 pb-2">
			<h3 class="review-heading mb-1 mt-0 text-truncate">
				<a href="{SITE_URL}profile/%USER_ID%">
          %USER_NAME%
        </a>
			</h3>
			<ul class="rate-bx mr-0">
          %RATING%
      </ul>
      <p class="mb-0">
      	{TEL}: %CONTACT_NO%
      </p>
		</div>
	</div>
</div>