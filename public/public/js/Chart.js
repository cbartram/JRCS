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
    textTransform: 'uppercase'
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
gridLineWidth: 1,
labels: {
style: {
    fontSize: '10px'
}
}
},
yAxis: {
minorTickInterval: 'auto',
title: {
style: {
    textTransform: 'uppercase'
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