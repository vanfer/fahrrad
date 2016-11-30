// WICHTIG: IP ändern, oder einfach localhost nehmen!
var BASE_PATH = "http://localhost/fahrrad/public/";

$(document).ready(function () {
    window.streckeData = { data: [], labels: [] };
    window.leistungData = { data: [], labels: [] };

    /*
    * Aktualisierung der Daten: Charts und Fahredetails
    * */
    window.setInterval(function () {
        // Updates der Charts nur auf den Seiten Central und Mobile
        if(window.location.href.includes("central") ||
           window.location.href.includes("mobile"))
        {
            updateDetails();
            updateCharts();
        }
    }, 1000);


    /*
    * Button bindings
    * */

    $("#btnGenerateName").click(function(){
        var namen = ["test1", "test2", "test3", "test4", "test5", "test6"];

        // Gibt einen zufälligen Eintrag aus dem namen Array zurück
        var name = namen.sort(function() {return 0.5 - Math.random()})[0];

        $("#name").attr("value", name);
    });
});

function updateChartData() {
    // Todo: Strecke id irgendwo her holen (hidden input zb)
    var strecke_id = 2;

    getDataFromAPI("strecke/" + strecke_id, true, function(response) {
        if(response && response.strecke ) {
            window.streckeData = { data: [], labels: [] };
            $.each(response.strecke.abschnitte,
                function(index, value) {
                    window.streckeData.labels.push(value.laenge); // X
                    window.streckeData.data.push(value.hoehe);  // Y
                }
            );
        }
    });

    getDataFromAPI("leistung", true, function(response) {
        if(response && response.fahrerleistung ) {
            window.leistungData = { data: [], labels: [] };
            $.each(response.fahrerleistung,
                function(index, value) {
                    window.leistungData.labels.push(value.name);
                    window.leistungData.data.push(value.istLeistung);
                }
            );
        }
    });
}

function updateCharts() {
    this.updateChartData();

    var track_chart = new Chart(document.getElementById("track"), {
        type: 'line',
        data: {
            labels: window.streckeData.labels, // X AXIS
            datasets: [{
                label: "My First dataset",
                fill: true,
                data: window.streckeData.data // Y AXIS
            }]
        },
        options: {
            animation: false,
            scales: {
                xAxes: [{
                    display: true
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    var energy_chart = new Chart(document.getElementById("energy-current"), {
        type: 'bar',
        data: {
            labels: window.leistungData.labels,
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
                    data: window.leistungData.data
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

function updateDetails(){
    getDataFromAPI("data", false, function(response) {
        if(response && response.fahrerleistung ) {
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
    /*$.ajax({
        url: BASE_PATH + "data",
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(response) {

        }
    });*/
}

function getDataFromAPI(url, async, successHandler){
    $.ajax({
        url: BASE_PATH + url,
        type: 'get',
        async: async,
        success: successHandler
    });
}