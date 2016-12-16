<div class="row">
    <div class="col-md-12 text-nowrap">
        <div class="panel panel-default" id="panelAdmin">
            <div class="panel-heading" id="panelHeadingAdmin">
                <h3 class="panel-title pull-left" id="panelTitelAdmin">Fahrrad #{{$fahrrad->id}}</h3>
                <div class="pull-right">
                    <div class="fahrradBtnAbmelden pull-left" style="display: {{ ($fahrrad->fahrer_id == null) ? "none" : "block"  }}">
                        <form action="{{ url("fahrrad/".$fahrrad->id) }}" method="DELETE">
                            <button type="button" class="btn btn-default btnAbmelden">
                                <span class="glyphicon glyphicon-trash"></span>
                                Zuordnung löschen
                            </button>
                        </form>
                        <button type="button" class="btn btn-default btnHilfeAktiv">Hilfe</button>
                    </div>
                    <div class="fahrradBtnAnmelden" style="display: {{ ($fahrrad->fahrer_id == null) ? "block" : "none"  }}">
                        <form action="{{ url("fahrrad/".$fahrrad->id) }}" method="POST">
                            <button type="button" class="btn btn-default btnAnmelden">
                                <span class="glyphicon glyphicon-plus"></span>
                                Zuordnung hinzufügen
                            </button>
                        </form>
                        <button type="button" class="btn btn-default btnHilfeInaktiv ">Hilfe</button>
                    </div>
                </div>
                <span class="clearfix"></span>
            </div>

            <div class="panel-body panelBodyAdmin" id="panelBodyAdmin">
                @if($fahrrad->fahrer_id)
                    <div class="row">
                        <div class="col-md-6">Fahrer:</div>
                        <div id="fahrername-anzeige-{{ $fahrrad->id }}" class="col-md-4">{{ $fahrrad->getFahrerName() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">Geschwindigkeit</div>
                        <div id="geschwindigkeit-anzeige-{{ $fahrrad->id }}" class="col-md-4">{{ $fahrrad->geschwindigkeit }} km/h</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Gesamtleistung</div>
                        <div id="istLeistung-anzeige-{{ $fahrrad->id }}" class="col-md-4">{{ $fahrrad->istLeistung }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Zurückgelegte Kilometer</div>
                        <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-md-4">{{ $fahrrad->strecke }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Fahrdauer</div>
                        <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-md-4"></div>
                    </div>
                    <div class="row">
                        <form action="{{ url("fahrrad/".$fahrrad->id) }}" method="PUT">
                            <div class="col-md-6" id="betriebsmodusText">Betriebsmodus</div>
                            <div id="betriebsmodus-anzeige-{{ $fahrrad->id }}" class="col-md-4">
                                <select class="form-control" id="betriebsmodusAuswahlFahrrad">
                                    @foreach($modi as $modus)
                                        @if($fahrrad->modus_id == $modus->id)
                                            <option value="{{ $modus->id }}" selected>{{ $modus->name }}</option>
                                        @else
                                            <option value="{{ $modus->id }}">{{ $modus->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                @else
                    Fahrrad ist inaktiv
                @endif
            </div>
        </div>
    </div>
</div>