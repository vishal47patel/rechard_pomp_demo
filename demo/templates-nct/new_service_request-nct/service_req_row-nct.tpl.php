<div class="col-12 col-md-6 col-lg-4 card-deck">
	<div class="card item-service">
		%STATUS%
		<div class="event-img text-center">
	    	<a href="%CUSTOMER_URL%" class="provider-detail">
	    		<!-- <img src="%CUSTOMER_IMG%"> -->
	    		<picture>
                      <source srcset="%CUSTOMER_IMG%" type="image/webp">
                      <source srcset="%CUSTOMER_IMG_MAIN%" type="image/jpg"> 
                      <img src="%CUSTOMER_IMG_MAIN%" />
                    </picture>
	    		<h3 class="nps-name">%CUSTOMER_NAME%</h3>
	    	</a>
    	</div>
    	<div class="card-body">
    		<h4 class="mb-0">
    			<a href="%CUSTOMER_URL%">
    				%CUSTOMER_NAME%
    			</a>
    		</h4>
	    	<div class="slider-content-des">
	    		<p>
	    			%SERVICE_TYPE%
	    		</p>
	    		<p>
	    			{DATE}: %SERVICE_DATE%
	    		</p>
	    		<p>
	    			%ADDRESS%
	    		</p>
	    		<p>
	    			{TEL}: %CONTACT_NO%
	    		</p>
	    		<p>
	    			{MESSAGE}: %MESSAGE%
	    		</p>				
								
					%DEST_DETAIL%
	    		
								
	    			%NUM_PASS%
	    		
	    	</div>
		</div>
		<div class="card-footer">
	    	<div class="row row-5 h-padding-0">
	    		%REQ_BTN%
	    		%DETAIL_BTN%
			</div>
		</div>
	</div>
</div>