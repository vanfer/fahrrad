// WICHTIG: IP ändern, oder einfach localhost nehmen!
var BASE_PATH = "http://localhost/fahrrad/public/";

$(document).ready(function () {
    window.selectedUserRow = 0;
    window.selectedUserMode = 0;

    $(".formAddFahrer").hide();

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

    initDialog("#falschesPasswort",         "warnung",   true);
    initDialog("#zuordnungLoeschen",        "warnung",   true);
    initDialog("#keinFahrerAusgewaehlt",    "fehler",    true);
    initDialog("#fahrerSchonZugeordnet",    "fehler",    true);
    initDialog("#addFahrer",                "addFahrer", true);
    initDialog("#fahrerLoeschen",           "fehler",    true);
    initDialog("#hilfeAktiv",               "hilfe",    false);
    initDialog("#hilfeInaktiv",             "hilfe",    false);
    initDialog("#hilfeTabelle",             "hilfe",    false);

    $("#hilfeFahrer").dialog({
        autoOpen: false,
        dialogClass: "hilfe",
        modal: false,
        resizable: false,
        stack: true
    })


    // Element Bindings

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
        var namen = ["Athletische Ameise", "Schnelle Schnecke", "Flinker Fuchs", "Kräftiges Känguru",
            "Sportlicher Seehund", "Muskulöse Maus", "Beweglicher Biber", "Starke Schildkröte", "Rasantes Rentier",
            "Trainierter Tiger", "Aktiver Affe"];

        // Gibt einen zufälligen Eintrag aus dem namen Array zurück
        var name = namen.sort(function() {return 0.5 - Math.random()})[0];

        $("input#name").attr("value", name);
    });

    $(".btnAnmelden").each(function(){
        $(this).click(function(e){
            var fahrrad_id = $(this).attr("id");
            var context = $(this).parents("#panelAdmin");

            if(window.selectedUserRow == 0){
                $("#keinFahrerAusgewaehlt").dialog({
                    buttons : {
                        "OK" : function() {
                            $(this).dialog("close");
                        }
                    }
                });
                $("#keinFahrerAusgewaehlt").dialog("open");
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

            $("#zuordnungLoeschen").dialog({
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

            $("#zuordnungLoeschen").dialog("open");
            $(".ui-widget-overlay").addClass('custom-overlay');
        });
    });

    $("#btnAddFahrer").on("click", function(){
        $("#addFahrer").dialog("open");
        $('.ui-widget-overlay').addClass('custom-overlay');
    });

    $("#btnSubmitAddFahrer").click(function (e) {
        var form = e.currentTarget.closest("form");

        $.ajax({
            url: $(form).attr("action"),
            method: $(form).attr("method"),
            data: $(form).serialize()
        }).done(function (data, statusText, xhr){
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
                console.log("success");
                console.log(data);

                $("#addFahrer").dialog("close");

                // Hack
                window.location.reload();
            }
        });
    });

    $("#userTable").editableTableWidget();
    $("#userTable").on("click", ".btnDelete", function () {

        var form = $(this).closest("form");

        var fahrer_tr = $(this).parents("tr");
        var fahrer_id = $(fahrer_tr).attr("id");


        $("#fahrerLoeschen").dialog({
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

        $("#fahrerLoeschen").dialog("open");
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
        }).done(function (data, statusText, xhr){
            var status = xhr.status;

            if(status == 200){
                console.log("success");
            }
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
        }).done(function (data, statusText, xhr){
            var status = xhr.status;

            if(status == 200){
                console.log("success");
            }
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
});

function zuordnungLoeschen(context, fahrrad_id){
    $.ajax({
        url: BASE_PATH + "fahrrad/" + fahrrad_id,
        method: "DELETE",
        async: false
    }).done(function (data, statusText, xhr){
        if(xhr.status == 200){
            updateFahrradKasten(context, false);
        }
    });
}
function zuordnungHerstellen(context, fahrrad_id, fahrer_id, modus_id){
    var url =  BASE_PATH + "fahrrad/" + fahrrad_id + "/fahrer/" + fahrer_id;

    console.log(context);

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

            updateFahrradKasten(context, true, fahrrad, fahrer);
        }
    }).fail(function(data, statusText, xhr) {
        $("#fahrerSchonZugeordnet").dialog({
            buttons : {
                "OK" : function() {
                    $(this).dialog("close");
                }
            }
        });
        $("#fahrerSchonZugeordnet").dialog("open");
        $(".ui-widget-overlay").addClass('custom-overlay');
    });
}

// Wird nach dem herstellen/löschen einer Zuordnung aufgerufen um den Kasten zu aktualisieren
function updateFahrradKasten(context, modus, fahrrad, fahrer){
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