
var Charts = function () {

    return {
        generateUsersReport: function () {

            if (!jQuery.plot) {
                return;
            }

            var totalPoints = 250;

            var data = {
                grow: {stepMode: "linear"},
                data: users_report_array,
                animator: {
                    steps: 136,
                    duration: 2500,
                    start: 0
                },
                label: "Mechanics Registered",
                lines: {
                    lineWidth: 1,
                },
                shadowSize: 0

            };

            var options = {
                series: {
                    grow: {active: true},
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }
                            ]
                        }
                    },
                    points: {
                        show: true,
                        radius: 3,
                        lineWidth: 1
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eee",
                    borderColor: "#eee",
                    borderWidth: 1
                },
                colors: ["#d12610", "#37b7f3", "#52e136"],
                xaxis: {
                    mode: "categories",
                    tickLength: 0

                },
                yaxis: {
                    ticks: 11,
                    tickDecimals: 0,
                    tickColor: "#eee",
                }
            };

            //plot = $.plotAnimator($("#users_report"), [data], options);
            plot = $.plot($("#users_report"), [data], options);

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y + 5,
                    left: x + 15,
                    border: '1px solid #333',
                    padding: '4px',
                    color: '#fff',
                    'border-radius': '3px',
                    'background-color': '#333',
                    opacity: 0.80
                }).appendTo("body").fadeIn(200);
            }

            var previousPoint = null;

            $("#users_report").bind("plotclick", function (event, pos, item) {
                if (item) {
                    portlet = $(this).parents('.portlet');
                    day = '';
                    if(portlet.find('.month').val() == '-') {
                        month = item.datapoint[0] + 1;
                    } else {
                        day = item.datapoint[0] + 1;
                        month = portlet.find('.month').val();
                    }
                    year = portlet.find('.year').val();

                    url_to_redirect = SITE_ADM_URL_USERS;
                    if(day != '')  {
                        url_to_redirect += "?day=" + day + "&month=" + month;
                    } else {
                        url_to_redirect += "?month=" + month;
                    }

                    url_to_redirect += "&year=" + year;
                    /*window.open(url_to_redirect, '_blank');*/
                }
            });

            $("#users_report").bind("plothover", function (event, pos, item) {
                month = $(this).parents(".portlet").find(".month").val();
                year = $(this).parents(".portlet").find(".year").val();

                if (month == '-') {
                    report_tenure = "yearly";
                } else {
                    report_tenure = "monthly";
                }

                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));

                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0],
                                y = item.datapoint[1];


                        if (report_tenure == "yearly") {
                            showTooltip(item.pageX, item.pageY, y + " " + item.series.label + " in " + MONTH_NAMES_SHORT[x] + ", " + year);
                        } else {
                            showTooltip(item.pageX, item.pageY, y + " " + item.series.label + " on " + (x + 1) + " " + MONTH_NAMES_SHORT[(month - 1)] + ", " + year);
                        }
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });

        },
        generateSeekersReport: function () {

            if (!jQuery.plot) {
                return;
            }

            var totalPoints = 250;

            var data = {
                grow: {stepMode: "linear"},
                data: seekers_report_array,
                animator: {
                    steps: 136,
                    duration: 2500,
                    start: 0
                },
                label: "Seekers Registered",
                lines: {
                    lineWidth: 1,
                },
                shadowSize: 0

            };

            var options = {
                series: {
                    grow: {active: true},
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }
                            ]
                        }
                    },
                    points: {
                        show: true,
                        radius: 3,
                        lineWidth: 1
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eee",
                    borderColor: "#eee",
                    borderWidth: 1
                },
                colors: ["#d12610", "#37b7f3", "#52e136"],
                xaxis: {
                    mode: "categories",
                    tickLength: 0

                },
                yaxis: {
                    ticks: 11,
                    tickDecimals: 0,
                    tickColor: "#eee",
                }
            };

            //plot = $.plotAnimator($("#users_report"), [data], options);
            plot = $.plot($("#seekers_report"), [data], options);

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y + 5,
                    left: x + 15,
                    border: '1px solid #333',
                    padding: '4px',
                    color: '#fff',
                    'border-radius': '3px',
                    'background-color': '#333',
                    opacity: 0.80
                }).appendTo("body").fadeIn(200);
            }

            var previousPoint = null;

            $("#seekers_report").bind("plotclick", function (event, pos, item) {
                if (item) {
                    portlet = $(this).parents('.portlet');
                    day = '';
                    if(portlet.find('.month').val() == '-') {
                        month = item.datapoint[0] + 1;
                    } else {
                        day = item.datapoint[0] + 1;
                        month = portlet.find('.month').val();
                    }
                    year = portlet.find('.year').val();

                    url_to_redirect = SITE_ADM_URL_USERS;
                    if(day != '')  {
                        url_to_redirect += "?day=" + day + "&month=" + month;
                    } else {
                        url_to_redirect += "?month=" + month;
                    }

                    url_to_redirect += "&year=" + year;
                    /*window.open(url_to_redirect, '_blank');*/
                }
            });

            $("#seekers_report").bind("plothover", function (event, pos, item) {
                month = $(this).parents(".portlet").find(".month").val();
                year = $(this).parents(".portlet").find(".year").val();

                if (month == '-') {
                    report_tenure = "yearly";
                } else {
                    report_tenure = "monthly";
                }

                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));

                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0],
                                y = item.datapoint[1];


                        if (report_tenure == "yearly") {
                            showTooltip(item.pageX, item.pageY, y + " " + item.series.label + " in " + MONTH_NAMES_SHORT[x] + ", " + year);
                        } else {
                            showTooltip(item.pageX, item.pageY, y + " " + item.series.label + " on " + (x + 1) + " " + MONTH_NAMES_SHORT[(month - 1)] + ", " + year);
                        }
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });

        },
        generateServicesReport: function () {

            if (!jQuery.plot) {
                return;
            }

            var totalPoints = 250;

            var data = {
                grow: {stepMode: "linear"},
                data: services_report_array,
                animator: {
                    steps: 136,
                    duration: 2500,
                    start: 0
                },
                label: "Services Completed",
                lines: {
                    lineWidth: 1,
                },
                shadowSize: 0

            };

            var options = {
                series: {
                    grow: {active: true},
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }
                            ]
                        }
                    },
                    points: {
                        show: true,
                        radius: 3,
                        lineWidth: 1
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eee",
                    borderColor: "#eee",
                    borderWidth: 1
                },
                colors: ["#d12610", "#37b7f3", "#52e136"],
                xaxis: {
                    mode: "categories",
                    tickLength: 0

                },
                yaxis: {
                    ticks: 11,
                    tickDecimals: 0,
                    tickColor: "#eee",
                }
            };

            //plot = $.plotAnimator($("#users_report"), [data], options);
            plot = $.plot($("#services_report"), [data], options);

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y + 5,
                    left: x + 15,
                    border: '1px solid #333',
                    padding: '4px',
                    color: '#fff',
                    'border-radius': '3px',
                    'background-color': '#333',
                    opacity: 0.80
                }).appendTo("body").fadeIn(200);
            }

            var previousPoint = null;

            $("#services_report").bind("plotclick", function (event, pos, item) {
                if (item) {
                    portlet = $(this).parents('.portlet');
                    day = '';
                    if(portlet.find('.month').val() == '-') {
                        month = item.datapoint[0] + 1;
                    } else {
                        day = item.datapoint[0] + 1;
                        month = portlet.find('.month').val();
                    }
                    year = portlet.find('.year').val();

                    url_to_redirect = SITE_ADM_URL_USERS;
                    if(day != '')  {
                        url_to_redirect += "?day=" + day + "&month=" + month;
                    } else {
                        url_to_redirect += "?month=" + month;
                    }

                    url_to_redirect += "&year=" + year;
                    /*window.open(url_to_redirect, '_blank');*/
                }
            });

            $("#services_report").bind("plothover", function (event, pos, item) {
                month = $(this).parents(".portlet").find(".month").val();
                year = $(this).parents(".portlet").find(".year").val();

                if (month == '-') {
                    report_tenure = "yearly";
                } else {
                    report_tenure = "monthly";
                }

                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));

                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0],
                                y = item.datapoint[1];


                        if (report_tenure == "yearly") {
                            showTooltip(item.pageX, item.pageY, y + " " + item.series.label + " in " + MONTH_NAMES_SHORT[x] + ", " + year);
                        } else {
                            showTooltip(item.pageX, item.pageY, y + " " + item.series.label + " on " + (x + 1) + " " + MONTH_NAMES_SHORT[(month - 1)] + ", " + year);
                        }
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });

        },
        unBindClickEvent: function (element) {
            element.unbind("plotclick");
        },
    };

}();