<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Dashboard <small>statistics and more</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                Home
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">
                    Dashboard
                </a>
            </li>
            <li class="pull-right">
                <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                    <i class="fa fa-calendar"></i>
                    <span>
                    </span>
                    <i class="fa fa-angle-down"></i>
                </div>
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->

<div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue">
                <a href="{SITE_ADM_MOD}mechanics-nct" title="Users">
                    <div class="visual">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            %NO_OF_MECHANIC%
                        </div>
                        <div class="desc">
                             Providers
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue">
                <a href="{SITE_ADM_MOD}users-nct" title="Users">
                    <div class="visual">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            %NO_OF_SEEKER%
                        </div>
                        <div class="desc">
                             Customers
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="clearfix"></div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="user_tab">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="users">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Providers Report
                        </div>
                        <div class="tools">
                            <div class="col-sm-6 col-md-6">
                                %MONTH_DD_USERS_REPORT%
                            </div>
                            <div class="col-sm-6 col-md-6">
                                %YEAR_DD_USERS_REPORT%
                            </div>

                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="users_report" data-callback="generateUsersReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="user_tab">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="seekers">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Customers Report
                        </div>
                        <div class="tools">
                            <div class="col-sm-6 col-md-6">
                                %MONTH_DD_SEEKERS_REPORT%
                            </div>
                            <div class="col-sm-6 col-md-6">
                                %YEAR_DD_SEEKERS_REPORT%
                            </div>

                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="seekers_report" data-callback="generateSeekersReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="user_tab">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="services">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Completed Services Report
                        </div>
                        <div class="tools">
                            <div class="col-sm-6 col-md-6">
                                %MONTH_DD_SERVICE_REPORT%
                            </div>
                            <div class="col-sm-6 col-md-6">
                                %YEAR_DD_SERVICE_REPORT%
                            </div>

                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="services_report" data-callback="generateServicesReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
</div>

<script type="text/javascript">

    users_report_array = %USER_REPORT_ARRAY%;    
    seekers_report_array = %SEEKER_REPORT_ARRAY%;
    services_report_array = %SERVICE_REPORT_ARRAY%;

    jQuery(document).ready(function () {
        Charts.generateUsersReport();
        Charts.generateSeekersReport();
        Charts.generateServicesReport();
    });

    function updateReport(portlet,report_type) {
        //portlet = $(this).parents('.portlet');

        //report_type = portlet.data('report-type');

        month = portlet.find('.month').val();
        year = portlet.find('.year').val();
        console.log(report_type);
        $.ajax({
            type: 'POST',
            url: "<?php echo SITE_ADM_MOD . $this->module ?>/ajax.<?php echo $this->module; ?>.php",
            data: {
                action: 'getReportData',
                report_type: report_type,
                month: month,
                year: year,
            },
            beforeSend: function () {
                addOverlay();
                //portlet.find('.month').prop("disabled", true);
                //portlet.find('.year').prop("disabled", true);
            },
            complete: function () {
                removeOverlay();
            },
            dataType: 'json',
            success: function (result) {
                console.log(result);
                if (result.status) {
                    report_data = result.report_data;
                    if (report_type == 'users') {
                        users_report_array = report_data;
                        Charts.unBindClickEvent($("#users_report"));
                        Charts.generateUsersReport();
                        return false;

                    }
                    else if (report_type == 'seekers') {
                        seekers_report_array = report_data;
                        Charts.unBindClickEvent($("#seekers_report"));
                        Charts.generateSeekersReport();
                        return false;

                    }
                    else if (report_type == 'services') {
                        services_report_array = report_data;
                        Charts.unBindClickEvent($("#services_report"));
                        Charts.generateServicesReport();
                        return false;

                    }
                    return false;

                } else {
                    toastr["error"](result.message);
                }

            }
        });
    }

    $(".chart").on("animatorComplete", function() {
        portlet = $(this).parents('.portlet');
        portlet.find('.month').prop("disabled", false);
        portlet.find('.year').prop("disabled", false);
        return false;
    });

    $(document).on('change', ".month", function () {
        portlet = $(this).parents('.portlet');
        report_type = portlet.data('report-type');
        updateReport(portlet,report_type);
    });

    $(document).on('change', ".year", function () {
        portlet = $(this).parents('.portlet');
        report_type = portlet.data('report-type');
        updateReport(portlet,report_type);
    });

</script>
