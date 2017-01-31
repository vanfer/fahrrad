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
                        <div id="istLeistung-anzeige-{{ $fahrrad->id }}" class="col-md-4">{{ $fahrrad->istLeistung }} Watt</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Zurückgelegte Strecke</div>
                        <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-md-4">{{ $fahrrad->strecke }} m</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Fahrdauer</div>
                        <div id="fahrdauer-anzeige-{{ $fahrrad->id }}" class="col-md-4">00:00:00</div>
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
                                    <input data-slider-id="modusSlider" id="{{ $fahrrad->modus_id }}" class="modus_option" type="text" data-provide="slider" data-slider-ticks="[3, 6, 9]" data-slider-ticks-labels='["leicht", "mittel", "schwer"]' data-slider-step="3" data-slider-value="{{ ($fahrrad->sollDrehmoment == null) ? 200 : $fahrrad->sollDrehmoment }}" data-slider-tooltip="hide"/>
                                    <!-- <input type="range" min="3" max="9" step="3" value="{{ ($fahrrad->sollDrehmoment == null) ? 200 : $fahrrad->sollDrehmoment }}" id="{{ $fahrrad->modus_id }}" class="modus_option" /> -->
                                @elseif($fahrrad->modus_id == 3) <!--  Leistung  -->
                                    <input data-slider-id="modusSlider" id="{{ $fahrrad->modus_id }}" class="modus_option" type="text" data-provide="slider" data-slider-ticks="[30, 60, 90]" data-slider-ticks-labels='["leicht", "mittel", "schwer"]' data-slider-step="30" data-slider-value="{{ ($fahrrad->sollLeistung == null) ? 200 : $fahrrad->sollLeistung }}" data-slider-tooltip="hide"/>
                                    <!-- <input type="range" min="30" max="90" step="30" value="{{ ($fahrrad->sollLeistung == null) ? 200 : $fahrrad->sollLeistung }}" id="{{ $fahrrad->modus_id }}" class="modus_option" /> -->
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