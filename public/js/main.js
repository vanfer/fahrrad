// WICHTIG: IP ändern, oder einfach localhost nehmen!
var BASE_PATH = "http://localhost/fahrrad/public/";

$(document).ready(function () {
    window.setInterval(function () {
        if(!window.location.href.includes("login")){
            refreshView();
            updateCharts();
        }
    }, 1500);

    $("#btnGenerateName").click(function(){
        var namen = ["test1", "test2", "test3", "test4", "test5", "test6"];
        var name = namen.sort(function() {return 0.5 - Math.random()})[0];

        $("#name").attr("value", name);
    });


    $('#selFahrrad').on('change', function() {

    });
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
                    function(index, fahrrad) {
                        var strname = "";
                        $.each( response.fahrer,
                            function(index, fahrer) {
                                strname = (fahrer.id == fahrrad.fahrer_id) ? fahrer.name : "";
                            }
                        );
                        $("#fahrername-"+fahrrad.id).html("Fahrer: " + strname);
                        $("#geschwindigkeit-anzeige-"+fahrrad.id).html(fahrrad.geschwindigkeit + " km/h");
                        $("#istLeistung-anzeige-"+fahrrad.id).html(fahrrad.istLeistung + " Watt");
                        $("#strecke-anzeige-"+fahrrad.id).html(fahrrad.strecke + " Meter");
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
