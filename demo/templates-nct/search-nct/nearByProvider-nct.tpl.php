<div class="col-12 col-md-6 col-lg-3 card-deck providerItem">
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
        <div class="card-body">
            <div class="rating-review">
                <ul class="rate-bx mr-0">
                    %AVG_RATING%
                </ul>
            </div>
            <h4 class="mb-0">
                %PROVIDER_NAME%
            </h4>
            <div class="slider-content-des">
                <p>
                    %ADDRESS% <span>|</span>  %DISTANCE% {KM}
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
            <ul class="contact-list">
                <li class="contact-li">
                    <a href="javascript:void(0);" class="openCallModal" userid="%PROVIDER_ID%">
                        <i class="icon-telephone"></i>
                    </a>
                </li>
                <li class="contact-li">
                    <a href="javascript:void(0);" class="openSendMsgModal" userid="%PROVIDER_ID%">
                        <i class="icon-speech-bubble"></i>
                    </a>
                </li>
                <li class="contact-li">
                    <div class="dropdown dropdown-h open">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="icon-share"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a id="fbShare" title="Facebook" href="%FB_LINK%" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                            <!-- <li><a id="gplusShare" title="Google+" href="%GOOGLE_LINK%" target="_blank"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a></li> -->
                            <li><a id="gplusShare" title="Google+" href="%TWITTER_LINK%" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <a class="btn-main btn-main-red w-100" href="{SITE_URL}service-request/%PROVIDER_ID%">
                {BOOK_NOW}
            </a>
        </div>
    </div>
</div>