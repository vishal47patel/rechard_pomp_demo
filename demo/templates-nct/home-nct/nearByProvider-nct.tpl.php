<div class="item providerItem %ITEM_CLASS%">
    <div class="col-12 p-0 card-deck nearby-provider-box">
        <div class="card item-service">
            <div class="event-img text-center">
                <a href="{SITE_URL}profile/%PROVIDER_ID%" class="provider-detail">
                    <!-- <img src="%USER_IMAGE%"> -->
                    <picture>
                      <source srcset="%USER_IMAGE%" type="image/webp">
                      <source srcset="%USER_IMAGE_MAIN%" type="image/jpg"> 
                      <img src="%USER_IMAGE_MAIN%" />
                    </picture>
                    <h3 class="nps-name">%PROVIDER_NAME%</h3>
                </a>
            </div>
            <div class="service-right-div service-right-div2">
                <div class="avail-label avail-label2">%AVAILABILITY%</div>
                <div class="rating-review">
                    <ul class="rate-bx mr-0">
                        %AVG_RATING%
                    </ul>
                </div>
                <h4 class="my-2 color-gray">%DISTANCE% {KM}</h4>
                <div class="dropdown dropdown-h">
                    <a href="javascript:void(0)" class="btn-gray dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <i class="icon-share"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a id="fbShare" title="Facebook" href="%FB_LINK%" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                        <!-- <li><a id="gplusShare" title="Google+" href="%GOOGLE_LINK%" target="_blank"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a></li> -->
                        <li><a id="gplusShare" title="Google+" href="%TWITTER_LINK%" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <h4 class="mb-0">
                    %PROVIDER_NAME%
                </h4>
                <div class="slider-content-des">
                    <p>
                        %ADDRESS%
                    </p>
                    <p>
                        <a href="mailto:%EMAIL%" class="color-blue">%EMAIL%</a>
                    </p>
                    <p>
                        {TEL}: %CONTACT_NO%
                    </p>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-icon-home">
                    <a href="javascript:void(0);" userid="%PROVIDER_ID%" class="openCallModal btn-icon-name">
                        <i class="icon-telephone"></i>
                        <span>{CALL}</span>
                    </a>
                    <a href="javascript:void(0);" userid="%PROVIDER_ID%" class="openSendMsgModal btn-icon-name">
                        <i class="icon-speech-bubble"></i>
                        <span>{MESSAGE}</span>
                    </a>
                    <a href="{SITE_URL}service-request/%PROVIDER_ID%" class="btn-icon-name">
                        <i class="icon-instructions"></i>
                        <span>{BOOK}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>