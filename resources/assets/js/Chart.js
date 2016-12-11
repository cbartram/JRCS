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

/*
 * Handle preparing the data to show
 */

var text = $("#current-group").html();
var currentGroup = text.substring(8, text.length);


//add previous week to an array in RESTLib Format
var week = [
    {
        name:'dates',
        data:[],
        hours:[]
    }
];

var opts = {
    lines: 14, length: 18, width: 5, radius: 61, scale: .7, corners: 0.4, color: '#4584ef', opacity: 0.15
    , rotate: 0, direction: 1, speed: 1.4, trail: 36, fps: 20, zIndex: 1, className: 'spinner', top: '50%'
    , left: '50%', shadow: false, hwaccel: false, position: 'absolute'
};

var target = document.getElementById('listing');
new Spinner(opts).spin(target);

$("#month").val(moment().daysInMonth());

if(currentGroup != "ADMIN") {
    for (var i = 0; i < 7; i++) {
        var date = moment().subtract(i, 'd').format("YYYY-MM-DD");
        week[0].data.push(date);

        $.ajax({
            type: 'GET',
            url: "api/v1/hours/group/" + currentGroup + "/" + date + "/" + date,
            dataType: "json",
            success: function (data) {
                week[0].hours.push(data.minutes);

                //the array is full
                if(week[0].hours.length == 7) {
                    createChart(week[0].hours, "#listing");
                }
            }
        });
    }

} else {
    //They are viewing the admin group
    for(var j = 0; j < 7; j++) {
        var adminDate = moment().subtract(j, 'd').format("YYYY-MM-DD");
        week[0].data.push(adminDate);

        $.ajax({
            type: 'GET',
            url: "api/v1/hours/date/" + adminDate,
            dataType: "json",
            success: function (data) {
                week[0].hours.push(data.minutes);

                //the array is full
                if(week[0].hours.length == 7) {
                    createChart(week[0].hours, "#listing");
                }
            }
        });

    }

}

//When the user changes the timeframe we need to adapt to display it
$("#timeframe").change(function() {

    $('#listing').find('.highcharts-container').hide();

    var target = document.getElementById('listing');
    new Spinner(opts).spin(target);

    //get the number of days we need to display
    var days = $(this).val();
    week[0].data = [];

    if(currentGroup != "ADMIN") {
        //iterate over the number of days
        for (var i = 0; i < days; i++) {
            //for each day subtract a day and add it to an array
            var date = moment().subtract(i, 'd').format("YYYY-MM-DD");
            week[0].data.push(date);

            $.ajax({
                type: 'GET',
                url: "api/v1/hours/group/" + currentGroup + "/" + date + "/" + date,
                dataType: "json",
                success: function (data) {
                    week[0].hours.push(data.minutes);

                    //the array is full
                    if(week[0].hours.length == days) {
                        createChart(week[0].hours, "#listing");
                    }
                }
            });
        }

        //after the chart is displayed remove the data from the array to prepare for another timeframe change
        week[0].hours = [];

    } else {
        //Clear out the previous week data before pushing new data onto the stack
        week[0].data = [];

        //They are viewing the admin group
        for(var j = 0; j < days; j++) {
            var adminDate = moment().subtract(j, 'd').format("YYYY-MM-DD");
            week[0].data.push(adminDate);

            $.ajax({
                type: 'GET',
                url: "api/v1/hours/date/" + adminDate,
                dataType: "json",
                success: function (data) {
                    week[0].hours.push(data.minutes);

                    //the array is full
                    if(week[0].hours.length == days) {
                        createChart(week[0].hours, "#listing");
                    }
                }
            });
        }
        week[0].hours = [];
    }

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
function createChart(data, id) {
    $(function () {
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
                categories: week[0].data,
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
    });
}

var smallSpinner = {
    lines: 14, length: 10, width: 5, radius: 61, scale: .7, corners: 0.4, color: '#4584ef', opacity: 0.15
    , rotate: 0, direction: 1, speed: 1.4, trail: 36, fps: 20, zIndex: 1, className: 'spinner', top: '50%'
    , left: '50%', shadow: false, hwaccel: false, position: 'absolute'
};


/**
 * Start of Individual volunteer profile card charts
 */
var openDrawerIds = [];

$('.collapsable').click(function() {
    var index = $(this).attr('data-index');
    var chartContainerId = 'chart' + index;
    var drawerId =  'collapse' + index;
    var innerDrawer = $("#" + drawerId).find('.collapse-inner');
    var chart = $('#' + chartContainerId).highcharts();
    var id = $(this).attr('data-id');
    var target = $(this).attr('data-render');
    var groups = ['BEBCO', 'JACO', 'JBC'];
    var start  = moment().subtract(4, 'days').format('YYYY-MM-DD');
    var end    = moment().format('YYYY-MM-DD');


    //Apply the Spinner & Blur
    var spinnerTarget = document.getElementById(drawerId);
    var spinner = new Spinner(opts).spin(spinnerTarget);
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

    //todo should only run for the first time
    // For each group
    for(var j = 0; j < groups.length; j++) {


            //get the hours for each group between start and end date
            $.ajax({
                context: this,
                type: 'GET',
                url: "api/v1/hours/" + id + "/" + groups[j] + "/" + start + "/" + end,
                dataType: "json",
                success: function (data) {
                    //for each group append the result to it
                    switch(data.group) {
                        case "BEBCO":
                            $(this).parent().parent().next().find('.bebco-number').text(data.hours);
                            break;
                        case "JACO":
                            $(this).parent().parent().next().find('.jaco-number').text(data.hours);
                            break;
                        case "JBC":
                            $(this).parent().parent().next().find('.jbc-number').text(data.hours);
                            break;
                    }
                }
            });
        }

        //combine all 3 groups volunteer hours
        $(this).parent().parent().next().find('.all-number').text('50:44');


    week[0].data = [];

    for (var i = 0; i < 4; i++) {
        //for each day subtract a day and add it to an array
        var date = moment().subtract(i, 'd').format("YYYY-MM-DD");
        week[0].data.push(date);

        $.ajax({
            type: 'GET',
            url: "api/v1/hours/" + id + "/" + date + "/" + date,
            dataType: "json",
            success: function (data) {
                week[0].hours.push(data.minutes);

                //the array is full
                if(week[0].hours.length == 4) {
                    innerDrawer.removeClass('blur');
                    $("#" + drawerId).data('spinner').stop();
                    createChart(week[0].hours, target);

                }
            }
        });

    }

    week[0].hours = [];
});




