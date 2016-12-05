// WICHTIG: IP ändern, oder einfach localhost nehmen!
var BASE_PATH = "http://localhost/fahrrad/public/";

$(document).ready(function () {
    window.streckeData = { data: [], labels: [] };
    window.leistungData = { data: [], labels: [] };

    window.selectedUserRow = 0;
    window.newUserTemp = {};

    $(".formAddFahrer").hide();

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

    $(".btnAbmelden").each(function(){
        $(this).click(function(e){
            var form = e.currentTarget.closest("form");

            $.ajax({
                url: $(form).attr("action"),
                method: $(form).attr("method")
            }).done(function (data, statusText, xhr){
                var status = xhr.status;

                if(status == 200){
                    var btnAbmelden = $(form).parents(".panel").find(".fahrradBtnAbmelden");
                    var btnAnmelden = $(form).parents(".panel").find(".fahrradBtnAnmelden");

                    var fahrerdetailElement = $(form).parents(".panel").find(".panel-body");

                    $(fahrerdetailElement).html("Fahrrad ist inaktiv");

                    $(btnAbmelden).css("display", "none");
                    $(btnAnmelden).css("display", "block");
                }
            });
        });
    });

    $(".btnAnmelden").each(function(){
        $(this).click(function(e){
            var form = e.currentTarget.closest("form");

            var btnAbmelden = $(form).parents(".panel").find(".fahrradBtnAbmelden");
            var btnAnmelden = $(form).parents(".panel").find(".fahrradBtnAnmelden");

            var fahrerdetailElement = $(form).parents(".panel").find(".panel-body");

            if(window.selectedUserRow == 0){
                alert("Bitte zuerst rechts einen Fahrer wählen!");
            }else{

                // Zuordnen Request
                console.log();
                $.ajax({
                    url: $(form).attr("action") + "/fahrer/" + window.selectedUserRow,
                    method: "GET"
                }).done(function (data, statusText, xhr){
                    var status = xhr.status;

                    if(status == 200){
                        var fahrrad = data.fahrrad;
                        var fahrer = data.fahrer;

                        var template = '<div class="row">' +
                            '<div class="col-md-8">Fahrer:</div>' +
                            '<div id="fahrername-anzeige-' + fahrrad.id + '" class="col-md-3">' + fahrer.name + '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-8 ">Geschwindigkeit</div>' +
                            '<div id="geschwindigkeit-anzeige-' + fahrrad.id + '" class="col-md-3">' + fahrrad.geschwindigkeit + ' km/h</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-8">istLeistung</div>' +
                            '<div id="istLeistung-anzeige-' + fahrrad.id + '" class="col-md-3">' + fahrrad.istLeistung + '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-8">Zurückgelegte Strecke</div>' +
                            '<div id="strecke-anzeige-' + fahrrad.id + '" class="col-md-3">' + fahrrad.strecke + '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-8">Betriebsmodus</div>' +
                            '<div id="betriebsmodus-anzeige-' + fahrrad.id + '" class="col-md-3">' +
                            '<select class="form-control">' +
                            '<option>Strecke</option>' +
                            '<option>Konstante Leistung</option>' +
                            '<option>Konstanter Drehmoment</option>' +
                            '</select>' +
                            '</div>' +
                            '</div>';

                        $(fahrerdetailElement).html(template);
                    }
                });

                $(btnAbmelden).css("display", "block");
                $(btnAnmelden).css("display", "none");

                $(".radio-fahrer-id").each(function () {
                    $(this).prop('checked', false);
                });
            }
        });
    });

    $(".btnDelete").each(function(){
        $(this).click(function(e){
            var form = e.currentTarget.closest("form");

            var fahrer_tr = $(this).parents("tr");
            var fahrer_id = $(fahrer_tr).attr("id");

            $.ajax({
                url: $(form).attr("action") + "/" + fahrer_id,
                method: "delete"
            }).done(function (data, statusText, xhr){
                var status = xhr.status;

                if(status == 200){
                    $(fahrer_tr).remove();
                }
            });
        });
    });

    $("#btnAddFahrer").click(function (e) {
        $(".formAddFahrer").show();
        $("#newUserTable").editableTableWidget();
    });

    $('#userTable td').on('change', function(e, newValue) {
        var form = e.currentTarget.closest("form");

        var changedElement = $(this).attr("id");
        var fahrer_id = $(this).parents("tr").attr("id");

        var data = null;
        if(changedElement == "name"){
            data = { name : newValue };
        }else if(changedElement == "email"){
            data = { email : newValue || "_"};
        }else if(changedElement == "groesse"){
            data = { groesse : newValue };
        }else if(changedElement == "gewicht"){
            data = { gewicht : newValue };
        }


        $.ajax({
            url: $(form).attr("action") + "/" + fahrer_id,
            method: $(form).attr("method"),
            data: data
        }).done(function (data, statusText, xhr){
            var status = xhr.status;

            if(status == 200){
                console.log("success");
            }
        });

    });

    $(".btnCancel").click(function (e) {
        $(".formAddFahrer").hide();
        //window.newUserTemp = {};
    });

    $(".btnSave").click(function (e) {
        var form = e.currentTarget.closest("form");

        $.ajax({
            url: $(form).attr("action"),
            method: $(form).attr("method"),
            data: window.newUserTemp
        }).done(function (data, statusText, xhr){
            var status = xhr.status;

            console.log(data);

            var template = '<tr draggable="true" id="' + data.id + '">' +
                '<th id="th_fahrer_id">' +
                    '<fieldset>' +
                        '<input type="radio" name="radio_fahrer_id" class="radio-fahrer-id" value="' + data.id + '">' +
                    '</fieldset>' +
                '</th>' +
                '<td id="name">' + data.name + '</td>' +
                '<td id="email">' + data.email + '</td>' +
                '<td id="gewicht">' + data.gewicht + '</td>' +
                '<td id="groesse">' + data.groesse + '</td>' +
                '<th>' +
                    '<div class="btn btn-default btnDelete">' +
                        '<span class="glyphicon glyphicon-trash"></span>' +
                    '</div>' +
                '</th>' +
                '</tr>';

            $('#userTable tr:last').after(template);
            window.newUserTemp = {};

            if(status == 200){
                console.log("success");
            }
        });

        $(".formAddFahrer").hide();
    });

    $('#newUserTable td').on('change', function(e, newValue) {
        var form = e.currentTarget.closest("form");

        var changedElement = $(this).attr("id");
        var fahrer_id = $(this).parents("tr").attr("id");

        var data = null;
        if(changedElement == "name"){
            window.newUserTemp.name = newValue;
        }else if(changedElement == "email"){
            window.newUserTemp.email = newValue ;
        }else if(changedElement == "groesse"){
            window.newUserTemp.groesse = newValue;
        }else if(changedElement == "gewicht"){
            window.newUserTemp.gewicht = newValue ;
        }
    });

    $(".radio-fahrer-id").click(function () {
        window.selectedUserRow = $(this).val();
    });


    $("#userTable").editableTableWidget();
    $('#userTable td').on('change', function(e, newValue) {
        var form = e.currentTarget.closest("form");

        var changedElement = $(this).attr("id");
        var fahrer_id = $(this).parents("tr").attr("id");

        var data = null;
        if(changedElement == "name"){
            data = { name : newValue };
        }else if(changedElement == "email"){
            data = { email : newValue || "_"};
        }else if(changedElement == "groesse"){
            data = { groesse : newValue };
        }else if(changedElement == "gewicht"){
            data = { gewicht : newValue };
        }


        $.ajax({
            url: $(form).attr("action") + "/" + fahrer_id,
            method: $(form).attr("method"),
            data: data
        }).done(function (data, statusText, xhr){
            var status = xhr.status;

            if(status == 200){
                console.log("success");
            }
        });
    });
});

/*
 * Functions
 * */


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