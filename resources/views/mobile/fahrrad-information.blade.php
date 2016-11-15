<div id="fahrrad-information-wrapper-mobile">
    <div class="fahrrad-wrapper-mobile" id="{{ $fahrrad->id }}">
        <div class="row">
            <div class="col-xs-6">Geschwindigkeit</div>
            <div id="geschwindigkeit-anzeige-{{ $fahrrad->id }}" class="col-md-6">{{ $fahrrad->geschwindigkeit }} km/h</div>
        </div>
        <div class="row">
            <div class="col-xs-6">Erzeugte Leistung</div>
            <div id="istLeistung-anzeige-{{ $fahrrad->id }}" class="col-md-6">{{ $fahrrad->istLeistung }}</div>
        </div>
        <div class="row">
            <div class="col-xs-6">Zurückgelegte Strecke</div>
            <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-xs-6">{{ $fahrrad->strecke }} m</div>
        </div>
    </div>
    <div class="clear"></div>
</div>