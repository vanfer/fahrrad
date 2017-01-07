$(document).ready(function () {
    window.selectedUserRow = 0;
    window.selectedUserMode = 0;

    $(".formAddFahrer").hide();

    /*
     * autocomplete admin fahrer suche
     * */
    $("#q").autocomplete({
        source: "search/autocomplete",
        minLength: 1,
        select: function (event, ui) {
            $('#q').val(ui.item.label);
        },
        change: function (event, ui) {
        }
    });

    // Todo: Admin Login zu AJAX, Fehlerdialog statt Blade Fehler
    $("#falschesPasswort").dialog({
        autoOpen: false,
        dialogClass: "warnung",
        resizable: false,
        modal: true
    });

    /*
    $("#falschesPasswort").dialog("open");
    $('.ui-widget-overlay').addClass('custom-overlay');
    $("#btnfalschespasswort").on("click", function () {
        $("#falschesPasswort").dialog("close");
    });
    */

    $(".panelBodyAdmin").on("change", "select", function (e, newValue) {
        $.ajax({
            url: $(this).closest("form").attr("action"),
            method: "PUT",
            data: { modus_id: $(this).val() }
        }).done(function (data, statusText, xhr){
            var status = xhr.status;

            if(status == 200){
                console.log("success");
            }
        });
    });

    $("#btnGenerateName").click(function(){
        var namen = ["test1", "test2", "test3", "test4", "test5", "test6"];

        // Gibt einen zufälligen Eintrag aus dem namen Array zurück
        var name = namen.sort(function() {return 0.5 - Math.random()})[0];

        $("input#name").attr("value", name);
    });

    //Zuordnung löschen
    $( "#zuordnungLoeschen" ).dialog({
        autoOpen: false,
        dialogClass: "warnung",
        resizable: false,
        modal: true
    });

    $(".btnAbmelden").each(function(){
        $(this).click(function(e){
            var form = e.currentTarget.closest("form");

            $("#zuordnungLoeschen").dialog({
                buttons : {
                    "Ja" : function() {
                        $.ajax({
                            url: $(form).attr("action"),
                            method: $(form).attr("method"),
                            async: false
                        }).done(function (data, statusText, xhr){
                            if(xhr.status == 200){
                                zuordnungGeloescht(form);
                            }
                        });

                        $(this).dialog("close");
                    },
                    "Nein" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#zuordnungLoeschen").dialog("open");
        });
    });

    function zuordnungGeloescht(form){
        var btnAbmelden = $(form).parents(".panel").find(".fahrradBtnAbmelden");
        var btnAnmelden = $(form).parents(".panel").find(".fahrradBtnAnmelden");

        var fahrerdetailElement = $(form).parents(".panel").find(".panel-body");
        $(fahrerdetailElement).html("Fahrrad ist inaktiv");

        $(btnAbmelden).css("display", "none");
        $(btnAnmelden).css("display", "block");
    }


    //  Todo: Dialoge vereinfachen und redundanten Code vermeiden
    /*function showDialog(el, el_class){
        $(el).dialog({
            dialogClass: el_class,
            resizable: false,
            autoOpen: false,
            modal: true
        });
    }*/

    //Dialog "Kein Fahrer ausgewählt"
    $( "#keinFahrerAusgewaehlt" ).dialog({
        dialogClass:"fehler",
        resizable: false,
        autoOpen: false,
        modal: true
    });

    //Dialog "Fahrer schon zugeordnet
    $( "#fahrerSchonZugeordnet" ).dialog({
        dialogClass:"fehler",
        resizable: false,
        autoOpen: false,
        modal: true,
    });

    //Zuordnung hinzufügen
    $(".btnAnmelden").each(function(){

        $(this).click(function(e){
            var form = e.currentTarget.closest("form");

            var btnAbmelden = $(form).parents(".panel").find(".fahrradBtnAbmelden");
            var btnAnmelden = $(form).parents(".panel").find(".fahrradBtnAnmelden");
            var btnHilfeAktiv = $(form).parents(".panel").find(".fahrradBtnAbmelden");
            var btnHilfeInaktiv = $(form).parents(".panel").find(".fahrradBtnAnmelden");

            var fahrerdetailElement = $(form).parents(".panel").find(".panel-body");

            if(window.selectedUserRow == 0){

                $( "#keinFahrerAusgewaehlt" ).dialog( "open" );
                $(".ui-widget-overlay").addClass('custom-overlay');

                $( "#btnCloseKeinFahrerAusgewaehlt" ).on( "click", function() {
                    $( "#keinFahrerAusgewaehlt" ).dialog( "close" );
                });

            }else{

                // Zuordnen Request
                var url = $(form).attr("action") + "/fahrer/" + window.selectedUserRow;
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        modus_id: window.selectedUserMode
                    }
                }).done(function (data, statusText, xhr){
                    var status = xhr.status;

                        if(status == 200){
                        var fahrrad = data.fahrrad;
                        var fahrer = data.fahrer;

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
                            '				<option value="1"' + ((data.fahrer.modus_id == 1) ? ' selected' : '') + '>Strecke</option>' +
                            '				<option value="2"' + ((data.fahrer.modus_id == 2) ? ' selected' : '') + '>Konstantes Drehmoment</option>' +
                            '				<option value="3"' + ((data.fahrer.modus_id == 3) ? ' selected' : '') + '>Konstante Leistung</option>' +
                            '			</select>' +
                            '		</div>' +
                            '	</form>' +
                            '</div>';

                        $(fahrerdetailElement).html(template);

                        $(btnAbmelden).css("display", "block");
                        $(btnAnmelden).css("display", "none");
                        $(btnHilfeInaktiv).css("display", "none");
                        $(btnHilfeAktiv).css("display", "block");

                        $(".radio-fahrer-id").each(function () {
                            $(this).prop('checked', false);
                        });

                        window.selectedUserRow = 0;
                        window.selectedUserMode = 0;

                    }

                }).fail(function(data, statusText, xhr) {
                    $("#fahrerSchonZugeordnet").dialog("open");
                    $(".ui-widget-overlay").addClass('custom-overlay');

                    $("#btnCloseFahrerSchonZugeordnet").on("click", function () {
                        $("#fahrerSchonZugeordnet").dialog("close");
                    });
                });
            }
        });
    });

    //Fahrer hinzufügen

    $("#addFahrer").dialog({
        dialogClass:"addFahrer",
        resizable: false,
        autoOpen: false,
        modal: true
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
            }
        });
    });


    $("#userTable").editableTableWidget();

    //Dialog "Fahrer wirklich löschen"
    $( "#fahrerLoeschen" ).dialog({
        dialogClass:"fehler",
        resizable: false,
        autoOpen: false,
        modal: true,
    });

    //Fahrer löschen
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
    $('#newUserTable').on('change', 'td', function(e, newValue) {
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

    $("#userTable").on("click", ".radio-fahrer-id", function () {
        window.selectedUserRow = $(this).val();
        window.selectedUserMode = $(this).parents("tr").find("select").val();
    });

    $("#hilfeTabelle").dialog({
        dialogClass:"hilfe",
        resizable: false,
        autoOpen: false,
    });

    $("#btnHilfeTabelle").on("click", function() {
        $("#hilfeTabelle").dialog("open");
    });

    $("#hilfeInaktiv").dialog({
        dialogClass:"hilfe",
        resizable: false,
        autoOpen: false,
    });
    $(".btnHilfeInaktiv").on("click", function() {
        $("#hilfeInaktiv").dialog("open");
    });

    $("#hilfeAktiv").dialog({
        dialogClass:"hilfe",
        resizable: false,
        autoOpen: false,
    });
    $(".btnHilfeAktiv").on("click", function() {
        $("#hilfeAktiv").dialog("open");
    });
});