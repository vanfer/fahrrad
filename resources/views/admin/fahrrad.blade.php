<div class="row">
    <div class="col-md-12 text-nowrap">
        <div class="panel panel-default" id="panelAdmin" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="panel-heading" id="panelHeadingAdmin">
                <h3 class="panel-title pull-left" id="panelTitelAdmin">Fahrrad #{{$fahrrad->id}}</h3>
                <div class="pull-right">
                    <div class="fahrradBtnAbmelden" style="display: {{ ($fahrrad->fahrer_id == null) ? "none" : "block"  }}">
                        <div class="pull-left">
                            <button type="button" class="btn btn-default btnAbmelden" id="{{$fahrrad->id}}">
                                <span class="glyphicon glyphicon-trash"></span>
                                Zuordnung löschen
                            </button>
                        </div>
                        <div class="pull-right">
                        <button type="button" class="btn btn-default btnHilfeAktiv">Hilfe</button>
                        </div>
                    </div>
                    <div class="fahrradBtnAnmelden" style="display: {{ ($fahrrad->fahrer_id == null) ? "block" : "none"  }}">
                        <div class="pull-left">
                            <button type="button" class="btn btn-default btnAnmelden" id="{{$fahrrad->id}}">
                                <span class="glyphicon glyphicon-plus"></span>
                                Zuordnung hinzufügen
                            </button>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-default btnHilfeInaktiv ">Hilfe</button>
                        </div>
                    </div>
                </div>
                <span class="clearfix"></span>
            </div>
            <div class="panel-body panelBodyAdmin" id="panelBodyAdmin-{{ $fahrrad->id }}">
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

                    @if($fahrrad->modus_id != 1)                <!-- Nicht Streckenmodus -->
                        <div class="row modus">
                            <div class="col-md-6">Modus Option</div>
                            <div id="modus-option-{{ $fahrrad->id }}" class="col-md-3">
                                @if($fahrrad->modus_id == 2)     <!-- Drehmoment -->
                                    <input type="range" min="0" max="1000" step="100" value="{{ ($fahrrad->sollDrehmoment == null) ? 200 : $fahrrad->sollDrehmoment }}" id="{{ $fahrrad->modus_id }}" class="modus_option" />
                                @elseif($fahrrad->modus_id == 3) <!--  Leistung  -->
                                    <input type="range" min="0" max="1000" step="100" value="{{ ($fahrrad->sollLeistung == null) ? 200 : $fahrrad->sollLeistung }}" id="{{ $fahrrad->modus_id }}" class="modus_option" />
                                @endif

                            </div>

                            <div class="modus_value" class="col-md-1">
                                @if($fahrrad->modus_id == 2)     <!-- Drehmoment -->
                                    {{ $fahrrad->sollDrehmoment }} Nm
                                @elseif($fahrrad->modus_id == 3) <!--  Leistung  -->
                                    {{ $fahrrad->sollLeistung }} W
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    Fahrrad ist inaktiv
                @endif
            </div>
        </div>
    </div>
</div>