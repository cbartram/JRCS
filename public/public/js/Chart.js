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
    fontWeight: 'bold',
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
style: {
}
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

$(function () {
    $('#listing').highcharts({
        chart: {
            type: 'area'
        },
        title: {
            text: 'Volunteer Donations over Time'
        },
        subtitle: {

        },
        xAxis: {
            allowDecimals: false,
            labels: {
                formatter: function () {
                    return this.value; // clean, unformatted number for year
                }
            }
        },
        yAxis: {
            title: {
                text: 'Donation Amount'
            },
            labels: {
                formatter: function () {
                    return '$' + this.value / 1000;
                }
            }
        },
        tooltip: {
            pointFormat: '{series.name} donated <b>{point.y:,.0f}</b><br/>dollars in {point.x}'
        },
        plotOptions: {
            area: {
                pointStart: 1940,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            }
        },
        series: [{
            name: 'Jane',
            data: [500, 3000, 2500, 1900, 710, 600, 110, 322, 110, 235, 369, 640,
                1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468, 20434, 24126,
                27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342, 26662,
                26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
                24304, 23464, 23708, 24099, 24357, 24237, 24401, 24344, 23586,
                22380, 21004, 17287, 14747, 13076, 12555, 12144, 11009, 10950,
                10871, 10824, 10577, 10527, 10475, 10421, 10358, 10295, 10104]
        }, {
            name: 'John',
            data: [1000, 1049, 5000, 3000, 2000, 600, 899, 559, 440, 300,
                544, 205, 500, 120, 150, 200, 426, 660, 869, 1060, 1605, 2471, 3322,
                4238, 5221, 6129, 7089, 8339, 9399, 10538, 11643, 13092, 14478,
                15915, 17385, 19055, 21205, 23044, 25393, 27935, 30062, 32049,
                33952, 35804, 37431, 39197, 43000, 43000, 41000, 38000, 37000,
                35000, 33000, 31000, 22000, 27000, 25000, 24000, 23000, 22000,
                21000, 20000, 19000, 18000, 18000, 17000, 16000]
        }]
    });
});