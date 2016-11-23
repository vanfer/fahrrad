<div class="row">
    <div class="col-md-12 text-nowrap">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title pull-left">Fahrrad {{$fahrrad->id}}</h3>
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a>Löschen</a></li>
                        <li><a>Editieren</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a>Hilfe</a></li>
                    </ul>
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
            </div>
        </div>
    </div>
</div>