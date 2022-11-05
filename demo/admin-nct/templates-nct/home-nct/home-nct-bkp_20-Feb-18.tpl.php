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
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        %NO_OF_USER%
                    </div>
                    <div class="desc">
                         No. of Users
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat red">
                <div class="visual">
                    <i class="fa fa-plane"></i>
                </div>
                <div class="details">
                    <div class="number">
                         %RIDE_OFFER%
                    </div>
                    <div class="desc">
                         Total rides Offered
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat yellow">
                <div class="visual">
                    <i class="fa fa-thumbs-o-up"></i>
                </div>
                <div class="details">
                    <div class="number">
                         %RIDE_BOOKED%
                    </div>
                    <div class="desc">
                        Total rides booked
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat green">
                <div class="visual">
                    <i class="fa fa-smile-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                         %RIDE_COMPLETED%
                    </div>
                    <div class="desc">
                         Total rides completed
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat dark">
                <div class="visual">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="number">
                        {CURRENCY_SIGN} %TOTAL_EARNED%
                    </div>
                    <div class="desc">
                         Total revenue
                    </div>
                </div>
            </div>
        </div>
        <?php /*
        <div class="col-md-12 col-sm-12">
            <ul id="" class="switcher">
              <li class="active"><a data-toggle="tab" href="#user_tab" >View Users</a></li>
              <li ><a data-toggle="tab" href="#offered_ride" >Rides offered </a></li>
              <li><a data-toggle="tab" href="#ride_booked" >Rides booked</a></li>
              <li><a data-toggle="tab" href="#ride_completed" >Ride Successful</a></li>
              <li><a data-toggle="tab" href="#revenue_earned" >Revenue Earned</a></li>
            </ul>
        </div>
         <div class="tab-content home-tab">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-pane fade in active" id="user_tab">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="users">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Users Report
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-pane fade" id="offered_ride">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="users">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Rides offered
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
                        <div id="rides_report" data-callback="generateRidesReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-pane fade" id="ride_booked">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="ride_booking">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-thumbs-o-up"></i>Ride Booked
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
                        <div id="booking_report" data-callback="generateBookingReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-pane fade" id="ride_completed">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="ride_completed">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-smile-o"></i>CompletedRide
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
                        <div id="rides_completed" data-callback="generateRideCompletedReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-pane fade" id="revenue_earned">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="revenue_earned">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-money"></i>Revenue Earned
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
                        <div id="revenue_earned_report" data-callback="generateRevenueEarnedReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
        </div>
        */ ?>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="user_tab">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="users">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Users Report
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
            <?php /*
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="offered_ride">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="users">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Rides offered
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
                        <div id="rides_report" data-callback="generateRidesReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="ride_booked">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="ride_booking">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-thumbs-o-up"></i>Ride Booked
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
                        <div id="booking_report" data-callback="generateBookingReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="ride_completed">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="ride_completed">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-smile-o"></i>CompletedRide
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
                        <div id="rides_completed" data-callback="generateRideCompletedReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="revenue_earned">
                <!-- BEGIN INTERACTIVE CHART PORTLET-->
                <div class="portlet box blue" data-report-type="revenue_earned">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-money"></i>Revenue Earned
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
                        <div id="revenue_earned_report" data-callback="generateRevenueEarnedReport()" class="chart"></div>
                    </div>
                </div>
                <!-- END INTERACTIVE CHART PORTLET-->
            </div> */ ?>

</div>

<script type="text/javascript">

    users_report_array = %USER_REPORT_ARRAY%;
    rides_report_array = %RIDES_REPORT_ARRAY%;
    booking_report_array = %RIDES_BOOK_REPORT_ARRAY%;
    rides_completed_report_array = %RIDES_COMPLETED_REPORT_ARRAY%;
    revenue_earned_report_array = %REVENUE_REPORT_ARRAY%;

    jQuery(document).ready(function () {
        Charts.generateUsersReport();
        Charts.generateRidesReport();
        Charts.generateBookingReport();
        Charts.generateBookingReport();
        Charts.generateRideCompletedReport();
        Charts.generateRevenueEarnedReport();
    });

    function updateReport(portlet) {
        //portlet = $(this).parents('.portlet');

        report_type = portlet.data('report-type');
        month = portlet.find('.month').val();
        year = portlet.find('.year').val();

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
                if (result.status) {
                    report_data = result.report_data;
                    if (report_type == 'users') {
                        users_report_array = report_data;
                        Charts.unBindClickEvent($("#users_report"));
                        Charts.generateUsersReport();
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
        updateReport(portlet);
    });

    $(document).on('change', ".year", function () {
        portlet = $(this).parents('.portlet');
        updateReport(portlet);
    });

</script>
