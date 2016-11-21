<div class ="container-fluid">
    @foreach($fahrraeder as $fahrrad)
        <div class="panel panel-default pull-left fahrrad-information-panel">
            <div class="panel-heading" id="{{ $fahrrad->id }}">
                <h3 class="panel-title">Fahrrad #{{ $fahrrad->id }}</h3>
            </div>
            <div class="panel-body ">
                    <div class="row">
                        <div class="col-lg-6">Fahrer:</div>
                        <div id="fahrername-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->getFahrerName() }}</div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 ">Geschwindigkeit</div>
                        <div id="geschwindigkeit-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->geschwindigkeit }} km/h</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">istLeistung</div>
                        <div id="istLeistung-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->istLeistung }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">Zurückgelegte Strecke</div>
                        <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->strecke }} m</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">sollLeistung</div>
                        <div id="sollLeistung-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->sollLeistung }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">sollDrehmoment</div>
                        <div id="sollDrehmoment-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->sollDrehmoment }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">strecke_id</div>
                        <div id="strecke_id-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->strecke_id }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">abschnitt_id</div>
                        <div id="abschnitt_id-anzeige-{{ $fahrrad->id }}" class="col-lg-6">{{ $fahrrad->abschnitt_id }}</div>
                    </div>
            </div>
        </div>

    @endforeach
    <div class="clear"></div>
</div>