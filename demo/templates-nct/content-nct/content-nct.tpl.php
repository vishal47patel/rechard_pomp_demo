<!--Content Start-->
<?php if($_GET['viewType'] != 'app') { ?>
<div class="breadcrumbs-main">
    <div class="container">
        <h1>
            %pageTitle%
        </h1>
        <ul class="breadcrumb">
            <li><a href="{SITE_URL}">{HOME}</a></li>
            <li>%pageTitle%</li>
        </ul>
    </div>
</div>
<?php } ?>
%pageDesc%
