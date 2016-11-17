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
        data:[]
    }
];

var hours = [
    {
        group:currentGroup,
        hours:[]
    }
];

var adminHours = [
    {
        group:currentGroup,
        hours:[]
    }
];

var opts = {
    lines: 11 // The number of lines to draw
    , length: 15 // The length of each line
    , width: 5 // The line thickness
    , radius: 61 // The radius of the inner circle
    , scale: 1 // Scales overall size of the spinner
    , corners: 0.4 // Corner roundness (0..1)
    , color: '#000' // #rgb or #rrggbb or array of colors
    , opacity: 0.15 // Opacity of the lines
    , rotate: 0 // The rotation offset
    , direction: 1 // 1: clockwise, -1: counterclockwise
    , speed: 1.4 // Rounds per second
    , trail: 36 // Afterglow percentage
    , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
    , zIndex: 2e9 // The z-index (defaults to 2000000000)
    , className: 'spinner' // The CSS class to assign to the spinner
    , top: '50%' // Top position relative to parent
    , left: '50%' // Left position relative to parent
    , shadow: false // Whether to render a shadow
    , hwaccel: false // Whether to use hardware acceleration
    , position: 'absolute' // Element positioning
};

var target = document.getElementById('listing');
var spinner = new Spinner(opts).spin(target);

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
                hours[0].hours.push(data.minutes);

                //the array is full
                if(hours[0].hours.length == 7) {
                    createChart(hours[0].hours, "#listing");
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
                adminHours[0].hours.push(data.minutes);

                //the array is full
                if(adminHours[0].hours.length == 7) {
                    createChart(adminHours[0].hours, "#listing");
                }
            }
        });

    }

}

//When the user changes the timeframe we need to adapt to display it
$("#timeframe").change(function() {

    //get the number of days we need to display
    var days = $(this).val();

    if(currentGroup != "ADMIN") {
        //iterate over the number of days
        for (var i = 0; i < days; i++) {
            //for each day subtract a day and add it to an array
            var date = moment().subtract(i, 'd').format("YYYY-MM-DD");
            week[0].data.push(date);

            //get hours for each group given a start date and an end date
            getHoursByGroupBetween(currentGroup, date, date, function(data) {
                hours[0].hours.push(data.minutes);
            });
        }
        //create the chart and pass in the data
        createChart(hours[0].hours, "#listing");

        //after the chart is displayed remove the data from the array to prepare for another timeframe change
        hours[0].hours = [];

    } else {
        //They are viewing the admin group
        for(var j = 0; j < days; j++) {
            var adminDate = moment().subtract(j, 'd').format("YYYY-MM-DD");
            week[0].data.push(adminDate);

            getAllHoursOnDate(adminDate, function(data) {
                adminHours[0].hours.push(data.minutes);
            });
        }

        createChart(adminHours[0].hours, "#listing");
        adminHours[0].hours = [];
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

/**
 * Start of Individual volunteer profile card charts
 */
$('.btn-success').click(function() {
    var element = $(this).parent().parent().parent().find(".vol-id").text();
    var id = element.substr(element.length - 12, element.length);

    for (var i = 0; i < 4; i++) {
        //for each day subtract a day and add it to an array
        var date = moment().subtract(i, 'd').format("YYYY-MM-DD");
        week[0].data.push(date);

        //get hours for each group given a start date and an end date
        getHoursByIdOnDate(id, date, function(data) {
            hours[0].hours.push(data.minutes);
            //create the chart and pass in the data
            createChart(hours[0].hours, ".volunteer-chart");
        });
    }

    hours[0].hours = [];
});




