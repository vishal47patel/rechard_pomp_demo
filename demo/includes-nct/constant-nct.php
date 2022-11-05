<?php

$sqlSettings = $db->select("tbl_site_settings", array("constant", "value"),array('isActive'=>'y'))->results();

foreach ($sqlSettings as $conskey => $consval) {
    define($consval["constant"], $consval["value"]);
}

define("SALT_FOR_ENCRYPTION", "ts");

$host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$canonical_url = "http://" . $host . $request_uri;
define('CANONICAL_URL', $canonical_url);

/*define('YEAR', date("Y"));*/

define('MEND_SIGN', '*');

define('AUTHOR', 'ncrypted');
define('ADMIN_NM', 'Administrator');
define('DEFAULT_CURRENCY_SIGN_FA_FA', '<i class="fa fa-usd" aria-hidden="true"></i>');
define('DEFAULT_CURRENCY_SIGN', '$');
define('DEFAULT_CURRENCY_CODE', 'USD');
define('REGARDS', SITE_NM);


define("SITE_INC", SITE_URL . "includes-nct/");
define("DIR_INC", DIR_URL . "includes-nct/");
define("SITE_MOD", SITE_URL . "modules-nct/");
define("DIR_MOD", DIR_URL . "modules-nct/");



define("SITE_UPD", SITE_URL . "upload-nct/");
define("DIR_UPD", DIR_URL . "upload-nct/");


define('SITE_THEME', SITE_URL . 'themes-nct/');
define("DIR_THEME", DIR_URL . "themes-nct/");
define('SITE_CSS', SITE_THEME . 'css-nct/');
define("DIR_CSS", DIR_THEME . "css-nct/");
define('SITE_IMG', SITE_THEME . 'images-nct/');
define("DIR_IMG", DIR_THEME . "images-nct/");
define("DIR_FONT", DIR_INC . "fonts-nct/");

define('SITE_HYBRIDAUTH', DIR_INC . 'hybridauth-master/hybridauth/');
define("DIR_HYBRIDAUTH", DIR_INC . "hybridauth-master/hybridauth/");




//define("SITE_THEME_CSS", SITE_URL . "themes-nct/css-nct/");
define('SITE_THEME_FONTS', SITE_URL . 'fonts/');
define('SITE_THEME_IMG', SITE_URL . 'images/');
define('SITE_THEME_JS', SITE_URL . 'js/');


define('DIR_THEME_IMG', DIR_THEME . 'images-nct/');

define("SITE_JS", SITE_INC . "javascript-nct/");
define("SITE_PLUGIN", SITE_JS . "plugins-nct/");
define("SITE_JS_MOD", SITE_JS . "modules-nct/");

define('SITE_LOGO_URL', SITE_URL . 'theme-image/' . SITE_LOGO . '?w=161&h=37');

define("DIR_FUN", DIR_URL . "includes-nct/functions-nct/");
define("DIR_TMPL", DIR_URL . "templates-nct/");
define("DIR_CACHE", DIR_UPD . "cache-nct/");

define('USER_DEFAULT_AVATAR', 'default_profile_pic.png');
define('PRODUCT_DEFAULT_IMAGE', SITE_THEME_IMG . 'product-default-image.jpg');

/* Start ADMIN SIDE */
define("SITE_ADMIN_URL", SITE_URL . "admin-nct/");
define("SITE_ADM_CSS", ADMIN_URL . "themes-nct/css-nct/");
define("SITE_ADM_IMG", ADMIN_URL . "themes-nct/images-nct/");
define("SITE_ADM_INC", ADMIN_URL . "includes-nct/");
define("SITE_ADM_MOD", ADMIN_URL . "modules-nct/");
define("SITE_ADM_JS", ADMIN_URL . "includes-nct/javascript-nct/");
define("SITE_ADM_UPD", ADMIN_URL . "upload-nct/");
define("SITE_JAVASCRIPT", SITE_URL . "includes-nct/javascript-nct/");
define("SITE_ADM_PLUGIN", ADMIN_URL . "includes-nct/plugins-nct/");
define("SITE_ADM_JAVA", SITE_ADMIN_URL . "includes-nct/javascript-nct/");

define("DIR_ADMIN_URL", DIR_URL . "admin-nct/");
define("DIR_ADMIN_THEME", DIR_ADMIN_URL . "themes-nct/");
define("DIR_ADMIN_TMPL", DIR_ADMIN_URL . "templates-nct/");
define("DIR_ADM_INC", DIR_ADMIN_URL . "includes-nct/");
define("DIR_ADM_MOD", DIR_ADMIN_URL . "modules-nct/");
define("DIR_ADM_PLUGIN", DIR_ADM_INC . "plugins-nct/");
define("DIR_ADMIN_FIELDS_HTML", DIR_ADMIN_TMPL."fields_html-nct/");

/* End ADMIN SIDE */

define("NMRF", '<div class="no-results text-center">No more results found.</div>');
define("NRF", '<div class="no-results text-center">No results found.</div>');

define("NO_MSG_FOUND", '<div class="no-results text-center">No Message Found.</div>');
define("LOADER", '<img alt="Loading.." src=" ' . SITE_THEME_IMG . 'ajax-loader-transparent.gif" class="lazy-loader" />');

define("PHP_DATE_FORMAT", 'M d, Y');
define("PHP_DATE_FORMAT_MONTH", 'M Y');
define("PHP_DATE_FORMAT_MONTH_YEAR", 'M Y');
define("MYSQL_DATE_FORMAT", '%b %d, %Y');
define("BOOTSTRAP_DATEPICKER_FORMAT", 'M d, yyyy');

define("GOOGLE_MAPS_API_KEY", "AIzaSyDdUNwDsMUgonNscXdqmZAAWn4B1mFweDM");

define('BN_CODE',"NCryptedTechnologies_SP_EC");
define('NO_FILE_FOUND','No File Found.');

define('MSG_SCROLL_LIMIT','25');

define("DIR_CAT_IMG", DIR_UPD . "service_category/");
define("SITE_CAT_IMG", SITE_UPD . "service_category/");

define('SUPER_ADMIN_EMAIL','gaurav.chavda@ncrypted.com');
define('SUPER_ADMIN','Gaurav');

define('GOOGLE_ADS_SECTION' , '<div class="ad-block ad-block-home">
    <div class="container">
        <img src="'.SITE_IMG.'ad.jpg">
    </div>
</div>');
