<div class="col-md-6">
    @foreach($fahrraeder as $fahrrad)
        <div class="row">
            <div class="col-md-12 text-nowrap">
                <div class="panel panel-default pull-left fahrrad-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fahrrad {{$fahrrad->id}}</h3>
                    </div>
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-md-8">Fahrer:</div>
                        <div id="fahrername-anzeige-{{ $fahrrad->id }}" class="col-md-3">{{ $fahrrad->getFahrerName() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 ">Geschwindigkeit</div>
                        <div id="geschwindigkeit-anzeige-{{ $fahrrad->id }}" class="col-md-3">{{ $fahrrad->geschwindigkeit }} km/h</div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">istLeistung</div>
                        <div id="istLeistung-anzeige-{{ $fahrrad->id }}" class="col-md-3">{{ $fahrrad->istLeistung }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">Zurückgelegte Strecke</div>
                        <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-md-3">{{ $fahrrad->strecke }}</div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    @endforeach
</div>