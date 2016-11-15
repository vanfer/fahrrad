<div id="fahrrad-information-wrapper">
    @foreach($fahrraeder as $fahrrad)
        <div class="fahrrad-wrapper" id="{{ $fahrrad->id }}">
            <h1>Fahrrad #{{ $fahrrad->id }}</h1>
            <div id="fahrername-{{ $fahrrad->id }}">Fahrer: {{ $fahrrad->getFahrerName() }}</div>
            <hr>
            <div class="row">
                <div class="col-md-6">Geschwindigkeit</div>
                <div id="geschwindigkeit-anzeige-{{ $fahrrad->id }}" class="col-md-6">{{ $fahrrad->geschwindigkeit }} km/h</div>
            </div>
            <div class="row">
                <div class="col-md-6">istLeistung</div>
                <div id="istLeistung-anzeige-{{ $fahrrad->id }}" class="col-md-6">{{ $fahrrad->istLeistung }}</div>
            </div>
            <div class="row">
                <div class="col-md-6">Zurückgelegte Strecke</div>
                <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-md-6">{{ $fahrrad->strecke }} m</div>
            </div>
        </div>
    @endforeach
    <div class="clear"></div>
</div>