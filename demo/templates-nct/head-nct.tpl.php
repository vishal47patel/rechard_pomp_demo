<title>%TITLE%</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
%METATAG%
<link rel="stylesheet" type="text/css" href="{SITE_CSS}fontawesome.min.css">
<!--css styles starts-->
<!-- <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="{SITE_CSS}bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{SITE_CSS}bootstrap-select.css">
<link rel="stylesheet" href="{SITE_CSS}animate.min-nct.css">
<link rel="stylesheet" href="{SITE_CSS}icomoon-nct.css">
<link rel="stylesheet" type="text/css" href="{SITE_CSS}style-nct.css">
<link rel="stylesheet" type="text/css" href="{SITE_CSS}dev_style-nct.css">
<link rel="stylesheet" type="text/css" href="{SITE_CSS}responsive.css">

<?php if(($this->module == 'edit_profile-nct') || ($this->module == 'registration-nct') ) { ?>
<link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css'/>
<?php } ?>

<?php if($this->module == 'service_detail-nct') { ?>
<link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.12.0/maps/maps.css'>
<?php } ?>

<script>
	var SITE_URL = "{SITE_URL}";
	var TOMTOM_KEY = "{TOMTOM_KEY}";
	var MEND_SIGN = "{MEND_SIGN}";
	var VOIP_SERVER_ADDRESS = "{VOIP_SERVER_ADDRESS}";
</script>

<!-- Old CSS 05-May-18 -->
<link rel="shortcut icon" type="image/ico" href="{SITE_IMG}{SITE_FAVICON}">


<link href="{SITE_CSS}toastr.css" rel="stylesheet">
<!-- blue imp css-->

<?php if( ($this->module == 'profile-nct') || ($this->module == 'edit_profile-nct') || ($this->module == 'service_request-nct') ) { ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<?php } ?>