// WICHTIG: IP ändern, oder einfach localhost nehmen!
var BASE_PATH = "http://localhost/fahrrad/public/";

function getDataFromAPI(url, async, successHandler) {
    $.ajax({
        url: BASE_PATH + url,
        type: 'get',
        async: async,
        success: successHandler
    });
}

$(document).ready(function () {
    window.selectedUserRow = 0;
    window.selectedUserMode = 0;

    setInterval(function () {
        updateFahrradKasten();
    }, 1000);

    // autocomplete admin fahrer suche
    $("#q").autocomplete({
        source: "search/autocomplete",
        minLength: 1,
        select: function (event, ui) {
            $('#q').val(ui.item.label);
        },
        change: function (event, ui) {
        }
    });

    // Dialoginitialisierungen
    function initDialog(selector, dialogClass, modal) {
        $(selector).dialog({
            autoOpen: false,
            dialogClass: dialogClass,
            resizable: false,
            modal: modal
        });
    }

    initDialog("#dialogFalschesPasswort",           "warnung",          true);
    initDialog("#dialogZuordnungLoeschen",          "warnung",          true);
    initDialog("#dialogEinstellungenSpeichern",     "warnung",          true);
    initDialog("#dialogFahrerLoeschen",             "warnung",          true);
    initDialog("#dialogValidationFailed",           "fehler",           true);
    initDialog("#dialogKeinFahrerAusgewaehlt",      "fehler",           true);
    initDialog("#dialogFahrerSchonZugeordnet",      "fehler",           true);
    initDialog("#dialogFahrernameSchonVergeben",    "fehler",           true);
    initDialog("#dialogEinstellungen",              "einstellungen",    true);
    initDialog("#addFahrer",                        "addFahrer",        true);
    initDialog("#hilfeAktiv",                       "hilfe",            false);
    initDialog("#hilfeInaktiv",                     "hilfe",            false);
    initDialog("#hilfeTabelle",                     "hilfe",            false);
    initDialog("#hilfeEinstellungen",               "hilfe",            false);

    $("#hilfeFahrer").dialog({
        autoOpen: false,
        dialogClass: "hilfe",
        modal: false,
        resizable: false,
        stack: true
    });

    // Close Button Fix
    $(".ui-dialog-titlebar-close").each(function () {
       $(this).css("color", "#000");
       $(this).css("font-size", "12px");
       $(this).html("X");
    });

    // Form Felder beim schließen leeren
    $('.addFahrer').on('dialogclose', function(event) {
        var form = $(this).find("#addFahrer").find("form");
        $(form).trigger("reset");
    });

    // Modus ändern (Fahrradkasten)
    $(".panelBodyAdmin").on("change", "select", function (e, newValue) {
        var context = $(this).parents(".panel-body");

        $.ajax({
            url: $(this).closest("form").attr("action"),
            method: "PUT",
            data: { modus_id: $(this).val() }
        }).done(function (data, statusText, xhr){
            if(xhr.status == 200){
                // Hack
                window.location.reload();
            }
        });
    });

    // Modus Option anpassen
    $(".modus_option").each(function () {
        $(this).on("change", function () {
            var value_html = $(this).parents(".row").find(".modus_value");

            var modus_id = $(this).parents(".row").find("#betriebsmodusAuswahlFahrrad").val();
            var modus_value = $(this).val();

            var einheit = (modus_id == 2) ? "Nm" : ((modus_id == 3) ? "W" : "");
            value_html.html($(this).val() + " " + einheit);

            var fahrrad_id = $(this).parents(".panelBodyAdmin").attr("id").split("-")[1];

            // Ajax /fahrrad/ID PUT - modus_id, modus_value
            $.ajax({
                url: BASE_PATH + "fahrrad/" + fahrrad_id,
                method: "PUT",
                data: {
                    modus_id: modus_id,
                    modus_value: modus_value
                }
            }).done(function (data, statusText, xhr){
                if(xhr.status == 200){
                    // Hack
                    window.location.reload();
                }
            });
        });
    });

    $("#btnGenerateName").click(function(){
        //Zufallsnamen, max. 19 Zeichen
        var namen = [
            "Athletische Ameise",
            "Schnelle Schnecke",
            "Flinker Fuchs",
            "Kräftiges Känguru",
            "Sportlicher Seehund",
            "Muskulöse Maus",
            "Beweglicher Biber",
            "Starke Schildkröte",
            "Rasantes Rentier",
            "Trainierter Tiger",
            "Aktiver Affe",
            "Dynamischer Dachs",
            "Springender Storch",
            "Wildes Wiesel",
            "Lebhafter Lemming",
            "Stürmischer Specht",
            "Eifriger Elch",
            "Forscher Frosch",
            "Fittes Faultier",
            "Strammer Springbock",
            "Wendiger Waschbär",
            "Flotte Fliege",
            "Eiliges Erdmännchen",
            "Leichtfüßiger Luchs",
            "Quirlige Qualle",
            "Energische Eule",
            "Schwungvoller Stier",
            "Zügiges Zebra",
            "Zackiger Zitteraal",
            "Agile Antilope"
        ];

        // Gibt einen zufälligen Eintrag aus dem namen Array zurück
        var name = namen.sort(function() {return 0.5 - Math.random()})[0];

        $("#fahrername").val(name);
    });

    $(".btnAnmelden").each(function(){
        $(this).click(function(e){
            var fahrrad_id = $(this).attr("id");
            var context = $(this).parents("#panelAdmin");

            if(window.selectedUserRow == 0){
                $("#dialogKeinFahrerAusgewaehlt").dialog({
                    buttons : {
                        "OK" : function() {
                            $(this).dialog("close");
                        }
                    }
                });
                $("#dialogKeinFahrerAusgewaehlt").dialog("open");
                $(".ui-widget-overlay").addClass('custom-overlay');
            }else{
                zuordnungHerstellen(context, fahrrad_id, window.selectedUserRow, window.selectedUserMode);

                $(".radio-fahrer-id").each(function () {
                    $(this).prop('checked', false);
                });

                window.selectedUserRow = 0;
                window.selectedUserMode = 0;
            }
        });
    });
    $(".btnAbmelden").each(function(){
        $(this).click(function(e){
            var fahrrad_id = $(this).attr("id");
            var context = $(this).parents("#panelAdmin");

            $("#dialogZuordnungLoeschen").dialog({
                buttons : {
                    "Ja" : function() {
                        zuordnungLoeschen(context, fahrrad_id);

                        $(this).dialog("close");
                    },
                    "Nein" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialogZuordnungLoeschen").dialog("open");
            $(".ui-widget-overlay").addClass('custom-overlay');
        });
    });

    $("#btnAddFahrer").on("click", function(){

        $("#addFahrer").dialog("open");
        $('.ui-widget-overlay').addClass('custom-overlay');
    });
    $("#btnSubmitAddFahrer").click(function (e) {
        var form = e.currentTarget.closest("form");

        if(!validateInput(form)) {
            $("#dialogValidationFailed").dialog({
                buttons : {
                    "OK" : function() {
                        $(this).dialog("close");
                    }
                }
            });
            $("#dialogValidationFailed").dialog("open");
            $(".ui-widget-overlay").addClass('custom-overlay');
        }
        else{
            $.ajax({
                url: $(form).attr("action"),
                method: $(form).attr("method"),
                data: $(form).serialize()
            }).done(function (data, statusText, xhr)
            {
                var status = xhr.status;

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
                    '<td id="betriebsmodus">' +
                    '<select class="form-control" id="betriebsmodusAuswahlFahrer">' +
                    '<option value="1" ' + ((data.modus_id == 1) ? 'selected' : '') + '>Strecke</option>' +
                    '<option value="2" ' + ((data.modus_id == 2) ? 'selected' : '') + '>Konstantes Drehmoment</option>' +
                    '<option value="3" ' + ((data.modus_id == 3) ? 'selected' : '') + '>Konstante Leistung</option>' +
                    '</select>' +
                    '</td>' +
                    '<th>' +
                    '<div class="btn btn-default btnDelete">' +
                    '<span class="glyphicon glyphicon-trash"></span>' +
                    '</div>' +
                    '</th>' +
                    '</tr>';

                $('#userTable tr:last').after(template);
                $("#userTable").editableTableWidget();

                if(status == 200){
                    $("#addFahrer").dialog("close");

                    // Hack
                    window.location.reload();
                }
            });
        }
    });

    $("#userTable").editableTableWidget();
    $("#userTable").on("click", ".btnDelete", function () {
        var form = $(this).closest("form");

        var fahrer_tr = $(this).parents("tr");
        var fahrer_id = $(fahrer_tr).attr("id");

        $("#dialogFahrerLoeschen").dialog({
            buttons : {
                "Ja" : function() {
                    $.ajax({
                        url: $(form).attr("action") + "/" + fahrer_id,
                        method: "delete"
                    }).done(function (data, statusText, xhr){
                        var status = xhr.status;

                        if(status == 200){
                            $(fahrer_tr).remove();

                            var fahrrad_kasten = $("#panelBodyAdmin-"+data.id);
                            fahrrad_kasten.html("Fahrrad ist inaktiv");

                            var buttons = fahrrad_kasten.siblings(".panel-heading").find(".pull-right");
                            var btnAbmelden = buttons.find(".fahrradBtnAbmelden");
                            var btnAnmelden = buttons.find(".fahrradBtnAnmelden");

                            $(btnAbmelden).css("display", "none");
                            $(btnAnmelden).css("display", "block");
                        }
                    });

                    $(this).dialog("close");
                },
                "Nein" : function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialogFahrerLoeschen").dialog("open");
        $('.ui-widget-overlay').addClass('custom-overlay');
    });
    $('#userTable').on('change', 'td', function(e, newValue) {
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
        });
    });
    $('#userTable').on('change', 'th', function(e, newValue) {
        var form = e.currentTarget.closest("form");

        var changedElement = $(this).attr("id");
        var fahrer_id = $(this).parents("tr").attr("id");

        var selectVal = $(e.currentTarget).find("select").val();

        $.ajax({
            url: $(form).attr("action") + "/" + fahrer_id,
            method: $(form).attr("method"),
            data: { modus_id : selectVal }
        });
    });
    $("#userTable").on("click", ".radio-fahrer-id", function () {
        window.selectedUserRow = $(this).val();
        window.selectedUserMode = $(this).parents("tr").find("select").val();
    });
    $("#userTable").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    });

    $("#btnHilfeTabelle").on("click", function() {
        $("#hilfeTabelle").dialog("open");
    });
    $(".btnHilfeInaktiv").on("click", function() {
        $("#hilfeInaktiv").dialog("open");
    });
    $(".btnHilfeAktiv").on("click", function() {
        $("#hilfeAktiv").dialog("open");
    });
    $("#btnHilfeFahrer").on("click", function() {
        $("#hilfeFahrer").dialog("open");
    })

    $("#btnEinstellungen").on("click", function(){
        $("#dialogEinstellungen").dialog("open");
        $('.ui-widget-overlay').addClass('custom-overlay');
    });
    $("#btnSubmitEinstellungen").on("click", function() {
        $("#dialogEinstellungenSpeichern").dialog({
            buttons : {
                "Ja" : function() {
                    //Speichern
                    var id = $(".radio-strecke-id:checked").val();
                    createCookie("strecke", id, 1);

                    $(this).dialog("close");
                    $("#dialogEinstellungen").dialog("close");
                },
                "Nein" : function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialogEinstellungenSpeichern").dialog("open");
        $(".ui-widget-overlay").addClass('custom-overlay');
    });

    $("#btnHilfeEinstellungen").on("click", function() {
            $("#hilfeEinstellungen").dialog("open");
        });

    // Einstellungen Streckeauswahl

    window.strecke_vorschau_data = {data: [], labels: []};
    window.strecke_vorschau_abschnitte = [];
    window.chart_strecke_vorschau = new Highcharts.Chart({
        title: {
            text: ''
        },
        chart: {
            renderTo: 'streckenvorschau',
            animation: true,
            backgroundColor: "#E6E9ED",
            spacingBottom: 10,
            spacingTop: 10,
            spacingLeft: 10,
            spacingRight: 10
        },
        legend: {
            enabled: false
        },
        xAxis: {
            labels: {
                formatter: function () {
                    if (window.strecke_vorschau_data.labels[this.value]) return window.strecke_vorschau_data.labels[this.value].toFixed(2) + " m";
                },
                style: {
                    fontSize: '14px'
                }
            }
        },
        yAxis: {
            min: 0,
            max: 20,
            labels: {
                format: '{value}',
                style: {
                    fontSize: '18px'
                }
            },
            title: {
                text: 'Höhe (Meter)',
                x: -10,
                style: {
                    fontSize: '16px'
                }
            }
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5,
                marker: {
                    enabled: true
                }
            }
        },
        tooltip: {
            enabled: false
        },
        series: [{
            data: window.strecke_vorschau_data.data,
            type: 'area',
            color: '#AAB2BD',
            enableMouseTracking: false,
            zIndex: 5
        }]
    });

    updateChartStreckeData(1);

    $(".radio-strecke-id").change(function (e) {
        updateChartStreckeData($(e.target).val());
    })
});

function zuordnungLoeschen(context, fahrrad_id){
    $.ajax({
        url: BASE_PATH + "fahrrad/" + fahrrad_id,
        method: "DELETE",
        async: false
    }).done(function (data, statusText, xhr){
        if(xhr.status == 200){
            initFahrradKasten(context, false);
        }
    });
}
function zuordnungHerstellen(context, fahrrad_id, fahrer_id, modus_id){
    var url =  BASE_PATH + "fahrrad/" + fahrrad_id + "/fahrer/" + fahrer_id;

    $.ajax({
        url: url,
        method: "GET",
        data: {
            modus_id: modus_id
        }
    }).done(function (data, statusText, xhr){
        var status = xhr.status;

        if(status == 200){
            var fahrrad = data.fahrrad;
            var fahrer = data.fahrer;

            initFahrradKasten(context, true, fahrrad, fahrer);
        }
    }).fail(function(data, statusText, xhr) {
        $("#dialogFahrerSchonZugeordnet").dialog({
            buttons : {
                "OK" : function() {
                    $(this).dialog("close");
                }
            }
        });
        $("#dialogFahrerSchonZugeordnet").dialog("open");
        $(".ui-widget-overlay").addClass('custom-overlay');
    });
}

// Wird nach dem herstellen/löschen einer Zuordnung aufgerufen um den Kasten zu aktualisieren
function initFahrradKasten(context, modus, fahrrad, fahrer){
    // Optionale Parameter nur bei Zuordnung herstellen nötig
    fahrrad = fahrrad || null;
    fahrer  = fahrer  || null;

    var btnAbmelden = $(context).find(".fahrradBtnAbmelden");
    var btnAnmelden = $(context).find(".fahrradBtnAnmelden");

    var fahrerdetailElement = $(context).find(".panel-body");

    if(modus){ // Zuordnung Herstellen
        if(fahrrad && fahrer){
            var template = '<div class="row">' +
                '	<div class="col-md-6">Fahrer:</div>' +
                '	<div id="fahrername-anzeige-' + fahrrad.id + '" class="col-md-4">' + fahrer.name + '</div>' +
                '</div>' +
                '<div class="row">' +
                '	<div class="col-md-6 ">Geschwindigkeit</div>' +
                '	<div id="geschwindigkeit-anzeige-' + fahrrad.id + '" class="col-md-4">' + fahrrad.geschwindigkeit + ' km/h</div>' +
                '</div>' +
                '<div class="row">' +
                '	<div class="col-md-6">Gesamtleistung</div>' +
                '	<div id="istLeistung-anzeige-' + fahrrad.id + '" class="col-md-4">' + fahrrad.istLeistung + '</div>' +
                '</div>' +
                '<div class="row">' +
                '	<div class="col-md-6">Zurückgelegte Strecke</div>' +
                '	<div id="strecke-anzeige-' + fahrrad.id + '" class="col-md-4">' + fahrrad.strecke + '</div>' +
                '</div>' +
                '<div class="row">' +
                '   <div class="col-md-6">Fahrdauer</div>' +
                '   <div id="fahrdauer-anzeige-{{ $fahrrad->id }}" class="col-md-4">00:00:00</div>' +
                '</div>' +
                '<div class="row">' +
                '	<form action="./fahrrad/'+fahrrad.id+'" method="PUT">' +
                '		<div class="col-md-6" id="betriebsmodusText">Betriebsmodus</div>' +
                '		<div id="betriebsmodus-anzeige-' + fahrrad.id + '" class="col-md-4">' +
                '			<select class="form-control" id="betriebsmodusAuswahlFahrrad">' +
                '				<option value="1"' + ((fahrer.modus_id == 1) ? ' selected' : '') + '>Strecke</option>' +
                '				<option value="2"' + ((fahrer.modus_id == 2) ? ' selected' : '') + '>Konstantes Drehmoment</option>' +
                '				<option value="3"' + ((fahrer.modus_id == 3) ? ' selected' : '') + '>Konstante Leistung</option>' +
                '			</select>' +
                '		</div>' +
                '	</form>' +
                '</div>';

            $(fahrerdetailElement).html(template);

            $(btnAbmelden).css("display", "block");
            $(btnAnmelden).css("display", "none");
        }
    }
    else{ // Zuordnung Löschen
        $(fahrerdetailElement).html("Fahrrad ist inaktiv");

        $(btnAbmelden).css("display", "none");
        $(btnAnmelden).css("display", "block");
    }

    // Hack
    window.location.reload();
}
// Im Intervall 2s ausführen
function updateFahrradKasten() {
    getDataFromAPI("data", false, function (response) {
        if (response && response.data) {
            $.each(response.data.fahrrad, function (index, fahrrad) {
                if(fahrrad.fahrer != null){
                    var fahrdauer = getElapsedTime(fahrrad.zugeordnet_at);

                    $("#fahrername-anzeige-" + fahrrad.id).html(fahrrad.fahrer.name);
                    $("#geschwindigkeit-anzeige-" + fahrrad.id).html(fahrrad.geschwindigkeit + " km/h");
                    $("#istLeistung-anzeige-" + fahrrad.id).html(fahrrad.istLeistung + " Watt");
                    $("#strecke-anzeige-" + fahrrad.id).html(fahrrad.strecke + " m");
                    $("#fahrdauer-anzeige-" + fahrrad.id).html(fahrdauer);
                }else{
                    $("#panelBodyAdmin-" + fahrrad.id).html("Fahrrad ist inaktiv");
                }
            });
        }
    });
}

// Validiert die Eingaben beim Erstellen eines Fahrers
function validateInput(form){
    var validates = true;

    var name = $(form).find("#fahrername").val();
    if(!name){
        validates = false;
    }

    var email = $(form).find("input#email").val();
    var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(email){
        if(regex_email.test(email) == false){
            validates = false;
        }
    }

    var modus = $('input[name=betriebsmodus]:checked', form).val();
    if(!modus){
        validates = false;
    }

    var groesse = $(form).find("input#groesse").val();
    if(groesse){
        try{
            validates = $.isNumeric(groesse);
        }catch (ex){
            validates = false;
        }
    }

    var gewicht = $(form).find("input#gewicht").val();
    if(gewicht){
        try{
            validates = $.isNumeric(gewicht);
        }catch (ex){
            validates = false;
        }
    }

    return validates;
}

// Drag & Drop
function allowDrop(ev) {
    ev.preventDefault();
}
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    ev.dataTransfer.setData("modus", $(ev.target).find("#betriebsmodus").find("select").val());
}
function drop(ev) {
    ev.preventDefault();

    var fahrrad_id = $(ev.target).attr("id").split("-")[1];
    var user_id = ev.dataTransfer.getData("text");
    var modus_id = ev.dataTransfer.getData("modus");
    var context = $(ev.target).parents("#panelAdmin");

    zuordnungHerstellen(context, fahrrad_id, user_id, modus_id);
}

function getElapsedTime(fahrrad_timestamp) {
    var current_timestamp = Math.floor(new Date().getTime() / 1000);
    var elapsed_seconds = (current_timestamp - fahrrad_timestamp);

    var d = new Date(null);
    d.setSeconds(elapsed_seconds); // Sekunden zu JS Date Objekt
    d.setTime(d.getTime() + d.getTimezoneOffset() * 60 * 1000); // Zeitzone anpassen!

    // String zusammenbauen
    return ('0' + d.getHours()).slice(-2) + ':' + ('0' + (d.getMinutes())).slice(-2) + ':' + ('0' + (d.getSeconds() + 1)).slice(-2);
}

function updateChartStreckeData(id) {
    getDataFromAPI("strecke/" + id, false, function (response) {
        if (response && response.strecke) {
            window.strecke_vorschau_abschnitte = [];
            window.strecke_vorschau_data = {data: [0], labels: [0]};
            var gesamtlaenge = 0;

            $.each(response.strecke.abschnitte,
                function (index, value) {
                    gesamtlaenge += value.laenge;
                    window.strecke_vorschau_data.labels.push(gesamtlaenge); // X
                    window.strecke_vorschau_data.data.push(value.hoehe);  // Y

                    window.strecke_vorschau_abschnitte.push(value.id);
                }
            );
        }
    });

    window.chart_strecke_vorschau.series[0].setData(window.strecke_vorschau_data.data);
    window.chart_strecke_vorschau.xAxis[0].setCategories(window.strecke_vorschau_data.labels);
    window.chart_strecke_vorschau.redraw();
}

function createCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}