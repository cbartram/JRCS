/**
 * Highcharts theme
 */
Highcharts.createElement('link', {
    href: 'https://fonts.googleapis.com/css?family=Open+Sans:400',
    rel: 'stylesheet',
    type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
    colors: ["#72c6ef", "#2484C6", "#832A81", "#D7DEE2", "#72C6EF", "#39BB9D"],
    chart: {
        backgroundColor: null,
        style: {
            fontFamily: "Open Sans, sans-serif"
        }
    },
    title: {
        style: {
            fontSize: '16px',
            fontWeight: 'bold'
        }
    },
    tooltip: {
        borderWidth: 0,
        backgroundColor: 'rgba(219,219,216,0.8)',
        shadow: false
    },
    legend: {
        itemStyle: {
            fontWeight: 'normal',
            fontSize: '11px'
        }
    },
    credits: {
        enabled: false   // Whether to show the credits text.
    },
    xAxis: {
        gridLineWidth: 0,
        labels: {
            style: {
                fontSize: '10px'
            }
        }
    },
    yAxis: {
        minorTickInterval: 5,
        title: {
            style: {}
        },
        labels: {
            style: {
                fontSize: '10px'
            }
        }
    },

// General
    background2: '#fff'

};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);

/**
 * Handle preparing the data to show
 */
var text = $("#current-group").html();
var currentGroup = text.substring(8, text.length);

var opts = {
    lines: 14, length: 18, width: 5, radius: 61, scale: .7, corners: 0.4, color: '#4584ef', opacity: 0.15
    , rotate: 0, direction: 1, speed: 1.4, trail: 36, fps: 20, zIndex: 1, className: 'spinner', top: '50%'
    , left: '50%', shadow: false, hwaccel: false, position: 'absolute'
};

var target = document.getElementById('listing');
new Spinner(opts).spin(target);

$("#month").val(moment().daysInMonth());

        $.ajax({
            type: 'GET',
            url: "api/v1/hours/group/" + currentGroup + "/null/null",
            dataType: "json",
            success: function (data) {
                createVolunteerProfileChart(data[0], data[1], '#listing')
            }
        });

//When the user changes the timeframe we need to adapt to display it
$("#timeframe").change(function() {

    $('#listing').find('.highcharts-container').hide();

    var target = document.getElementById('listing');
    new Spinner(opts).spin(target);

    //get the number of days we need to display
    var days = $(this).val();

            $.ajax({
                type: 'GET',
                url: "api/v1/hours/group/" + currentGroup + "/null/null",
                dataType: "json",
                data: {days: days},
                success: function (data) {
                    createVolunteerProfileChart(data[0], data[1], "#listing");
                }
            });

    });

/**
 * Converts minutes to hours in the format HH:MM
 * @param minutes integer Int value in minutes
 * @return string Hours in the format HH:MM
 */
function minutesToHours(minutes) {
    var m = minutes % 60;
    var h = (minutes - m) / 60;

    return h + " hours and " + (m < 10 ? "0" : "") + m + " minutes";
}

/**
 * Create the highcharts bar chart
 */
function createVolunteerProfileChart(data, xAxis, id) {
    $(id).highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Hours Volunteered'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: xAxis,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Minutes Vounteered'
            }
        },
        tooltip: {
            formatter: function() {
                return "Volunteered <b>" + minutesToHours(this.y) + "</b>";
            },
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Date',
            data: data

        }]
    });
}

/**
 * Start of Individual volunteer profile card charts
 */
var openDrawerIds = [];

var smallSpinner = {
    lines: 14, length: 10, width: 5, radius: 61, scale: .7, corners: 0.4, color: '#4584ef', opacity: 0.15
    , rotate: 0, direction: 1, speed: 1.4, trail: 36, fps: 20, zIndex: 1, className: 'spinner', top: '50%'
    , left: '50%', shadow: false, hwaccel: false, position: 'absolute'
};

$('.collapsable').click(function() {
    var index = $(this).attr('data-index');
    var chartContainerId = 'chart' + index;
    var drawerId =  'collapse' + index;
    var innerDrawer = $("#" + drawerId).find('.collapse-inner');
    var chart = $('#' + chartContainerId).highcharts();
    var id = $(this).attr('data-id');
    var target = $(this).attr('data-render');

    var groups = ['BEBCO', 'JACO', 'JBC', 'ALL'];

    var start  = moment().subtract(4, 'days').format('YYYY-MM-DD');
    var end    = moment().format('YYYY-MM-DD');


    //Apply the Spinner & Blur
    var spinnerTarget = document.getElementById(drawerId);
    var spinner = new Spinner(smallSpinner).spin(spinnerTarget);
    $(spinnerTarget).data('spinner', spinner);
    innerDrawer.addClass('blur');

    //collapses open drawers after a new drawer is clicked
    for(var x = 0; x < openDrawerIds.length; x++) {
        //collapse drawer and update array
        $('#' + openDrawerIds[0]).collapse('hide');
        openDrawerIds.shift();
        if(chart) {
            chart.destroy();
        }

    }

    openDrawerIds.push(drawerId);
            //get the hours for each group between start and end date
            $.ajax({
                context: this,
                type: 'GET',
                url: "api/v1/hours/" + id + "/null/" + start + "/" + end,
                dataType: "json",
                success: function (data) {
                    //Append Data to DOM
                    $(this).parent().parent().next().find('.bebco-number').text(data.bebco);
                    $(this).parent().parent().next().find('.jaco-number').text(data.jaco);
                    $(this).parent().parent().next().find('.jbc-number').text(data.jbc);
                    $(this).parent().parent().next().find('.all-number').text(data.all);
                }
            });

        $.ajax({
            type: 'GET',
            url: "/api/v1/volunteer/hours/" + id + "/null/null",
            dataType: "json",
            success: function (data) {
                createVolunteerProfileChart(data[0], data[1], target);
            }
        });

    innerDrawer.removeClass('blur');
    $("#" + drawerId).data('spinner').stop();

});




