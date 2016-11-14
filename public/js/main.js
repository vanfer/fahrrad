var BASE_PATH = "http://localhost/SPIN/web/public/";

$(document).ready(function () {
    window.setInterval(function () {
        refreshView();
        updateCharts();
    }, 1500);
});

function updateCharts() {
    var trackData = getTrack(3);
    var track = new Chart(document.getElementById("track"), {
        type: 'line',
        data: {
            labels: trackData[1],
            datasets: [
                {
                    label: "My First dataset",
                    fill: true,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: trackData[0],
                    spanGaps: false,
                }
            ]
        },
        options: {
            animation: false,
            scales: {
                xAxes: [{
                    display: true
                }]
            }
        }
    });

    var energy_currentData = getEnergyCurrent();
    var energy_current = new Chart(document.getElementById("energy-current"), {
        type: 'bar',
        data: {
            labels: energy_currentData[1],
            datasets: [
                {
                    label: "My First dataset",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    data: energy_currentData[0],
                }
            ]
        },
        options: {
            animation: false,
            scales: {
                xAxes: [{
                    display: true
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}

function refreshView(){
    $.ajax({
        url: BASE_PATH + "data",
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(response) {
            if(response && response.fahrrad ) {
                $.each( response.fahrrad,
                    function(index, value) {
                        $("#geschwindigkeit-anzeige-"+value.id).html(value.geschwindigkeit + " km/h");
                        $("#istLeistung-anzeige-"+value.id).html(value.istLeistung + " Watt");
                        $("#sollLeistung-anzeige-"+value.id).html(value.sollLeistung);
                        $("#sollDrehmoment-anzeige-"+value.id).html(value.sollDrehmoment);
                        $("#strecke-anzeige-"+value.id).html(value.strecke + " Meter");
                        $("#strecke_id-anzeige-"+value.id).html(value.strecke_id);
                        $("#abschnitt_id-anzeige-"+value.id).html(value.abschnitt_id);
                        $("#updated_at-anzeige-"+value.id).html(value.updated_at);
                    }
                );
            }
        }
    });
}

function getTrack(id){
    var yAxis = [];
    var xAxis = [];

    $.ajax({
        url: BASE_PATH + "strecke/"+id,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            if(response && response.strecke ) {
                $.each(response.strecke.abschnitte,
                    function(index, value) {
                        yAxis.push(value.hoehe);
                        xAxis.push(value.laenge);
                    }
                );
            }
        }
    });

    return [yAxis, xAxis];
}
function getEnergyCurrent(){
    var yAxis = [];
    var xAxis = [];

    $.ajax({
        url: BASE_PATH + "leistung",
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            if(response && response.fahrerleistung ) {
                $.each(response.fahrerleistung,
                    function(index, value) {
                        yAxis.push(value.istLeistung);
                        xAxis.push(value.name);
                    }
                );
            }
        }
    });

    return [yAxis, xAxis];
}
