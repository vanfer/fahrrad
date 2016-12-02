<div class="row">
    <div class="col-md-12 text-nowrap">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title pull-left" style="">Fahrrad {{$fahrrad->id}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn btn-default" id="btnAbmelden">
                        <span class="glyphicon glyphicon-trash"></span>
                        Zuordnung löschen
                    </button>
                    <button type="button" class="btn btn-default">Hilfe</button>
                </div>
                <span class="clearfix"></span>
            </div>
            <div class="panel-body">
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
                <div class="row">
                    <div class="col-md-8">Betriebsmodus</div>
                    <div id="betriebsmodus-anzeige-{{ $fahrrad->id }}" class="col-md-3">
                        <select class="form-control">
                            <option>Strecke</option>
                            <option>Konstante Leistung</option>
                            <option>Konstanter Drehmoment</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>